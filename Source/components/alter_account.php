<?php

$login = $_POST['login'];
$jmeno = $_POST['jmeno'];
$prijmeni = $_POST['prijmeni'];
$email = $_POST['email'];
$opravneni = $_POST['opravneni'];
$tel = $_POST['tel'];
$instituce = $_POST['instituce'];
$adresa = $_POST['adresa'];

require('connect.php');

$check_login = "SELECT *, uzivatel_opravneni+0 as uzivatel_opravneni_num FROM uzivatel WHERE uzivatel_login = '{$login}'";
$result = mysqli_query($db_connection, $check_login);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o uživateli";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);

session_start();
$is_logged = isset($_SESSION["logged"]);
$is_admin = false;
$is_self = false;
if ($is_logged) {
    $is_admin = $_SESSION["opravneni"] == "Admin";
    $is_self = $login == $_SESSION["login"];
}

if ((!$is_logged && $opravneni != "Autor") || ($is_logged && (!$is_admin && $opravneni != $data["uzivatel_opravneni_num"]))) {
    echo "Forbidden";
    return;
}

$check_email = "SELECT uzivatel_login, COUNT(*) as total FROM uzivatel WHERE uzivatel_email = '{$email}'";
$result = mysqli_query($db_connection, $check_email);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0 && $data['uzivatel_login'] != $login) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: ../result.php?msg=Email již existuje');
    return;
}

$uzivatel_query = "UPDATE uzivatel SET 
uzivatel_jmeno = '{$jmeno}', 
uzivatel_prijmeni = '{$prijmeni}', 
uzivatel_email = '{$email}', 
uzivatel_opravneni = {$opravneni}, 
uzivatel_tel = '{$tel}', 
uzivatel_instituce = '{$instituce}', 
uzivatel_adresa = '{$adresa}' 
WHERE uzivatel_login = '{$login}'";
$uzivatel_query = trim(preg_replace('/\s+/', ' ', $uzivatel_query));

if (mysqli_query($db_connection, $uzivatel_query)) {
    $_POST = array();
    header('Location: ../ucet.php?user='.$login);
    mysqli_close($db_connection);
} else {
    $_POST = array();
    header('Location: ../result.php?msg=Chyba: ' . $uzivatel_query . " " . mysqli_error($db_connection));
    mysqli_close($db_connection);
}
