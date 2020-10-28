<?php 
include '../../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
////DIA CREACION/////////////
$dia     = date("d");
$año     = date("Y");
$obt_mes = date("m");
//////DIA +1///////
$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
$dia_mas = substr($nuevafecha,-2);
$mes_mas = substr($nuevafecha,5,-3);
$año_mas = substr($nuevafecha,0,-6);

$folio = $_GET['folio'];
$mes       = "";
$mes_nuevo = "";
$contadores = "";

switch ($obt_mes) {
    case 1:
        $mes = "Enero";
        break;
    case 2:
        $mes = "Febrero";
        break;
    case 3:
        $mes = "Marzo";
        break;
    case 4:
        $mes = "Abril";
        break;
    case 5:
        $mes = "Mayo";
        break;
    case 6:
        $mes = "Junio";
        break;
    case 7:
        $mes = "Julio";
        break;
    case 8:
        $mes = "Agosto";
        break;
    case 9:
        $mes = "Septiembre";
        break;
    case 10:
        $mes = "Octubre";
        break;
    case 11:
        $mes = "Noviembre";
        break;
    case 12:
        $mes = "Diciembre";
        break;
}
switch ($mes_mas) {
    case 1:
        $mes_nuevo = "Enero";
        break;
    case 2:
        $mes_nuevo = "Febrero";
        break;
    case 3:
        $mes_nuevo = "Marzo";
        break;
    case 4:
        $mes_nuevo = "Abril";
        break;
    case 5:
        $mes_nuevo = "Mayo";
        break;
    case 6:
        $mes_nuevo = "Junio";
        break;
    case 7:
        $mes_nuevo = "Julio";
        break;
    case 8:
        $mes_nuevo = "Agosto";
        break;
    case 9:
        $mes_nuevo = "Septiembre";
        break;
    case 10:
        $mes_nuevo = "Octubre";
        break;
    case 11:
        $mes_nuevo = "Noviembre";
        break;
    case 12:
        $mes_nuevo = "Diciembre";
        break;
}

