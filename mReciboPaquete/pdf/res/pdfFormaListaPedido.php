<?php 
include '../../global_settings/conexion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
$Folio = $_GET['folio'];

mysqli_set_charset($conexion,'utf8');
$consulta=mysqli_query($conexion,"SELECT
                                    m.id,
                                    m.folio,
                                    m.id_sucursal,
                                    s.nombre,
                                    m.id_usuario,
                                    CONCAT(
                                        p.nombre,
                                        ' ',
                                        p.ap_paterno,
                                        ' ',
                                        p.ap_materno
                                    ) AS persona,
                                    m.fecha,
                                    h.codigo,
                                    c.nombre,
                                    h.pedido,
                                    h.envio
                                FROM
                                    materiales m
                                INNER JOIN historial_pedido_materiales h ON h.folio = m.folio
                                INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                                INNER JOIN sucursales s ON s.id = m.id_sucursal
                                INNER JOIN usuarios u ON u.id = h.id_usuario
                                INNER JOIN personas p ON p.id = u.id_persona
                                WHERE
                                    m.activo = '2'
                                AND m.folio = '$Folio'
                                AND h.pedido != '0'");

ini_set('max_execution_time', 500);
mysqli_set_charset($conexion,'utf8');
$consulta2=mysqli_query($conexion,"SELECT
                                    m.id,
                                    m.folio,
                                    m.id_sucursal,
                                    s.nombre,
                                    m.id_usuario,
                                    CONCAT(
                                        p.nombre,
                                        ' ',
                                        p.ap_paterno,
                                        ' ',
                                        p.ap_materno
                                    ) AS persona,
                                    m.fecha,
                                    h.codigo,
                                    c.nombre,
                                    h.pedido,
                                    h.envio
                                FROM
                                    materiales m
                                INNER JOIN historial_pedido_materiales h ON h.folio = m.folio
                                INNER JOIN catalago_materiales c ON c.codigo = h.codigo
                                INNER JOIN sucursales s ON s.id = m.id_sucursal
                                INNER JOIN usuarios u ON u.id = h.id_usuario
                                INNER JOIN personas p ON p.id = u.id_persona
                                WHERE
                                    m.activo = '2'
                                AND m.folio = '$Folio'
                                AND h.pedido != '0'");
$row2=mysqli_fetch_row($consulta2);

$usuario = $row2[6];
$SubTotal = $row2[4];
$iva = $SubTotal * 0.16;
$Total = $SubTotal + $iva;                         
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

<table>
    <col style="width: 20%" class="col1">
    <col style="width: 80%" class="col1">
    <tr>
        <td align="left">
            <img src="../../d_plantilla/dist/img/logo.png" width="150">
        </td>
        <td align="center">
            <h3>LA MISION SUPERMERCADOS, S.A. DE C.V.</h3>
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
            <b>               &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;RFC: MSU-940322-LJ4<br>
            DIRECCION: BOULEVARD DIAZ ORDAZ 901 C.P. 67700 CENTRO LINARES N.L<br>                &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;TELS. 01(821)212-6200 Y 2126210
            </b>
        </td>
        <td align="right">
        </td>
    </tr>
</table>
<br>
<table>
    <col style="width: 33%" class="col1">
    <col style="width: 33%" class="col1">
    <col style="width: 33%" class="col1">
    <tr>
        <td align="left">           
        </td>
        <td  align="center">
           <label class="grande">
                <h4>
                    PEDIDO DE SISTEMAS
                </h4>
            </label> 
        </td>
        <td align="right">          
        </td>
    </tr>
</table>
<table>
    <col style="width: 5%" class="col1">
    <col style="width: 80%" class="col1">
    <col style="width: 15%" class="col1">
    <tr>
        <td align="left">
           <label class="grande">
               
            </label> 
        </td>
        <td align="left">
           <label class="grande">
                <b><br>
                    Folio: <?php echo $Folio; ?><br>
                    Sucursal: <?php echo "$row2[3]";?><br>
                    Fecha: <?php echo date("d-m-Y",strtotime($row2[6]));?><br>
                    Usuario: <?php echo "$row2[5]";?><br>
                </b>
            </label> 
        </td>
        <td align="right">
                       
        </td>
    </tr>
</table>
<table style="width: 95%" cellpadding="0" cellspacing="0">
    <col style="width: 5%" class="col1">
    <col style="width: 25%" >
    <col style="width: 25%">
    <col style="width: 25%">
    <col style="width: 20%">

    <tr>
        <td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    
    <tr>
        <td colspan="7"><hr></td>
    </tr>
    <tr>
        <td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>

</table>

<table  style="width: 100%" cellpadding="0" cellspacing="0">
    <col style="width: 15%">
    <col style="width: 40%">
    <col style="width: 20%">
    <col style="width: 20%">

    <tr class="rojo">
        <td colspan="1" align="center" border=1>
            <label class="grande">
                <b class="blanco">Codigo.</b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="grande">
                <b class="blanco">Descripción.</b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="grande">
                <b class="blanco">Pedido.</b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="grande">
                <b class="blanco">Envio.</b>
            </label>
        </td>
    </tr>
    <?php
        $n=1;
        while ($row=mysqli_fetch_row($consulta)) 
        {     
    ?>
    <tr>
        <td colspan="1" align="center" border=1>
            <label class="mediano">
                 <b><?php echo "$row[7]";?></b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="mediano">
                 <b><?php echo "$row[8]";?></b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="mediano">
                <b><?php echo "$row[9]";?></b>
            </label>
        </td>
        <td colspan="1" align="center" border=1>
            <label class="mediano">
                <b><?php echo "$row[10]";?></b>
            </label>
        </td>
    </tr>

    <?php
    $n++;
    }
    ?>
</table>
