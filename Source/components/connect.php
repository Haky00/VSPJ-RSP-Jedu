<?php 

$db_servername = "localhost";
$db_username = "USERNAME";
$db_password = "PASSWORD";
$db_name = "DB_NAME";
$db_connection = mysqli_connect($db_servername, $db_username, $db_password, $db_name);
mysqli_set_charset($db_connection, "utf8");

?>
