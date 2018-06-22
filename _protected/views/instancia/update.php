<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Instancia */

$this->title = 'Update Instancia: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instancia-update">

    <?= $this->render('_form', [
        'model' => $model,
        'torneos' => $torneos,
    ]) ?>

</div>
