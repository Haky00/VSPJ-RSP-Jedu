<?php
session_start();
if(isset($_SESSION["opravneni"]) && $_SESSION["opravneni"] != "Admin")
{
    echo "Forbidden";
    return;
}

?>

<!DOCTYPE html>

<html lang="cs">

<head>
    <title>Nový uživatel</title>
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
                            <td><label for='login-field'>Login*</label></td>
                            <td><input id='login-field' type='text' name="login" required autofocus></td>
                        </tr>
                        <tr>
                            <td><label for='heslo-field'>Heslo*</label></td>
                            <td><input id='heslo-field' type='password' name="heslo" required></td>
                        </tr>
                        <tr>
                            <td><label for='heslo-verify-field'>Heslo znovu*</label></td>
                            <td><input id='heslo-verify-field' type='password' name="heslo-verify" required></td>
                        </tr>
                        <tr>
                            <td><label for='opravneni-field'>Role*</label></td>
                            <td>
                                <?php
                                if(!isset($_SESSION["opravneni"]) || $_SESSION["opravneni"] != "Admin")
                                {
                                    echo "<input id='opravneni-field' type='text' value='Autor' disabled>
                                    <input type='hidden' name='opravneni' value='1' required>";
                                }
                                else
                                {
                                    echo "
                                <div class='custom-select'>
                                    <select id='opravneni-field' name='opravneni' required>
                                        <option value='1'>Autor</option>
                                        <option value='2'>Redaktor</option>
                                        <option value='3'>Recenzent</option>
                                        <option value='4'>Šéfredaktor</option>
                                        <option value='5'>Admin</option>
                                    </select>
                                    <script src='custom_select.js'></script>
                                </div>
                                ";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><label for='jmeno-field'>Jméno*</label></td>
                            <td><input id='jmeno-field' type='text' name="jmeno" required></td>
                        </tr>
                        <tr>
                            <td><label for='prijmeni-field'>Příjmení*</label></td>
                            <td><input id='prijmeni-field' type='text' name="prijmeni" required></td>
                        </tr>
                        <tr>
                            <td><label for='email-field'>E-mail*</label></td>
                            <td><input id='email-field' type='email' name="email" required></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td><label for='tel-field'>Telefonní číslo</label></td>
                            <td><input id='tel-field' type='text' name="tel" maxlength="16"></td>
                        </tr>
                        <tr>
                            <td><label for='instituce-field'>Instituce</label></td>
                            <td><input id='instituce-field' type='text' name="instituce"></td>
                        </tr>
                        <tr>
                            <td><label for='adresa-field'>Adresa</label></td>
                            <td><input id='adresa-field' type='text' name="adresa"></td>
                        </tr>
                    </table>
                </div>
                <br />
                <div class='submit-center'>
                    <input type='submit' value='Potvrdit' />
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