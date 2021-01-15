<?php

session_start();
if (!isset($_SESSION["logged"]) || !isset($_GET["id"])) {
    echo "Forbidden";
    return;
}

require('components/connect.php');

$prispevek_query = "SELECT * FROM prispevek WHERE prispevek_id = {$_GET["id"]}";
$result = mysqli_query($db_connection, $prispevek_query);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o příspěvku";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);

$id = $_GET["id"];
$nazev = $data["prispevek_nazev"];
$autor = $data["prispevek_autor"];
$spoluautori = $data["prispevek_spoluautori"];
$status = $data["prispevek_status"];
$datum_vlozeni = $data["prispevek_datum_vlozeni"];
$tematicke_cislo = $data["prispevek_tematicke_cislo"];
$zmena = $data["prispevek_zmena"];

if ($autor != $_SESSION["login"] && $_SESSION["opravneni"] == "Autor") {
    echo "Forbidden";
    return;
}

$check_login = "SELECT * FROM uzivatel WHERE uzivatel_login = '{$autor}'";
$result = mysqli_query($db_connection, $check_login);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o uživateli";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);

$autor_jmeno = $data["uzivatel_jmeno"] . " " . $data["uzivatel_prijmeni"];

if ($tematicke_cislo) {
    $check_cislo = "SELECT * FROM cislo WHERE cislo_id = '{$tematicke_cislo}'";
    $result = mysqli_query($db_connection, $check_cislo);
    if (mysqli_num_rows($result) != 1) {
        echo "Chyba při získávání informací o čísle časopisu";
        mysqli_close($db_connection);
        return;
    }
    $data = mysqli_fetch_assoc($result);
    $tematicke_cislo_nazev = $data["cislo_nazev"];
} else {
    $tematicke_cislo_nazev = "";
}

$texty = array();
$check_cislo = "SELECT * FROM text WHERE text_prispevek = '{$id}'";
$result = mysqli_query($db_connection, $check_cislo);
if (mysqli_num_rows($result)) {
    while ($data = mysqli_fetch_assoc($result)) {
        $texty[$data["text_id"]] = $data["text_datum_nahrani"];
    }
}


?>

