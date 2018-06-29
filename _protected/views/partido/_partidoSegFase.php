<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 22/6/2018
 * Time: 17:58
 */

use yii\helpers\Url;

/* @var $model app\models\Partido */

?>

<?php $url = Url::toRoute(['/prediccion/seg_fase_pred', 'id_prediccion' => $partido->prediccion_id,
    'id_partido' => $partido->id, 'id_instancia' => $id_instancia, 'jugado' => $partido->jugado]);?>
<?php
if($partido->jugado == 1){ ?>
    <?php
    $puntos = 0;
    $clase = "alert alert-danger";
    //Resultado exacto
    if ($partido->goles_local == $partido->prediccion_goles_local && $partido->goles_visitante == $partido->prediccion_goles_visitante) {
        $clase = "alert alert-success";
        $puntos = 3;
    }else {
        //resultado empate
        if ( ($partido->goles_local == $partido->goles_visitante) && $partido->prediccion_resultado == 1){
            $clase = "alert alert-info";
            $puntos = 1;
        }
        //resultado ganador local
        if ($partido->goles_local > $partido->goles_visitante && $partido->prediccion_resultado == 0){
            $clase = "alert alert-info";
            $puntos = 1;
        }
        //resultado ganador visitante
        if ($partido->goles_local < $partido->goles_visitante && $partido->prediccion_resultado == 2){
            $clase = "alert alert-info";
            $puntos = 1;
        }
    }
} else $clase = "alert alert-warning";
?>
<div class="modalButton wrap_partido_seg_fase <?= $clase?>"  value="<?= $url ?>" title="Instancia <?= $partido->instancia ?>" size="modal-sm" style="">
    <div class="equipo_part_seg_fase  " >
        <div><img class="pais_flag" src="/themes/light/img/flags/<?= $partido->local_nombre ?>.png" width="20px" alt=""> <?= $partido->local->abreviatura ?></div>
        <div><?= $partido->goles_local; ?></div>
        <div><?php if ($partido->prediccion_goles_local == '') echo 0; else echo $partido->prediccion_goles_local ?></div>
    </div>
    <div class="equipo_part_seg_fase ">
        <div><img class="pais_flag" src="/themes/light/img/flags/<?= $partido->visitante_nombre ?>.png" width="20px" alt=""> <?= $partido->visitante->abreviatura ?></div>
        <div><?= $partido->goles_visitante ?></div>
        <div><?php if ($partido->prediccion_goles_visitante == '') echo 0; else echo $partido->prediccion_goles_visitante ?></div>
    </div>
    <?php $date = date_format(new DateTime($partido->fecha),"d-m"); ?>
    <div class="fecha_hora_part_seg_fase" ><span><?= $date ?></span><span> <?= $partido->hora ?></span></div>
</div>
