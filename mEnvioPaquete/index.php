<?php
include '../global_seguridad/verificar_sesion.php';
date_default_timezone_set('America/Monterrey');
$fecha=date("Y-m-d"); 
$hora=date ("h:i:s");
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
  <aside class="main-sidebar">
    <?php include 'menuV.php'; ?>
  </aside>
  <div class="content-wrapper">
    <section class="content">
        <div id="tabla">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Envio de Paquete | Tabla</h3>
              </div>
              <div class="box-body">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="tabbable">
                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#1" data-toggle="tab">Liberar Envios</a></li>
                            <li><a href="#2" data-toggle="tab">Imprimir Hoja</a></li>
                              <li><a href="#3" data-toggle="tab">Envios Liberados</a></li>
                          </ul>
                          <div class="tab-content">
                            <div class="tab-pane active" id="1">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" id="llenar">
                                
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="tab-pane" id="2">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" id="llenar2">
                                
                                        </div>
                                    </div>
                                </div>  
                            </div>
                            <div class="tab-pane" id="3">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="table-responsive" id="llenar3">
                                
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
        </div>
    </section>
  </div>
  <?php include '../footer2.php'; ?>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
  <div class="control-sidebar-bg"></div>
</div>
<?php include '../footer.php'; ?>
<script src="funciones.js"></script>
<script>llenar();</script>
<script>llenar2();</script>
<script>llenar3();</script>
<script type="text/javascript">
  $('.form_datetime').datetimepicker({
      //language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      forceParse: 0,
      showMeridian: 1
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
  $('.form_time').datetimepicker({
      language:  'fr',
      weekStart: 1,
      todayBtn:  1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 1,
      minView: 0,
      maxView: 1,
      forceParse: 0
  });
</script>
</body>
</html>