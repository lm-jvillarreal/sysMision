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
          <h3 class="box-title">Captura de Faltantes de Morralla</h3>
        </div>
        <div class="box-body">
          <div class="row justify-content-center">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive text-center">
                <form id="lista">
                <table id="lista_morralla" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Moneda</th>
                      <th>Faltante</th>
                      <th>Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $morralla = array(1 =>'20.00',2=> '10.00',3 =>'5.00',4 => '2.00',5 => '1.00',
                                  6 => '0.50',7 => '0.20',8 => '0.10');
                        for ($i=1; $i <= 8; $i++) { 
                    ?>
                        <tr>
                          <td>
                            <?php echo $i;?>
                          </td>
                          <td>$ <?php echo $morralla[$i];?>
                            <input type="text" value="<?php echo $morralla[$i];?>" class="hidden" name="morralla[]">
                          </td>
                          <td>
                            <input type="text" name="faltante[]" id="faltante<?php echo $i;?>" class="form-control" onkeyup="if(event.keyCode == 13)llenar(this.value,'<?php echo $morralla[$i];?>','<?php echo $i;?>')">
                          </td>
                          <td>
                              <div class="input-group">
                                <div class="input-group-addon">
                                  $
                                </div>
                                <input type="text" id="resultado<?php echo $i;?>" class="form-control" readonly name="resultado[]">
                              </div>
                          </td>
                        </tr>
                    <?php
                      }
                    ?>
                  </tbody>  
                </table>
                </form>
              </div>
            </div>
          </div>
        <div class="box-footer text-right">
          <div class="col-md-12">
            <button onclick="guardar();" class="btn btn-warning" id="guardar">Guardar</button>
          </div>
        </div>
        </div>
      </div>
      <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Faltantes</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista_faltante" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th>Folio</th>
                      <th>Usuario</th>
                      <th>Sucursal</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                      <th>Ver</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                    </tr>
                  </tbody>  
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
  $('#faltante'+1).focus();
</script>
<script>
  function men(folio){
      swal({
      title: "¿Está seguro de eliminar registro?",
      icon: "warning",
      buttons: ["No", "Si"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        eliminar(folio);
        swal("El registro se ha eliminado.", {
          icon: "success",
        });
      } else {
        swal("No se ha eliminado el registro.",{
          icon: "error",
        });
      }
    });
  }
  function eliminar(folio){
    var url = "eliminar_registro.php";
    $.ajax({
      data: {
              'folio':folio
            }, //datos que se envian a traves de ajax
      url: url, //archivo que recibe la peticion
      type: 'POST', //método de envio
      dateType: 'html',
      success: function(respuesta){
        if (respuesta=="ok") {
          alertify.success("Registro eliminado correctamente");
          cargar_tabla();
        }else {
          alertify.error("Ha ocurrido un error");
        }
      }
     });
  }
</script>
<script>
  function guardar(){
    $.ajax({
      url: 'insertar_faltante.php',
      type: 'POST',
      dateType: 'html',
      data: $('#lista').serialize(),
      success:function(respuesta){
        if(respuesta == "ok")
        {
          alertify.success("Se ha Guardado el registro");
          limpiar();
          cargar_tabla();
        }
        else if (respuesta == "vacio")
        {
          alertify.error("Verifica Campos"); 
        }
        else
        {
          alertify.error("Ha ocurrido un error");
        }
      }
    });
  }
</script>
<script>
  function limpiar() {
    var i = 1;
    while(i <= 8){
      $('#faltante'+i).val("");
      i ++;
    }
  }
</script>
<!-- <script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script> -->
<script>
  function llenar(cantidad,morralla,id){
    if(cantidad == "")
    {
      cantidad = 0;
      $('#faltante'+id).val(cantidad);
    }
      resultado = cantidad * morralla;

      $('#resultado'+id).val(resultado.toFixed(2));

      total = parseInt(id) + 1;

      if (total <= 8)
      {
        $('#faltante'+total).focus();
      }
  }
  function cargar_tabla(){
    $('#lista_faltante').dataTable().fnDestroy();
    $('#lista_faltante').DataTable( {
      'language': {"url": "../plugins/DataTables/Spanish.json"},
        "paging":   false,
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
            title: 'Faltante',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            text: 'Exportar a PDF',
            className: 'btn btn-default',
            title: 'Faltante',
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
      "ajax": {
          "type": "POST",
          "url": "tabla_morralla.php",
          "dataSrc": ""
      },
      "columns": [
          { "data": "#" },
          { "data": "Folio" },
          { "data": "Usuario" },
          { "data": "Sucursal" },
          { "data": "Fecha" },
          { "data": "Hora" },
          { "data": "Editar" },
          { "data": "Eliminar" },
          { "data": "Ver" },
      ]
   });
  }
</script>
<script>
  cargar_tabla();
</script>
</body>
</html>