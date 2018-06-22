<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Instancia */

$this->title = 'Create Instancia';
$this->params['breadcrumbs'][] = ['label' => 'Instancias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instancia-create">

    <?= $this->render('_form', [
        'model' => $model,
        'torneos' => $torneos,
    ]) ?>

</div>
