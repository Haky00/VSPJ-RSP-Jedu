<?php

session_start();
if (!isset($_SESSION["logged"]) || $_SESSION["opravneni"] != "Recenzent" || !isset($_GET["id"])) {
    echo "Forbidden";
    return;
}
require('components/connect.php');

$recenze_query = "SELECT * FROM recenze JOIN prispevek ON recenze_prispevek = prispevek_id WHERE recenze_id = {$_GET["id"]} AND recenze_recenzant = '{$_SESSION['login']}'";
$result = mysqli_query($db_connection, $recenze_query);
if (mysqli_num_rows($result) != 1) {
    echo "Chyba při získávání informací o příspěvku";
    mysqli_close($db_connection);
    return;
}
$data = mysqli_fetch_assoc($result);
if($data["recenze_hodnoceni_a"] > 0)
{
    echo "Recenze již byla podána";
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
        <div class="content-section">
            <h2>Tvorba recenze pro příspěvek <a href="prispevek.php?id=<?php echo $data["prispevek_id"]; ?>"> <?php echo $data["prispevek_nazev"]; ?></a></h2>
            <form method="post" action="components/change_review.php">
                <div class="formtable">
                    <table>
                        <colgroup>
                            <col style="width: 28%; max-width: 400px;">
                            <col style="width: 72%;">
                        </colgroup>
                        <tr>
                            <td><label>Známka A (aktuálnost, zajímavost a přínosnost)</label></td>
                            <td>
                                <label class="custom_radio">1
                                    <input name="znamka_a" type="radio" value="1" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">2
                                    <input name="znamka_a" type="radio" value="2" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">3
                                    <input name="znamka_a" type="radio" value="3" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">4
                                    <input name="znamka_a" type="radio" value="4" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">5
                                    <input name="znamka_a" type="radio" value="5" required>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Známka B (originalita)</label></td>
                            <td>
                                <label class="custom_radio">1
                                    <input name="znamka_b" type="radio" value="1" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">2
                                    <input name="znamka_b" type="radio" value="2" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">3
                                    <input name="znamka_b" type="radio" value="3" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">4
                                    <input name="znamka_b" type="radio" value="4" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">5
                                    <input name="znamka_b" type="radio" value="5" required>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Známka C (odborná úroveň)</label></td>
                            <td>
                                <label class="custom_radio">1
                                    <input name="znamka_c" type="radio" value="1" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">2
                                    <input name="znamka_c" type="radio" value="2" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">3
                                    <input name="znamka_c" type="radio" value="3" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">4
                                    <input name="znamka_c" type="radio" value="4" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">5
                                    <input name="znamka_c" type="radio" value="5" required>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Známka D (jazyková a stylistická úroveň)</label></td>
                            <td>
                                <label class="custom_radio">1
                                    <input name="znamka_d" type="radio" value="1" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">2
                                    <input name="znamka_d" type="radio" value="2" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">3
                                    <input name="znamka_d" type="radio" value="3" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">4
                                    <input name="znamka_d" type="radio" value="4" required>
                                    <span class="checkmark"></span>
                                </label>
                                <label class="custom_radio">5
                                    <input name="znamka_d" type="radio" value="5" required>
                                    <span class="checkmark"></span>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="text-field">Textové vyjádření</label></td>
                            <td>
                                <textarea id="text-field" name="text"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <br />
                <input type="hidden" value="<?php echo $_GET["id"]; ?>" name="id">
                <div class="submit-center">
                    <input type="submit" value="Potvrdit" />
                </div>
            </form>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>