<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Prediccion */
?>
<div class="prediccion-view white_opacity col-md-12 alert">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_user',
            'id_partido',
            'goles_local',
            'goles_visitante',
            'resultado',
        ],
    ]) ?>

</div>
