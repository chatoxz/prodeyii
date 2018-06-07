<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Instancia */

$this->title = 'Update Instancia: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instancia-update white_opacity col-md-12 alert">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'torneos' => $torneos,
    ]) ?>

</div>
