<html>
	<head>
		<title>Carga de imágenes con Ajax usando PHP y jQuery</title>
		<link rel="stylesheet" href="style.css" />
		<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed|Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- <script src="script.js"></script> -->
	</head>
	<body>
		<div class="main">
			<h1>Carga de imágenes Ajax</h1><br/>
			<hr>
			<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
				<div id="image_preview" ><img id="previewing" src="noimage.png" /></div>
				<hr id="line" >
				<div id="selectImage">
				<label>Selecciona tu imagen</label><br/>
				<input type="file" name="file" id="file" required />
				<input type="file" name="file2" id="file2" required />
				<input type="submit" value="Subir imágen" class="submit" />
				</div>
			</form>
		</div>
		<h4 id='loading' >Cargando..</h4>
		<div id="message"></div>
	</body>
	<script type="text/javascript">
		$("#uploadimage").on('submit',(function(e) {
		e.preventDefault();
		$("#message").empty(); 
		$('#loading').show();
		$.ajax({
        	url: "subir_archivo.php",   	// URL a la que se envía la solicitud
			type: "POST",      				// Tipo de solicitud que se enviará, llamado como método 
			data:  new FormData(this), 		// Datos enviados al servidor 
			contentType: false,       		// El tipo de contenido utilizado al enviar datos al servidor. El valor predeterminado es: "application / x-www-form-urlencoded"
    	    cache: false,					// Para no poder solicitar que las páginas se almacenen en caché
			processData:false,  			// Para enviar DOMDocument o archivo de datos no procesados, se establece en falso (es decir, los datos no deben estar en forma de cadena)
			success: function(data)  		// Una función a ser llamada si la solicitud tiene éxito
		    {
			$('#loading').hide();
			$("#message").html(data);			
		    }	        
		   });
		}));
 
	// Función para previsualizar la imagen
		$(function() {
	        $("#file").change(function() {
				$("#message").empty();         // Para eliminar el mensaje de error anterior
				var file = this.files[0];
				var imagefile = file.type;
				var match= ["image/jpeg","image/png","image/jpg"];	
				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
				{
				$('#previewing').attr('src','noimage.png');
				$("#message").html("&lt;p id='error'&gt;Selecciona un archivo de imagen válido&lt;/p&gt;"+"&lt;h4&gt;Nota&lt;/h4&gt;"+"&lt;span id='error_message'&gt;Solo jpeg, jpg y png Tipo de imágenes permitidas&lt;/span&gt;");
				return false;
				}
	            else
				{
	                var reader = new FileReader();	
	                reader.onload = imageIsLoaded;
	                reader.readAsDataURL(this.files[0]);
	            }		
	        });
	    });
		function imageIsLoaded(e) { 
			$("#file").css("color","green");
	        $('#image_preview').css("display", "block");
	        $('#previewing').attr('src', e.target.result);
			$('#previewing').attr('width', '250px');
			$('#previewing').attr('height', '230px');
		};
	// });
	</script>
</html>