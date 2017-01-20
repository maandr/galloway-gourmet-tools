<?php
require_once '../scripts/init_database.php';

if(isset($_GET['delete']))
{
    $qry = "DELETE FROM `gg_pricing-tool-labels` WHERE `id` = '".$_GET['delete']."'";
    mysql_query($qry, $mysql);
}

if(isset($_POST['submitAdd']))
{
    // insert
    $qry = "INSERT INTO `gg_pricing-tool-labels` (`name`, `desc`, `price`, `priceKg`, `volume`) VALUES ('".$_POST['productName']."', '".$_POST['productDesc']."', '".str_replace(",", ".", $_POST['productPrice'])."', '".str_replace(",", ".", $_POST['productPriceKg'])."', '".$_POST['productVolume']."')";
    mysql_query($qry, $mysql);
}

if(isset($_POST['editId']))
{
    $nameOnly = 0;
    if(isset($_POST['editNameOnly']))
    {
        $nameOnly = ($_POST['editNameOnly']) ? 1 : 0;
    }

    // update
    $qry = "UPDATE `gg_pricing-tool-labels` SET
                `name` = '".$_POST['editName']."',
                `desc` = '".$_POST['editDesc']."',
                `price` = '".str_replace(",", ".", $_POST['editPrice'])."',
                `priceKg` = '".str_replace(",", ".", $_POST['editPriceKg'])."',
                `volume` = '".$_POST['editVolume']."',
                `nameOnly` = '".$nameOnly."'
            WHERE
                `id` = '".$_POST['editId']."'";
    mysql_query($qry, $mysql);
}

// fetch entries
$qry = "SELECT * FROM gg_pricing-tool-labels";
$result = mysql_query($qry, $mysql);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
        <title>EdekaEtiketten Tool</title>
        <script type="text/javascript">
            function deleteEntry(id)
            {
                var r = confirm("Eintrag wirklich löschen?");

                if(r)
                {
                    window.location.href = "index.php?delete=" + id;
                }
            }

            function printEntry(id)
            {
                var css = document.getElementById("template").value;

                window.location.href = "print.php?css=" + css + "&id=" + id;
            }

            function printAll()
            {
                var css = document.getElementById("template").value;

                window.location.href = "print.php?css=" + css;
            }
        </script>
    </head>
    <body>
        <div class="left">
            <div class="addForm">
                <h1>Hinzufügen</h1>
                <form method="post" action="index.php">
                    <label>Produkt Name</label>
                    <input type="text" name="productName" value="" />
                    <label>Produkt Beschreibung</label>
                    <input type="text" name="productDesc" value="vom Galloway" />
                    <label>Preis pro Stück</label>
                    <input type="text" name="productPrice" value="" />
                    <label>Preis pro kg</label>
                    <input type="text" name="productPriceKg" value="" />
                    <label>Inhalt (g)</label>
                    <input type="text" name="productVolume" value="" />

                    <input type="submit" name="submitAdd" value="Hinzufügen" />
                </form>
            </div>

            <div class="print">
                <h1>Druck</h1>

                <select name="css" id="template">
                    <option value="default">Standard</option>
                    <option value="edeka">Edeka</option>
                </select>
                <input type="button" name="print" value="Alle Drucken" onclick="printAll()" />
            </div>
        </div>

        <div class="products">
            <h1>Übersicht</h1>
            <table>
                <tr>
                    <th>Produkt Name</th>
                    <th>Produkt Beschreibung</th>
                    <th>Preis pro Stück</th>
                    <th>Preis pro kg</th>
                    <th>Inhalt (g)</th>
                    <th>Nur Name</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php
                while($row = mysql_fetch_assoc($result))
                {
                    $checked = ($row['nameOnly']) ? 'checked' : '';

                    echo '<tr>';
                    echo '<form method="post" action="index.php">';
                    echo '<td><input type="text" name="editName" value="'.$row['name'].'" onchange="this.form.submit()" /></td>';
                    echo '<td><input type="text" name="editDesc" value="'.$row['desc'].'" onchange="this.form.submit()" /></td>';
                    echo '<td><input type="text" name="editPrice" style="width: 75px;" value="'.$row['price'].'" onchange="this.form.submit()" /></td>';
                    echo '<td><input type="text" name="editPriceKg" style="width: 75px;" value="'.$row['priceKg'].'" onchange="this.form.submit()" /></td>';
                    echo '<td><input type="text" name="editVolume" style="width: 75px;" value="'.$row['volume'].'" onchange="this.form.submit()" /></td>';
                    echo '<td><input type="checkbox" name="editNameOnly" '.$checked.' onchange="this.form.submit()" /></td>';
                    echo '<td><input type="button" name="print" value="Drucken" onclick="printEntry('.$row['id'].')" /></td>';
                    echo '<td>
                            <input type="button" name="delete" value="x" onclick="deleteEntry('.$row['id'].')" />
                            <input type="hidden" name="editId" value="'.$row['id'].'" />
                          </td>';
                    echo '</form>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
    </body>
</html>
