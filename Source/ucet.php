<?php

session_start();
if (!isset($_SESSION["logged"])) {
    echo "Forbidden";
    return;
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
        if (session_id() == "") {
            session_start();
        }
        if (isset($_GET["user"])) {
            $login = $_GET["user"];
        } else {
            if (isset($_SESSION["logged"])) {
                $login = $_SESSION["login"];
            }
            else
            {
                echo "Chyba při získávání informací o uživateli";
                return;
            }
        }

        require('components/connect.php');

        $check_login = "SELECT * FROM uzivatel WHERE uzivatel_login = '{$login}'";
        $result = mysqli_query($db_connection, $check_login);
        if (mysqli_num_rows($result) != 1) {
            echo "Chyba při získávání informací o uživateli";
            mysqli_close($db_connection);
            return;
        }
        $data = mysqli_fetch_assoc($result);
        mysqli_close($db_connection);

        $jmeno = $data["uzivatel_jmeno"] . " " . $data["uzivatel_prijmeni"];
        $opravneni = $data["uzivatel_opravneni"];
        $email = $data["uzivatel_email"];
        $tel = $data["uzivatel_tel"];
        $instituce = $data["uzivatel_instituce"];
        $adresa = $data["uzivatel_adresa"];


        echo "

        <div class='content-section'>
            <div class='account-info'>
                <div class='name-row'>
                    <div class='user-img'><img src='resources/user.png'></div>
                    <div class='user-id'>
                        <div class='user-name'>{$jmeno}</div>
                        <div class='user-role'>{$opravneni}</div>
                    </div>
                </div>
                <div class='account-table'>
                    <table>
                        <colgroup>
                            <col style='width: 200px;' />
                            <col/>
                        </colgroup>
                        <tr>
                            <td>Login</td>
                            <td>{$login}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{$email}</td>
                        </tr>
                        <tr>
                            <td>Telefonní číslo</td>
                            <td>{$tel}</td>
                        </tr>
                        <tr>
                            <td>Instituce</td>
                            <td>{$instituce}</td>
                        </tr>
                        <tr>
                            <td>Adresa</td>
                            <td>{$adresa}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class='submit-center'>
        ";
        if($login == $_SESSION["login"] || $_SESSION["opravneni"] == "Admin")
        {
            echo "
            <a class='button' href='upravit_ucet.php?user=".$login."'>
            <div class='button-text-center'>Upravit profil</div>
            </a>";
        }
        if($_SESSION["opravneni"] == "Admin" && $opravneni != "Admin")
        {
            echo "
            <a class='button' href='confirm.php?msg=Opravdu chcete smazat účet {$login}?&yes=components/delete_account.php?user=".$login."&no=".urlencode($_SERVER['REQUEST_URI'])."'>
            <div class='button-text-center'>Smazat profil</div>
            </a>";
        }
        if($login == $_SESSION["login"])
        {
            echo "
            <a class='button' href='confirm.php?msg=Opravdu se chcete odhlásit?&yes=components/logout.php&no=".urlencode($_SERVER['REQUEST_URI'])."'>
            <div class='button-text-center'>Odhlásit se</div>
            </a>";
        }
        echo "</div>";
        require("components/footer.php");
        ?>
    </div>
</body>

</html>