<?php

use app\models\InstanciaUser;
use app\models\Prediccion;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<div id="id_instancia" class="hidden"><?= $instancia_torneo->id ?></div>
<?php $url = Url::toRoute(['/partido/posiciones', 'id_instancia' => $instancia_torneo->id]);?>
<div class="row" style="display: flex; justify-content: space-around">
    <div id="wrap_chat" class="col-md-6 col-sm-12">
        <?= $this->render('/chat/_chat', ['chats' => $chats, 'new_chat' =>  $new_chat, ]); ?>
    </div>
    <div class="modalButton boton_posiciones col-sm-12" value="<?= $url ?>" title="Posiciones" size="">
        <span class="glyphicon glyphicon-king"> </span> <span class="label_boton_posiciones">Ver Posiciones</span>
    </div>
</div>
<!-- PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD -->
<?= $this->render('/partido/publicidad'); ?>
<!-- PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD -->

<div class="row">
    <h1 class="nombre_torneo alert alert-info col-md-12 col-xs-12" style="width: auto;text-align: center" ><?= "Torneo ".$instancia_torneo->nombre.", ".$torneo->nombre?></h1>
    <?php $i = 1;
    foreach($partidos as $p){
    $puntos = "";
    $prediccion = Prediccion::find()->where(['id_partido' => $p->id, 'id_user' => $id_user, 'id_instancia' => $instancia_torneo->id])->one();
    //clase de la fila si le pega o no al resultado
    $clase = "alert alert-danger";
    if($p->jugado == 1){ ?>
        <?php
        $puntos = 0;
        $clase = "alert alert-danger";
        if(sizeof($prediccion) > 0){
            //Resultado exacto
            if ($p->goles_local == $prediccion->goles_local && $p->goles_visitante == $prediccion->goles_visitante) {
                $clase = "alert alert-success";
                $puntos = 3;
            }else {
                //resultado empate
                if ( ($p->goles_local == $p->goles_visitante) && $prediccion->resultado == 1){
                    $clase = "alert alert-info";
                    $puntos = 1;
                }
                //resultado ganador local
                if ($p->goles_local > $p->goles_visitante && $prediccion->resultado == 0){
                    $clase = "alert alert-info";
                    $puntos = 1;
                }
                //resultado ganador visitante
                if ($p->goles_local < $p->goles_visitante && $prediccion->resultado == 2){
                    $clase = "alert alert-info";
                    $puntos = 1;
                }
            }
        }
    } else $clase = "";
    if ($i % $partidos_por_grupo == 1 ) {
    $url = Url::toRoute(['/prediccion/grupo_prediccion','id_user' => $id_user,'grupo' => $p->grupo, 'id_instancia' => $instancia_torneo->id]);
    //encabezados de las tablas    ?>
    <div class="col-md-12 col-xs-12 col-sm-12">
        <table class="table table-responsive modalButton white_opacity tabla_grupo" value="<?= $url ?>" title="Predicciones" size="modal-sm"
               style="margin-left: auto;margin-right:auto;text-align: center;cursor: pointer" data-target="#modal">
            <thead style="border: 2px solid #ddd">
            <tr style="font-size: 18px">
                <th></th>
                <th class="relleno"></th>
                <th>Grupo</th><th class="relleno"></th>
                <th><?php echo $p->grupo ?></th>
                <th class="relleno"></th>
                <th class="relleno"></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr style="text-align: center">
                <th >Equipos</th>
                <th class="relleno"></th>
                <th >Resultado</th>
                <th class="relleno"></th>
                <th >Prediccion</th>
                <th class="relleno"></th>
                <th >Fecha</th>
                <th >Hora</th>
                <th class="relleno">Lugar</th>
                <th>Ptos</th>
            </tr>
            </thead>
            <tbody style="border: 2px solid #ddd">
            <?php } ?>
            <?php $goles_local = sizeof($prediccion) > 0 ? $prediccion->goles_local : '0'?>
            <?php $goles_visitante = sizeof($prediccion) > 0 ? $prediccion->goles_visitante : '0'?>
            <?php //cuerpo de las tablas ?>
            <tr class="<?= $clase ?>">
                <td class="t_td"><div><span> <?= $p->local_nombre?></span><span></span><span> <?=$p->visitante_nombre ?></span></div></td>
                <td class="relleno">|</td>
                <td class="t_td"><div><span><?= $p->goles_local ?></span><span><?= $p->goles_visitante ?></span></div></td>
                <td class="relleno">|</td>
                <td class="t_td"><div><span><?= $goles_local ?></span><span><?= $goles_visitante ?></span></div></td>
                <td class="relleno">-</td>
                <td><?php $date = new DateTime($p->fecha); echo date_format($date,"d-m") ?></td>
                <td><?php echo $p->hora ?></td>
                <td class="relleno"><?php echo $p->lugar ?></td>
                <td><?php echo $puntos ?></td>
            </tr>
            <?php if ($i % $partidos_por_grupo == 0) { ?>
            </tbody>
        </table>
    </div>
    <?php if ($i%12 == 0){ ?> </div> <div class="clearfix"></div><div class="row"> <?php } ?>
    <?php }
    ++$i;
    } ?>

</div>
<!-- PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD -->
<?= $this->render('/partido/publicidad'); ?>
<!-- PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD PUBLICIDAD -->
