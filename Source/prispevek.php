<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <h2>Nový příspěvek</h2>
            <form>
                <div class="formtable">
                    <table>
                        <colgroup>
                            <col style="width: 15%; max-width: 180px;">
                            <col style="width: 75%;">
                        </colgroup>
                        <tr>
                            <td><label for="#nazev-field">Název</label></td>
                            <td><input id="nazev-field" type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="#cislo-field">Tématické číslo časopisu</label></td>
                            <td>
                                <div class="custom-select">
                                    <select id="cislo-field" style="width: 200px;">
                                    <?php

                                    require('components/connect.php');
                                    $cisla_query = "SELECT * FROM Cislo";
                                    $result = mysqli_query($db_connection, $cisla_query);
                                    while ($cislo = mysqli_fetch_assoc($result))
                                    {
                                        echo "<option value={$cislo['cislo_id']}>{$cislo['cislo_nazev']}</option>";
                                    }
                                    mysqli_close($spojeni);

                                    ?>
                                </select>
                                    <script src="custom_select.js"></script>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="#spoluautori-field">Spoluautoři</label></td>
                            <td><input id="spoluautori-field" type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="#file-field">Text</label></td>
                            <td><label for="#file-field">Soubor nevybrán...</label> <button id="file-field">Procházet</button></td>
                        </tr>
                    </table>
                </div>
                <br/>
                <div class="submit-center">
                    <input type="submit" value="Přidat příspěvek" />
                </div>
            </form>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>