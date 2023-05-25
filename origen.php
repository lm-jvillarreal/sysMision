<?php
$ip_address = $_SERVER['REMOTE_ADDR'];
echo "La dirección IP local del cliente es: " . $ip_address;
if($ip_address=="172.16.1.253" || $ip_address=="172.16.1.253"){
    echo "si coincide";
}
?>