<?php

session_start();
if (!isset($_SESSION["logged"])) {
    echo "Forbidden";
    return;
}
require('components/connect.php');
?>

<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

    <script src="dropdown.js"></script>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <?php
            if ($_SESSION["opravneni"] == "Admin") {
                echo "
            <h2>Uživatelé</h2>
            <div class='datatable'>
                <table>
                    <thead>
                        <tr>
                            <th>Login</th>
                            <th>Jméno</th>
                            <th>Příjmení</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th>Tel. číslo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>";
                $sql = "SELECT * FROM uzivatel";
                $result = mysqli_query($db_connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($radek = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $radek["uzivatel_login"] . "</td>";
                        echo "<td>" . $radek["uzivatel_jmeno"] . "</td>";
                        echo "<td>" . $radek["uzivatel_prijmeni"] . "</td>";
                        echo "<td>" . $radek["uzivatel_email"] . "</td>";
                        echo "<td>" . $radek["uzivatel_opravneni"] . "</td>";
                        echo "<td>" . $radek["uzivatel_tel"] . "</td>";
                        echo "<td class='button-cell'>
                                <div class='more-button'>
                                    <a onclick=showDropDown('dropdown_user_" . $radek["uzivatel_login"] . "') class='more-button-link dropdown-button'><img class='table-button' src='resources/more.png'></a>
                                    <div class='dropdown-content' id='dropdown_user_" . $radek["uzivatel_login"] . "'>
                                        <a href='ucet.php?user=" . $radek["uzivatel_login"] . "'>Detail</a>
                                        <a href='upravit_ucet.php?user=" . $radek["uzivatel_login"] . "'>Upravit</a>";
                        if ($radek["uzivatel_opravneni"] != "Admin") {
                            echo "<a href='confirm.php?msg=Opravdu chcete smazat účet {$radek["uzivatel_login"]}?&yes=components/delete_account.php?user=" . $radek["uzivatel_login"] . "&no=" . urlencode($_SERVER['REQUEST_URI']) . "'>Smazat</a>";
                        }
                        echo "</div>
                            </div>
                            </td>
                        </tr>";
                    }
                }
                echo "
                    </tbody>
                </table>
            </div>";
            }

            if ($_SESSION["opravneni"] == "Admin" || $_SESSION["opravneni"] == "Autor" || $_SESSION["opravneni"] == "Redaktor" || $_SESSION["opravneni"] == "Šéfredaktor") {
                $sql = "SELECT * FROM prispevek JOIN uzivatel ON uzivatel_login = prispevek_autor";
                if ($_SESSION["opravneni"] == "Autor") {
                    $sql = $sql . " WHERE prispevek_autor = '{$_SESSION["login"]}'";
                }
                $sql = $sql . " ORDER BY prispevek_zmena DESC";
                echo "
                <h2>Příspěvky</h2>
                <div class='datatable'>
                <table>
                    <thead>
                        <tr>
                            <th>Název</th>
                            <th>Autor</th>
                            <th>Datum podání</th>
                            <th>Status</th>
                            <th>Poslední změna</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                ";
                $result = mysqli_query($db_connection, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($radek = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $radek["prispevek_nazev"] . "</td>";
                        echo "<td><a href='ucet.php?user=" . $radek["prispevek_autor"] . "'>" . $radek["uzivatel_jmeno"] . " " . $radek["uzivatel_prijmeni"] . "</a></td>";
                        echo "<td>" . $radek["prispevek_datum_vlozeni"]  . "</td>";
                        echo "<td>" . $radek["prispevek_status"] . "</td>";
                        echo "<td>" . $radek["prispevek_zmena"] . "</td>";
                        echo "<td class='button-cell'>
                                <div class='more-button'>
                                    <a onclick=showDropDown('dropdown_prispevek_" . $radek["prispevek_id"] . "') class='more-button-link dropdown-button'><img class='table-button' src='resources/more.png'></a>
                                    <div class='dropdown-content' id='dropdown_prispevek_" . $radek["prispevek_id"] . "'>
                                        <a href='prispevek.php?id=" . $radek["prispevek_id"] . "'>Detail</a>
                                        <a href='upravit_prispevek.php?id=" . $radek["prispevek_id"] . "'>Upravit</a>";
                                        if ($_SESSION["opravneni"] == "Admin") {
                                            echo "<a href='confirm.php?msg=Opravdu chcete smazat příspěvek {$radek["prispevek_nazev"]}?&yes=components/delete_paper.php?id=" . $radek["prispevek_id"] . "&no=" . urlencode($_SERVER['REQUEST_URI']) . "'>Smazat</a>";
                                        }
                        echo "</div>
                            </div>
                            </td>
                        </tr>";
                    }
                }
                echo "
                    </tbody>
                </table>
            </div>";
            }
            ?>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>