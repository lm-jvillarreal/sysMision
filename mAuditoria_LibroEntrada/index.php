<?php
include '../global_seguridad/verificar_sesion.php';
//Fecha y hora actual
date_default_timezone_set('America/Monterrey');
$fecha=date('Y-m-d'); 
$hora=date ("H:i:s");
?>
<!DOCTYPE html>
<html>
<head>
  <?php include '../head.php'; ?>
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
            <h3 class="box-title">Libro Diario | Filtros</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-datos">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_inicio">*Fecha de inicio:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_inicio" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_inicial" name="fecha_inicial">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="fecha_fin">*Fecha final:</label>
                  <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="fecha_fin" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="<?php echo $fecha; ?>" readonly id="fecha_final" name="fecha_final">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                  </div>
                </div>
              </div>
            </div>
            </form>
          </div>
          <div class="box-footer text-right">
            <button class="btn btn-warning" id="btn-guardar">Visualizar Información</button>
          </div>
        </div>
         <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Libro Diario | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id='libro_diario' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                    <thead>
                      <tr>
                        <th width="5%">Folio</th>
                        <th>Proveedor</th>
                        <th width="5%">Recibo</th>
                        <th width="10%">Factura</th>
                        <th width="10%">Total</th>
                        <th width="10%">Observaciones</th>
                        <th width="22%">Folio Infofin</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include 'modal_comentario.php'; ?>
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
  $(document).ready(function (e) {
    libro_diario();
    $('#modal-comentario').on('show.bs.modal', function(e) {    
     var comentario = $(e.relatedTarget).data().coment;
     var id_auditoria = $(e.relatedTarget).data().id;
     console.log(comentario);
     $(this).find('#comentario_auditoria').val(comentario);
     $(this).find('#id_auditoria').val(id_auditoria);
    });
  });
  $("#btn-guardar").click(function(){
    libro_diario();
  });
  function libro_diario(){
    fecha_inicio = $("#fecha_inicial").val();
    fecha_fin = $("#fecha_final").val();
    $('#libro_diario').dataTable().fnDestroy();
    $('#libro_diario').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
      'order': [[0,"desc"]],
      "ajax": {
          "type": "POST",
          "url": "consulta_libroDiario.php",
          "dataSrc": "",
          "data": {fecha_inicio: fecha_inicio, fecha_fin: fecha_fin}
      },
      "columns": [
        { "data": "folio" },
        { "data": "no_proveedor" },
        { "data": "fecha_entrada" },
        { "data": "factura" },
        { "data": "total" },
        { "data": "observaciones" },
        { "data": "autorizar" }
      ]
    });
  }
  function libera_sistemas(id_libroDiario){
    var url = "liberar_sistemas.php";
    var folio = $("#folio_"+id_libroDiario).val();
    $.ajax({
      url: url,
      type: "POST",
      dateType: "html",
      data: {id_libroDiario: id_libroDiario, folio: folio},
      success: function(respuesta) {
        if (respuesta=="ok") {
          alertify.success("El registro ha sido actualizado con éxito");
        }else if(respuesta=="no_existe"){
          alertify.error("El folio de entrada no coincide con el registro");
        }else if(respuesta=="repetido"){
          alertify.error("El folio ya fue asignado");
        }else if(respuesta=="no_coincide"){
          alertify.error("El folio no coincide con el proveedor");
        }
      },
      error: function(xhr, status) {
          alert("error");
          //alert(xhr);
      },
    });
    libro_diario();
    return false;
  }
  $("#btn-comentario").click(function(){
    var url = "insertar_comentario.php";
    var coment_auditoria = $("#comentario_auditoria").val();
    var id_auditoria = $("#id_auditoria").val();
      $.ajax({
        url: url,
        type: "POST",
        dateType: "html",
        data: {coment_auditoria: coment_auditoria, id_auditoria: id_auditoria},
        success: function(respuesta) {
          if (respuesta=="ok") {
          alertify.success("Merma registrada correctamente");
          }else if(respuesta=="repetido"){
            alertify.error("Existió un error");
          }
          $('#modal-comentario').modal('hide');
        },
        error: function(xhr, status) {
            alert("error");
            //alert(xhr);
        },
    });
    libro_diario();
    //$(":text").val('');
    return false;
   });
  $('.form_date').datetimepicker({
    language:  'es',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
  });
</script>
</body>
</html>
