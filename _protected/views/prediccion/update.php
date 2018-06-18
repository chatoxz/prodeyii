<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Prediccion */
?>
<div class="prediccion-update">
    <?php $this->registerJs('$("#modal-content").addClass("white_opacity col-md-12 alert"); '); ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
