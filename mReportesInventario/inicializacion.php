<?php
include '../global_seguridad/verificar_sesion.php';
include '../global_settings/conexion_oracle.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date('Y-m-d', mktime(0, 0, 0, date('m'),date('d')-1,date('Y'))); 
$hora=date ("h:i:s");
 ?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
  <script type="text/javascript" src="funciones.js?v=<?php echo(rand()) ?>"></script>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php include 'menuV.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Inicialización | Filtros</h3>
        </div>
        <div class="box-body">
          <form id="frmDatosMapeo" method="GET" action="reporte_ini.php">
            <div class="row">
              <div class="col-md-3">
                <label>Departamento</label>
                <select class="form-control" id="cmbDpto" name="cmbDpto">
                  <option>Seleccione...</option>
                  <?php
                    $sql = "SELECT famc_familia, famc_descripcion FROM COM_FAMILIAS WHERE FAMN_NIVEL = '1'";
                    $exSql = oci_parse($conexion_central, $sql);
                    oci_execute($exSql);
                    while ($row = oci_fetch_row($exSql)) {
                      echo "<option value=$row[0]>$row[1]</option>";
                    }
                   ?>
                </select>
              </div>
              <div class="col-md-4">
                <label>Sucursal</label>
                <select class="form-control" name="cmbSucursal">
                  <option selected disabled>Seleccione...</option>
                  <option value="1">Diaz Ordaz</option>
                  <option value="2">Arboledas</option>
                  <option value="3">Villegas</option>
                  <option value="4">Allende</option>
                </select>
              </div>
            </div>
            <input type="submit" name="" value="Enviar" class="btn btn-danger">
          </form>
        </div>
        <div class="box-footer">

            <a href="reporte_ini.php?departamento=" class="btn btn-danger">Generar</a>
            <!-- <a href="#" id="btnGuardar" onclick="javascript:insert()" class="btn btn-danger">Guardar</a>
            
            <a href="#" onclick="javascript:finalizar()" class="btn btn-danger" id="btnFinalizar" disabled>Finalizar</a> -->
        </div>
      </div>
<!--         <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Inventario | Detalle del mapeo</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla">
              <?php include 'mapeos_dia.php'; ?>
            </div>
          </div>
          <div class="box-footer text-right">
          </div>
        </div> -->
<!--          <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Cajas de articulos | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div id="contenedor_tabl2a"></div>
                </div>
              </div>
            </div>
          </div>
        </div> -->

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include '../footer2.php'; ?>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php include '../footer.php'; ?>
<!-- Page script -->

  <script>
    $(document).ready(function() {
      $('#example').dataTable({
        "dom": 'Bfrtip',
    buttons: [{
        extend: 'pageLength',
        text: 'Registros',
        className: 'btn btn-default'
      },
      {
        extend: 'excel',
        text: 'Exportar a Excel',
        className: 'btn btn-default',
        title: 'NuevoMapeo',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        text: 'Exportar a PDF',
        className: 'btn btn-default',
        title: 'NuevoMapeo',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'copy',
        text: 'Copiar registros',
        className: 'btn btn-default',
        copyTitle: 'Ajouté au presse-papiers',
        copyKeys: 'Appuyez sur <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> pour copier les données du tableau à votre presse-papiers. <br><br>Pour annuler, cliquez sur ce message ou appuyez sur Echap.',
        copySuccess: {
          _: '%d lignes copiées',
          1: '1 ligne copiée'
        }
      }
    ],
        "lengthMenu":
          [[-1], [ "All"]],
        
         "language": {
        "url": "../assets/js/Spanish.json"
         }
      });
    });
  </script>
  <script>
  $(function () {
    $('#cmbDpto').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
    })
  })
</script>
<script type="text/javascript">
  function insert() {    
      $.ajax({
          url: "insertar_mapeo.php",
          type: "POST",
          dateType: "html",
          data: $('#frmDatosMapeo').serialize(),
          success: function(respuesta) {
              if (respuesta == "false") {
                  alert("Este mapeo ya existe, intenta con otros valores");
                  $('#habilitar').modal('show');
              } else {
                  $('#txtCara').attr('readonly', 'true');
                  $('#txtMueble').attr('readonly', 'true');
                  $('#txtZona').attr('readonly', 'true');
                  $('#btnGuardar').attr('disabled', 'true');
                  $('#txtEstante').val(1);
                  $('#txtCodigo').removeAttr('readonly');
                  $('#btnFinalizar').removeAttr('disabled');
                  $('#btnCambiar').removeAttr('disabled');
                  $('#cmbArea').attr('disabled');
                  $('#id_mapeo').val(respuesta);
              }
          },
          error: function(xhr, status) {
              alert(xhr);
          },
      });
  }
  
</script>
<script type="text/javascript">
  function insert_detalle() {
    var id_mapeo = $('#id_mapeo').val();
    var codigo = $('#txtCodigo').val();
    var estante = $('#txtEstante').val();
    var consecutivo = $('#txtConsecutivo').val();
    var descripcion = $('#txtDescripcion').val();

  let datos = {
    id_mapeo: id_mapeo,
    codigo: codigo,
    estante: estante,
    consecutivo: consecutivo,
    descripcion: descripcion
  };    
      $.ajax({
          url: "insertar_detalle.php",
          type: "POST",
          dateType: "html",
          data: datos,
          success: function(respuesta) {
            console.log(respuesta);
              if (respuesta == "false") {
                  alert("Este articulo no existe en la Base de Datos");
                  $('#txtCodigo').val('');
                  
              } else {
                  $('#txtDescripcion').val(respuesta);
                  cargar_tabla(id_mapeo);
                  var c = parseInt(consecutivo) + 1;
                  $('#txtConsecutivo').val(c);
                  $('#txtCodigo').val('');
              }
          },
          error: function(xhr, status) {
              alert(xhr);
          },
      });
  }
</script>
<script type="text/javascript">
  function cargar_tabla(id_mapeo){
    $.ajax({
          url: "tabla_detalle_mapeo.php",
          type: "POST",
          dateType: "html",
          data: {
            'id_mapeo': id_mapeo
          },
          success: function(respuesta) {
              $('#contenedor_tabla').html(respuesta);
          },
          error: function(xhr, status) {
              alert(xhr);
          },
      });
  }
  
</script>
<script type="text/javascript">
  function finalizar(){
    var id_mapeo = $('#id_mapeo').val();
    $.ajax({
          url: "guardar_mapeo.php",
          type: "POST",
          dateType: "html",
          data: {
            'id_mapeo': id_mapeo
          },
          success: function(respuesta) {
            alert("Mapeo registrado");
            location.reload();
              //$('#contenedor_tabla').html(respuesta);
          },
          error: function(xhr, status) {
              alert(xhr);
          },
      });
  }

</script>
<script type="text/javascript">
  function cambiar_estante() {
    var estante = $('#txtEstante').val();
    var n_es = parseInt(estante)+1;
    $('#txtEstante').val(n_es);
    $('#txtConsecutivo').val(1); 
  }
</script>
</body>
</html>
