<?php
session_start();
if (!isset($_SESSION["logged"]) || $_SESSION['opravneni'] != "Redaktor") {
    echo "Forbidden";
    return;
}

require('connect.php');

$prispevek = $_POST['id'];

$check_reviews = "SELECT COUNT(*) as total FROM recenze WHERE recenze_prispevek = '{$prispevek}'";
$result = mysqli_query($db_connection, $check_reviews);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    echo "Forbidden";
    return;
}

if ($_POST['duedate'] < date('Y-m-d')) {
    header("Location: ../result.php?msg=Datum je neplatné");
    return;
}

if ($_POST['recenzent1'] == $_POST['recenzent2']) {
    header("Location: ../result.php?msg=Recenzenti se nesmí shodovat");
    return;
}

$change_status = "UPDATE prispevek SET
prispevek_status = 3 
WHERE prispevek_id = '{$prispevek}'";
mysqli_query($db_connection, $change_status);

$sql = "INSERT INTO recenze(recenze_prispevek, recenze_redaktor, recenze_due_date, recenze_datum_zadani, recenze_recenzant) VALUES 
({$prispevek}, '{$_SESSION['login']}', '{$_POST['duedate']}', '" . date('Y-m-d') . "', '{$_POST['recenzent1']}'),
({$prispevek}, '{$_SESSION['login']}', '{$_POST['duedate']}', '" . date('Y-m-d') . "', '{$_POST['recenzent2']}')";


if (mysqli_query($db_connection, $sql)) {
    $_POST = array();
    mysqli_close($db_connection);
    header("Location: ../prispevek.php?id=" . $prispevek);
} else {
    $_POST = array();
    echo 'Chyba: ' . mysqli_error($db_connection);
    mysqli_close($db_connection);
}
