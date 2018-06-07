<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InstanciaUser */

$this->title = 'Update Instancia User: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancia User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instancia-user-update white_opacity col-md-12 alert">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
