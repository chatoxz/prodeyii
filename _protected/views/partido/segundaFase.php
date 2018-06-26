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
<br>
<br>
<br>
<br>
<div style="font-family: myFirstFont;opacity: 0.95" class="container-fluid just_white" >
    <br>
    <div class="row seven-cols relleno" style="display: flex;justify-content: space-around;flex-wrap: wrap; font-size: 20px;" >
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Octavos</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Cuartos</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Semifinal</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Finales</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Semifinal</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Cuartos</div>
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">Octavos</div>
    </div>
    <br>
    <div class="row seven-cols" style="display: flex;justify-content: space-around;flex-wrap: wrap" >
        <!-- OCTAVOS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Octavos</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[0], 'alineacion' => $der, 'id_instancia' => $id_instancia ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[1], 'alineacion' => $der, 'id_instancia' => $id_instancia ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[2], 'alineacion' => $der, 'id_instancia' => $id_instancia ]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[3], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- CUARTOS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Cuartos</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[0], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[1], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- SEMIS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Semifinal</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $semis[0], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- FINALES -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <div><img src="/themes/light/img/copa_mundo.jpg" width="20"></div>
            <br>
            <h4 class="visible-sm visible-xs">Final</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $final[0], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
            <h4 class="visible-sm visible-xs">Tercer Puesto</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $tercer[0], 'alineacion' => $der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- SEMIS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Semifinal</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $semis[1], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- CUARTOS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Cuartos</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[2], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $cuart[3], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
        <!-- OCTAVOS -->
        <div class="wrap_inst_seg_fase col-md-1 col-sm-6 col-xs-12 ">
            <h4 class="visible-sm visible-xs">Octavos</h4>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[4], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[5], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[6], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
            <?= $this->render('/partido/_partidoSegFase',
                ['partido'=> $oct[7], 'alineacion' => !$der, 'id_instancia' => $id_instancia]); ?>
        </div>
        
    </div>
</div>

