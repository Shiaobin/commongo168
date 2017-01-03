<?php
session_start();
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword'])
{
  unset($_SESSION['yuserid']);
  unset($_SESSION['ypassword']);
  unset($_SESSION['username']);
  unset($_SESSION['MM_Username']);
  unset($_SESSION['go']);

  //session_destroy();
}

?>

<HTML>
<HEAD>
<TITLE>退出登入</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="shop.css" type="text/css">
<meta http-equiv="refresh" content="3;URL=index.php">
</HEAD>

<body  text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<br>
<br>
<table width="760" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35">
<div align="center">
        <p>謝謝您！正在退出，三秒鐘後自動返回網站首頁，</p>
        <p>如果不想等待，請點擊下面連接返回首頁<br>
        </p>
      </div></td>
  </tr>
  <tr>
    <td><div align="center"><a href="index.php"><font color="#FF0000">點擊返回首頁</font></a>
      </div></td>
  </tr>
</table>
</BODY>
</HTML>