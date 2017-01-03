<?php //require_once('../Connections/webshop.php'); ?>
<?php //require('../include/system.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['userpsw'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admingoods.php";
  $MM_redirectLoginFailed = "adminlogin.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_webshop, $webshop);

  $LoginRS__query=sprintf("SELECT username, userpsw FROM shop_admin WHERE username=%s AND userpsw=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));

  $LoginRS = mysql_query($LoginRS__query, $webshop) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup = "";

	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_AdminName'] = $loginUsername;
    $_SESSION['MM_AdminGroup'] = $loginStrGroup;

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>登入欄位</title>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="32%" height="100%" rowspan="4">&nbsp;</td>
    <td width="32%" height="100%" rowspan="4">
      <table width="100%" height="85%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0">
      <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
      	<!-------------------------------------------------------------->
        <tr>
          <td width="26%" height="8%" align="center"><span class="text_login"> 帳號</span></td>
          <td width="74%" >
            <label for="username"></label>
            <input type="text" name="username" id="username" style="width:97%; height:40px"/>
          </td>
        </tr>
        <!-------------------------------------------------------------->
        <tr>
          <td width="26%" height="8%" align="center"><span class="text_login">密碼</span></td>
          <td>
           <label for="userpsw"></label>
           <input type="text" name="userpsw" id="userpsw" style="width:97%; height:40px" />
          </td>
        </tr>
        <!-------------------------------------------------------------->
        <tr>
          <td height="30%" colspan="3" align="right">
            <input name="login" type="submit" class="btn_login" id="login" value="登入管理系統"  style="width:60%; height:40px; margin-right:3px"/></td>
        </tr>
      </form>
      </table>
    </td>
    <td width="45%" height="100%" rowspan="4">&nbsp;</td>
  </tr>
</table>
