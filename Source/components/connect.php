<?php 

$db_servername = "localhost";
$db_username = "JMENO";
$db_password = "HESLO";
$db_name = "NAZEV";
$db_connection = mysqli_connect($db_servername, $db_username, $db_password, $db_name);
mysqli_set_charset($db_connection, "utf8");

?>
