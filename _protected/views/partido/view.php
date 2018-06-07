<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Partido */
?>
<div class="partido-view white_opacity col-md-12 alert">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_local',
            'id_visitante',
            'id_torneo',
            'fecha',
            'hora',
            'lugar',
            'instancia',
            'goles_local',
            'goles_visitante',
            'jugado',
            'grupo',
        ],
    ]) ?>

</div>
