<?php
	 try {
	 	$bdd = new PDO('mysql:host=200.1.1.178;dbname=sysadmision2', 'jvillarreal', 'Xoops1991');
	 } catch(Exception $e) {
	 	exit('Impossible de se connecter à la base de données.');
	 }
?>