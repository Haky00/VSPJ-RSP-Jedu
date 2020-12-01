<?php

session_start();
if (!isset($_SESSION["logged"]) || ($_SESSION["opravneni"] != "Autor" && $_SESSION["opravneni"] != "Admin" && $_SESSION["opravneni"] != "Redaktor") || !isset($_GET["id"])) {
    echo "Forbidden";
    return;
}
require('components/connect.php');

$prispevek_query = "SELECT * FROM prispevek WHERE prispevek_id = {$_GET["id"]}";
$result = mysqli_query($db_connection, $prispevek_query);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o příspěvku";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);
$id = $_GET["id"];
$nazev = $data["prispevek_nazev"];
$cislo = $data["prispevek_tematicke_cislo"];
$spoluautori = $data["prispevek_spoluautori"];

?>

<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <h2>Upravit příspěvek</h2>
            <form method="post" action="components/alter_paper.php">
                <div class="formtable">
                    <table>
                        <colgroup>
                            <col style="width: 15%; max-width: 180px;">
                            <col style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><label for="nazev-field">Název</label></td>
                            <td><input id="nazev-field" name="nazev" type="text" value="<?php echo $nazev; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="cislo-field">Tématické číslo časopisu</label></td>
                            <td>
                                <div class="custom-select">
                                    <select id="cislo-field" name="cislo" style="width: 200px;">
                                        <?php
                                        echo "<option value=''}>Nevybráno</option>";
                                        $cisla_query = "SELECT * FROM cislo";
                                        $result = mysqli_query($db_connection, $cisla_query);
                                        while ($radek = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$cislo['cislo_id']}'";
                                            if($radek['cislo_id'] == $cislo)
                                            {
                                                echo " selected ";
                                            }
                                            echo">{$radek['cislo_nazev']}</option>";
                                        }
                                        mysqli_close($spojeni);

                                        ?>
                                    </select>
                                    <script src="custom_select.js"></script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="spoluautori-field">Spoluautoři</label></td>
                            <td><input id="spoluautori-field" name="spoluautori" type="text" value="<?php echo $spoluautori; ?>"></td>
                        </tr>
                    </table>
                </div>
                <br />
                <input type="hidden" value="<?php echo $id; ?>" name="id">
                <div class="submit-center">
                    <input type="submit" value="Potvrdit" />
                </div>
            </form>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>