<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InstanciaRegla */

$this->title = 'Save As New Instancia Regla: '. ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instancia Regla', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'id_instancia' => $model->id_instancia]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="instancia-regla-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
