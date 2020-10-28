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
<body class="hold-transition skin-red sidebar-mini" onload="cargar_tabla();">
<div class="wrapper">
  <header class="main-header">
    <?php include '../header.php'; ?>
  </header>
  <aside class="main-sidebar">
    <?php include 'menuV.php'; ?>
  </aside>
  <div class="content-wrapper">
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Materiales | Detalle</h3>
          </div>
          <div class="box-body">
            <form method="POST" id="form_materiales">
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <input type="text" name="id_registro" id="id_registro" value="0" class='hidden'>
                        <label for="nombre">*Nombre</label>
                          <input type="text" name="nombre" id="nombre" class="form-control" autofocus>
                      </div>
                  </div> 
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="descripcion">*Descripción</label>
                          <input type="text" name="descripcion" id="descripcion" class="form-control">
                      </div>
                  </div> 
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="bodega">*Bodega</label>
                        <select class="form-control select2" style="width: 100%;" name="bodega" id="bodega">
                        </select>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="existencia">*Existencia</label>
                          <input type="number" name="existencia" id="existencia" class="form-control">
                      </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                      <div class="form-group">
                        <label for="proveedor">*Proveedor</label>
                          <input type="text" name="proveedor" id="proveedor" class="form-control">
                      </div>
                  </div>  
                </div>
                <div class="box-footer text-right">
                    <button type="submit" class="btn btn-danger" id="guardar">Guardar</button>
                </div>
            </form> 
          </div>
        </div>
        <div class="box box-danger">
        <div class="box-header">
          <h3 class="box-title">Lista de Materiales</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12" id="tabla">
              <div class="table-responsive">
                <table id="lista" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">#</th>
                      <!-- <th>Codigo</th> -->
  	                  <th width="15%">Bodega</th>
                      <th>Nombre</th>
                      <th >Proveedor</th>
  	                  <th width="5%">Existencia</th>
                      <th width="5%">Pedir</th>
                      <th width="10%">Editar</th>
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
                    </tr>
                  </tbody>  
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <?php include 'modal_materiales_pedidos.php'; ?>
  <?php include 'modal_usar_material.php'; ?>
  <?php include '../footer2.php'; ?>
  <div class="control-sidebar-bg"></div>
</div>
<?php include '../footer.php'; ?>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="funciones.js"></script>
<script>CargarBodega();</script>
<script>CargarSistema();</script>
<script>
  function estilo_tablas () {
    $('#lista').DataTable({
      'paging'    : false,
      'lengthChange'  : true,
      'searching'   : true,
      'ordering'    : true,
      'info'      : true,
      'autoWidth'   : true,
      'language'    : {"url": "../plugins/DataTables/Spanish.json"}
    })
   }
    $.validator.setDefaults( {
      submitHandler: function () {
        var url = "insertar.php"; 
          $.ajax({
                 type: "POST",
                 url: url,
                 data: $("#form_materiales").serialize(),
                 success: function(respuesta)
                 {
                    if(respuesta == 1)
                        {
                            alertify.error("Algunos Campos Estan Vacios.",2);
                            document.getElementById("nombre").focus();
                        }
                    else if(respuesta == 2)
                        {
                            alertify.success("Se Regitro Correctamente.",2);
                            $("#form_materiales")[0].reset();
                            // $(":text").val(''); 
                            // document.getElementById("existencia").value = "";
                            cargar_tabla();
                            CargarBodega();
                            CargarSistema();
                            // document.getElementById("nombre").focus();
                        }
                    else
                        {
                            alertify.error("Algo salio Mal.",2);    
                            $(":text").val('');
                            cargar_tabla();
                        }
                 }
               });
          return false;
      }
    });
    $( document ).ready( function () {
      $( "#form_materiales" ).validate( {
        rules: {
          nombre: "required",
          descripcion: "required",
          bodega: "required",
          existencia: "required"
        },
        messages: {
          nombre: "Campo requerido",
          descripcion: "Campo requerido",
          bodega: "Campo requerido",
          existencia: "Campo requerido"
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) 
          {
            error.addClass( "help-block" );
            if ( element.prop( "type" ) === "checkbox" ) 
              {
                error.insertAfter( element.parent( "label" ) );
              } 
            else 
              {
                error.insertAfter( element );
              }
          },
        highlight: function ( element, errorClass, validClass ) 
          {
            $( element ).parents( ".col-md-2" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-4" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-6" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-8" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-10" ).addClass( "has-error" ).removeClass( "has-success" );
            $( element ).parents( ".col-md-12" ).addClass( "has-error" ).removeClass( "has-success" );
          },
        unhighlight: function (element, errorClass, validClass) 
          {
            $( element ).parents( ".col-md-2" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-4" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-6" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-8" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-10" ).addClass( "has-success" ).removeClass( "has-error" );
            $( element ).parents( ".col-md-12" ).addClass( "has-success" ).removeClass( "has-error" );
          }
      });
    });
