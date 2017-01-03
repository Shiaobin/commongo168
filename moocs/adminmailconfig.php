<?php require('../utility/init.php'); ?>
<?php //require('../include/admin_system.php'); ?>

<?php // ** initialize the session **
if (!isset($_SESSION)) {
  session_start();
}


// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_AdminName'] = NULL;
  $_SESSION['MM_AdminGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_AdminName']);
  unset($_SESSION['MM_AdminGroup']);
  unset($_SESSION['PrevUrl']);

  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>


<?php // ** Login未成功重新到login.php畫面 **
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized.
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_AdminName set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username.
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "adminlogin.php";
if (!((isset($_SESSION['MM_AdminName'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_AdminName'], $_SESSION['MM_AdminGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Imagetoolbar" content="no" />
<title>後台管理</title>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="../img/favicon.ico" />
<link rel="icon" type="image/vnd.microsoft.icon" href="../img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/fonts.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/global.css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.imgpreload.js"></script>
<script type="text/javascript" src="js/global.js"></script>
</head>
<body >
<div id="wrap">
<div id="contents" class="cf">
<div id="side">
<div class="bg">
<?php include("../include/admin/admin_menubar_vertical.php"); ?>
</div>
</div>

<div id="main">
<div class="bgt">
<div class="bgb">
<h2><a href="../index.php">回前台</a></h2>
<!---------------------網頁程式碼start--------------------------------->
<?php  //-----------------------------更新商品資訊------------------------------------//
//$sysConnDebug = true;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_config"])) && ($_POST["update_config"] == "更新")) {

  $table_shopsetup = SYS_DBNAME . ".mailbox_setup";
  $whereClause = "ID=1";
  $record = array
  (
	  'FromName' => $_POST['fromname'],
	  'ReplyMail' => $_POST['replymail'],
	  'Subject' => $_POST['subject'],
	  'Body' => $_POST['body']

  );

  $is_update = dbUpdate( $table_shopsetup, $record, $whereClause );

  $updateGoTo = "adminmailconfig.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }

}
?>
<?php  //-----------------------------取得網站設置資訊------------------------------------//
	$column = "*";
	$table_shopsetup		= SYS_DBNAME . ".mailbox_setup";

  	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
			'mssql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
			'oci8'	=> "SELECT {$column} FROM {$table_shopsetup} "
	);
	$row_showconfigRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

?>
<h3 class=ttl01><font color=#800080>信件回覆設置</h3>
<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------寄件者資訊--------------------------------->
<form name="editconfig" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editconfig">
  <tr>
    <td width="20%" align="right">寄件者姓名:</td>
    <td width="80%" colspan="3" align="left">
      <input id="fromname" name="fromname" value="<?php echo $row_showconfigRec['FromName']; ?>"  type="text" class="sizeML" />
    </td>
  </tr>
  <!----------------------------回覆至此信箱---------------------------->
  <tr>
    <td width="20%" align="right">回覆至此信箱:</td>
    <td width="80%" colspan="3" align="left">
      <input id="replymail" name="replymail"  type="text" class="sizeML" value="<?php echo $row_showconfigRec['ReplyMail']; ?>"/></td>
  </tr>

  <!------------------------信件主旨------------------------>
  <tr>
    <td width="20%" align="right">信件主旨:</td>
    <td width="80%" colspan="3" align="left">
      <input id="subject" name="subject" type="text" class="sizeML" value="<?php echo $row_showconfigRec['Subject']; ?>"/>
    </td>
  </tr>
  <!----------------------------信件內容---------------------------->
  <tr>
    <td width="20%" align="right">信件內容:</td>
    <td width="80%" colspan="3" align="left">
      <textarea id="body" name="body" cols="30" rows="15" ><?php echo $row_showconfigRec['Body']; ?></textarea>
    </td>
  </tr>

  <tr>
    <td colspan="2" align="center">
      <input type="submit" name="update_config"  value="更新" style="font-size:16px;width:120px; height:30px; margin: 3px"/>
    </td>
  </tr>
</form>
</table>
<?php
//mysql_free_result($showconfigRec);
?>
<!---------------------網頁程式碼結束--------------------------------->
</div>
</div>
</div>
</div>
</body>

