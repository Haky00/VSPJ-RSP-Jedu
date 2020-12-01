<?php

require('connect.php');

$login = $_POST['login'];
$heslo = $_POST['heslo'];
$return_address = $_POST['return_address'];

$check_login = "SELECT * FROM uzivatel WHERE uzivatel_login = '{$login}' AND uzivatel_heslo_hash = '".sha1($heslo)."'";
$result = mysqli_query($db_connection, $check_login);
if(mysqli_num_rows($result) == 1)
{
    $data = mysqli_fetch_assoc($result);
    mysqli_close($db_connection);
    session_start();
    $_SESSION["logged"] = true;
    $_SESSION["opravneni"] = $data["uzivatel_opravneni"];
    $_SESSION["login"] = $data["uzivatel_login"];
    header('Location: ../index.php');
}
else
{
    header('Location: '.$return_address.'?error_msg=Neplatné přihlášení ');
}
$_POST = array();