<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chat */

$this->title = 'Save As New Chat: '. ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="chat-create white_opacity col-md-12 alert">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
