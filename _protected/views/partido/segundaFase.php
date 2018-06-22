<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 15/6/2018
 * Time: 09:57
 */
?>
<div style="" class="row just_white">
    <!--<img style="position: absolute;height: calc(100% - 60px);width: 100%;opacity: 0.7;margin: 0px !important;padding: 0px !important;" src="" />-->
    <div class="col-md-12">
    <h1> Segunda fase </h1>
    </div>
    <div class="col-md-12 " >
        <div class="col-md-2" style="float: left">
            <h3>Octavos</h3>
            <?= $this->render('/partido/_partidoSegFase',['partido'=> $octavos[0]]); ?>
            <?= $this->render('/partido/_partidoSegFase',['partido'=> $octavos[1]]); ?>
            <?= $this->render('/partido/_partidoSegFase',['partido'=> $octavos[2]]); ?>
            <?= $this->render('/partido/_partidoSegFase',['partido'=> $octavos[3]]); ?>
        </div>
        <div class="clearfix visible-xs"></div>
        <div class="col-md-2" style="float: right">
            <h3>Octavos</h3>
            <?= $this->render('/partido/partidoSegFase',['partido'=> $octavos[0],'id_instancia_user'=>$id_instancia_user]); ?>
            <?= $this->render('/partido/partidoSegFase',['partido'=> $octavos[1],'id_instancia_user'=>$id_instancia_user]); ?>
            <?= $this->render('/partido/partidoSegFase',['partido'=> $octavos[2],'id_instancia_user'=>$id_instancia_user]); ?>
            <?= $this->render('/partido/partidoSegFase',['partido'=> $octavos[3],'id_instancia_user'=>$id_instancia_user]); ?>
        </div>
    </div>
</div>

