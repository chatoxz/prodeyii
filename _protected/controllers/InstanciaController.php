<?php

namespace app\controllers;

use app\models\base\InstanciaUser;
use app\models\Torneo;
use Yii;
use app\models\Instancia;
use app\models\InstanciaSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * InstanciaController implements the CRUD actions for Instancia model.
 */
class InstanciaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new','admin_torneo'],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                },
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->can('theCreator') || Yii::$app->user->can('admin'));
                        }
                    ],
                    [
                        'actions' => ['admin_torneo'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all Instancia models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstanciaSearch();
        //filtrado de mis torneos esta en el search
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Instancia models.
     * @return mixed
     */
    public function actionAdmin_torneo($id_user)
    {
        $searchModel = new InstanciaSearch();
        //filtrado de mis torneos esta en el search
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin_torneo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Instancia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Instancia model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Instancia();
        $model->id_user = Yii::$app->user->id;
        $torneos =  ArrayHelper::map(Torneo::find()->orderBy(['id'=> SORT_DESC])->all(), 'id','nombre');

        if($request->isAjax){
            if($model->load($request->post()) && $model->save()) {
                //inscribo al usuario e el torneo.
                $instancia_user = new InstanciaUser();
                $instancia_user->id_user = Yii::$app->user->id;
                $instancia_user->id_instancia = $model->id;
                $instancia_user->save();
                echo "Copa creada!";
            }else {
                return $this->renderAjax('create', [
                    'model' => $model,
                    'torneos' => $torneos,
                ]);
            }
        }else {
            if($model->load($request->post()) && $model->save()) {
                //inscribo al usuario e el torneo.
                $instancia_user = new InstanciaUser();
                $instancia_user->id_user = Yii::$app->user->id;
                $instancia_user->id_instancia = $model->id;
                $instancia_user->save();

                //filtrado de mis torneos esta en el search
                $searchModel = new InstanciaSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('admin_torneo', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                    'torneos' => $torneos,
                ]);
            }
        }
    }

    /**
     * Updates an existing Instancia model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new Instancia();
        }else{
            $model = $this->findModel($id);
        }
        if($request->isAjax){
            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return "Torneo Modificado.";
                //return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $torneos =  ArrayHelper::map(Torneo::find()->orderBy(['id'=> SORT_DESC])->all(), 'id','nombre');
                return $this->renderAjax('update', [
                    'model' => $model,
                    'torneos' => $torneos,
                ]);
            }
        }else{
            if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $torneos =  ArrayHelper::map(Torneo::find()->orderBy(['id'=> SORT_DESC])->all(), 'id','nombre');
                return $this->render('update', [
                    'model' => $model,
                    'torneos' => $torneos,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Instancia model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
     * Creates a new Instancia model by another data,
     * so user don't need to input all field from scratch.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param mixed $id
     * @return mixed
     */
    public function actionSaveAsNew($id) {
        $model = new Instancia();

        if (Yii::$app->request->post('_asnew') != '1') {
            $model = $this->findModel($id);
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('saveAsNew', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Instancia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Instancia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Instancia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
