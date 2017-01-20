<?php
/* parse global.conf */
$env = parse_ini_file("../config/global.conf", TRUE);

/* create connection */
if (!$mysql = mysql_connect($env['mysql']['hostname'], $env['mysql']['username'], $env['mysql']['password'])) {
    die("Connection failed: " . mysql_error());
}

/* select database */
mysql_select_db($env['mysql']['database'], $mysql);
?>
