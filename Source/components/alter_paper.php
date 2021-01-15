<?php

$id = $_POST['id'];
$nazev = $_POST['nazev'];
$spoluautori = $_POST['spoluautori'];
$cislo = $_POST['cislo'];
$status = $_POST['status'];

require('connect.php');

$old_data_sql = "SELECT * FROM prispevek WHERE prispevek_id = '{$id}'";
$result = mysqli_query($db_connection, $old_data_sql);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o příspěvku";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);

session_start();
$is_logged = isset($_SESSION["logged"]);
$is_admin = false;
$is_self = false;
if ($is_logged) {
    $is_permitted = $_SESSION["opravneni"] == "Admin" || $_SESSION["opravneni"] == "Redaktor";
    $is_self = $data["prispevek_autor"] == $_SESSION["login"];
}

if (!$is_logged || (!$is_permitted && !$is_self)) {
    echo "Forbidden";
    return;
}

$prispevek_query = "UPDATE prispevek SET 
prispevek_nazev = '{$nazev}', 
prispevek_spoluautori = '{$spoluautori}', 
prispevek_tematicke_cislo = '{$cislo}'";
if ($_SESSION["opravneni"] != "autor") {
    $prispevek_query = $prispevek_query . ", prispevek_status = '$status'";
}
$prispevek_query = $prispevek_query . " WHERE prispevek_id = '{$id}'";
$prispevek_query = trim(preg_replace('/\s+/', ' ', $prispevek_query));

if (mysqli_query($db_connection, $prispevek_query)) {
    $_POST = array();
    header('Location: ../prispevek.php?id=' . $id);
    mysqli_close($db_connection);
} else {
    $_POST = array();
    header('Location: ../result.php?msg=Chyba: '. mysqli_error($db_connection));
    mysqli_close($db_connection);
}
