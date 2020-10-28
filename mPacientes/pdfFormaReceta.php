<?php
 include '../global_seguridad/verificar_sesion.php';
 include 'barcode.php'; 

     $id_paciente = $_GET['id'];
    
     $datos = mysqli_query($conexion, "SELECT CONCAT(nombre,' ',ap_paterno,' ',ap_materno),edad FROM pacientes WHERE id = '$id_paciente'");
     $row_datos = mysqli_fetch_array($datos);

     $consulta = mysqli_query($conexion, "SELECT id, MAX(folio)FROM receta");
     $row_folio = mysqli_fetch_array($consulta);
     $folio = $row_folio[1];

     $informacion = mysqli_query($conexion, "SELECT id, (SELECT CONCAT (nombre,' ',ap_paterno,' ',ap_materno) FROM personas WHERE personas.id = medicos.id_persona), cedula, instituciones, especialidad FROM medicos WHERE id_persona = '$id_persona'");


     $datos_medicamento = mysqli_query($conexion, "SELECT id, nombre_generico, nombre_farmacia, dosis, presentacion, via_adm, duracion_tratamiento, notas FROM receta WHERE folio = '$folio'");


     date_default_timezone_set('America/Monterrey');
     $fecha=date("Y-m-d");
     $hora=date ("h:i:s");

     $code = $folio;
     barcode('codigos/'.$code.'.png', $code, 20, 'horizontal', 'code128', false);
     $ruta = 'codigos/'.$code.'.png';
     // echo $code;
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
        border: solid 1px #000000;
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
        border: solid 1px #000000;
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
        border: solid 1px #000000;
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

    .rojo{
       color: #F10B0B;
    }
    .rench{

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
    /*      background-color: #cc3366; */
    /*      //font-family: verdana, arial; */
        font-size: 10pt;
    }
    .cursiva{
       font-size: 30px;
       text-align: center;
    }
</style>
<br>
<table class="borde">
    <col style="width: 10.1%" class="col1">
    <col style="width: 81.4%" class="col1">
    <col style="width: 10.1%" class="col1">
    <tr>
        <td align="left">
            <img src="../d_plantilla/dist/img/logom.png" width="70">
        </td>

<?php
    while ($row_medico = mysqli_fetch_array($informacion)) {
        $nomMedico = $row_medico[1];

 ?>
        <td align="center">
            <h1 class="cursiva" > Dr. <?php echo $row_medico[1]; ?> </h1>
            <p><?php echo $row_medico[4]; ?> <br> CÉDULA PROFESIONAL: <?php echo $row_medico[2]; ?>
            <br><?php echo $row_medico[3]; ?></p>

        </td>

<?php
   }
 ?>

        <td align="right">
            <img src="../d_plantilla/dist/img/logofm.jpg" width="120">
            <p class="rojo" align="center" style="font-size: 17px;" >No° <?php echo $folio; ?></p>
        </td>
    </tr>
</table>
<table class="borde">
          <col style="width: 60%" class="col1">
          <col style="width: 20%" class="col1">
          <col style="width: 30%" class="col1">
    <tr class="borde" >
           <td align="left" > <b>Nombre Paciente: <?php echo $row_datos[0]; ?> </b> </td>
           <td align="left" > <b>Edad: <?php  echo $row_datos[1]; ?>            </b> </td>
           <td align="left" > <b>Fecha de Emisión: <?php echo $fecha; ?> </b> </td>

     </tr>
</table>
<table class="borde">
         <col style="width: 20.5%" class="col1">
         <col style="width: 20.5%" class="col1">
         <col style="width: 10%" class="col1">
         <col style="width: 19%" class="col1">
         <col style="width: 20%" class="col1">
         <col style="width: 20%" class="col1">
     <tr class="borde">
         <td align="left" class="borde" ><b>Nombre Génerico:</b></td>
         <td align="left" class="borde" ><b>Nombre Farmacia:</b></td>
         <td align="left" class="borde" ><b>Dosís:</b></td>
         <td align="left" class="borde" ><b>Presentación:</b></td>
         <td align="left" class="borde" ><b>Via de Adm:</b></td>
         <td align="left" class="borde" ><b>Duracion:</b></td>
     </tr>
</table>

<!--med-->

<?php
   while ($row_medicamento=mysqli_fetch_array($datos_medicamento)) {

       $notas=$row_medicamento[7];

?>
<table class="borde">
         <col style="width: 20.5%" class="col1">
         <col style="width: 20.5%" class="col1">
         <col style="width: 10%" class="col1">
         <col style="width: 19%" class="col1">
         <col style="width: 20%" class="col1">
         <col style="width: 20%" class="col1">

     <tr class="borde">
         <td align="left" class="borde" > <?php echo $row_medicamento[1]; ?> </td>
         <td align="left" class="borde" > <?php echo $row_medicamento[2]; ?> </td>
         <td align="left" class="borde" > <?php echo $row_medicamento[3]; ?> </td>
         <td align="left" class="borde" > <?php echo $row_medicamento[4]; ?> </td>
         <td align="left" class="borde" > <?php echo $row_medicamento[5]; ?> </td>
         <td align="left" class="borde" > <?php echo $row_medicamento[6]; ?> </td>
     </tr>

</table>

         <?php

      }

 ?>


<!--med-->


<table class="borde">
<col style="width: 110%" class="col1">
     <tr class="borde">
        <td align="left" ><b>Notas:</b> <br> <?php echo $notas; ?></td>
     </tr>
</table>
<table class="borde">
    <col style="width: 60%" class="col1">
    <col style="width: 50%" class="col1">
    <col style="width: 60%" class="col1">

    <tr>

        <td align="center"><b> <br>
        <br>
        <br>
        <br>
        _____________________________________ <br>
        LA MISION SUPERMERCADO S.A DE C.V</b></td>
        <td align="center"><b><br>
        <br>
        <br>
        <br>
        _________________________________________ <br>
        Dr/Dra. <?php echo $nomMedico;?> </b></td>
    </tr>
    <tr>
        <td class="borde" align="center"><b>Sello</b></td>
         <td class="borde" align="center"><b>Firma</b></td>
    </tr>
    <tr>
        <td colspan="2">
            <h5 align="center"> NO OLVIDES SURTIR TU RECETA EN TU SUPER "LA MISION"</h5>
            <img width="170" src="<?php echo $ruta; ?>" /> <br><br>
        </td>
    </tr>
    <tr>
        <td>
            <h5>MODESTO GALVÁN CANTÚ, #601, COL. CENTRO</h5>
        </td>
    </tr>
</table>