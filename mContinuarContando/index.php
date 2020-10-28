<?php
include '../global_seguridad/verificar_sesion.php';
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
          <h3 class="box-title">Continuar Mapeo | Registro</h3>
        </div>
        <div class="box-body" id="div_datos">
          <form id="frmDatosMapeo">
            <div class="row">
              <!-- <div class="col-md-3">
                <label>Area</label>
                <select id="cmbArea" name="cmbArea" class="form-control"></select>
              </div> -->
              <div class="col-md-3">
                <label>Zona</label>
                <input type="text" id="zonaCon" readonly  name="txtZona" class="form-control">
                <input type="hidden" id="id_mapeoCon" value="" name="">
              </div>
              <div class="col-md-3">
                <label>Mueble</label>
                <input type="text" readonly class="form-control" name="txtMueble" id="muebleCon">
              </div>
              <div class="col-md-3">
                <label>Cara</label>
                <input type="text" readonly class="form-control" name="txtCara" id="caraCon">
              </div>
            </div>
          </form>
          <form id="frmDatosCodigo">
            <div class="row">
              <div class="col-md-3">
                <label>Codigo</label>
                <input type="text" readonly id="txtCodigoCon" onchange="javascript:insert_detalle();" name="txtCodigo" class="form-control">
              </div>
              <div class="col-md-3">
                <label>Descripcion</label>
                <input type="text" id="txtDescripcionCon" name="txtDescripcion" class="form-control" readonly>
              </div>
              <div class="col-md-3">
                <label>Cantidad</label>
                <input type="text" class="form-control" name="cantidad" id="txtCantidad" value="1">
              </div>
              
            </div>
          </form>
        </div>
        <div class="box-footer">
            <a href="#" onclick="javascript:finalizar()" class="btn btn-danger" id="btnFinalizar">Finalizar</a>
        </div>
      </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Continuar Mapeo | Lista de mapeos</h3>
          </div>
          <div class="box-body">
            <div id="contenedor_tabla_detalle" style="display: none">
              
            </div>
            <div id="contenedor_tabla">
              <?php include 'lista_mapeos.php'; ?>
            </div>
          </div>
          <div class="box-footer text-right">
          </div>
        </div>
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
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example').dataTable({

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
    $('#cmbArea').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "consulta_areas.php",
     type: "post",
     dataType: 'json',
     delay: 250,
     data: function (params) {
      return {
        searchTerm: params.term // search term
      };
     },
     processResults: function (response) {
       return {
          results: response
       };
     },
     cache: true
    }
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
    var id_mapeo = $('#id_mapeoCon').val();
    var codigo = $('#txtCodigoCon').val();
    var estante = $('#txtEstanteCon').val();
    var consecutivo = $('#txtConsecutivoCon').val();
    var descripcion = $('#txtDescripcionCon').val();
    var cantidad  =$('#txtCantidad').val();

  let datos = {
    id_mapeo: id_mapeo,
    codigo: codigo,
    estante: estante,
    consecutivo: consecutivo,
    descripcion: descripcion,
    cantidad: cantidad
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
                  $('#txtDescripcionCon').val(respuesta);
                  cargar_tabla(id_mapeo);
                  var c = parseInt(consecutivo) + 1;
                  $('#txtConsecutivoCon').val(c);
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
    var id_mapeo = $('#id_mapeoCon').val();
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
  function editar(id_mapeo, zona, mueble, cara) {
    $.ajax({
        url: "editar.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_mapeo': id_mapeo

        },
        success: function(respuesta) {
            //$('#inicio_cont').modal('show');
            var conse = 1;
            var esta = 1;
            $('#edicion').show();
            $('#contenedor_tabla').html(respuesta);
            $('#lista_mapeos').hide();
            $('#zonaCon').val(zona);
            $('#muebleCon').val(mueble);
            $('#caraCon').val(cara);
            $('#id_mapeoCon').val(id_mapeo);
            $('#txtCodigoCon').removeAttr('readonly');
            $('#txtConsecutivoCon').removeAttr('readonly');
            $('#txtEstanteCon').removeAttr('readonly');
            alertify.success("Favor de colocar valores en estante y consecutivo");
            $('#txtEstanteCon').focus();
        },
        error: function(xhr, status) {

        },

    });
}
</script>
</body>
</html>
