<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 15/6/2018
 * Time: 09:57
 */

use yii\helpers\Url;

?>
<?php
$der = true;
?>
<div style="" class="row just_white">
    <div class="col-md-12">
        <h1> Segunda fase </h1>
    </div>

    <div class="col-md-12" style="display: flex;justify-content: space-around" >
        <!-- OCTAVOS -->
        <?php $url = Url::toRoute(['/partido/seg_fase_pred','id_partido' => $oct[0]->id, 'id_prediccion' => $oct[0]->prediccion_id]);?>
        <div class="wrap_part_seg_fase modalButton" value="<?= $url ?>" title="Posiciones" size="">
            <h3>Octavos</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[0], 'alineacion' => $der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[1], 'alineacion' => $der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[2], 'alineacion' => $der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[3], 'alineacion' => $der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- CUARTOS -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Cuartos</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[0], 'alineacion' => $der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[1], 'alineacion' => $der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- SEMIS -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Semifinal</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $semis[0], 'alineacion' => $der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- FINALES -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Final</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $final[0], 'alineacion' => $der ]); ?>
            <h3>Tercer Puesto</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $tercer[0], 'alineacion' => $der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- SEMIS -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Semifinal</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $semis[1], 'alineacion' => !$der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- CUARTOS -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Cuartos</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[2], 'alineacion' => !$der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[3], 'alineacion' => !$der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <!-- OCTAVOS -->
        <div class="wrap_part_seg_fase modalButton " value="<?= $url ?>" title="Posiciones" size="">
            <h3>Octavos</h3>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[4], 'alineacion' => !$der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[5], 'alineacion' => !$der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[6], 'alineacion' => !$der ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[7], 'alineacion' => !$der ]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
    </div>
</div>

