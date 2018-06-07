<?php
/**
 * Created by PhpStorm.
 * User: chatoxz
 * Date: 8/5/2018
 * Time: 13:45
 */
?>

<div style="margin: 10px 40px;" >
    <table class="tabla_posiciones table table-hover " >
        <thead style="border: 2px solid #ddd">
        <th>Usuario</th>
        <th>Ptos</th>
        </thead>
        <tbody style="border: 2px solid #ddd">
        <?php
        foreach ( $instancia_usuarios as $u ) { ?>
            <tr>
                <td ><?= $u->getUser_nombre() ;?></td>
                <td ><?= $u->puntos ;?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
