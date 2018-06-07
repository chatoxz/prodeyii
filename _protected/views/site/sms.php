<?php // http://www.forosdelweb.com/f18/codigo-php-para-envio-sms-948437/ ?>

<html>
<head>
    <title>Documento sin t&iacute;tulo</title>
    <meta http-equiv="" content="text/html; charset=iso-8859-1">
    <link href="main.css" rel="stylesheet" type="text/css">
    <meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"><meta http-equiv="" content="text/html; charset=iso-8859-1"></head>

<body>
<form action="/site/enviasms.php" method="get" name="enviamensaje" id="enviamensaje">
    <p align="center"><font color="#3E7B7B" size="4" face="Georgia, Times New Roman, Times, serif"><strong>Envio
                de SMS</strong></font></p>
    <table width="69%" border="0" align="center" cellpadding="0" cellspacing="0" class="RecuadroTabla">
        <tr>
            <td width="47%" class="texto"><div align="right">Numero de Celular</div></td>
            <td width="5%">&nbsp;</td>
            <td width="48%"><input name="numerocel" type="text" class="textbox" id="numerocel" size="40"></td>
        </tr>
        <tr>
            <td class="texto"><div align="right">Empresa</div></td>
            <td>&nbsp;</td>
            <td><select name="empresa" class="textbox" id="select">
                    <option value="01">Argentina - PERSONAL: (ca + nº sin 0 ni 15)</option>
                    <option value="02">Argentina - CTI: (ca + nº sin 0 ni 15)</option>
                    <option value="06">Argentina - VOMISTAR: (ca + nº sin 0 ni 15)</option>
                    <option value="07">Argentina - NEXTEL: (ca + nº sin 0 ni 15)</option>
                    <option value="08">Argentina - SKYTEL: (ca + nº sin 0 ni 15)</option>
                    <option value="09">Argentina - CONECTEL: (ca + nº sin 0 ni 15)</option>
                </select></td>
        </tr>
        <tr>
            <td class="texto"><div align="right">Tu Nombre</div></td>
            <td>&nbsp;</td>
            <td><input name="nombre" type="text" class="textbox" id="nombre2" size="40">
            </td>
        </tr>
        <tr>
            <td valign="top" class="texto"><div align="right">Mensaje</div></td>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2"><textarea name="mensajeenv" cols="35" class="textbox" id="mensajeenv"></textarea></td>
        </tr>
        <tr>
            <td><div align="right"></div></td>
        </tr>
        <tr>
            <td height="23">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3"><div align="center">
                    <input name="Submit" type="submit" class="boton" value="Enviar SMS">
                </div></td>
        </tr>
    </table>
</form>
<table width="523" border="0" align="center" cellpadding="0" cellspacing="0">
    <!--DWLayoutTable-->
</body>
</html>