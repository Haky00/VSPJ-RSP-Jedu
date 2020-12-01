<?php

$login = $_POST['login'];
$heslo = $_POST['heslo'];
$jmeno = $_POST['jmeno'];
$prijmeni = $_POST['prijmeni'];
$email = $_POST['email'];
$opravneni = $_POST['opravneni'];
$tel = $_POST['tel'];
$instituce = $_POST['instituce'];
$adresa = $_POST['adresa'];
$return_address = $_POST['return_address'];

session_start();
$is_logged = isset($_SESSION["logged"]);
$is_admin = false;
if($is_logged)
{
    $is_admin = $_SESSION["opravneni"] == "Admin";
}
if ((!$is_logged && $opravneni != 1) || ($is_logged && !$is_admin)) {
    echo "Forbidden";
    return;
}

require('connect.php');

$check_login = "SELECT COUNT(*) as total FROM uzivatel WHERE uzivatel_login = '{$login}'";
$result = mysqli_query($db_connection, $check_login);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=Login již existuje');
    return;
}

$check_email = "SELECT COUNT(*) as total FROM uzivatel WHERE uzivatel_email = '{$email}'";
$result = mysqli_query($db_connection, $check_email);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=E-mail již existuje');
    return;
}

$uzivatel_query = "
INSERT INTO uzivatel(uzivatel_login, uzivatel_heslo_hash, uzivatel_jmeno, uzivatel_prijmeni, uzivatel_email, uzivatel_opravneni, uzivatel_tel, uzivatel_instituce, uzivatel_adresa) 
VALUES ('{$login}', '".sha1($heslo)."', '{$jmeno}', '{$prijmeni}', '{$email}', '{$opravneni}', '{$tel}', '{$instituce}', '{$adresa}')
";

if (mysqli_query($db_connection, $uzivatel_query)) {
    $_POST = array();
    mysqli_close($db_connection);
    if($is_logged)
    {
    header('Location: '.$return_address.'?success_msg=Uživatel byl úspěšně vytvořen');
    }
    else
    {
    header("Location: ../result.php?msg=Uživatel byl úspěšně vytvořen, nyní se můžete <a href='prihlaseni.php'>přihlásit</a>");
    }
} else {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=Chyba: ' . $uzivatel_query . ' ' . mysqli_error($db_connection));
}
