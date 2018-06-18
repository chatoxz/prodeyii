<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */
?>
<div class="partido-update ">
    <?php
    $this->registerJs('$("#modal-content").addClass("white_opacity col-md-12 alert"); ');
    if ( $guardado ) {
        $modal_hide = <<<'javascript'
    setTimeout(function(){ 
    $("#ajaxCrudModal").find("#modal-body").html("<h3>Guardado</h3>");
    //$('#ajaxCrudModal').modal('toggle'); 
    }, 1000);
javascript;
        $this->registerJs($modal_hide);
    } else{
        echo $this->render('_form', [
            'model' => $model, 'torneos' => $torneos, 'paises' => $paises
        ]);
    } ?>
</div>
