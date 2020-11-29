<?php

if(session_id() == "")
{
    session_start();
}

if(!isset($_SESSION["logged"]) || $_SESSION["opravneni"] != "Admin")
{
    echo "Unauthorized";
    return;
}

require('connect.php');

if(!isset($_GET['user']))
{
    echo "No user specified";
    return;
}

$login = $_GET['user'];

$sql = "DELETE FROM uzivatel WHERE uzivatel_login = '{$login}'";
if (mysqli_query($db_connection, $sql)) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: ../result.php?msg=Uživatel byl úspěšně vymazán');
} else {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: ?msg=Chyba: ' . $sql . ' ' . mysqli_error($db_connection));
}
