  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>bootstrap-datetimepicker</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- bootstrap-datetimepicker css-->
    <!-- jquery -->
    <script src="jquery/jquery-1.8.3.min.js"></script>
    
    <link href="bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

  </head>

  <div class="container">

  <legend>bootstrap-datetimepicker</legend>

     <div class="row"> 
              <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                      <label for="Fecha">Fecha:</label>
                      <div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <input class="form-control"  type="text" id='Fecha' name='Fecha' readonly>
                        <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                      </div>
                </div>
              </div>
     </div> 

  </div>

<script type="text/javascript" src="bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>

<script type="text/javascript">
// configuracion
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