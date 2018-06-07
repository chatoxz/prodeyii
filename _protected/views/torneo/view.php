<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Torneo */
?>
<div class="torneo-view white_opacity col-md-12 alert">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'fecha_inicio',
            'fecha_fin',
        ],
    ]) ?>

</div>
