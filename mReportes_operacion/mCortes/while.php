<?php  
date_default_timezone_set('America/Monterrey');
$fechauno = "18-01-2010";
$fechados = "10-02-2010";

$fechaaamostar = $fechauno;
while(strtotime($fechados) >= strtotime($fechauno))
{
if(strtotime($fechados) != strtotime($fechaaamostar))
{
echo "$fechaaamostar<br />";
$fechaaamostar = date("d-m-Y", strtotime($fechaaamostar . " + 1 day"));
}
else
{
echo "$fechaaamostar<br />";
break;
}
}

?>
