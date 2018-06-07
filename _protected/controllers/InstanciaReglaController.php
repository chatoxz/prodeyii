<?php

namespace app\controllers;

use Yii;
use app\models\InstanciaRegla;
use app\models\InstanciaReglaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InstanciaReglaController implements the CRUD actions for InstanciaRegla model.
 */
class InstanciaReglaController extends Controller
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
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new'],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all InstanciaRegla models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InstanciaReglaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InstanciaRegla model.
     * @param integer $id
     * @param integer $id_instancia
     * @return mixed
     */
    public function actionView($id, $id_instancia)
    {
        $model = $this->findModel($id, $id_instancia);
        return $this->render('view', [
            'model' => $this->findModel($id, $id_instancia),
        ]);
    }

    /**
     * Creates a new InstanciaRegla model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InstanciaRegla();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_instancia' => $model->id_instancia]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InstanciaRegla model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_instancia
     * @return mixed
     */
    public function actionUpdate($id, $id_instancia)
    {
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new InstanciaRegla();
        }else{
            $model = $this->findModel($id, $id_instancia);
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_instancia' => $model->id_instancia]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InstanciaRegla model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_instancia
     * @return mixed
     */
    public function actionDelete($id, $id_instancia)
    {
        $this->findModel($id, $id_instancia)->deleteWithRelated();

        return $this->redirect(['index']);
    }

    /**
    * Creates a new InstanciaRegla model by another data,
    * so user don't need to input all field from scratch.
    * If creation is successful, the browser will be redirected to the 'view' page.
    *
    * @param mixed $id
    * @return mixed
    */
    public function actionSaveAsNew($id, $id_instancia) {
        $model = new InstanciaRegla();

        if (Yii::$app->request->post('_asnew') != '1') {
            $model = $this->findModel($id, $id_instancia);
        }
    
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id, 'id_instancia' => $model->id_instancia]);
        } else {
            return $this->render('saveAsNew', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Finds the InstanciaRegla model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_instancia
     * @return InstanciaRegla the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_instancia)
    {
        if (($model = InstanciaRegla::findOne(['id' => $id, 'id_instancia' => $id_instancia])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
