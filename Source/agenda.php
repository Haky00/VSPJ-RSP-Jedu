<!DOCTYPE html>

<html lang="cs">

<head>

    <?php require("components/common_head.php"); ?>

    <script src="dropdown.js"></script>

</head>

<body>

    <?php require("components/menu.php"); ?>

    <div id="main-content">
        <div class="content-section">
            <h2>Uživatelé</h2>
            <div class="datatable">
                <table>
                    <thead>
                        <tr>
                            <th>
                                Login
                            </th>
                            <th>
                                Jméno
                            </th>
                            <th>
                                Příjmení
                            </th>
                            <th>
                                E-mail
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                Tel. číslo
                            </th>
                            <th>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require('components/connect.php');
                        $sql = "SELECT * FROM uzivatel";
                        $result = mysqli_query($db_connection, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($radek = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $radek["uzivatel_login"] . "</td>";
                                echo "<td>" . $radek["uzivatel_jmeno"] . "</td>";
                                echo "<td>" . $radek["uzivatel_prijmeni"] . "</td>";
                                echo "<td>" . $radek["uzivatel_email"] . "</td>";
                                echo "<td>" . $radek["uzivatel_opravneni"] . "</td>";
                                echo "<td>" . $radek["uzivatel_tel"] . "</td>";
                                echo "<td class='button-cell'>
                                <div class='more-button'>
                                    <a onclick=showDropDown('dropdown_user_" . $radek["uzivatel_login"] . "') class='more-button-link dropdown-button'><img class='table-button' src='resources/more.png'></a>
                                    <div class='dropdown-content' id='dropdown_user_" . $radek["uzivatel_login"] . "'>
                                        <a href='ucet.php?user=".$radek["uzivatel_login"]."'>Detail</a>
                                        <a href='#'>Upravit</a>";
                                if($radek["uzivatel_opravneni"] != "Admin")
                                {
                                    echo "<a href='confirm.php?msg=Opravdu chcete smazat účet {$radek["uzivatel_login"]}?&yes=components/delete_account.php?user=".$radek["uzivatel_login"]."&no=".urlencode($_SERVER['REQUEST_URI'])."'>Smazat</a>";
                                }
                                echo"
                                    </div>
                                </div>
                                </td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <h2>Podané příspěvky</h2>
            <div class="datatable">
                <table>
                    <thead>
                        <tr>
                            <th>
                                Název
                            </th>
                            <th>
                                Autor
                            </th>
                            <th>
                                Datum podání
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Poslední změna
                            </th>
                            <th>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM uzivatel WHERE uzivatel_login = '{$_SESSION['login']}'";
                        ?>
                        <tr>
                            <td>
                                Průzkum konzumace bramborové kaše
                            </td>
                            <td>
                                Marek Hák
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
                            <td class="button-cell">
                                <div class="more-button">
                                    <a onclick="showDropDown('drop1')" class="more-button-link dropdown-button"><img class="table-button" src="resources/more.png"></a>
                                    <div class="dropdown-content" id="drop1">
                                        <a href="#">Detail</a>
                                        <a href="#">Upravit</a>
                                        <a href="#">Smazat</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Průzkum konzumace bramborové kaše
                            </td>
                            <td>
                                Marek Hák
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
                            <td class="button-cell">
                                <div class="more-button">
                                    <a onclick="showDropDown('drop2')" class="more-button-link dropdown-button"><img class="table-button" src="resources/more.png"></a>
                                    <div class="dropdown-content" id="drop2">
                                        <a href="#">Link 1</a>
                                        <a href="#">Link 2</a>
                                        <a href="#">Link 3</a>
                                    </div>
                                </div>
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