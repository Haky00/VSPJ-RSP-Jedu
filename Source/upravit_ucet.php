<?php
session_start();
if (!isset($_SESSION["logged"]) || (isset($_GET['user']) && ($_GET['user'] != $_SESSION['login'] && $_SESSION['opravneni'] != "Admin"))) {
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

        <div class='content-section'>

            <h2>Úprava uživatele</h2>
            <?php

            if (session_id() == "") {
                session_start();
            }
            if (isset($_GET["user"])) {
                $login = $_GET["user"];
            } else {
                if (isset($_SESSION["logged"])) {
                    $login = $_SESSION["login"];
                } else {
                    echo "Chyba při získávání informací o uživateli";
                    return;
                }
            }

            require('components/connect.php');

            $check_login = "SELECT *, uzivatel_opravneni+0 as uzivatel_opravneni_num FROM uzivatel WHERE uzivatel_login = '{$login}'";
            $result = mysqli_query($db_connection, $check_login);
            if (mysqli_num_rows($result) != 1) {
                echo "Chyba při získávání informací o uživateli";
                mysqli_close($db_connection);
                return;
            }
            $data = mysqli_fetch_assoc($result);
            mysqli_close($db_connection);

            $jmeno = $data["uzivatel_jmeno"];
            $prijmeni = $data["uzivatel_prijmeni"];
            $opravneni = $data["uzivatel_opravneni"];
            $opravneni_num = $data["uzivatel_opravneni_num"];
            $email = $data["uzivatel_email"];
            $tel = $data["uzivatel_tel"];
            $instituce = $data["uzivatel_instituce"];
            $adresa = $data["uzivatel_adresa"];


            echo "
            <form method='POST' action='components/alter_account.php'>
                <div class='formtable'>
                    
                    <table>
                        <colgroup>
                            <col style='width: 15%; max-width: 180px;'>
                            <col style='width: 75%;'>
                        </colgroup>
                         
                        <tr>
                            <td><label for='login-field'>Login*</label></td>
                            <td><input id='login-field' type='text' name='login' value='{$login}' required disabled></td>
                        </tr>
                        <tr>
                            <td><label for='opravneni-field'>Role*</label></td>
                            <td>";
            if ($_SESSION["opravneni"] == "Admin") {
                echo "
                                <div class='custom-select'>
                                    <select id='opravneni-field' name='opravneni' required>";
                $options = array(1 => "Autor", 2 => "Redaktor", 3 => "Recenzent", 4 => "Šéfredaktor", 5 => "Admin");
                foreach($options as $option => $name)
                {
                    if($opravneni == $name)
                    {
                        echo "<option value='{$option}' selected>{$name}</option>";
                    }
                    else
                    {
                        echo "<option value='{$option}'>{$name}</option>";
                    }
                }
                echo"
                                    </select>
                                    <script src='custom_select.js'></script>
                                </div>";
            } else {
                echo "<input id='opravneni-field' type='text' value='{$opravneni}' disabled>
                <input type='hidden' name='opravneni' value='{$opravneni_num}'>";
            }
            echo "
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><label for='jmeno-field'>Jméno*</label></td>
                            <td><input id='jmeno-field' type='text' name='jmeno' value='{$jmeno}' required></td>
                        </tr>
                        <tr>
                            <td><label for='prijmeni-field'>Příjmení*</label></td>
                            <td><input id='prijmeni-field' type='text' name='prijmeni' value='{$prijmeni}' required></td>
                        </tr>
                        <tr>
                            <td><label for='email-field'>E-mail*</label></td>
                            <td><input id='email-field' type='email' name='email' value='{$email}' required></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><label for='tel-field'>Telefonní číslo</label></td>
                            <td><input id='tel-field' type='text' name='tel' value='{$tel}' maxlength='16'></td>
                        </tr>
                        <tr>
                            <td><label for='instituce-field'>Instituce</label></td>
                            <td><input id='instituce-field' type='text' value='{$instituce}' name='instituce'></td>
                        </tr>
                        <tr>
                            <td><label for='adresa-field'>Adresa</label></td>
                            <td><input id='adresa-field' type='text' value='{$adresa}' name='adresa'></td>
                        </tr>
                    </table>
                </div>
                <br />
                <input type='hidden' name='login' value='{$login}' />
                <div class='submit-center'>
                    <input type='submit' value='Potvrdit' />
                </div>
            </form>";
            ?>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>