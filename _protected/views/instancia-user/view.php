<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\InstanciaUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancia User', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instancia-user-view white_opacity col-md-12 alert">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Instancia User'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'attribute' => 'user.username',
            'label' => 'Id User',
        ],
        [
            'attribute' => 'instancia.id',
            'label' => 'Id Instancia',
        ],
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
    <div class="row">
        <h4>User<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnUser = [
        ['attribute' => 'id', 'visible' => false],
        'username',
        'email',
        'password_hash',
        'status',
        'auth_key',
        'password_reset_token',
        'account_activation_token',
        'puntos',
    ];
    echo DetailView::widget([
        'model' => $model->user,
        'attributes' => $gridColumnUser    ]);
    ?>
</div>
