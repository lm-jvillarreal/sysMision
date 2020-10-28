function CargarBodega()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_bodega.php',
        success: function(respuesta) 
              {
                document.getElementById("bodega").value=respuesta;
              }
      });
    }

function CargarFolio()
    {
      $.ajax({
        type: 'POST',
        url: 'obtener_folio.php',
        success: function(respuesta) 
              {
                document.getElementById("folio").value=respuesta;
              }
      });
    }

function cargar_tabla()
    {
      $('#lista').dataTable().fnDestroy();
      $('#lista').DataTable( 
          {
              "paging":   false,
              "dom": 'Bfrtip',
              "buttons": [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              "ajax": {
                  "type": "POST",
                  "url": "tabla_pedido.php",
                  "dataSrc": "",
                  "data": {}
              },
              "columns": [
                  { "data": "#" },
                  { "data": "Folio" },
                  { "data": "Fecha" },
                  { "data": "Sucursal" },
                  { "data": "Usuario" },
                  { "data": "Editar" }
              ]
          } );
    }

function guardar()
    {
        $.ajax({
        url:"insertar.php",
        type:"POST",
        dateType:"html",
        data:$('#form_pedidos').serialize(),
        success:function(respuesta)
            {
                alert(respuesta);
                /*if(respuesta == 12)
                   {
                       alertify.error("Algunos Campos Estan Vacios.",2);
                   }
                else if(respuesta == '')
                   {
                       alertify.error("Algunos Campos Estan Vacios.",2);
                   }
                else
                   {
                       alertify.success("Se Guardo Exitosamente.",2);
                   }*/
            },
           error:function(xhr,status){
            alert(xhr);
             },
        });
    }

function Editar()
    {
        $.ajax({
        url:"update.php",
        type:"POST",
        dateType:"html",
        data: $("#form_materiales_editar").serialize(),
        success:function(respuesta)
            {
              
                if(respuesta == 1)
                    {
                        alertify.error("Algunos Campos Estan Vacios.",2);
                        document.getElementById("det_actividad").focus();
                    }
                else if(respuesta == 2)
                    {
                        llenarTabla();
                        location.href ="index.php";
                        document.getElementById("nombre").focus();
                    }
                else
                   {
                         alertify.error("Algo salio Mal.",2);      
                   }
            },
        error:function(xhr,status){
            alert("no se muestra");
            }
            });
    }

function validar(numero2,codigo,existencia,cantidad,bodega)
    {
        var sum;
              $.ajax({
                type: 'POST',
                url: 'calcular.php',
                data: {'codigo':codigo,
                       'existencia':existencia,
                       'cantidad':cantidad,
                       'bodega':bodega},
                  success: function(response) 
                      {
                          
                        if(response > cantidad)
                            {
                                sum = response - cantidad;
                                alertify.success("Exelente."+'<br />'+"Te quedaras con: "+sum,4);
                            }
                        else if(response < cantidad)
                            {
                                alertify.error("No cuentas con suficientes piezas."+'<br />'+"Tu cuentas con: "+response,4);
                            }
                        else if(response = cantidad)
                            {
                                sum = response - cantidad;
                                alertify.success("Exelente."+'<br />'+"Tu stock queda en 0"+'<br />'+"Encarga mas piezas.",4);
                            }
                        else if(response == 'vacio')
                            {
                                alertify.error("Algunos Campos Estan Vacios.",4);
                            }
                      }
              }); 
    }

function validar2(numero2,codigo,existencia,cantidad,bodega)
    {
        var sum;
              $.ajax({
                type: 'POST',
                url: 'calcular.php',
                data: {'codigo':codigo,
                       'existencia':existencia,
                       'cantidad':cantidad,
                       'bodega':bodega},
                  success: function(response) 
                      {
                        if(response > cantidad)
                            {
                                sum = response - cantidad;
                                alertify.success("Exelente."+'<br />'+"Te quedaras con: "+sum,4);
                            }
                        else if(response < cantidad)
                            {
                                alertify.error("No cuentas con suficientes piezas."+'<br />'+"Tu cuentas con: "+response,4);
                            }
                        else if(response = cantidad)
                            {
                                sum = response - cantidad;
                                alertify.success("Exelente."+'<br />'+"Tu stock queda en 0"+'<br />'+"Encarga mas piezas.",4);
                            }
                        else if(response == 'vacio')
                            {
                                alertify.error("Algunos Campos Estan Vacios.",4);
                            }
                      }
              }); 
    }