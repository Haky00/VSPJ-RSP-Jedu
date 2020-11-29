<?php

require('connect.php');

$login = $_POST['login'];
$heslo = $_POST['heslo'];
$jmeno = $_POST['jmeno'];
$prijmeni = $_POST['prijmeni'];
$email = $_POST['email'];
$opravneni = $_POST['opravneni'];
$tel = $_POST['tel'];
$return_address = $_POST['return_address'];

$check_login = "SELECT COUNT(*) as total FROM Uzivatel WHERE uzivatel_login = '{$login}'";
$result = mysqli_query($db_connection, $check_login);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=Login již existuje');
    return;
}

$check_email = "SELECT COUNT(*) as total FROM Uzivatel WHERE uzivatel_email = '{$email}'";
$result = mysqli_query($db_connection, $check_email);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=E-mail již existuje');
    return;
}

$uzivatel_query = "
INSERT INTO -Uzivatel(uzivatel_login, uzivatel_heslo_hash, uzivatel_jmeno, uzivatel_prijmeni, uzivatel_email, uzivatel_opravneni, uzivatel_tel) 
VALUES ('{$login}', '".sha1($heslo)."', '{$jmeno}', '{$prijmeni}', '{$email}', '{$opravneni}', '{$tel}')
";

if (mysqli_query($db_connection, $uzivatel_query)) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?success_msg=Uživatel byl úspěšně vytvořen');
} else {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: '.$return_address.'?error_msg=Chyba: ' . $uzivatel_query . ' ' . mysqli_error($db_connection));
}
