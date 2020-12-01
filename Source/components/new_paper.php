<?php

session_start();
$is_logged = isset($_SESSION["logged"]);
if (!$is_logged || $_SESSION["opravneni"] != "Autor") {
    echo "Forbidden";
    return;
}

$nazev = $_POST['nazev'];
$cislo = $_POST['cislo'];
if (isset($_POST['spoluautori'])) {
    $spoluautori = $_POST['spoluautori'];
}
else {
    $spoluautori = "";
}

if ($_FILES['prispevek_text']['size'] != 0) {
    if ($_FILES['prispevek_text']['size'] > 2 * 1024 * 1024) {
        header("Location: ../result.php?msg=Příspěvek nebyl vytvořen - velikost souboru překračuje 2MB");
        return;
    }
    $target_dir = "../uploads/";
    $uploadOk = 1;
}

require('connect.php');

$prispevek_query = "INSERT INTO prispevek(prispevek_nazev, prispevek_autor, prispevek_spoluautori, prispevek_status, prispevek_datum_vlozeni, prispevek_tematicke_cislo, prispevek_zmena) VALUES ('{$nazev}', '" . $_SESSION["login"] . "', '{$spoluautori}', 1, '" . date('Y-m-d') . "', '{$cislo}', '".date('Y-m-d H:i:s')."')";

if (mysqli_query($db_connection, $prispevek_query)) {
    if ($_FILES['prispevek_text']['size'] != 0) {
        $file_query = "
        INSERT INTO text(text_prispevek, text_datum_nahrani) VALUES ('" . mysqli_insert_id($db_connection) . "', '" . date('Y-m-d H:i:s') . "')
        ";
        if (!mysqli_query($db_connection, $file_query))
        {
            header('Location: ../result.php?error_msg=Chyba: ' . mysqli_error($db_connection));
            mysqli_close($db_connection);
            return;
        }
        $file_path = $target_dir . mysqli_insert_id($db_connection) . ".txt";
        move_uploaded_file($_FILES["prispevek_text"]["tmp_name"], $file_path);
    }
    $_POST = array();
    mysqli_close($db_connection);
    header("Location: ../result.php?msg=Příspěvek byl úspěšně vytvořen");
} else {
    $_POST = array();
    header('Location: ../result.php?error_msg=Chyba: ' . mysqli_error($db_connection));
    mysqli_close($db_connection);
}
