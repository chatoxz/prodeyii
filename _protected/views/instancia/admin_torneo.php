<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstanciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Instancias';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="instancia-index just_white col-md-12 alert">

    <h1>Mis Torneos</h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php $url = Url::toRoute(['/instancia/create', 'id_user' => Yii::$app->user->id]);?>
       <!-- <?= Html::a('Crear Torneo', '#', ['class' => 'btn btn-success modalButton', 'value' => $url ]) ?>-->

    <div class="modalButton boton_posiciones" value="<?= $url ?>" title="Posiciones" size="">
        <span class="glyphicon glyphicon-king"> </span> <span class="label_boton_posiciones">Crear Torneo</span>
    </div>

        <!-- <?= Html::a('Advance Search', '#', ['class' => 'btn btn-info search-button']) ?>-->
    </p>
    <br>
    <div class="search-form" style="display:none">
        <?=  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'torneo_nombre',
        'nombre',
        //'max_participantes',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{usuarios}',
            'buttons' => [
                'update' => function ($model,$key,$index) {
                    $url = Url::toRoute(['/instancia/update','id' => $key->id]);
                    return Html::a(
                        '<span style="padding-right: 10px;" class="glyphicon glyphicon-pencil" title="Actualizar Torneo"></span>','#',
                        $options = ['class' => 'modalButton','value' => $url, 'title' => 'Actualizar Torneo',]);
                },
                'usuarios' => function ($model,$key,$index) {
                    $url = Url::toRoute(['/instancia-user/usuarios','id_instancia' => $key->id]);
                    return Html::a(
                        '<span style="padding-right: 10px;" class="glyphicon glyphicon-user" title="Participantes"></span>','#',
                        $options = ['class' => 'modalButton','value' => $url, 'title' => 'Usuarios',]);
                },
            ],
        ],
    ];
    ?>
    <?= GridView::widget([
        'id' => 'id_gridview',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'id_gridview']],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
    ]); ?>

</div>
