function consulta() {
    $.ajax({
        url: "consulta_datos.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
        	var array = eval(respuesta);
        	$('#autoriza').val(array[0]);
        	$('#ctb_usuario').val(array[1]);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function guardar() {
    $.ajax({
        url: "guardar_registro.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
            //alert("Registro insertado");
            location.reload();
            //document.write(respuesta);
        	// if (respuesta == "FALSE") {
        	// 	alert("Este registro ya existe");
        	// 	$('#frmDatos')[0].reset();
        	// }else{
        	// 	alert("Registro insertado");
        	// 	$('#frmDatos')[0].reset();
         //        cargar_tabla();
        	// }
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}

function cargar_tabla(){
	$.ajax({
        url: "tabla.php",
        type: "POST",
        dateType: "html",
        data: $('#frmDatos').serialize(),
        success: function(respuesta) {
        	$('#contenedor').html(respuesta);
        },
        error: function(xhr, status) {
            alert(xhr);
        },
    });
}