</script>
<script>
    function editar_registro(id){
      $.ajax({
        url: 'editar_registro.php',
        data: '&id='+ id,
        type: "POST",
        success: function(respuesta) {
          var array = eval(respuesta);

          $('#id_registro').val(id);
          $('#nombre').val(array[0]);
          $('#descripcion').val(array[1]);
          $('#bodega').val(array[2]);
          $('#existencia').val(array[3]);
          $('#proveedor').val(array[4]);
        }
      });
    }
    function pedir(id,dato){
      $.ajax({
        url: 'pedir_material.php',
        data: {'id':id,'dato':dato},
        type: "POST",
        success: function(respuesta) {
          if(respuesta == "ok"){
            alertify.success("Material Pedido Correctamente");
            cargar_tabla();
            cargar_tabla_modal();
          }else if(respuesta == "cancelado"){
            alertify.error("Cancelado Correctamente");
            cargar_tabla();
            cargar_tabla_modal();
          }else{
            alertify.success("Entregado a Sistemas");
            cargar_tabla();
            cargar_tabla_modal();
          }
        }
      });
    }
  function cargar_tabla_modal(){
		$('#lista_materiales_pedidos').dataTable().fnDestroy();
		$('#lista_materiales_pedidos').DataTable({
			'language': {"url": "../plugins/DataTables/Spanish.json"},
			"ajax": {
				"type": "POST",
				"url": "tabla_materiales_pedidos.php",
				"dataSrc": ""
			},
			"columns": [
				{ "data": "#" },
				{ "data": "Nombre" },
				{ "data": "Cantidad" },
        { "data": "Status" },
        { "data": "Cancelar" }
			]
		});
	}	
	$('#modal-default').on('show.bs.modal', function(e) {
		cargar_tabla_modal();
  });
  $(function(){
    $('.select2').select2({
      placeholder:"Seleccione una opcion"
    });
  });
  $(function () {
    $('#material').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es',
      //minimumResultsForSearch: Infinity
      ajax: { 
       url: "combo_materiales.php",
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
  });
  function llenar(id_material){
    $('#cantidad').attr('readonly', false);
    $('#guardar').attr('disabled', false);
    $.ajax({
      type: "POST",
      url: 'data.php',
      data: {'id_material':id_material}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta != "0"){
          $('#existencia_modal').html(respuesta);
          $('#cantidad_existencia').val(respuesta);
        }
      }
    });
  }
  function verificar(cantidad){
    var limite = $('#cantidad_existencia').val();
    if (cantidad < limite){
      $('#guardar').attr('disabled', false);
    }
    else if(cantidad == limite){
      $('#cantidad').attr('max', limite);
      $('#guardar').attr('disabled', false);
    }
    else{
      alertify.error("No hay suficientes piezas");
      $('#guardar').attr('disabled', true);
      $('#cantidad').attr('max', limite);
    }
  }
  $(function(){
    $("#guardar_modal").click(function(){
      var url = "usar_materiales.php"; // El script a dónde se realizará la petición.
        $.ajax({
          type: "POST",
          url: url,
          data: $("#form_datos_modal").serialize(), // Adjuntar los campos del formulario enviado.
          success: function(respuesta)
          {
            if(respuesta == "ok"){
              alertify.success("Se ha descontado de existencia correctamente");
              $('#existencia_modal').html("");
              $('#cantidad_existencia').val("0");
              $('#cantidad').val("0");
              $('#cantidad').attr('readonly');
              $("#material").select2("trigger", "select", {
                data: { id: '', text:'' }
              });
              cargar_tabla();
            }else if(respuesta == "1"){
              alertify.error("Verifica la cantidad a usar");
            }else if(respuesta == "2"){
              alertify.error("Verificar Campos");
            }else{
              alertify.error("Ha ocurrido un error");
            }
          }
        });
        return false;
    });
  });
</script>
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
<script>
  function verificar() {
    $.ajax({
      url: 'verificar.php',
      type: "POST",
      success: function(respuesta) {
        alert(respuesta);
      }
    });
  }
  function activar(numero) {
    if ($('#nueva_existencia'+numero).hasClass('hidden')){
      $('#nueva_existencia'+numero).removeClass('hidden');  
    }
    else{
      $('#nueva_existencia'+numero).addClass('hidden');
    }
  }
  function actualizar_existencia(valor,id) {
    var url = "actualizar_exi.php"; // El script a dónde se realizará la petición.
    $.ajax({
      type: "POST",
      url: url,
      data: {'valor':valor,'id':id}, // Adjuntar los campos del formulario enviado.
      success: function(respuesta)
      {
        if (respuesta == "ok"){
          cargar_tabla();
          alertify.success("Se ha Actualizado la Existencia");
        }
        else{
          alertify.error("Ha ocurrido un error");
        }
      }
    });
  }
</script>
</body>
</html>