<?php
require_once '../scripts/init_database.php';

$css = "default.css";
if(isset($_GET['css']))
{
    $css = $_GET['css'].".css";
}

// fetch entries
$qry = (isset($_GET['ids'])) ? "SELECT * FROM `gg_pricing-tool-labels` WHERE `id` IN (".$_GET['ids'].")" : "SELECT * FROM `gg_pricing-tool-labels`";

$result = mysql_query($qry, $mysql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="css/label-theme-<?=$css?>" media="all" />
        <title>EdekaEtiketten Tool</title>
    </head>
    <body>
        <div class="a4wrapper">
            <ul class="etikett">
                <?php
                while($row = mysql_fetch_assoc($result))
                {
                    if($row['nameOnly'])
                    {
                        echo '<li class="nameOnly">';
                        echo '<div class="bio"></div>';
                        echo '<h1>'.$row['name'].'</h1>';
                        echo '<p class="desc">'.$row['desc'].'</p>';
                        echo '</li>';
                    }
                    else
                    {
                        echo '<li class="namePrice">';
                        echo '<div class="bio"></div>';
                        echo '<h1>'.$row['name'].'</h1>';
                        echo '<p class="desc">'.$row['desc'].'</p>';
                        echo '<p class="price">'.number_format($row['price'], 2, ',', '.').'</p>';
                        echo '<p class="volume">Inhalt: '.$row['volume'].' g</p>';
                        echo '<p class="price100g">100 g = '.number_format($row['priceKg']*0.1, 2, ',', '.').'</p>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </body>
</html>
