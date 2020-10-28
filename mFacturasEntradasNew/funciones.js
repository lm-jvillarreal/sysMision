function cargar_tabla()
    {
      $('#lista').dataTable().fnDestroy();
      $('#lista').DataTable( 
          {
              aLengthMenu: [
                  [25, 50, 100, 200, -1],
                  [25, 50, 100, 200, "All"]
              ],
              iDisplayLength: -1,
              'language': {"url": "../plugins/DataTables/Spanish.json"},
              "ajax": {
                  "type": "POST",
                  "url": "tabla.php",
                  "dataSrc": "",
                  "data": {}
              },
              "columns": [
                  { "data": "#" },
                  { "data": "Bodega" },
                  { "data": "Codigo" },
                  { "data": "Nombre" },
                  { "data": "Descripción" },
                  { "data": "Existencia" },
                  { "data": "Editar" }
              ]
          } );
    }

function CargarBodega()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_bodega.php',
        success: function(response) 
              {
                document.getElementById("bodega").innerHTML=response;
              }
      });
    }

function CargarSistema()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_sistema.php',
        success: function(response) 
              {
                document.getElementById("sistema").innerHTML=response;
              }
      });
    }

function consulta_carta(id) {
    $.ajax({
        url: "consulta_datos_carta.php",
        type: "POST",
        dateType: "html",
        data: {
            'id': id
        },
        success: function(respuesta) {
          var e = eval(respuesta);
            $('#proveedor2').val(e[5]);
            $('#factura2').val(e[0]);
            $('#total_carta').val(e[6]);
            
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
  }
function guardar_relacion(id, total) {
    var id_nota = $('#folio_mov').val();
    $.ajax({
        url: "cartas_notas.php",
        type: "POST",
        dateType: "html",
        data: {
            'id': id,
            'id_nota': id_nota,
            'total': total
        },
        success: function(respuesta) {
          if (respuesta > 0) {
            $('#dif').val(respuesta);
              const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
              },
              buttonsStyling: false,
            })

          swalWithBootstrapButtons.fire({
            title: 'Tienes una diferencia de $' + respuesta + '!',
            text: "Que deseas hacer?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Registrar Diferencia!',
            cancelButtonText: 'Subir carta faltante!',
            reverseButtons: true
          }).then((result) => {
            if (result.value) {

              mostrar_tabla(id_nota);
            } else if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.cancel
            ) {
              //alert("fun");
              $('#modal_carta').modal('show');
              //smostrar_tabla_notas();
            }
          })

          }else{
            alert("Ya no hay diferencia");
            location.reload();
          }
          //alertify.success("Registrado");
          // if (respuesta == "true") {
          //   alertify.success("Diferencia correcta");
          // }else{
          //   alertify.error("Aun queda diferencia sin justificar");
          // }
            
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function filtro() {
  var id = $('#id_nota').val();
  var radio = $('input:radio[name=seleccion]:checked').val();
  if (radio == 1) {
    mostrar_tabla(id);
  }else if(radio == 2){
    $('#modal_carta').modal('show');
  }else if(radio == 3){
    descuento_general();
  }else if(radio == 4){
    otra_entrada();
  }else{
    alert("Seleccione otra opcion");
  }
}

function descuento_general() {
  var id_nota = $('#id_nota').val();
    $.ajax({
        url: "descuento_general.php",
        type: "POST",
        dateType: "html",
        data: {
            'id_nota': id_nota
        },
        success: function(response) {
            alertify.success("Descuento registrado");
            $('#dif').val("0");
        },
        error: function(xhr, status) {

        },
    });
}

function otra_entrada() {
  $('#modal_entrada').modal('show');
}

function insertar_otra() {
  $.ajax({
        url: "insertar_otra.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatosEntradaDos').serialize(),
        success: function(response) {
            // alertify.success("Descuento registrado");
            // $('#dif').val("0");
        },
        error: function(xhr, status) {
        },
    });
}

function editar_dato(tipo, proveedor, sucursal, movimiento, folio, total, id, id_sucursal) {
  
  if (tipo == 1) {
    location.href="index_editar.php?proveedor="+proveedor + "&sucursal="+sucursal + "&movimiento="+movimiento + "&folio="+folio + "&total="+total + "&id=" + id + "&id_sucursal=" + id_sucursal;
  }else{
    $('#modal_mod').modal('show');
  }
}

function eliminar_dato(id){
  $.ajax({
        url: "eliminar_dif.php",
        type: "POST",
        dateType: "html",
        data: {
            'id': id
        },
        success: function(respuesta) {
          alert("Eiminado");
          location.reload();

            
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    }); 
}