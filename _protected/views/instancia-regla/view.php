<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\InstanciaRegla */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancia Regla', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instancia-regla-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Instancia Regla'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->id, 'id_instancia' => $model->id_instancia], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->id, 'id_instancia' => $model->id_instancia], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id, 'id_instancia' => $model->id_instancia], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'instancia.id',
            'label' => 'Id Instancia',
        ],
        'regla:ntext',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>Instancia<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnInstancia = [
        ['attribute' => 'id', 'visible' => false],
        'id_torneo',
        'nombre',
        'max_participantes',
    ];
    echo DetailView::widget([
        'model' => $model->instancia,
        'attributes' => $gridColumnInstancia    ]);
    ?>
</div>
