<?php

namespace app\controllers;

use app\models\Instancia;
use app\models\Partido;
use app\models\Torneo;
use Yii;
use app\models\Prediccion;
use app\models\PrediccionSearch;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PrediccionController implements the CRUD actions for Prediccion model.
 */
class PrediccionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new', 'prediccion'],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['grupo_prediccion'],
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'save-as-new', 'prediccion'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->can('theCreator') || Yii::$app->user->can('admin'));
                        },

                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Prediccion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrediccionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Prediccion model.
     * @param integer $id
     * @param integer $id_user
     * @param integer $id_partido
     * @return mixed
     */
    public function actionView($id, $id_user, $id_partido)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Prediccion #".$id, $id_user, $id_partido,
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id, $id_user, $id_partido),
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Edit',['update','id, $id_user, $id_partido'=>$id, $id_user, $id_partido],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id, $id_user, $id_partido),
            ]);
        }
    }

    //DEVUELVE LA PREDICCION PERO ANTES CHEQUEA SI EXISTE SINO LA CREA
    public function checkprediccion($id_patido, $id_user, $id_instancia, $jugado){
        $prediccion = Prediccion::find()
            ->where(['id_partido' => $id_patido, 'id_user' => $id_user, 'id_instancia' => $id_instancia])
            ->orderBy(['id_partido' => SORT_ASC])->one();
        //var_dump($prediccion);
        if(sizeof($prediccion) == 0){
            $prediccion = new Prediccion();
            $prediccion->id = (Prediccion::find()->orderBy(['id' => SORT_DESC])->one()->id)+1;
            $prediccion->id_partido = $id_patido;
            $prediccion->id_user = $id_user;
            $prediccion->goles_visitante = 0;
            $prediccion->goles_local = 0;
            if($jugado == 1)
                $prediccion->resultado = 3;
            else
                $prediccion->resultado = 1;
            $prediccion->id_instancia = $id_instancia;
            $prediccion->save();
        }

        return $prediccion;
    }

    /**
     * Creates a several new Prediccion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionGrupo_prediccion($id_user, $grupo, $id_instancia){
        $request = Yii::$app->request;
        //$last_id_torneo = Torneo::find()->orderBy(['id' => SORT_DESC])->one()->id;
        $instancia = Instancia::findOne(['id' => $id_instancia]);
        $partidos_grupo = Partido::find()
            ->where([ 'grupo' => $grupo, 'id_torneo' => $instancia->id_torneo ])
            ->orderBy(['grupo'=>SORT_ASC, 'fecha'=> SORT_ASC, 'hora' => SORT_ASC ])->all();

        //var_dump($partidos_grupo);
        if($request->isAjax){
            if($request->isGet) {
                $predicciones = array();
                //$predicciones = Prediccion::find()->indexBy('id')->all();
                foreach ($partidos_grupo as $p) {
                    $prediccion = $this->checkprediccion($p->id, $id_user, $id_instancia, $p->jugado);
                    //var_dump($prediccion);
                    $predicciones[] = $prediccion;
                }
                return $this->renderAjax('grupo_prediccion', [
                    'predicciones' => $predicciones,
                ]);
            }else{
                $count = count(Yii::$app->request->post('Prediccion', []));
                //Send at least one model to the form
                $predicciones = [new Prediccion()];
                //Create an array of the products submitted
                for($i = 1; $i < $count; $i++) {
                    $predicciones[] = new Prediccion();
                }
                //Load and validate the multiple models
                if (Model::loadMultiple($predicciones, Yii::$app->request->post()) &&  Model::validateMultiple($predicciones)) {
                    PartidoController::ControlarFechaHoraPartido($id_instancia);
                    foreach ($predicciones as $prediccion_form) {
                        $prediccion = Prediccion::findOne(['id_user' => $prediccion_form->id_user, 'id_partido' => $prediccion_form->id_partido, 'id_instancia' => $id_instancia]);
                        $p = Partido::find()->where(['id' => $prediccion_form->id_partido])->one();
                        if($p->jugado == 0){
                            $prediccion->id_instancia = $id_instancia;
                            $prediccion->goles_local  = $prediccion_form->goles_local;
                            $prediccion->goles_visitante = $prediccion_form->goles_visitante;
                            if ($prediccion->goles_local == $prediccion->goles_visitante) $prediccion->resultado = 1;
                            if ($prediccion->goles_local > $prediccion->goles_visitante) $prediccion->resultado = 0;
                            if ($prediccion->goles_local < $prediccion->goles_visitante) $prediccion->resultado = 2;
                            $prediccion->save(false);
                        }
                    }
                    //return $this->redirect('view');
                }
                //echo $count = count(Yii::$app->request->post('Prediccion', []));
                //var_dump($request->post('Prediccion', []));
            }
        }else{

        }
    }

    public function actionSeg_fase_pred($id_partido, $id_prediccion = 0){
        $request = Yii::$app->request;
        if($id_prediccion != 0){
            $prediccion = Prediccion::find()->where(['id' => $id_prediccion])->one();
            if($request->isAjax){
                if($request->isGet) {
                    return $this->renderAjax('seg_fase_pred', [
                        'prediccion' => $prediccion,
                    ]);
                }
        }
        }

    }

    public function actionPrediccion($id_patido, $id_user){
        $request = Yii::$app->request;
        $model = prediccion($id_patido, $id_user, $request);
        $partido = Partido::find()
            ->joinWith('local l')
            ->joinWith('visitante v')
            ->where(['partido.id' => $id_patido])->one();

        if($request->isAjax){
            if($request->isGet) {
                return $this->renderAjax('prediccion', [
                    'model' => $model,
                    'partido' => $partido,
                ]);
            }else{
                if (!$model->load($request->post()) || !$model->save()){
                    return "Error de validacion";
                }else
                    return "Prediccion ralizada";
            }
        }
    }



    /**
     * Creates a new Prediccion model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Prediccion();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Prediccion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                if ($model->goles_local == $model->goles_visitante) $model->resultado = 1;
                if ($model->goles_local > $model->goles_visitante) $model->resultado = 0;
                if ($model->goles_local < $model->goles_visitante) $model->resultado = 2;
                if ($model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Create new Prediccion",
                        'content'=>'<span class="text-success">Create Prediccion success</span>',
                        'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                    ];
                }
            }else{
                return [
                    'title'=> "Create new Prediccion",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'id_user' => $model->id_user, 'id_partido' => $model->id_partido]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing Prediccion model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_user
     * @param integer $id_partido
     * @return mixed
     */
    public function actionUpdate($id, $id_user, $id_partido)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id, $id_user, $id_partido);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Prediccion #".$id, $id_user, $id_partido,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post())){
                if ($model->goles_local == $model->goles_visitante) $model->resultado = 1;
                if ($model->goles_local > $model->goles_visitante) $model->resultado = 0;
                if ($model->goles_local < $model->goles_visitante) $model->resultado = 2;
                if ($model->save()) {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Prediccion #" . $id, $id_user, $id_partido,
                        'content' => $this->renderAjax('view', [
                            'model' => $model,
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::a('Edit', ['update', 'id, $id_user, $id_partido' => $id, $id_user, $id_partido], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                    ];
                }
            }else{
                return [
                    'title'=> "Update Prediccion #".$id, $id_user, $id_partido,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'id_user' => $model->id_user, 'id_partido' => $model->id_partido]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Prediccion model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_user
     * @param integer $id_partido
     * @return mixed
     */
    public function actionDelete($id, $id_user, $id_partido)
    {
        $request = Yii::$app->request;
        $this->findModel($id, $id_user, $id_partido)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing Prediccion model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_user
     * @param integer $id_partido
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Prediccion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_user
     * @param integer $id_partido
     * @return Prediccion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_user, $id_partido)
    {
        if (($model = Prediccion::findOne(['id' => $id, 'id_user' => $id_user, 'id_partido' => $id_partido])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
