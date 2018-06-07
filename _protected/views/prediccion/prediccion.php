<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prediccion */

?>
<div class="prediccion-create white_opacity col-md-12 alert">
    <?php  echo $this->render('_form', ['model' => $model, 'partido' => $partido,]) ?>
</div>