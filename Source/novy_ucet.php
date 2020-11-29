<?php
session_start();
if(!isset($_SESSION["opravneni"]) || $_SESSION["opravneni"] != "Admin")
{
    echo "forbidden";
    return;
}

?>

<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

    <script>

        function ValidaceVstupu() {
            var heslo = document.getElementById('heslo-field').value;
            var heslo_verify = document.getElementById('heslo-verify-field').value;
            if (heslo != heslo_verify)
            {
                document.getElementById('error-msg').innerHTML = "Hesla se neshodují";
                return false;
            }
            return true;
        }

    </script>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <div class='content-section'>

            <h2>Nový uživatel</h2>
            <form method="POST" action="components/create_account.php" onsubmit="return ValidaceVstupu()">
                <div class='formtable'>
                    <table>
                        <colgroup>
                            <col style='width: 15%; max-width: 180px;'>
                            <col style='width: 75%;'>
                        </colgroup>
                        <tr>
                            <td><label for='#login-field'>Login*</label></td>
                            <td><input id='login-field' type='text' name="login" required></td>
                        </tr>
                        <tr>
                            <td><label for='#heslo-field'>Heslo*</label></td>
                            <td><input id='heslo-field' type='password' name="heslo" required></td>
                        </tr>
                        <tr>
                            <td><label for='#heslo-verify-field'>Heslo znovu*</label></td>
                            <td><input id='heslo-verify-field' type='password' name="heslo-verify" required></td>
                        </tr>
                        <tr>
                            <td><label for='#cislo-field'>Role</label></td>
                            <td>
                                <div class='custom-select'>
                                    <select id='cislo-field' name='opravneni' required>
                                        <option value='1'>Autor</option>
                                        <option value='2'>Redaktor</option>
                                        <option value='3'>Recenzent</option>
                                        <option value='4'>Šéfredaktor</option>
                                        <option value='5'>Admin</option>
                                    </select>
                                    <script src='custom_select.js'></script>
                                </div>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><label for='#jmeno-field'>Jméno*</label></td>
                            <td><input id='jmeno-field' type='text' name="jmeno" required></td>
                        </tr>
                        <tr>
                            <td><label for='#prijmeni-field'>Příjmení*</label></td>
                            <td><input id='prijmeni-field' type='text' name="prijmeni" required></td>
                        </tr>
                        <tr>
                            <td><label for='#email-field'>E-mail*</label></td>
                            <td><input id='email-field' type='text' name="email" required></td>
                        </tr>
                        <tr>
                            <td><label for='#tel-field'>Telefonní číslo</label></td>
                            <td><input id='tel-field' type='text' name="tel" required></td>
                        </tr>
                    </table>
                </div>
                <br />
                <div class='submit-center'>
                    <input type='submit' value='Přidat uživatele' />
                </div>
                <input type='hidden' value="<?php require('components/current_address.php') ?>" name="return_address">
                <div id="error-msg"><?php if(isset($_GET["error_msg"])) { echo $_GET["error_msg"]; } ?></div>
                <div id="success-msg"><?php  if(isset($_GET["success_msg"])) { echo $_GET["success_msg"]; } ?></div>
            </form>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>