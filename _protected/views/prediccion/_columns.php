<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Usuario',
        'attribute'=>'username',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_partido',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'local',
        'attribute'=>'local_nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'vis',
        'attribute'=>'visitante_nombre',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'goles_local',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'goles_visitante',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'resultado',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Inst.',
        'attribute'=>'id_instancia',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_at',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {
            return Url::to([$action,'id'=>$model->id, 'id_user' => $model->id_user,'id_partido' => $model->id_partido ]);
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