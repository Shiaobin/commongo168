<?php session_start();
if(!isset($_POST["userid"])){
header('Location:index.php');
exit;
}
include("connections/webshop.php");
header("Content-type: text/html; charset=utf-8"); 
$query='select * from usermain';
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
$A=$_POST["userid"];
$P=$_POST["password"];

if($_POST["userid"]==""){?>
<script>
alert("請輸入帳號");
location.href='my_accounts.php';
</script><?php
exit;
}
if($_POST["password"]==""){?>
<script>
alert("請輸入密碼");
location.href='my_accounts.php';
</script><?php
exit;
}

while($rs = mysql_fetch_array($result)){
if($A==$rs['UserId'] & $P==$rs['UserPassword']){
  if($rs['Status']=="0")
  {
  $_SESSION['yuserid']=$A;
  $_SESSION['ypassword']=$P;
  $_SESSION['username']=$rs['UserName'];
  $_SESSION['MM_Username']=$A;  
  if(isset($_SESSION['go']))
  {
	   $go=$_SESSION['go'];
	   unset($_SESSION['go']);
	   header('Location:'.$go.".php");
  }

  else header('Location:my_accounts.php');
  exit;
  }
  else
  {
	  echo "<script>alert('該帳號已被凍結');location.href='my_accounts.php';</script>";
	  exit;
  }
 }
}?>
<script>
alert("密碼錯誤");
location.href='my_accounts.php';
</script>


