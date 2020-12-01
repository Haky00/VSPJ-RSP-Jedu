<?php
session_start();
if (!isset($_SESSION["logged"]) || ($_SESSION["opravneni"] != "Autor" && $_SESSION["opravneni"] != "Admin")) {
    echo "Forbidden";
    return;
}
?>

<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

    <script>
        function ValidateSize(file) {
            var FileSize = file.files[0].size / 1024 / 1024; // in MB
            var lbl = document.getElementById("file-lbl");
            var btn = document.getElementById("file-reset-btn");
            if (FileSize > 2) {
                alert('Velikost souboru překračuje 2MB');
                file.value = '';
                lbl.innerHTML = "Soubor nevybrán...";
                if (btn.classList.contains("show")) {
                    btn.classList.remove("show");
                }
            } else {
                lbl.innerHTML = file.files[0].name;
                if (!btn.classList.contains("show")) {
                    btn.classList.add("show");
                }
            }
        }

        function ResetFile() {
            document.getElementById("file-field").value = '';
            document.getElementById("file-lbl").innerHTML = "Soubor nevybrán...";
            var btn = document.getElementById("file-reset-btn");
            if (btn.classList.contains("show")) {
                btn.classList.remove("show");
            }
        }
    </script>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <h2>Nový příspěvek</h2>
            <form method="post" action="components/new_paper.php" enctype="multipart/form-data">
                <div class="formtable">
                    <table>
                        <colgroup>
                            <col style="width: 15%; max-width: 180px;">
                            <col style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><label for="nazev-field">Název</label></td>
                            <td><input id="nazev-field" name="nazev" type="text" required></td>
                        </tr>
                        <tr>
                            <td><label for="cislo-field">Tématické číslo časopisu</label></td>
                            <td>
                                <div class="custom-select">
                                    <select id="cislo-field" name="cislo" style="width: 200px;">
                                        <?php
                                        echo "<option value=''}>Nevybráno</option>";
                                        require('components/connect.php');
                                        $cisla_query = "SELECT * FROM cislo";
                                        $result = mysqli_query($db_connection, $cisla_query);
                                        while ($cislo = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$cislo['cislo_id']}'>{$cislo['cislo_nazev']}</option>";
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
                            <td><input id="spoluautori-field" name="spoluautori" type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="file-field">Text (velikost max. 2MB)</label></td>
                            <td>
                                <label for="file-field" class="button file-button" id="file-btn">
                                    <div class='button-text-center'>Procházet...</div>
                                </label>
                                <label id="file-lbl">Soubor nevybrán...</label>
                                <input id="file-field" type='file' name='prispevek_text' accept=".txt" onchange="ValidateSize(this)">
                                <a class="button file-reset-button" id="file-reset-btn" onclick="ResetFile()">
                                    <div class='button-text-center'>✖</div>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <br />
                <div class="submit-center">
                    <input type="submit" value="Přidat příspěvek" />
                </div>
            </form>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>