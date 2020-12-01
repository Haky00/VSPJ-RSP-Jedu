<?php

if(session_id() == "")
{
    session_start();
}

if(!isset($_SESSION["logged"]) || $_SESSION["opravneni"] != "Admin")
{
    echo "Forbidden";
    return;
}

require('connect.php');

if(!isset($_GET['id']))
{
    echo "No paper specified";
    return;
}

$id = $_GET['id'];

$sql = "SELECT * FROM text WHERE text_prispevek = {$id}";
$result = mysqli_query($db_connection, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($radek = mysqli_fetch_assoc($result)) {
        $filename = realpath("../uploads/{$radek["text_id"]}.txt");
        unlink($filename);
    }
}

$sql = "DELETE FROM prispevek WHERE prispevek_id = '{$id}'";
if (mysqli_query($db_connection, $sql)) {
    $_POST = array();
    header('Location: ../result.php?msg=Příspěvek byl úspěšně vymazán' . $filename);
    mysqli_close($db_connection);
} else {
    $_POST = array();
    header('Location: ../result.php?msg=Chyba: ' . $sql . ' ' . mysqli_error($db_connection));
    mysqli_close($db_connection);
}