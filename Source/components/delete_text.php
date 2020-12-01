<?php

session_start();

if(!isset($_SESSION["logged"]) || !isset($_GET["id"]))
{
    echo "Forbidden";
    return;
}

$id = $_GET["id"];

require('connect.php');

$sql = "SELECT * FROM text WHERE text_id = {$id}";
$result = mysqli_query($db_connection, $sql);
if (mysqli_num_rows($result) != 1) {
    echo "Vyskytla se chyba při získávání textu";
    return;
}
$data = mysqli_fetch_assoc($result);
$filename = realpath("../uploads/{$data["text_id"]}.txt");

$sql = "SELECT * FROM prispevek WHERE prispevek_id = {$data['text_prispevek']}";
$result = mysqli_query($db_connection, $sql);
if (mysqli_num_rows($result) != 1) {
    echo "Vyskytla se chyba při získávání příspěvku";
    return;
}
$data = mysqli_fetch_assoc($result);
$prispevek_id = $data["prispevek_id"];

if(!$_SESSION["opravneni"] == "Admin" && $_SESSION["login"] != $data["prispevek_autor"])
{
    echo "Forbidden";
    return;
}

unlink($filename);
$sql = "DELETE FROM text WHERE text_id = {$id}";
if (mysqli_query($db_connection, $sql)) {
    $_POST = array();
    header('Location: ../prispevek.php?id=' . $prispevek_id);
    mysqli_close($db_connection);
} else {
    $_POST = array();
    header('Location: ../result.php?msg=Chyba: ' . $sql . ' ' . mysqli_error($db_connection));
    mysqli_close($db_connection);
}