<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once("Data/db_config.php");

$hostname_webshop = DB_SERVER;
$database_webshop = DB_DATABASE;
$username_webshop = DB_USER;
$password_webshop = DB_PASSWORD;




//mysql_close($this->databaseLink);

$webshop = mysql_pconnect($hostname_webshop, $username_webshop, $password_webshop, TRUE) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_webshop, $webshop);

mysql_query('SET NAMES utf8',$webshop);   //設定MYSQL編碼
mysql_query('SET CHARACTER_SET_CLIENT=utf8',$webshop);
mysql_query('SET CHARACTER_SET_RESULTS=utf8',$webshop);
//$webshop = new Db($database_webshop, $username_webshop, $password_webshop, $hostname_webshop);

?>
