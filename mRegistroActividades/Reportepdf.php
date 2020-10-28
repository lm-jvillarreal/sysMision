<?php 
// include '/../global_settings/conexion.php';
include '../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");

$id_persona = $_GET['usuario'];
$fecha1     = $_GET['fecha1'];
$fecha2     = $_GET['fecha2'];

mysqli_set_charset($conexion,'utf8');
$consulta1=mysqli_query($conexion,"SELECT
    (SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE actividades_usuario.id_persona = personas.id)
FROM actividades_usuario WHERE id_persona = '$id_persona'");
$row1 = mysqli_fetch_array($consulta1);
$consulta=mysqli_query($conexion,"SELECT actividad,fecha_realizacion FROM actividades_usuario WHERE id_persona = '$id_persona'
    AND fecha_realizacion BETWEEN CAST('$fecha1' AS DATE) AND CAST('$fecha2' AS DATE) AND activo <> 0");
                        
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
<table style="width: 100%" cellpadding="0" cellspacing="0" align="left">
    <col style="width: 100%" class="col1">
    <tr>
        <td align="center">
            <h4>Lista de Actividades de <?php echo $row1[0]?></h4>
        </td>
    </tr>
</table>
<br>
<br>
<table style="width: 100%" cellpadding="0" cellspacing="0" align="left">
    <col style="width: 5%" class="col1">
    <col style="width: 70%" class="col1">
    <col style="width: 10%" class="col1">
    <tr>
        <th colspan="1" align="center" border=1>#</th>
        <th colspan="1" align="center" border=1>Nombre de Actividad</th>
        <th colspan="1" align="center" border=1>Fecha</th>
    </tr>
    <?php
        $n=1;
        while ($row=mysqli_fetch_row($consulta)) 
        {
    ?>
            <tr>
                <td colspan="1" align="center" border=1>
                    <label class="mediano">
                        <b><?php echo $n?></b>
                    </label>
                </td>
                <td colspan="1" align="left" border=1>
                    <label class="mediano">
                         <b><?php echo $row[0]?></b>
                    </label>
                </td>
                <td colspan="1" align="center" border=1>
                    <label class="mediano">
                         <b><?php echo $row[1];?></b>
                    </label>
                </td>
            </tr>
        <?php
        $n++;
        }
        ?>
</table>
<br>