<?php
define("SYSTEM_DIR",dirname(dirname(__FILE__)));//抓出system.php的絕對path dir
require_once SYSTEM_DIR.'/connections/Data/db_config.php';

//require_once("connections/data/db_config.php");

include SYSTEM_DIR."/include/classes/class_db.php";
include SYSTEM_DIR."/include/classes/class_webinfo.php";
//include SYSTEM_DIR."include/classes/class_news.php";
include SYSTEM_DIR."/include/classes/class_banner.php";
include SYSTEM_DIR."/include/classes/class_indexlist.php";
include SYSTEM_DIR."/include/classes/class_goodlist.php";
include SYSTEM_DIR."/include/classes/class_member.php";

//Db
$db = new Db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_SERVER);

//web info
$webInfo = new Config($db->getConnection());

//banner
$banner = new Banner($db->getConnection());

//list
$indexList = new IndexList($db->getConnection());

//goodlist
$goodList = new GoodList($db->getConnection());

//member
$member = new Member($db->getConnection());

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET=utf8");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

?>