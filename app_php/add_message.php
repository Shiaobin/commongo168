<?php

require_once("DBconfig.php");
mysql_connect($_DB['host'], $_DB['username'], $_DB['password']) or die("Error");

@mysql_select_db($_DB['dbname']) or die("Error");

mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET=utf8");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

$mem_id = $_POST["mem_id"];
$mem_nickname = $_POST["mem_nickname"];
$msg_send = $_POST["msg_send"];
$msg_location = $_POST["msg_location"];

$uploaddir = '../images/discussimg/medium/';
$file = $mem_id.date("His").".jpg";
$uploadfile = $uploaddir.$file;

if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
  //echo "http://ponikids.com.tw/mobile/upload/{$file}";
  $img = $file;
}else{
  //echo "fail";
  //$query = "INSERT INTO shop_member_msg(mem_nickname, msg_send) VALUES ('$mem_nickname', '$msg_send')";
  if($_POST["img"])
	$img=$_POST["img"];
  else
	$img = 'empty.png';
}

$query = "INSERT INTO shop_member_msg(mem_nickname, msg_img, msg_location, msg_send) VALUES ('$mem_nickname', '$img', '$msg_location', '$msg_send')";
if(mysql_query($query))
	echo "ok";
else
	echo "error";
mysql_close();
?>