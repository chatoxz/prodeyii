<?php
use yii\helpers\Url;

return [
    /* [
         'class' => 'kartik\grid\CheckboxColumn',
         'width' => '20px',
     ],
     [
         'class' => 'kartik\grid\SerialColumn',
         'width' => '30px',
     ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'local_nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'visitante_nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Torneo',
        'attribute'=>'torneo_nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hora',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'lugar',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'instancia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'GL',
        'attribute'=>'goles_local',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'GV',
        'attribute'=>'goles_visitante',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'jugado',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'grupo',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$model->id, 'id_local' => $model->id_local,'id_visitante' => $model->id_visitante ]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
            'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
            'data-request-method'=>'post',
            'data-toggle'=>'tooltip',
            'data-confirm-title'=>'Are you sure?',
            'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];   