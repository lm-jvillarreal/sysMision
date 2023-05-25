<?php
include '../global_seguridad/verificar_sesion.php';
?>
<!DOCTYPE html>
<html>

<head>
	<?php include '../head.php'; ?>
	<link rel="stylesheet" href="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.css">
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
                            <h3 class="box-title">Explosión de Materiales | Resumen</h3>
                        </div>
                        <div class="box-body">
                            <form>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Porcentaje | ejemplo: 20</label>
                                        <input type="number" class="form-control" id="txtId" name="txtId">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            <a href="#" class="btn btn-danger" id="btn-realizar" name="btn-realizar">Buscar</a>
                        </div>
                    </div>
                    <div class="box box-danger">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id='lista_articulos' class='table table-striped table-bordered' cellspacing='0' width='100%'>
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th width='10%'>CV</th>
                                                    <th width='10%'>PV. sugerido sin IEPS</th>
                                                    <th width='10%'>Precio sin IEPS</th>
                                                    <th width='10%'>Precio de venta</th>
                                                    <th width='10%'>CV %</th>
                                                    <th width='10%'>Margen Bruto %</th>
                                                    <th width='10%'>Utilidad Bruta</th>
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
        <script src="../d_plantilla/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function(e) {
                cargar_tabla(70);
            });

            function cargar_tabla(porcentaje) {
                $('#lista_articulos').dataTable().fnDestroy();
                $('#lista_articulos').DataTable({
                    'language': {
                        "url": "../plugins/DataTables/Spanish.json"
                    },
                    "paging": false,
                    "dom": 'Bfrtip',
                        buttons: [
                        {
                            extend: 'pageLength',
                            text: 'Registros',
                            className: 'btn btn-default'
                        },
                        {
                            extend: 'excel',
                            text: 'Exportar a Excel',
                            className: 'btn btn-default',
                            title: 'FaltantesLista',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'Exportar a PDF',
                            className: 'btn btn-default',
                            title: 'FaltantesLista',
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
                        },
                    ],
                    "ajax": {
                        "type": "POST",
                        "url": "tabla_articulos.php",
                        "dataSrc": "",
                        "data": {
                            porcentaje : porcentaje
                        }
                    },
                    "columns": [{
                            "data": "platillo"
                        },
                        {
                            "data": "costo"
                        },
                        {
                            "data": "ieps_sugerido"
                        },
                        {
                            "data": "sin_ieps"
                        },
                        {
                            "data": "con_iva"
                        },
                        {
                            "data": "cv"
                        },
                        {
                            "data": "mb"
                        },
                        {
                            "data": "utilidad"
                        }
                    ]
                });
            }

        $('#btn-realizar').click(function() {
            var val = $("#txtId").val();
            if (val == "") {
                alertify.error("Existen campos vacíos");
            }else{
                cargar_tabla(val)
            }
        });

        </script>
    </body>
</html>