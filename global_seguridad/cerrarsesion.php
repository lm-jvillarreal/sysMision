<?php
session_name("sysAdMision"); 
session_start(); 
session_destroy();
session_unset();

header('Location: ../mLogin/index.php'); 
 ?>