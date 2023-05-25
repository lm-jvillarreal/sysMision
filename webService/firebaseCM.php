<?php

$notification = array();
//$de = $_POST["de"];
$para = $_POST["para"];
$titulo = "Tiene nuevos Mensajes";//$_POST['de'];
$detalle = "Favor de Verificarlos";//$_POST['detalle'];
$notification['titulo'] =$titulo;
$notification['detalle'] = $detalle;
$notification['image'] = '';
$notification['action'] = '';
$notification['action_destination'] = '';
$extraNotificationData = ["title" => $titulo,"body" => $detalle];
$topic = "topic_general";

$fields = array(
  'to' => '/topics/' . "170",
  'notification' => $extraNotificationData,
  'data' => $notification
);

$url = 'https://fcm.googleapis.com/fcm/send';
$llave = "AAAAnfjLA_Y:APA91bEmK65ZWWfSqLNeN6JWAY43ggir5xgDUsgRybQWSBQx9IjT8diTggQjAkww4Q9TMa61YgM3BSyPEY4I4gTPb6lO4H2H0ZOkOtS5wP78QkUnLnmbZp7dORXhi1mdoOlorXsMlo2Q";
$headers = array(
  'Authorization:
  key = '.$llave,
  'Content-Type: application/json'
);
$ch = curl_init();
// colocar url, numero de post variables y la informacion post
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// deshabilitar temporalmente ssl
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));       

$result = curl_exec($ch);
if($result === FALSE) {
    die('Curl failed: ' . curl_error($ch));
}
// Close connection
curl_close($ch);
echo $result;
/*public function notificacion($titulo,$detalle){
  $notification = array();
  $titulo = $titulo;//'La misión titulo'+$_POST['titulo'];
  $detalle = $detalle;//'La misión texto detalle'+$_POST['detalle'];
  $notification['titulo'] =$titulo;
  $notification['detalle'] = $detalle;
  $notification['image'] = '';
  $notification['action'] = '';
  $notification['action_destination'] = '';
  $extraNotificationData = ["title" => $titulo,"body" => $detalle];
  $topic = "topic_general";

  $fields = array(
  'to' => '/topics/' . $topic,
  'notification' => $extraNotificationData,
  'data' => $notification
  );

  $url = 'https://fcm.googleapis.com/fcm/send';
  $llave = 'AAAAfG1PvHI:APA91bEFybUVQAu2-XkKjtanBihUNB0z0eBdedeupxV1K7MTNzl9Fw15qKFoohUqt0NHzJVVrzDGP2C3-QEDkLiftGio6YXomHyrsjZGG20NN4xkQiHotxhxqnZKS8JjBA87qz2HxQJL';
  $headers = array(
  'Authorization:
  key = '.$llave,
  'Content-Type: application/json'
  );
  $ch = curl_init();
  // Set the url, number of POST vars, POST data
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  // Disabling SSL Certificate support temporarily
  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));       

  $result = curl_exec($ch);
  if($result === FALSE) {
      die('Curl failed: ' . curl_error($ch));
  }
  // Close connection
  curl_close($ch);
  echo $result;
}*/
//error_reporting(0);
/*include '../../global_settings/conexion.php';
  date_default_timezone_set('America/Monterrey');
  $imagen = base64_decode($_POST["imagen"]);
  $id_evidencia = $_POST['folio'];
  $id_usuario = $_POST["id_usuario"];
  $nombre = $_POST["nombre"];
  $fecha=date("Y-m-d"); 
  $hora=date ("H:i:s");
  $fechahora = $fecha.' '.$hora;
  $status = "";
  $cadenaInsertar="INSERT INTO revision_cierre_historial (ID_REVISION_CIERRE, ID_USUARIOREVISA, FECHAHORA_REVISION)VALUES('$id_evidencia','$id_usuario','$fechahora')";
  $insertar=mysqli_query($conexion,$cadenaInsertar);

  $cadenaId="SELECT IFNULL(MAX(ID),0) FROM revision_cierre_historial";
  $consultaId=mysqli_query($conexion,$cadenaId);
  $rowId=mysqli_fetch_array($consultaId);
  $id_historial=$rowId[0];
  $fecha2=date("Ymd"); 
  $hora2=date ("His");
  if($id_historial>0){
   $directorio = "img/".$id_historial.".jpg";

  if(file_put_contents($directorio,$imagen)){
    $status = "Archivo subido"; 
  }else{ 
    $status = "Error al subir el archivo"; 
  }
}
  echo $status;*/



  /*Guardador*/
      /*$titulo = $row_verificar[1];//$_POST['de'];
			$detalle = $fecha;//$_POST['detalle'];
			$notification['titulo'] = $titulo;
			$notification['detalle'] = $detalle;
			$notification['image'] = '';
			$notification['action'] = '';
			$notification['action_destination'] = '';
			$extraNotificationData = ["title" => $titulo,"body" => $detalle];
			$topic = "topic_general";
			
			$fields = array(
			  'to' => '/topics/' . "170"/*$invitados[$i]*///,
			  /*'notification' => $extraNotificationData,
			  'data' => $notification
			);
			
			$url = 'https://fcm.googleapis.com/fcm/send';
			$llave = "AAAAnfjLA_Y:APA91bEmK65ZWWfSqLNeN6JWAY43ggir5xgDUsgRybQWSBQx9IjT8diTggQjAkww4Q9TMa61YgM3BSyPEY4I4gTPb6lO4H2H0ZOkOtS5wP78QkUnLnmbZp7dORXhi1mdoOlorXsMlo2Q";
			$headers = array(
			  'Authorization:
			  key = '.$llave,
			  'Content-Type: application/json'
			);
			$ch = curl_init();
			// colocar url, numero de post variables y la informacion post
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// deshabilitar temporalmente ssl
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));       
			
			$result = curl_exec($ch);
			if($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			// Close connection
			curl_close($ch);*/
			//echo $result;
?>