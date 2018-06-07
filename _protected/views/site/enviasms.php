<?php




/* VERIFICO LA EMPRESA Y SELECCIONO EL SERVER */
/*
Movistar
@sms.movistar.net.ar
@e-mocion.net.ar (creo que ya no está activo) ex unifon
@movimensaje.com.ar (creo que ya no está activo) ex movicom

Personal
@personal-net.com.ar

CTI @infotext.cti.com.ar (creo que ya no está activo)
@sms.ctimovil.com.ar

Conectel
@conectel.com.ar

Nextel
@nextel.net.ar

Skytel
@skytel.com.ar

//Para Personal // */

if ($empresasms=="01" ) {
    $server= 'personal-net.com.ar';
}

if ($empresasms == "02" ) {
    $server= 'sms.ctimovil.com.ar';
}

if ($empresasms == "06" ) {
    $server= 'sms.movistar.net.ar';
}

if ($empresasms == "07" ) {
    $server= 'nextel.net.ar';
}

if ($empresasms == "08" ) {
    $server= 'skytel.com.ar';
}

if ($empresasms == "09" ) {
    $server= 'conectel.com.ar';
}

$mensaje = wordwrap($mensaje, 100);
echo $mensaje;

$destinatario = $numero.'@'.$server;

$para = $destinatario;
$asunto = 'CiberCentro SMS';
$cabeceras = 'From: estoy@sin-etiketa.com.ar' . "\r\n" .
    'Reply-To: estoy@sin-etiketa.com.ar' . "\r\n" .
    'X-Mailer: PHP/';

mail($para, $asunto, $mensaje, $cabeceras);
$texto= $destinatario. '<br>'. $mensaje ;

mail('soporteargentina@gmail.com','SMS ENVIADO!!!',$texto,'FROM: $emailenvia');
echo 'El mensaje fue enviado!!! a '.$destinatario;


?>