<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <h2>Podané příspěvky</h2>
            <div class="datatable">
                <table>
                    <thead>
                        <tr>
                            <th>
                                Název
                            </th>
                            <th>
                                Datum podání
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Datum poslední změny
                            </th>
                            <th>
                                Akce
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Průzkum konzumace bramborové kaše
                            </td>
                            <td>
                                27.10.2020
                            </td>
                            <td>
                                Vráceno (téma)
                            </td>
                            <td>
                                4.11.2020
                            </td>
                            <td>
                                <a href="#">Přidat námitku</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Úrodnost betonových ploch
                            </td>
                            <td>
                                9.3.2019
                            </td>
                            <td>
                                Předáno recenzentům
                            </td>
                            <td>
                                15.9.2020
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Proč vychází slunce ráno
                            </td>
                            <td>
                                20.3.2020
                            </td>
                            <td>
                                Přijato
                            </td>
                            <td>
                                7.11.2020
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                Proč je nebe modré
                            </td>
                            <td>
                                11.10.2001
                            </td>
                            <td>
                                Podáno
                            </td>
                            <td>
                                11.10.2001
                            </td>
                            <td>
                                <a href="#">Přidat text</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php require("components/footer.php"); ?>

    </div>

</body>

</html>