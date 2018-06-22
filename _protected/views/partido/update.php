<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */
?>
<div class="partido-update ">
    <?php
    if ( $guardado ) {
        $modal_hide = <<<'javascript'
    setTimeout(function(){ 
    $("#ajaxCrudModal").find("#modal-body").html("<h3>Guardado</h3>");
    $('#ajaxCrudModal').modal('toggle'); 
    }, 3000);
javascript;
        $this->registerJs($modal_hide);
    } else{
        echo $this->render('_form', [
            'model' => $model, 'torneos' => $torneos, 'paises' => $paises
        ]);
    } ?>
</div>
