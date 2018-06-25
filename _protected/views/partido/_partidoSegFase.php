<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 22/6/2018
 * Time: 17:58
 */
?>
<?php $class = $alineacion ? "part_alineacion_der" : "part_alineacion_izq"; ?>
<?php $class = ($partido->instancia == 'Final' || $partido->instancia == 'Tercer') ? "part_alineacion_centro" : $class; ?>
<div class="part_seg_fase  <?= $class ?>" style="border-top: 1px solid grey;">
    <div><?= $partido->local->abreviatura ?></div>
    <div><?= $partido->goles_local ?></div>
    <div><?= $partido->prediccion_goles_local ?></div>
</div>
<div class="part_seg_fase <?= $class ?>" style="border-bottom: 1px solid grey;">
    <div><?= $partido->visitante->abreviatura ?></div>
    <div><?= $partido->goles_visitante ?></div>
    <div><?= $partido->prediccion_goles_visitante ?></div>
</div>
<br><br>
