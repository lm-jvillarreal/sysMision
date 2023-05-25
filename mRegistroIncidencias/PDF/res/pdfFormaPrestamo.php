<?php 
include '../../global_settings/conexion.php';
include '../../global_settings/consulta_sqlsrvr.php';

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

$id_registro = $_GET['id_registro'];
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

ini_set('max_execution_time', 500);
mysqli_set_charset($conexion,'utf8');

$consulta2=mysqli_query($conexion,"SELECT
incidencias.id,
incidencias.departamento,
comentario,
(SELECT nombre FROM sanciones_incidencias WHERE incidencias.decision = sanciones_incidencias.id) as decision,
(SELECT incidencia FROM catalogo_incidencias WHERE incidencias.incidencia = catalogo_incidencias.id)as incidencia,
sucursal,
incidencias.nombre
FROM
incidencias
WHERE folio = '1'
and incidencias.id= '$id_registro'");


$row_incidencias=mysqli_fetch_array($consulta2); //row_incidencia para llenar los campos adicionales
$consulta3=sqlsrv_query($conn,"SELECT nombre + ' ' + ap_paterno + ' ' + ap_materno AS 'nombre' FROM empleados WHERE codigo ='$row_incidencias[6]' ");

$row_persona = sqlsrv_fetch_array($consulta3);//row_persona para llenar campos de persona           
?>
<style type="text/css">
table
{
    width:  90%;
    border: solid 0px #5544DD;
    margin:auto;
}
</style>
<br><br><br><br><br><br>
<table>
    <col style="width: 20%" class="col1">
    <col style="width: 80%" class="col1">
    <col style="width: 10%" class="col1">
    <tr>
        <td align="left">  
        </td>
        <td align="center">
            <b>ACTA ADMINISTRATIVA
            </b>
            <br>
            <br>
            <br>
            <br>
            <br>
        </td>
        <td align="right">
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    
    <tr>
        <td align="left">
            El día <?php echo $dia;?> de <?php echo $mes_nuevo;?> del año <?php echo $año_mas;?> se levanta la presente ACTA ADMINISTRATIVA 
        </td>
    </tr>
    <tr>
        <td align="left">
        al Sr.(a): <b><?php echo $row_persona['nombre'];?></b>
        </td>
    </tr>
    <tr>
        <td align="left">
        perteneciente al departamento de: <b><?php echo $row_incidencias[1];?></b> en sucursal <b><?php echo $row_incidencias[5];?></b> debido a la siguiente falta administrativa:<b><?php echo $row_incidencias[4];?></b>
        </td>
    </tr>
</table>
<br>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
            Comentarios <b><?php echo $row_incidencias[2];?></b>
        </td>
    </tr>
</table>
<br>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
        Declara la persona señalada en este documento, haber realizado la(s) falta(s) arriba mencionada(s).
        </td>
    </tr>
</table>
<br>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
             Queda por enterado que usted está violando la Ley Federal del Trabajo y <b>usted puede ser sancionado</b> conforme al Artículo 47 Fracciones VII y XII plasmado en la Ley Federal del Trabajo vigente.
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
          Por lo cual se le otorga una sanción de tipo: <b><?php echo $row_incidencias[3];?></b>
        </td>
    </tr>
</table>
<br>
<br>
<br>


<table>
    <col style="width: 45%" class="col1">
    <col style="width: 40%" class="col1">
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left"><b>________________________________</b></td>
        <td align="left"><b>________________________________</b></td>
    </tr>
    
    <tr>
        <td align="left"><b><b><?php echo $row_persona['nombre'];?></b></b></td>
        <td align="left"><b>Nombre y firma</b></td>

    </tr>
    <tr>
        <td align="left"><b>Trabajador </b></td>
        <td align="left"><b>Jefe inmediato</b></td>
    </tr>
</table>
<br>
<br>
<br>

<table>
    <tr>
        <td align="right"><b>________________________________<br></b></td>
    </tr>
    <tr>
        <td align="center"><b>&#160;&#160;Nombre y firma<br></b></td>
    </tr>
    <tr>
        <td align="center"><b>Dpto. Recursos Humanos</b></td>
       
    </tr>
    
</table>

<br>
<br>
<br>
<table>
    <col style="width: 100%" class="col1">
    <tr>
        <td align="left">
        Artículo 47.- Son causas de rescisión de la relación de trabajo, sin responsabilidad para el patrón: 
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        VII.	Comprometer el trabajador, por su imprudencia o descuido inexcusable, la seguridad del establecimiento o de las personas que se encuentren en él;  
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        VIII.	Cometer el trabajador actos inmorales en el establecimiento o lugar de trabajo;   
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        IX.	Revelar el trabajador los secretos de fabricación o dar a conocer asuntos de carácter reservado, con perjuicio de la empresa;  
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        X.	Tener el trabajador más de tres faltas de asistencia en un período de treinta días, sin permiso del patrón o sin causa justificada;  
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        XI.	Desobedecer el trabajador al patrón o a sus representantes, sin causa justificada, siempre que se trate del trabajo contratado;  
        </td>
    </tr>
    <br>
    <tr>
        <td align="left">
        XII.	Negarse el trabajador a adoptar las medidas preventivas o a seguir los procedimientos indicados para evitar accidentes o enfermedades;   
        </td>
    </tr>
</table>