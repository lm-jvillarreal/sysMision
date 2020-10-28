<?php 
	include '../global_seguridad/verificar_sesion.php';
	
	date_default_timezone_set('America/Monterrey');
	
    $hora  = date('h:i:s');
    
    $folio = $_POST['folio'];
    
    $fecha           = $_POST['fecha'];
    $efectivo        = $_POST['efectivo'];
    $efectivo1       = $_POST['efectivo1'];
    $efectivo2       = $_POST['efectivo2'];
    $complemento     = $_POST['complemento'];
    $cheques_serfin  = $_POST['cheques_serfin'];
    $cheques_locales = $_POST['cheques_locales'];
    $total_efectivos = $_POST['total_efectivos'];
    ///////////////////////////////////////////////////
    $tarjetas_credito = $_POST['tarjetas_credito'];
    /////////////////////////////////////////////////////
    $tarjetas_debito     = $_POST['tarjetas_debito'];
    $tarjetas_prepago    = $_POST['tarjetas_prepago'];
    $tarjetas_accor      = $_POST['tarjetas_accor'];
    $tarjetas_ecovale    = $_POST['tarjetas_ecovale'];
    $tarjetas_efectivale = $_POST['tarjetas_efectivale'];
    $tarjetas_sivale     = $_POST['tarjetas_sivale'];
    $tarjeta_pass        = $_POST['tarjeta_pass'];
    $total_tarjetas      = $_POST['total_tarjetas'];
    ////////////////////////////////////////////////////
    $bonos_prestaciones_mex = $_POST['bonos_prestaciones_mex'];
    $bonos_universales      = $_POST['bonos_universales'];
    $bonos_efectivale       = $_POST['bonos_efectivale'];
    $bonos_accor            = $_POST['bonos_accor'];
    $bonos_mision_especial  = $_POST['bonos_mision_especial'];
    $bonos_creditos         = $_POST['bonos_creditos'];
    $bonos_tengo_despensa   = $_POST['tengo_despensa'];
    $total_bonos            = $_POST['total_bonos'];
    ///////////////////////////////////////////////////
    $concepto = isset($_POST['concepto']) ? $_POST['concepto'] : '';
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    $cant = count($id);

    $cadena_folio = mysqli_query($conexion,"SELECT id FROM efectivos WHERE folio = '$folio'");

    $i = 0;
	while ($row_folio = mysqli_fetch_array($cadena_folio)) { 
		
		$consulta = mysqli_query($conexion,"UPDATE efectivos SET efectivo = '$efectivo', efectivo1 = '$efectivo1', efectivo2 = '$efectivo2', complemento = '$complemento',cheques_serfin = '$cheques_serfin',cheques_locales = '$cheques_locales', total_efectivos = '$total_efectivos', tarjetas_credito = '$tarjetas_credito',t_debito = '$tarjetas_debito', t_prepago = '$tarjetas_prepago', t_accor = '$tarjetas_accor', t_ecovale = '$tarjetas_ecovale', t_efectivale = '$tarjetas_efectivale', t_sivale = '$tarjetas_sivale', t_tiendapass = '$tarjeta_pass', total_t = '$total_tarjetas', b_prest_mex = '$bonos_prestaciones_mex',b_prest_uni = '$bonos_universales', b_accor = '$bonos_accor', b_efectivale = '$bonos_efectivale', b_mision_esp = '$bonos_mision_especial', b_creditos = '$bonos_creditos', b_total = '$total_bonos',b_tengo_despensa = '$bonos_tengo_despensa', id_usuario = '$id_usuario', id_sucursal = '$id_sede', fecha = '$fecha', hora = '$hora' WHERE id = '$row_folio[0]'");
		$i ++;
	}

    if (isset($_POST['cantidad']) && isset($_POST['cantidad']) && isset($_POST['id'])){
        for ($o=0; $o < $cant; $o++) { 
            $verificar = mysqli_query($conexion,"SELECT id FROM otros WHERE id = '$id[$o]'");
            $existe = mysqli_num_rows($verificar);
            if($id[$o] == 0){
                $insertar_otros = mysqli_query($conexion,"INSERT INTO otros (folio,concepto,cantidad,id_sucursal,fecha_creacion,fecha,hora_creacion,hora,activo,id_usuario)VALUES('$folio','$concepto[$o]','$cantidad[$o]','$id_sede','$fecha','$fecha','$hora','$hora','1','$id_usuario')");
            }else{
                $consulta_otros = mysqli_query($conexion,"UPDATE otros SET concepto = '$concepto[$o]',cantidad = '$cantidad[$o]', fecha = '$fecha', hora = '$hora', id_usuario = '$id_usuario' WHERE id = '$id[$o]'");
            }
        }
    }

	echo "ok";
?>
