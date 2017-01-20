<?php
require_once '../scripts/init_database.php';

$shema_query = file_get_contents('migration/shema_gg_pricing-tool-labels.sql');

if(!mysql_query($shema_query, $mysql)) {
  die('database shema installation failed.');
}

$migration_query = file_get_contents('migration/migration_2017-01-20_initial.sql');

if(!mysql_query($migration_query, $mysql)) {
  die('database migration failed.');
}

echo 'success.';
?>
