<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">

        <div class='content-section'>

            <div class="display-text">
                <br/>
            <?php

            if(isset($_GET['id']))
            {
                echo nl2br(file_get_contents("uploads/{$_GET['id']}.txt"));
            }

            ?>
            </div>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>