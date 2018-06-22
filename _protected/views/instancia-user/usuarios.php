<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\InstanciaUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Instancia User';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="instancia-user-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?php //echo Html::a('Create Instancia User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="search-form" style="display:none">
        <?php //echo  $this->render('_search', ['model' => $searchModel]); ?>
    </div>
      -->
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'id_user',
            'label' => 'Id User',
            'value' => function($model){
                if ($model->user)
                {return $model->user->username;}
                else
                {return NULL;}
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->joinWith('instancia')->filterWhere('id_instancia')->asArray()->all(), 'id', 'username'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-instancia-user-search-id_user']
        ],
        [
            'attribute' => 'puntos',
            'label' => 'Puntos + Handicap',
        ],
       [
            'attribute' => 'handicap',
            'label' => 'Handicap',
        ],
        /* [
             'attribute' => 'id_instancia',
             'label' => 'Id Instancia',
             'value' => function($model){
                 if ($model->instancia)
                 {return $model->instancia->id;}
                 else
                 {return NULL;}
             },
             'filterType' => GridView::FILTER_SELECT2,
             'filter' => \yii\helpers\ArrayHelper::map(\app\models\Instancia::find()->asArray()->all(), 'id', 'id'),
             'filterWidgetOptions' => [
                 'pluginOptions' => ['allowClear' => true],
             ],
             'filterInputOptions' => ['placeholder' => 'Instancia', 'id' => 'grid-instancia-user-search-id_instancia']
         ],*/
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($model,$key,$index) {
                    $url = Url::toRoute(['/instancia-user/delete','id' => $key->id]);
                    return Html::a(
                        '<span style="padding-right: 10px;" class="glyphicon glyphicon-trash" title="ELIMINAR USUARIO DEL TORNEO"></span>','#',[
                            'title' => Yii::t('yii', 'Delete'),
                            //'method' => 'post',
                            'confirm' => 'Desea eliminar el usuario?',
                            'class' => 'modalButton',
                            'value' => $url
                        ]
                    );
                },
            ],
        ],
    ];
    ?>


    <?= GridView::widget([
        'id' => 'kv-pjax-container-instancia-user',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-instancia-user']],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => '<span class="glyphicon glyphicon-user"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
        // your toolbar can include the additional full export menu
        /*'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_PDF => false
                ]
            ]) ,
        ],*/
    ]); ?>
</div>
