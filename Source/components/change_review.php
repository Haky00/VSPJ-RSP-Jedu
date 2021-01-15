<?php

$id = $_POST['id'];
$h_a = $_POST['znamka_a'];
$h_b = $_POST['znamka_b'];
$h_c = $_POST['znamka_c'];
$h_d = $_POST['znamka_d'];
$text = $_POST['text'];

session_start();

if (!isset($_SESSION["logged"])) {
    echo "Forbidden";
    return;
}

require('connect.php');

$old_data_sql = "SELECT * FROM recenze WHERE recenze_id = '{$id}' AND recenze_recenzant = '{$_SESSION['login']}'";
$result = mysqli_query($db_connection, $old_data_sql);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o příspěvku";
    mysqli_close($db_connection);
    return;
}

$data = mysqli_fetch_assoc($result);

if ($data["recenze_hodnoceni_a"] > 0) {
    echo "Recenze již byla podána";
    return;
}

$recenze_query = "UPDATE recenze SET 
recenze_hodnoceni_a = {$h_a}, 
recenze_hodnoceni_b = {$h_b}, 
recenze_hodnoceni_c = {$h_c}, 
recenze_hodnoceni_d = {$h_d},
recenze_text = '{$text}',
recenze_datum_recenze = '" .date('Y-m-d'). "' 
WHERE recenze_id = {$id}";
$recenze_query = trim(preg_replace('/\s+/', ' ', $recenze_query));

if (mysqli_query($db_connection, $recenze_query)) {
    $_POST = array();
    header('Location: ../prispevek.php?id=' . $data["recenze_prispevek"]);
    mysqli_close($db_connection);
} else {
    $_POST = array();
    header('Location: ../result.php?msg=Chyba: ' . mysqli_error($db_connection));
    mysqli_close($db_connection);
}
