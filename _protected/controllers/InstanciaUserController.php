<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\InstanciaUser;
use app\models\InstanciaUserSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InstanciaUserController implements the CRUD actions for InstanciaUser model.
 */
class InstanciaUserController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new','usuarios'],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create', 'update','usuarios'],
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->can('theCreator') || Yii::$app->user->can('admin'));
                        }
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all InstanciaUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstanciaUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all InstanciaUser models.
     * @return mixed
     */
    public function actionUsuarios($id_instancia)
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new InstanciaUserSearch();
        $searchModel->id_instancia = $id_instancia;
        $query = InstanciaUser::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['id', 'id_user'],
            ],
        ]);
        $searchModel->load($params);
        $query->joinWith('user');
        $query->andFilterWhere([
            'id' => $searchModel->id,
            'id_user' => $searchModel->id_user,
            'id_instancia' => $searchModel->id_instancia,
            'user.status' => User::STATUS_ACTIVE, //solo usuarios activos
        ])->orderBy(['puntos' => SORT_DESC]);

        return $this->renderAjax('usuarios', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_instancia' => $id_instancia,
        ]);
    }

    /**
     * Displays a single InstanciaUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $instancias_user = InstanciaUser::find()->filterWhere(['id_instancia' => $model->id_instancia])->one();
        return $this->redirect(['/partido/fixture', 'id_instancia' => $instancias_user->id_instancia ]);
    }

    /**
     * Creates a new InstanciaUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InstanciaUser();

        if ($model->loadAll(Yii::$app->request->post()) ) {
            //controla si ya esta inscripto en el torneo
            if ( sizeof(InstanciaUser::findOne(['id_user' => $model->id_user, 'id_instancia' => $model->id_instancia])) == 0 ){
                $ultima_posicion_instancia = InstanciaUser::find()->joinWith('user')
                    ->filterWhere(['id_instancia' => $model->id_instancia])
                    ->andFilterWhere(['status' => User::STATUS_ACTIVE])
                    ->orderBy(['puntos'=> SORT_ASC])->one();
                $model->handicap = $ultima_posicion_instancia->puntos;
                $model->puntos = $ultima_posicion_instancia->puntos;
                if($model->saveAll()){
                    return $this->redirect(['/partido/fixture', 'id_instancia' => $model->id_instancia ]);
                }
            }else{
                return $this->redirect(['/partido/fixture', 'id_instancia' => $model->id_instancia ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstanciaUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new InstanciaUser();
        }else{
            $model = $this->findModel($id);
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InstanciaUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $instancia_user = InstanciaUser::findOne(['id' => $id]);
        $this->findModel($id)->deleteWithRelated();
        echo "Usuario eliminado";
        //return $this->redirect(['usuarios','id_instancia' => $instancia_user->id_instancia]);
    }

    /**
     * Creates a new InstanciaUser model by another data,
     * so user don't need to input all field from scratch.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param mixed $id
     * @return mixed
     */
    public function actionSaveAsNew($id) {
        $model = new InstanciaUser();

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
     * Finds the InstanciaUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InstanciaUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InstanciaUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
