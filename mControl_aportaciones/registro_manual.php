<?php
  include '../global_seguridad/verificar_sesion.php'; 
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
    <?php include 'menuV4.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Registro</h3>
          </div>
          <div class="box-body">
            <form action="" method="POST" id="form-datosAp">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="folio">*No. Folio</label>
                  <input type="text" id="folio" name="folio" class="form-control" readonly="true">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="fecha_afectacion">*Fecha</label>
                  <input type="text" id="fecha_afectacion" name="fecha_afectacion" class="form-control" readonly="true">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="movimiento">*Movimiento</label>
                  <input type="text" id="movimiento" name="movimiento" class="form-control" readonly="true" value="MANUAL">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="valor">*Valor</label>
                  <input type="number" id="valor" name="valor" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="metodo_pago">Método de Pago</label>
                  <select name="metodo_pago" id="metodo_pago" class="form-control">
                    <option value=""></option>
                    <option value="CHEQUE">Cheque</option>
                    <option value="EFECTIVO">Efectivo</option>
                    <option value="DEPOSITO">Depósito</option>
                    <option value="TRANSFERENCIA">Transferencia</option>
                    <option value="REMISION">Remisión</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="referencia">*Referencia</label>
                  <input type="text" name="referencia" id="referencia" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="proveedor">*Proveedor</label>
                  <select name="proveedor" id="proveedor" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="concepto">*Concepto</label>
                  <select name="concepto" id="concepto" class="form-control">
                    <option value="" selected="TRUE"></option>
                    <option value="APORTACION ANIVERSARIO">Aportación Aniversario</option>
                    <option value="APORTACION POR DIA DEL NIÑO">Aportación Día del Niño</option>
                    <option value="PLAN COMERCIAL">Plan Comercial</option>
                    <option value="FONDOS">Fondos</option>
                    <option value="APERTURA LA PETACA">Apertura La Petaca</option>
                    <option value="APERTURA MONTEMORELOS">Apertura Montemorelos</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="id_comprador">*Comprador</label>
                  <select name="id_comprador" id="id_comprador" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sucursal">*Sucursal</label>
                  <select name="sucursal" id="sucursal" class="form-control">
                    <option value=""></option>
                    <option value="1">Díaz Ordaz</option>
                    <option value="2">Arboledas</option>
                    <option value="3">Villegas</option>
                    <option value="4">Allende</option>
                    <option value="5">La Petaca</option>
                    <option value="6">Montemorelos</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="comentarios">*Comentarios</label>
                <input type="text" id="comentarios" name="comentarios" class="form-control">
              </div>
            </div>
          </form>
          </div>
           <div class="box-footer text-right">
            <button type="submit" class="btn btn-warning" id="btn-insertar">Registrar aportación</button>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Control de Aportaciones | Lista de aportaciones</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div id="totales"></div><br><br>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table id="lista_aportaciones" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">Mov.</th>
                        <th width="5%">Folio</th>
                        <th width="5%">Fecha</th>
                        <th width="5%">Suc.</th>
                        <th>Proveedor</th>
                        <th>Comentarios</th>
                        <th>Comprador</th>
                        <th>Concepto</th>
                        <th width="7%">Valor</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Mov.</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Suc.</th>
                        <th>Proveedor</th>
                        <th>Comentarios</th>
                        <th>Comprador</th>
                        <th>Concepto</th>
                        <th>Valor</th>
                      </tr>
                    </tfoot>
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
  <?php include 'modal.php'; ?>
  <?php include 'modal_nc.php'; ?>
  <?php include 'modal_manual.php'; ?>
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
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<!-- Page script -->
<script>
$(document).ready(function (e) {
  $('#modal-default').on('show.bs.modal', function(e) {    
     var id = $(e.relatedTarget).data().id;
     var mov = $(e.relatedTarget).data().mov;
     var suc = $(e.relatedTarget).data().suc;
     //alert(id);
     var url = "tabla_modal.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {ide:id, movi:mov, suc:suc}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#tabla').html(respuesta);
        }
      });
  });
  $('#modal-nc').on('show.bs.modal', function(e) {    
     var id = $(e.relatedTarget).data().id;
     var consec = $(e.relatedTarget).data().consec;
     //alert(id);
     var url = "contenido_modal_nc.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id, consecutivo:consec}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#res').html(respuesta);
        }
      });
  });
  $('#modal-manual').on('show.bs.modal', function(e) {    
     var id = $(e.relatedTarget).data().id;
     //alert(id);
     var url = "contenido_modal_manual.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {id:id}, // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#res_manual').html(respuesta);
        }
      });
  });
});
</script>
  <script>
  $(function () {
    $('#tipo_movimiento').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    $('#metodo_pago').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      minimumResultsForSearch: Infinity
    })
    $('#concepto').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    $('#sucursal').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
    $('#id_comprador').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "consulta_compradores.php",
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
    });
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
     url: "consulta_proveedores.php",
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
    function folio(){
      var url = "consulta_folio_manual.php"; // El script a dónde se realizará la petición.
        $.ajax({
         type: "POST",
         url: url,
         data: {folio_mov:""}, // Adjuntar los campos del formulario enviado.
         success: function(respuesta)
         {
          var array = eval(respuesta);
          $('#folio').val(array[0]);
          $('#fecha_afectacion').val(array[1]);
         }
       });
  return false;
    }
    $("#btn-insertar").click(function(){
      var url = "insertar_aportacion_manual.php";
        $.ajax({
          url: url,
          type: "POST",
          dateType: "html",
          data: $('#form-datosAp').serialize(),
          success: function(respuesta) {
            if (respuesta=="ok") {
            alertify.success("Aportación registrada correctamente");
          }else if(respuesta=="repetido"){
            alertify.error("El folio que intenta registrar ya existe");
          }
          },
          error: function(xhr, status) {
              alert("error");
              //alert(xhr);
          },
      });
      cargar_tabla();
      $(":text").val('');
      $('#movimiento').val('MANUAL');
      $(':number').val('');
      folio();
      totales();
      return false;
     });
    function cargar_tabla(){
      $('#lista_aportaciones').dataTable().fnDestroy();
      $('#lista_aportaciones').DataTable( {
          'language': {"url": "../plugins/DataTables/Spanish.json"},
          "paging":   false,
          "dom": 'Bfrtip',
          "buttons": [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
          "ajax": {
              "type": "POST",
              "url": "tabla.php",
              "dataSrc": ""
          },
          "columns": [
              { "data": "tipo_movimiento" },
              { "data": "folio_movimiento" },
              { "data": "fecha_afectacion" },
              { "data": "sucursal" },
              { "data": "proveedor" },
              { "data": "comentarios" },
              { "data": "comprador" },
              { "data": "concepto" },
              { "data": "valor" }
          ]
      });
    }
    $(document).ready(function() {
      cargar_tabla();
      folio();
      totales();
  });
  })
  function totales(){
     var url = "consulta_totales.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: "", // Adjuntar los campos del formulario enviado.
        success: function(respuesta)
        {
          $('#totales').html(respuesta);
        }
      });
  }
</script>
</body>
</html>