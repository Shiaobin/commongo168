<?php require('../utility/init.php'); ?>

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

  $logoutGoTo = "index.php";
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
<?php include("small.php"); ?>
<?php  //-----------------------------更新商品資訊------------------------------------//
if ((isset($_POST["update_banner"])) && ($_POST["update_banner"] == "更新")) {

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['banner']=="" ) $img = date('his').".jpg";
	else                      $img = $_POST['banner'];

	move_uploaded_file( ($_FILES["upload_img"]["tmp_name"]), "../images/bannerimg/".$img);
        resize_banner_image($img);
  }
  else {
    $img = $_POST['banner'];
  }

  //更新商品資訊
  $table_banner		= SYS_DBNAME . ".banner";
  $record = array(
  				'po' => $_POST['po'],
				'title' => $_POST['title'],
				'banner' => $img
				);
  $whereClause = "Notice_ID={$_POST['Notice_ID']}";
  dbUpdate( $table_banner, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE banner SET po=%s, banner=%s, title=%s WHERE Notice_ID=%s",
                        GetSQLValueString($_POST['po'], "int"),
                        GetSQLValueString($img, "text"),
						GetSQLValueString($title, "text"),
						GetSQLValueString($_POST['Notice_ID'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
	*/
  $updateGoTo = "adminbanner.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showbannerRec = "%";
if (isset($_GET['Notice_ID'])) {
  $cloume_showbannerRec = $_GET['Notice_ID'];
}

$table_banner		= SYS_DBNAME . ".banner";
$whereClause = "Notice_ID='{$cloume_showbannerRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_banner} WHERE {$whereClause}"
		);
$row_showbannerRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showbannerRec = sprintf("SELECT * FROM banner WHERE Notice_ID=%s", GetSQLValueString($cloume_showbannerRec, "text"));
$showbannerRec = mysql_query($query_showbannerRec, $webshop) or die(mysql_error());
$row_showbannerRec = mysql_fetch_assoc($showbannerRec);
$totalRows_showbannerRec = mysql_num_rows($showbannerRec);
*/
?>
<h3 class=ttl01 >修改上架商品資訊</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editbanner" action="" method="POST" enctype="multipart/form-data" id="editbanner">
  <tr>
    <td>顯示順序:
      <input id="po" name="po" type="text" class=sizeSss
       value="<?php echo $row_showbannerRec['po']; ?>" />
    </td>
  </tr>
    <tr>
    <td>標題:
      <input id="title" name="title" type="text" class=sizeM
       value="<?php echo $row_showbannerRec['title']; ?>" />
    </td>
  </tr>
  <!----------------------------廣告圖片---------------------------->
  <tr>
    <td>廣告圖片:
      <img src="../../images/bannerimg/<?php echo $row_showbannerRec['banner']; ?>" alt="" name="image"
       width="520px" id="image" align="center" style="padding:5px;"/>
       <input name="banner" type="hidden" value="<?php echo $row_showbannerRec['banner']; ?>" />
    </td>
  </tr>
  <!----------------------------更新圖片---------------------------->
  <tr>
    <td>更新圖片:
      <input type="file" name="upload_img" style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="Notice_ID" type="hidden" value="<?php echo $row_showbannerRec['Notice_ID']; ?>" />
      <input type="submit" name="update_banner"  value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showbannerRec);
?>


</div>
</div>
</div>
</div>
</body>
<!---------------------網頁程式碼結束--------------------------------->
