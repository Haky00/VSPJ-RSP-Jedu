<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <?php
        if(session_id() == "")
        {
        session_start();
        }

        require('components/connect.php');

        $check_login = "SELECT * FROM Uzivatel WHERE uzivatel_login = '{$_SESSION['login']}'";
        $result = mysqli_query($db_connection, $check_login);
        if (mysqli_num_rows($result) != 1) {
            echo "Chyba při získávání informací o uživateli ".$check_login;
            mysqli_close($db_connection);
            return;
        }
        $data = mysqli_fetch_assoc($result);
        mysqli_close($db_connection);

        $jmeno = $data["uzivatel_jmeno"] . " " . $data["uzivatel_prijmeni"];
        $opravneni = $data["uzivatel_opravneni"];
        $email = $data["uzivatel_email"];
        $tel = $data["uzivatel_tel"];


        echo "

        <div class='content-section'>
            <div class='account-info'>
                <div class='name-row'>
                    <div class='user-img left'><img src='resources/user.png'></div>
                    <div class='user-id left'>
                        <div class='user-name'>{$jmeno}</div>
                        <div class='user-role'>{$opravneni}</div>
                    </div>
                </div>
                <div class='account-table'>
                    <table>
                        <colgroup>
                            <col style='width: 215px;' />
                            <col/>
                        </colgroup>
                        <tr>
                            <td>Email:</td>
                            <td>{$email}</td>
                        </tr>
                        <tr>
                            <td>Telefonní číslo:</td>
                            <td>{$tel}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        ";

        ?>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>