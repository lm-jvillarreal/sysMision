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
    <?php include 'menuV2.php'; ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="box box-danger">
          <div class="box-header">
            <h3 class="box-title">Captura de Efectivos</h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <input type="text" name="cant_input" id="cant_input" class="form-control">
              </div>
              <div class="col-md-2">
                <button onclick="myFunction($('#cant_input').val())" class="btn btn-danger" id="crear">Crear</button>
              </div>
            </div>
            <br>
            <div class="row">
              <form id="testform" action="prueba.php" method="POST">            
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Concepto</label>
                    <div id="concepto"></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>*Cantidad</label>
                    <div id="cantidad"></div>
                  </div>
                </div>
                <div class="box-footer text-right">
                  <button class="btn btn-warning" type="submit" name="guardar">Guardar</button>
                </div>
              </form>
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
<script>
  $('#e'+1).focus();
</script>
<script>
  function Totalt(){
    var resultado = 0;
    var numero;

    for (var i = 1; i <= 7; i++) {
        numero = $('#t'+i).val();
        if (numero == ""){
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
    $('#total_tarjetas').val(resultado.toFixed(2));
  }
  function Totalb(){
    var resultado = 0;
    var numero;

    for (var i = 1; i <= 6; i++) {
        numero = $('#b'+i).val();
        if (numero == ""){
          numero = 0;
        }
        resultado += parseFloat(numero);
      }
    $('#total_bonos').val(resultado.toFixed(2));
  }
</script>
<script>
function myFunction(cantidad) {
  for (var i = 1; i <= cantidad; i++) {
    var input = document.createElement("INPUT");
    input.classList.add('form-control');
    input.name = "concepto[]";
    input.id = 'o'+i;
    document.getElementById("concepto").appendChild(input);

    var br = document.createElement("BR");
    document.getElementById("concepto").appendChild(br); 

    var div = document.createElement("DIV");
    div.classList.add('input-group');
    div.id = "d" + i;
    document.getElementById("cantidad").appendChild(div);
    
    var div2 = document.createElement("DIV");
    div2.classList.add('input-group-addon');
    document.getElementById("d"+i).appendChild(div2);
    texto = document.createTextNode("$");
    div2.appendChild(texto);

    var input1 = document.createElement("INPUT");
    input1.classList.add('form-control');
    input1.name = "cantidad[]";
    input.id = 'c'+i;
    document.getElementById("d"+i).appendChild(input1);

    var br1 = document.createElement("BR");
    document.getElementById("cantidad").appendChild(br1);
  }
  $("#cant_input").prop("disabled", true);
  $("#crear").prop("disabled", true);
}
</script>
<script>
  function mensaje(folio){
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
      url: 'insertar_efectivo.php',
      type: 'POST',
      dateType: 'html',
      data: $('#form_efectivos').serialize(),
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
            alert(respuesta);
            alert("Ha ocurrido un error");
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
<script>
  $(function () {
    $('.select2').select2({
      placeholder: 'Seleccione una opcion',
      lenguage: 'es'
    })
  })
</script>
<script>
  function total_tarjetas(cantidad,morralla,id){
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