<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <?php

        echo "

        <div class='content-section'>
            <div class='account-info'>
                <h2>{$nazev}</h2>
                <div class='account-table'>
                    <table>
                        <colgroup>
                            <col style='width: 200px;' />
                            <col/>
                        </colgroup>
                        <tr>
                            <td>Autor</td>
                            <td><a href='ucet.php?user={$autor}'>{$autor_jmeno}</a></td>
                        </tr>
                        <tr>
                            <td>Spoluautoři</td>
                            <td>{$spoluautori}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{$status}</td>
                        </tr>
                        <tr>
                            <td>Datum vložení</td>
                            <td>".date_format(date_create($datum_vlozeni),"d. m. Y")."</td>
                        </tr>
                        <tr>
                            <td>Tématické číslo</td>
                            <td>{$tematicke_cislo_nazev}</td>
                        </tr>
                        <tr>
                            <td>Poslední změna</td>
                            <td>".date_format(date_create($zmena),"d. m. Y \\v H:i:s")."</td>
                        </tr>
                        <tr>
                            <td>Texty</td>
                            <td>
                                <ul>";

        foreach ($texty as $t_id => $t_datum) {
            echo "<li>
            <a href='display.php?id={$t_id}'>".date_format(date_create($t_datum),"d. m. Y \\v H:i:s")."</a>";
            if ($_SESSION["opravneni"] == "Admin" || $autor == $_SESSION["login"]) {
                echo "<a title='Smazat text' class='inline-button' href='confirm.php?msg=Opravdu chcete smazat text {$t_datum}?&yes=components/delete_text.php?id=" . $t_id . "&no=" . urlencode($_SERVER['REQUEST_URI']) . "'>✖</a>";
            }
            echo "
            </li>";
        }
        echo "
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        <div class='submit-center'>
        ";

        $check_reviews = "SELECT *, rec.uzivatel_jmeno as recenzent_jmeno, rec.uzivatel_prijmeni as recenzent_prijmeni, red.uzivatel_jmeno as redaktor_jmeno, red.uzivatel_prijmeni as redaktor_prijmeni FROM recenze JOIN uzivatel rec ON recenze_recenzant = rec.uzivatel_login JOIN uzivatel red ON recenze_redaktor = red.uzivatel_login WHERE recenze_prispevek = '{$id}'";
        $result = mysqli_query($db_connection, $check_reviews);

        if ($autor == $_SESSION["login"]) {
            echo "
            <form method='post' action='components/add_text.php' enctype='multipart/form-data'>
            <label for='file-field' class='button'>
                <div class='button-text-center'>Přidat text</div>
            </label>
            <input id='file-field' type='file' name='prispevek_text' accept='.txt' onchange='this.form.submit()'>
            <input type='hidden' name='prispevek' value='{$id}'>
            </form>";
        }

        if ($autor == $_SESSION["login"] || $_SESSION["opravneni"] == "Admin" || $_SESSION["opravneni"] == "Redaktor") {
            echo "
            <a class='button' href='upravit_prispevek.php?id=" . $id . "'>
            <div class='button-text-center'>Upravit příspěvek</div>
            </a>";
        }

        if ($_SESSION["opravneni"] == "Redaktor" && mysqli_num_rows($result) == 0) {
            echo "
            <a class='button' href='volba_recenzentu.php?id=" . $id . "'>
            <div class='button-text-center'>Zvolit recenzenty</div>
            </a>";
        }

        if ($_SESSION["opravneni"] == "Admin") {
            echo "
            <a class='button' href='confirm.php?msg=Opravdu chcete smazat příspěvek {$nazev}?&yes=components/delete_paper.php?id=" . $id . "&no=" . urlencode($_SERVER['REQUEST_URI']) . "'>
            <div class='button-text-center'>Smazat příspěvek</div>
            </a>";
        }
        echo "</div>";

        if (mysqli_num_rows($result) > 0) {
            $i = 1;
            $radek = mysqli_fetch_assoc($result);
            echo "<div class='account-info'>
            <h2>Recenze příspěvku</h2>
            <div class='account-table'>";
            echo "
                <table>
                <colgroup>
                    <col style='width: 200px;' />
                    <col/>
                </colgroup>
                <tr>
                    <td>Datum zadání</td>
                    <td>".date_format(date_create($radek['recenze_datum_zadani']),"d. m. Y")."</td>
                </tr>
                <tr>
                    <td>Termín</td>
                    <td>".date_format(date_create($radek['recenze_due_date']),"d. m. Y")."</td>
                </tr>
                <tr>
                    <td>Zadavatel</td>
                    <td><a href='ucet.php?user={$radek['recenze_redaktor']}'>{$radek['redaktor_jmeno']} {$radek['redaktor_prijmeni']}</a></td>
                </tr>
                </table>";
            do {
                $hodnoceni = "{$radek['recenze_hodnoceni_a']}/{$radek['recenze_hodnoceni_b']}/{$radek['recenze_hodnoceni_c']}/{$radek['recenze_hodnoceni_d']}";
                if ($hodnoceni == "///") {
                    $hodnoceni = "Nehodnoceno";
                }
                echo "
                <h3>Recenze {$i}</h3>
                <table>
                <colgroup>
                    <col style='width: 200px;' />
                    <col/>
                </colgroup>
                <tr>
                    <td>Recenzent</td>
                    <td><a href='ucet.php?user={$radek['recenze_recenzant']}'>{$radek['recenzent_jmeno']} {$radek['recenzent_prijmeni']}</a></td>
                </tr>
                <tr>
                    <td>Hodnocení</td>
                    <td>{$hodnoceni}</td>
                </tr> ";
                if ($radek["recenze_hodnoceni_a"] > 0) {
                    echo "<tr>
                    <td>Datum recenze</td>
                    <td>".date_format(date_create($radek['recenze_datum_recenze']),"d. m. Y")."</td>
                    </tr> ";
                }
                if (strlen($radek['recenze_text']) > 0) {
                    echo "<tr>
                    <td>Text</td>
                    <td>{$radek['recenze_text']}</td>
                    </tr>";
                }
                echo "
                </table>";
                if ($radek["recenze_recenzant"] == $_SESSION["login"] && $radek["recenze_hodnoceni_a"] == 0) {
                    echo "
                        <div class='submit-center'>
                        <a class='button' href='tvorba_recenze.php?id=" . $radek["recenze_id"] . "'>
                        <div class='button-text-center'>Podat recenzi</div>
                        </a>
                        </div>";
                }
                $i = $i + 1;
            } while ($radek = mysqli_fetch_assoc($result));
            echo "
            </div>
            </div>";
        }
        echo "
        </div>
        ";
        mysqli_close($db_connection);
        require("components/footer.php");
        ?>
    </div>
</body>

</html>