<?php
session_start();
if (!isset($_SESSION["logged"]) || !isset($_GET['id']) || $_SESSION['opravneni'] != "Redaktor") {
    echo "Forbidden";
    return;
}

require('components/connect.php');

$prispevek = $_GET['id'];

$check_reviews = "SELECT COUNT(*) as total FROM recenze WHERE recenze_prispevek = '{$prispevek}'";
$result = mysqli_query($db_connection, $check_reviews);
$data = mysqli_fetch_assoc($result);
if ($data['total'] > 0) {
    $_POST = array();
    mysqli_close($db_connection);
    header('Location: result.php?msg=Recenze již byly zadány recenzentům');
    return;
}

$recenzenti = array();
$recenzenti_query = "SELECT * FROM uzivatel WHERE uzivatel_opravneni = 'Recenzent'";
$result = mysqli_query($db_connection, $recenzenti_query);
while ($data = mysqli_fetch_assoc($result)) {
    $recenzenti[$data['uzivatel_login']] = $data['uzivatel_jmeno'] . " " . $data['uzivatel_prijmeni'];
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

            <h2>Volba recenzentů</h2>
            <form method="post" action="components/add_review.php">
                <div class="formtable">
                    <table>
                        <colgroup>
                            <col style="width: 15%; max-width: 180px;">
                            <col style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><label for="recenzent1-field">Recenzent 1</label></td>
                            <td>
                                <div class="custom-select">
                                    <select id="recenzent1-field" name="recenzent1" style="width: 200px;">
                                        <?php
                                        foreach ($recenzenti as $login => $jmeno) {
                                            echo "<option value='{$login}'>{$jmeno}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="recenzent2-field">Recenzent 2</label></td>
                            <td>
                                <div class="custom-select">
                                    <select id="recenzent2-field" name="recenzent2" style="width: 200px;">
                                        <?php
                                        foreach ($recenzenti as $login => $jmeno) {
                                            echo "<option value='{$login}'>{$jmeno}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <script src="custom_select.js"></script>
                        <tr>
                            <td><label for="duedate-field">Termín</label></td>
                            <td><input id="duedate-field" name="duedate" type="date" required></td>
                        </tr>
                    </table>
                </div>
                <br />
                <input type="hidden" name="id" value='<?php echo $prispevek; ?>'>
                <div class="submit-center">
                    <input type="submit" value="Potvrdit" />
                </div>
            </form>
            <?php



            ?>

        </div>

        <?php require("components/footer.php"); ?>

    </div>
</body>

</html>