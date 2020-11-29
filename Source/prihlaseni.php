<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <div class='content-section'>
            <form method="POST" action="components/login.php">
                <div class="formlayered">
                    <h3>Přihlášení</h3>
                    <label for="#login-field">Login</label>
                    <input id='login-field' type='text' name="login" required>
                    <label for="#heslo-field">Heslo</label>
                    <input id='heslo-field' type='password' name="heslo" required>
                    <div class='submit-center'>
                        <input type='submit' value='Přidat uživatele' />
                    </div>
                    <input type='hidden' value="<?php require('components/current_address.php') ?>" name="return_address">
                    <div id="error-msg"><?php if(isset($_GET["error_msg"])) { echo $_GET["error_msg"]; } ?></div>
                    <div id="success-msg"><?php  if(isset($_GET["success_msg"])) { echo $_GET["success_msg"]; } ?></div>
                </div>
            </form>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>