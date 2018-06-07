<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\InstanciaRegla */

$this->title = 'Create Instancia Regla';
$this->params['breadcrumbs'][] = ['label' => 'Instancia Regla', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instancia-regla-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
