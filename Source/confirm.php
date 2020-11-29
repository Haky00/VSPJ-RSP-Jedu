<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <div class='content-section'>

            <div class="confirm">
            <?php

            if(!isset($_GET['yes']) || !isset($_GET['no']))
            {
                echo "Addresses not specified";
                return;
            }

            if(isset($_GET['msg']))
            {
                echo $_GET['msg'];
            }

            echo"</div>
            <div class='submit-center'>
                <a class='button' href='{$_GET['no']}'>
                    <div class='button-text-center'>Ne</div>
                </a>
                <a class='button' href='{$_GET['yes']}'>
                    <div class='button-text-center'>Ano</div>
                </a>
            </div>";
            ?>


        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>
