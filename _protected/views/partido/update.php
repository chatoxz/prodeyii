<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */
?>
<div class="partido-update white_opacity col-md-12 alert">

    <?= $this->render('_form', [
        'model' => $model, 'torneos' => $torneos, 'paises' => $paises
    ]) ?>

</div>