mysqli_set_charset($conexion,'utf8');
$consulta=mysqli_query($conexion,"SELECT
                                        SUM(resultado)
                                    FROM
                                        prestamos_morralla
                                    WHERE
                                        folio = '$folio' AND activo = '1'");
$row =mysqli_fetch_row($consulta);

ini_set('max_execution_time', 500);
mysqli_set_charset($conexion,'utf8');
$consulta2=mysqli_query($conexion,"SELECT sucursales.id,sucursales.direccion
                                    FROM prestamos_morralla
                                    INNER JOIN sucursales ON sucursales.id = prestamos_morralla.id_sucursal
                                    WHERE prestamos_morralla.folio = '$folio'
                                    AND prestamos_morralla.activo = '1'");
$row2=mysqli_fetch_row($consulta2);

$consulta3=mysqli_query($conexion,"SELECT
                                        CONCAT(
                                            personas.nombre,
                                            ' ',
                                            personas.ap_paterno,
                                            ' ',
                                            personas.ap_materno
                                        ) AS Nomb
                                    FROM
                                        usuarios
                                    INNER JOIN personas ON personas.id = usuarios.id_persona
                                    WHERE
                                        usuarios.id_perfil = '10'
                                    AND personas.id_sede = '$row2[0]'");
$cantidad = mysqli_num_rows($consulta3);
$numero = 1;

while ($row_usuarios = mysqli_fetch_array($consulta3)){
    if($numero == $cantidad){
        $contadores .= $row_usuarios[0];
    }
    else{
        $contadores .= $row_usuarios[0].'/ ';
    }
    $numero ++;
}

$consulta4=mysqli_query($conexion,"SELECT
                                        morralla,
                                        resultado
                                    FROM
                                        prestamos_morralla
                                    WHERE
                                        folio = '$folio' AND activo = '1'");

$consulta5 =mysqli_query($conexion,"SELECT
                                        CONCAT(
                                            personas.nombre,
                                            ' ',
                                            personas.ap_paterno,
                                            ' ',
                                            personas.ap_materno
                                        ) AS Nom,
                                    perfil.nombre,
                                    personas.departamento,
                                    firmas.id
                                    FROM
                                        firmas
                                    INNER JOIN personas ON personas.id = firmas.id_persona
                                    INNER JOIN usuarios ON usuarios.id = firmas.id_usuario
                                    INNER JOIN perfil ON perfil.id = usuarios.id_perfil
                                    WHERE
                                        firmas.activo = '1'");
$row_firma = mysqli_fetch_array($consulta5);
//////////////////////FUNCION PARA CONVERTIR A LETRAS//////////////////////////

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}


$cantidad_letras = numtoletras($row[0]);               
?>
<style type="text/css">

table
{
    width:  90%;
    border: solid 0px #5544DD;
    margin:auto;
}

table.borde
{
    width:  90%;
    border: solid 1px #D8D8D8;
    margin:auto;
}
th
{
    text-align: center;
    border: solid 0px #113300;
    background: #EEFFEE;
}
th.borde
{
    text-align: center;
    border: solid 1px #D8D8D8;
    background: #EEFFEE;
}
td
{
    text-align: left;
    border: solid 0px #55DD44;
}

td.borde
{
    text-align: left;
    border: solid 1px #D8D8D8;
}
td.col1
{
    border: solid 0px red;
    text-align: right;
}
/*hojas de estilo propia*/
img{
    width: 60%;
}
.gris{
    background: #dcdcdc;
}
.verde{
    background: #1B5E20;
}
.rojo{
    background: #F10B0B;
}
    
.blanco{
     color: #FFFFFF;    
}



/*letras*/
.mchico{font-size: 1px; margin-top: 0px} 
.chico{font-size: 8px; margin-top: 0px}  
.mediano{font-size: 10px; margin-top: 0px}  
.grande{font-size:13px; margin-top: 0px}
.subrayado{text-decoration: underline;} 
.firma {font-size: 10px;font-style: italic;}

.subArriba{
    text-decoration: overline;
}
label{
     margin: 14px 0px 0px 0px;
}
.ancho{width:20px; };

.bajo{
    display: block;
    margin: 15px 0px 0px 0px;
    background: #ccc;
}
    
/**/
.punteado{ 
  border-style: dotted; 
  	border-width: 3px; 
  	border-color: #FF0000; 
/*  	background-color: #cc3366; */
/*  	//font-family: verdana, arial; */
  	font-size: 10pt; 
} 
</style>

<br>
<br>
<br>
<br>
<br>
<br>
<table>
    <col style="width: 20%" class="col1">
    <col style="width: 70%" class="col1">
    <tr>
        <td align="left">
            <!-- <img src="../../d_plantilla/dist/img/logo.png" width="150"> -->
        </td>
        <td align="right">
            <h4>Linares, Nuevo León a <?php echo $dia;?> de <?php echo $mes;?> de <?php echo $año;?></h4>
        </td>
    </tr>
</table>
<table>
    <col style="width: 20%" class="col1">
    <col style="width: 80%" class="col1">
    <col style="width: 10%" class="col1">
    <tr>
        <td align="left">  
        </td>
        <td align="ceter">
            <b>&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;CARTA SOLICITUD DE REMESA<br>
            </b>
        </td>
        <td align="right">
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
            <b>BANCO SANTANDER, México S.A</b>
        </td>
    </tr>
    <tr>
        <td align="left">
            <b>Caja General: Norte Noreste</b>
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
            Por este medio solicitamos se realicen las gestiones necesarias para que me sea enviada una remesa de efectivo por un importe de <b>$<?php echo $row[0]?> (<?php echo $cantidad_letras;?>)</b> en las denominaciones que más adelante se detallan y nos sea entregada por la compañía de traslado de valores <b>(SERVICIO PANAMERICANO DE PROTECCION, S.A DE C.V.)</b> en el Domicilio: <?php echo $row2[1];?>, el día <?php echo $dia_mas.'-'.$mes_nuevo.'-'.$año_mas;?> a la atención del Sr.(ita). <?php echo $contadores;?>.
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
             Asimismo autorizamos a Banco Santander México, S.A. a realizar los cargos tanto del importe de la remesa, costo de la preparación a nuestra cuenta de cheques <b>No. 065501533186.</b>
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
             Desglose de la remesa solicitada:
        </td>
    </tr>
</table>
<br>
<table style="width: 95%" cellpadding="0" cellspacing="0" align="left">
    <col style="width: 30%" class="col1">
    <col style="width: 30%" class="col1">
    <tr>
        <th colspan="1" align="center" border=1>DENOMINACIONES</th>
        <th colspan="1" align="center" border=1>IMPORTE</th>
    </tr>
    <?php
        $n=1;
        $denominacion = "";
        while ($row_prestamo=mysqli_fetch_row($consulta4)) 
        {
            if($row_prestamo[0] == "20.00"){
                $denominacion = "Billete";
            }
            else{
                $denominacion = "Moneda";   
            }
    ?>
            <tr>
                <td colspan="1" align="left" border=1>
                    <label class="mediano">
                         <b><?php echo $denominacion.' de $'."$row_prestamo[0]";?></b>
                    </label>
                </td>
                <td colspan="1" align="right" border=1>
                    <label class="mediano">
                         <b><?php echo "$row_prestamo[1]";?></b>
                    </label>
                </td>
            </tr>
        <?php
        $n++;
        }
        ?>
</table>
<br>
<table>
    <col style="width: 30%" class="col1">
    <tr>
        <td><b>Total de la Remesa: $<?php echo $row[0];?></b></td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">Sin más por el momento y agradeciendo sus atenciones, quedamos como siempre.</td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left"><b>Atentamente</b></td>
    </tr>
</table>
<br>
<!-- <br> -->
<?php
if($row_firma[3]=='3' || $row_firma[3]=='4'){
?>
<table>
    <col style="width: 45%" class="col1">
    <col style="width: 40%" class="col1">
    <col style="width: 100%" class="col1">
    <tr>
        <td align="center"><b>____________________________________</b></td>
        
    </tr>
    <tr>
        <td align="center"><b>Nombre: <?php echo $row_firma[0]?></b></td>
        
    </tr>
    <tr>
        <td align="center"><b>Puesto: <?php echo $row_firma[2]?></b></td>
        
    </tr>
</table>
<?php
}else{
?>
<table>
    <col style="width: 45%" class="col1">
    <col style="width: 40%" class="col1">
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left"><b>____________________________________</b></td>
        <td align="left"><b>___________________________________</b></td>
    </tr>
    <tr>
        <td align="left"><b>Nombre: <?php echo $row_firma[0]?></b></td>
        <td align="left"><b>Nombre: C.P José Luis Dávila Rodríguez</b></td>
    </tr>
    <tr>
        <td align="left"><b>Puesto: <?php echo $row_firma[2]?></b></td>
        <td align="left"><b>Puesto: Gerente Administrativo</b></td>
    </tr>
</table>
<?php 
}
?>
