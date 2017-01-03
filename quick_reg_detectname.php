<?php
include("connections/webshop.php");
//<!--#include file="Comm/conn.asp"-->
$Message="可以使用";
if(isset($_GET['UserId']) && $_GET['UserId']!=""){
 $UserId=$_GET['UserId'];
 $check_head = str_split($UserId, 1);
 if(count($check_head)>50)
 {
 	$Message="信箱長度超過限制";

 }
 else if(!preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $UserId))
 {
 	$Message="信箱格式錯誤";

 }else
 {

	$query="select UserId from usermain";
	$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
	while($rs = mysql_fetch_array($result))
	{

		if($UserId==$rs['UserId'])
		{
			$Message="已被使用";
 			break;
		}
 	}

  }
}
else{
 $UserId="";
 $Message="請填寫信箱";
}
header("Location:quick_reg.php?UserId=$UserId&Message=$Message");


echo $Message;
?>
