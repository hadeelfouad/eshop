<?php
$server   = "localhost";
$database = "db1";
$username = "root";
$password = "";

$mysqlConnection = mysql_connect($server, $username, $password);
if (!$mysqlConnection)
{
  echo "Please try later.";
}
else
{
	//echo "connected";
mysql_select_db($database, $mysqlConnection);
}
?>