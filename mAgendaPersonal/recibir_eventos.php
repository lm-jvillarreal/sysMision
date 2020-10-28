<?php
// liste des événements
include 'conexion_calendario.php';
include '../global_seguridad/verificar_sesion.php';
$filtro=(!empty($registros_propios) == '1')?"WHERE id_usuario = '$id_usuario'":"";
 $json = array();
 // requête qui récupère les événements
 $requete = "SELECT * FROM agenda ".$filtro." ORDER BY id";

 // exécution de la requête
 $resultat = $bdd->query($requete) or die(print_r($bdd->errorInfo()));
 
 // envoi du résultat au success
 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));
 
?>