<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <div class='content-section'>

            <div class="result">
            <?php

            if(isset($_GET['msg']))
            {
                echo $_GET['msg'];
            }

            ?>
            </div>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>