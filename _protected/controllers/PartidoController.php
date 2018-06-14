<?php

namespace app\controllers;

use app\models\Chat;
use app\models\Instancia;
use app\models\InstanciaUser;
use app\models\Pais;
use app\models\Prediccion;
use app\models\Torneo;
use app\models\User;
use Yii;
use app\models\Partido;
use app\models\PartidoSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * PartidoController implements the CRUD actions for Partido model.
 */
class PartidoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['fixture','create','update','view','index','posiciones','puntuar'],
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect(['/site/login']);
                },
                'rules' => [
                    [
                        'actions' => ['fixture','posiciones','reglas'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create','update','view','index','puntuar'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (Yii::$app->user->can('theCreator') || Yii::$app->user->can('admin'));
                        }
                    ],
                ],
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
     * Lists all Partido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Partido models.
     * @return mixed
     */
    public function actionFixture($id_instancia = 0){
        $request = Yii::$app->request;
        $id_user = Yii::$app->user->id;
        $instancias_user = InstanciaUser::find()->filterWhere(['id_user' => Yii::$app->user->getId()])->one();
        if(sizeof($instancias_user) == 0)
            return $this->redirect('/instancia-user/create');
        if(!$request->isAjax){
            $instancia = Instancia::find()->filterWhere(['id' => $id_instancia])->one();
            if (sizeof($instancia) == 0)
                return $this->redirect('/instancia-user/create');
            $torneo = Torneo::find()->filterWhere(['id' => $instancia->id_torneo])->one();
            $partidos_por_grupo = $torneo->partidos_grupo;

            $query = Partido::find()
                ->joinWith('local l')
                ->joinWith('visitante v')
                // ->joinWith('prediccions p', 'partido.id = p.id_partido and p.id_user = '.$id_user.' and p.id_instancia = '. $instancia->id)
                ->Where('partido.grupo is not null')
                ->andWhere('id_torneo ='. $instancia->id_torneo)
                ->andFilterWhere(['like', 'partido.instancia', 'Grupo'])
                ->orderBy(['grupo'=>SORT_ASC, 'fecha'=> SORT_ASC])->all();
            //var_dump($query->createCommand()->getRawSql());
            //var_dump($provider->getModels());

            $chats = Chat::find()->filterWhere(['id_instancia' => $id_instancia])->limit(100)->all();
            $new_chat = new Chat();
            $new_chat->id = Chat::find()->orderBy(['id' => SORT_DESC])->one()->id + 1 ;
            $new_chat->id_user = Yii::$app->user->id;
            $new_chat->id_instancia = $id_instancia;
            $new_chat->fecha = \Yii::$app->formatter->asDate(DATE('Y-m-d H:i:s'), 'php:Y-m-d H:i:s');
            return $this->render('fixture', [
                'partidos' => $query,
                'partidos_por_grupo' => $partidos_por_grupo,
                'id_user' => Yii::$app->user->id,
                'torneo' => $torneo,
                'instancia_torneo' => $instancia,
                'chats' => $chats,
                'new_chat' =>  $new_chat,
            ]);
        }else{

            $model = new Chat();
            if ($model->loadAll(Yii::$app->request->post()) ) {
                if($model->mensaje != ""){
                    $model->id = Chat::find()->orderBy(['id' => SORT_DESC])->one()->id + 1 ;
                    if( $model->saveAll()){
                        $chats = Chat::find()->filterWhere(['id_instancia' => $model->id_instancia])->limit(100)->all();
                        $new_chat = new Chat();
                        $new_chat->id = Chat::find()->orderBy(['id' => SORT_DESC])->one()->id + 1 ;
                        $new_chat->id_user = Yii::$app->user->id;
                        $new_chat->id_instancia = $model->id_instancia;
                        $new_chat->fecha = \Yii::$app->formatter->asDate(DATE('Y-m-d H:i:s'), 'php:Y-m-d H:i:s');
                        return $this->renderAjax('/chat/_chat', ['chats' => $chats, 'new_chat' =>  $new_chat, ]);
                    }else{
                        echo "Error: ".$model->errors();
                    }
                }else{
                    //mensaje vacio recarga el chat
                    $chats = Chat::find()->filterWhere(['id_instancia' => $model->id_instancia])->limit(100)->all();
                    $new_chat = new Chat();
                    $new_chat->id = Chat::find()->orderBy(['id' => SORT_DESC])->one()->id + 1 ;
                    $new_chat->id_user = Yii::$app->user->id;
                    $new_chat->id_instancia = $model->id_instancia;
                    $new_chat->fecha = \Yii::$app->formatter->asDate(DATE('Y-m-d H:i:s'), 'php:Y-m-d H:i:s');
                    return $this->renderAjax('/chat/_chat', ['chats' => $chats, 'new_chat' =>  $new_chat, ]);
                }
            }
        }
    }

    /**
     * Lists Reglas.
     * @return mixed
     */
    public function actionReglas($id_instancia)
    {
        $reglas = Instancia::find()->filterWhere(['id' => $id_instancia])->one();
        return $this->renderAjax('reglas', [
            'reglas' => $reglas->reglas,
        ]);
    }

    /**
     * Lists Posiciones.
     * @return mixed
     */
    public function actionPosiciones($id_instancia)
    {
        $instancia_usuarios = InstanciaUser::find()
            ->joinWith('user')
            ->filterWhere(['id_instancia' => $id_instancia])
            ->andFilterWhere(['status' => 10])
            ->orderBy(['puntos'=> SORT_DESC])->all();
        return $this->renderAjax('posiciones', ['instancia_usuarios' => $instancia_usuarios,]);
    }


    /**
     * Displays a single Partido model.
     * @param integer $id
     * @param integer $id_local
     * @param integer $id_visitante
     * @return mixed
     */
    public function actionView($id, $id_local, $id_visitante)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title'=> "Partido #".$id, $id_local, $id_visitante,
                'content'=>$this->renderAjax('view', [
                    'model' => $this->findModel($id, $id_local, $id_visitante),
                ]),
                'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                    Html::a('Edit',['update','id, $id_local, $id_visitante'=>$id, $id_local, $id_visitante],['class'=>'btn btn-primary','role'=>'modal-remote'])
            ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id, $id_local, $id_visitante),
            ]);
        }
    }

    /**
     * Creates a new Partido model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Partido();
        $torneos =  ArrayHelper::map(Torneo::find()->orderBy(['id'=> SORT_DESC])->all(), 'id','nombre');
        $paises =  ArrayHelper::map(Pais::find()->all(), 'id','nombre');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($request->isGet){
                $model->id = (Partido::find()->orderBy(['id' => SORT_DESC])->one()->id)+1;
                $model->instancia = 'Octavos';
                $model->jugado = 0;
                $model->grupo = '';
                $model->goles_local = 0;
                $model->goles_visitante = 0;
                return [
                    'title'=> "Crear nuevo Partido",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model, 'torneos' => $torneos, 'paises' => $paises
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post())){
                $model->id = (Partido::find()->orderBy(['id' => SORT_DESC])->one()->id)+1;
                if ($model->save()){
                    return [
                        'forceReload'=>'#crud-datatable-pjax',
                        'title'=> "Crear nuevo Partido",
                        'content'=>'<span class="text-success">Create Partido success</span>',
                        'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                    ];
                }
            }else{
                return [
                    'title'=> "Crear nuevo Partido",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model, 'torneos' => $torneos, 'paises' => $paises
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) ) {
                $model->id = (Partido::find()->orderBy(['id' => SORT_DESC])->one()->id)+1;
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id, 'id_local' => $model->id_local, 'id_visitante' => $model->id_visitante]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model, 'torneos' => $torneos, 'paises' => $paises
                ]);
            }
        }

    }

    /**
     * Updates an existing Partido model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $id_local
     * @param integer $id_visitante
     * @return mixed
     */
    public function actionUpdate($id, $id_local, $id_visitante)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id, $id_local, $id_visitante);
        $torneos =  ArrayHelper::map(Torneo::find()->all(), 'id','nombre');
        $paises =  ArrayHelper::map(Pais::find()->all(), 'id','nombre');

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;

            if($request->isGet){
                return [
                    'title'=> "Update Partido #".$id, $id_local, $id_visitante,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model, 'torneos' => $torneos, 'paises' => $paises
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                        Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                //$this->calcularPuntos();
                //$puntos = var_dump(User::find()->all());
                //var_dump($puntos);

                $searchModel = new PartidoSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            }else{
                return [
                    'title'=> "Update Partido #".$id, $id_local, $id_visitante,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model, 'torneos' => $torneos, 'paises' => $paises
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
                return $this->redirect(['view', 'id' => $model->id, 'id_local' => $model->id_local, 'id_visitante' => $model->id_visitante]);
            } else {
                return $this->render('update', [
                    'model' => $model, 'torneos' => $torneos, 'paises' => $paises
                ]);
            }
        }
    }

    public function actionPuntuar($id_instancia){
        //control para ver si se paso la fecha del partido, si es asi lo pone como jugado = 1.
        $id_torneo = Instancia::findOne(['id' => $id_instancia])->id_torneo;
        $partidos = Partido::find()->where(['id_torneo' => $id_torneo,'jugado' => 0])->all();
        //var_dump( DATE("Y-m-d H:i") );

        foreach ($partidos as $partido){
            if ( $partido->fecha < DATE("Y-m-d") ){
                $partido->jugado = 1;
                $partido->save();
            }else{
                if( $partido->fecha == DATE("Y-m-d") ){
                    $hora_local = DATE('H') - 3;
                    echo $partido->hora." <= ".$hora_local;
                    if ($partido->hora <= $hora_local ){
                        echo "cierra";
                        $partido->jugado = 1;
                        $partido->save();
                    }
                    echo "fecha igual, hora menor";
                }
            }
        }
        $this->calcularPuntos($id_instancia);
        $instancias_user = InstanciaUser::find()->filterWhere(['id_user' => Yii::$app->user->getId(), 'id_instancia' => $id_instancia])->one();
        //return $this->redirect(['/partido/fixture', 'id_instancia' => $id_instancia ]);
    }

    public function calcularPuntos($id_instancia){
        //trae los usuarios inscriptos en el
        $usuarios  = InstanciaUser::find()->where(['id_instancia' => $id_instancia])->all();
        $id_torneo = Instancia::findOne(['id' => $id_instancia])->id_torneo;
        foreach ($usuarios as $u) {
            $partidos = Partido::find()->where(['id_torneo' => $id_torneo,'jugado' => 1])->all();
            $puntos = 0;
            foreach ($partidos as $partido) {
                //prediccion del usuario de este partido
                $prediccion = Prediccion::find()->where(['id_user' => $u->id_user, 'id_partido' => $partido->id,
                    'id_instancia' => $id_instancia])->one();
                //var_dump($prediccion);
                if( sizeof($prediccion) > 0){
                    if ( ($partido->goles_local == $prediccion->goles_local ) &&
                        ($partido->goles_visitante == $prediccion->goles_visitante) ) {
                        $puntos = $puntos + 3;
                    } else {
                        //aciertos del resultado
                        //resultado empate
                        if ($partido->goles_local == $partido->goles_visitante && $prediccion->resultado == 1) {
                            $puntos = $puntos + 1;
                        } else {
                            //resultado ganador local
                            if ($partido->goles_local > $partido->goles_visitante && $prediccion->resultado == 0) {
                                $puntos = $puntos + 1;
                            } else {
                                //resultado ganador visitante
                                if ($partido->goles_local < $partido->goles_visitante && $prediccion->resultado == 2) {
                                    $puntos = $puntos + 1;
                                }
                            }
                        }
                    }
                }
            }
            $u->puntos = $puntos;
            $u->save();
        }
    }



    /**
     * Delete an existing Partido model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_local
     * @param integer $id_visitante
     * @return mixed
     */
    public function actionDelete($id, $id_local, $id_visitante)
    {
        $request = Yii::$app->request;
        $this->findModel($id, $id_local, $id_visitante)->delete();

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
     * Delete multiple existing Partido model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $id_local
     * @param integer $id_visitante
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
     * Finds the Partido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $id_local
     * @param integer $id_visitante
     * @return Partido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $id_local, $id_visitante)
    {
        if (($model = Partido::findOne(['id' => $id, 'id_local' => $id_local, 'id_visitante' => $id_visitante])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
