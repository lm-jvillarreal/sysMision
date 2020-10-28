<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$date = date("Y-m-d");
$ayer = date("Y-m-d", strtotime("-1 day", strtotime($date)));
//echo $ayer;

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
            <h3 class="box-title">Órdenes de Compra | Proveedores Diarios</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form-directo">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="proveedor">*Proveedor:</label>
                    <select name="proveedor" id="proveedor" class="form-control select2" lang="es">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="box-footer">
            <div class="col-md-12 text-right">
              <button class="btn btn-danger" id="btn-guardar">Guardar</button>
            </div>
          </div>
        </div>
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Órdenes de Compra | Detalle</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#1" data-toggle="tab">Órdenes sin comenzar</a></li>
                    <li><a href="#2" data-toggle="tab">Órdenes comenzadas</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="1">
                      <div class="row">
                        <div class="col-md-12">
                          <br>
                          <div class="table-responsive">
                            <table id="lista_ordenes" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th width="5%">Folio</th>
                                  <th width="5%">No. Prov</th>
                                  <th>Proveedor</th>
                                  <th width="5%">No. orden</th>
                                  <th width="10%">Arribo</th>
                                  <th width="5%">Retraso</th>
                                  <th width="5%">Sucursal</th>
                                  <th width="5%">Visualizar</th>
                                  <th width="5%">Iniciar Liberación</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th>Folio</th>
                                  <th>No. Prov</th>
                                  <th>Proveedor</th>
                                  <th>No. orden</th>
                                  <th>Fecha llegada</th>
                                  <th>Retraso</th>
                                  <th>Sucursal</th>
                                  <th>Visualizar</th>
                                  <th>Iniciar Liberación</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane" id="2">
                      <div class="row">
                        <div class="col-md-12">
                          <br>
                          <div class="table-responsive">
                            <table id="lista_ordenes_comenzadas" class="table table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Folio</th>
                                  <th width="5%">No. Prov</th>
                                  <th>Proveedor</th>
                                  <th>No. orden</th>
                                  <th>Fecha llegada</th>
                                  <th width="10%">Retraso</th>
                                  <th>Sucursal</th>
                                  <th>Visualizar</th>
                                  <th>Liberar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <th>Folio</th>
                                  <th>No. Prov</th>
                                  <th>Proveedor</th>
                                  <th>No. orden</th>
                                  <th>Fecha llegada</th>
                                  <th>Retraso</th>
                                  <th>Sucursal</th>
                                  <th>Visualizar</th>
                                  <th>Liberar</th>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
  <!-- Page script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <script>
    $("#btn-guardar").click(function() {
      var proveedor = $("#proveedor").val();
      iniciar_liberacion_directo(proveedor);
    });
    $("#lnk_iniciar").click(function(event) {
      alert("hola");
    });

    function ordenes_comenzadas() {
      $('#lista_ordenes_comenzadas thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_ordenes_comenzadas').dataTable().fnDestroy();
      var table = $('#lista_ordenes_comenzadas').DataTable({
        "order": [
          [4, "ASC"]
        ],
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "ajax": {
          "type": "POST",
          "url": "t_ordenes_comenzadas.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "no_proveedor"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "no_orden"
          },
          {
            "data": "fecha_llegada"
          },
          {
            "data": "retraso"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "ver"
          },
          {
            "data": "liberar"
          }
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }

    function ordenes_compra() {
      $('#lista_ordenes thead th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="' + title + '" style="width:100%" />');
      });
      $('#lista_ordenes').dataTable().fnDestroy();
      var table = $('#lista_ordenes').DataTable({
        'language': {
          "url": "../plugins/DataTables/Spanish.json"
        },
        "ajax": {
          "type": "POST",
          "url": "t_ordenes_compra.php",
          "dataSrc": ""
        },
        "columns": [{
            "data": "folio"
          },
          {
            "data": "no_proveedor"
          },
          {
            "data": "proveedor"
          },
          {
            "data": "no_orden"
          },
          {
            "data": "fecha_llegada"
          },
          {
            "data": "retraso"
          },
          {
            "data": "sucursal"
          },
          {
            "data": "ver"
          },
          {
            "data": "liberar"
          }
        ]
      });
      table.columns().every(function() {
        var that = this;
        $('input', this.header()).on('keyup change', function() {
          if (that.search() !== this.value) {
            that
              .search(this.value)
              .draw();
          }
        });
      });
    }
    $('#proveedor').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: {
        url: "consulta_proveedores.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            searchTerm: params.term // search term
          };
        },
        processResults: function(response) {
          return {
            results: response
          };
        },
        cache: true
      }
    });

    function cambiar_status(id) {
      var url = "iniciar_liberacion.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: {
          ide: id
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          console.log(respuesta);
        }
      });
      // Evitar ejecutar el submit del formulario.
      return false;
    }

    function iniciar_liberacion(id_orden) {
      var hora = new Date();
      var url = 'consulta_orden_compra.php';
      fecha = hora.getDate() + "/" + (hora.getMonth() + 1) + "/" + hora.getFullYear()
      var hora_actual = hora.getHours();
      var minutos = hora.getMinutes();
      $.ajax({
        type: "POST",
        url: url,
        data: {
          id_orden: id_orden
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          var array = eval(respuesta);
          no_orden = array[2];
          clave_proveedor = array[0];;
          nombre_proveedor = array[1];;
          swal({
              title: "¿Está seguro de iniciar la liberación?",
              text: "No. Proveedor: " + clave_proveedor + "\n Proveedor: " + nombre_proveedor + " \n Fecha: " + fecha + " \nHora: " + hora_actual + ":" + minutos,
              icon: "warning",
              buttons: ["Cancelar", "Iniciar"],
              dangerMode: true,
            })
            .then((willDelete) => {

              ///////////////////////////
              if (willDelete) {
                var url = "validar_situacionProveedor.php";
                $.ajax({
                  type: "POST",
                  url: url,
                  data: {
                    clave_proveedor: clave_proveedor
                  }, // Adjuntar los campos del formulario enviado.
                  success: function(respuesta) {
                    if (respuesta == "devoluciones") {
                      swal({
                          title: "Devoluciones",
                          text: "Existen devoluciones para este proveedor, ¿Desea liberarlos?",
                          icon: "warning",
                          buttons: ["Ignorar", "Liberar"],
                          dangerMode: true,
                        })
                        .then((WillDevolucion) => {
                          if (WillDevolucion) {
                            //redireccionar a devoluciones
                            cambiar_status(id_orden);
                            location.href = "../mDevoluciones/index.php";
                          } else {
                            cambiar_status(id_orden);
                            swal("La liberación de la orden " + no_orden + " ha sido inicializada.", {
                              icon: "success",
                            });
                            ordenes_compra();
                            ordenes_comenzadas();
                          }
                        });
                    } else if (respuesta == "cambios") {
                      swal({
                          title: "Cambios Físicos",
                          text: "Existen cambios para este proveedor, ¿Desea liberarlos?",
                          icon: "warning",
                          buttons: ["Ignorar", "Liberar"],
                          dangerMode: true,
                        })
                        .then((WillCambioFisico) => {
                          if (WillCambioFisico) {
                            //redireccionar a devoluciones
                            cambiar_status(id_orden);
                            location.href = "../mCambios_fisicos/index.php?cve_prov=" + clave_proveedor;
                          } else {
                            cambiar_status(id_orden);
                            swal("La liberación de la orden " + no_orden + " ha sido inicializada.", {
                              icon: "success",
                            });
                            ordenes_compra();
                            ordenes_comenzadas();
                          }
                        });
                    } else if (respuesta == "ambos") {
                      swal("Revisar", "Este proveedor tiene devoluciones y cambios físicos pendientes, favor de liberarlos.", "warning");
                    } else if (respuesta == "libre") {
                      cambiar_status(id_orden);
                      swal("La liberación de la orden " + no_orden + " ha sido inicializada.", {
                        icon: "success",
                      });
                      ordenes_compra();
                      ordenes_comenzadas();
                    }
                  }
                });
              } else {
                swal("La liberación de la orden " + no_orden + " ha sido cancelada.", {
                  icon: "error",
                });
              }
            });
        }
      });
    }
    $(document).ready(function(e) {
      ordenes_comenzadas();
      ordenes_compra();
    });

    function iniciar_liberacion_directo(cve_prov) {
      var url = 'validar_proveedorDirecto.php';
      $.ajax({
        type: "POST",
        url: url,
        data: {
          cve_prov: cve_prov
        }, // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "devoluciones") {
            swal({
                title: "Devoluciones",
                text: "Existen devoluciones para este proveedor, ¿Desea liberarlos?",
                icon: "warning",
                buttons: ["Ignorar", "Liberar"],
                dangerMode: true,
              })
              .then((WillDevolucion) => {
                if (WillDevolucion) {
                  //redireccionar a devoluciones
                  insertar_directo();
                  location.href = "../mDevoluciones/index.php";
                } else {
                  insertar_directo();
                }
              });
          } else if (respuesta == "cambios") {
            swal({
                title: "Cambios Físicos",
                text: "Existen cambios para este proveedor, ¿Desea liberarlos?",
                icon: "warning",
                buttons: ["Ignorar", "Liberar"],
                dangerMode: true,
              })
              .then((WillCambioFisico) => {
                if (WillCambioFisico) {
                  //redireccionar a devoluciones
                  insertar_directo();
                  location.href = "http://200.1.1.178/sysMision/mCambios_fisicos/index.php?cve_prov=" + cve_prov;
                } else {
                  insertar_directo();
                }
              });
          } else if (respuesta == "ambos") {
            swal({
                title: "Cambios Físicos y Devoluciones",
                text: "Existen cambios y devoluciones para este proveedor, ¿Desea liberarlos?",
                icon: "warning",
                buttons: ["Ignorar", "Liberar"],
                dangerMode: true,
              })
              .then((WillAmbos) => {
                if (WillAmbos) {
                  //redireccionar a devoluciones
                  insertar_directo();
                  location.href = "http://200.1.1.178/sysMision/mCambios_fisicos/index.php?cve_prov=" + cve_prov;
                } else {
                  insertar_directo();
                }
              });
          } else if (respuesta == "libre") {
            insertar_directo();
          }
        }
      });
    }

    function insertar_directo() {
      var url = "insertar_directo.php"; // El script a dónde se realizará la petición.
      $.ajax({
        type: "POST",
        url: url,
        data: $("#form-directo").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(respuesta) {
          if (respuesta == "ok") {
            swal("La liberación de la orden ha sido inicializada.", {
              icon: "success",
            });
          } else {
            alertify.error("Error al guardar el registro");
          }
          $(":text").val(''); //Limpiar los campos tipo Text
        }
      });
      ordenes_comenzadas();
    }
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    })
  </script>
</body>

</html>