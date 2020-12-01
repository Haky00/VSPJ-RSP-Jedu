<?php

session_start();
$is_logged = isset($_SESSION["logged"]);
if (!$is_logged || $_SESSION["opravneni"] != "Autor") {
    echo "Forbidden";
    return;
}

$prispevek = $_POST['prispevek'];

if ($_FILES['prispevek_text']['size'] == 0) {
    header("Location: ../result.php?msg=Nastala chyba při nahrávání souboru");
    return;
}


if ($_FILES['prispevek_text']['size'] > 2 * 1024 * 1024) {
    header("Location: ../result.php?msg=Text nebyl vytvořen - velikost souboru překračuje 2MB");
    return;
}

require('connect.php');

$target_dir = "../uploads/";
$uploadOk = 1;
$file_query = "
        INSERT INTO text(text_prispevek, text_datum_nahrani) VALUES ('" . $prispevek . "', '" . date('Y-m-d H:i:s') . "')
        ";
if (!mysqli_query($db_connection, $file_query)) {
    echo 'Location: ../result.php?error_msg=Chyba: ' . mysqli_error($db_connection);
    mysqli_close($db_connection);
    return;
}
$file_path = $target_dir . mysqli_insert_id($db_connection) . ".txt";
move_uploaded_file($_FILES["prispevek_text"]["tmp_name"], $file_path);
mysqli_close($db_connection);
header('Location: ../prispevek.php?id=' . $prispevek);
