<?php require('../utility/init.php'); ?>
<?php require_once('../connections/webshop.php'); ?>
<?php require('../include/admin_system.php'); ?>

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
<!---------------------網頁程式碼start--------------------------------->
<?php include("small.php"); ?>

<?php  //--------------------------修改分頁類別(中類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

      $img=$_FILES["upload_img"]["name"];
	$num=strrpos($img,".");
	$a=substr($img,$num+1);
	$img= date('his').".".$a;

    /*if($_POST['pic']=="none.gif" ) $img = date('his').".jpg";
	else                      $img = $_POST['pic'];*/

	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/app/".$img);
        resize_midcode_image($img);
  }
  else {
    $img = $_POST['pic'];
  }


  //更新中項內容
  $updateSQL = sprintf("UPDATE compclass SET MidSeq=%s, MidCode=%s, snum=%s, url=%s, pic=%s WHERE ClassId=%s",
                       GetSQLValueString($_POST['upd_MidSeq'], "int"),
					   GetSQLValueString($_POST['MidCode'], "text"),
					   GetSQLValueString($_POST['snum'], "int"),
					   GetSQLValueString($_POST['url'], "text"),
					   GetSQLValueString($img, "text"),
					   GetSQLValueString($_POST['ClassId'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());


  $updateGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>

<?php  //-----------------------------取得中類資訊------------------------------------//

$cloume_showitemClassId = "-1";
if (isset($_GET['ClassId'])) {

    $cloume_showitemClassId = $_GET['ClassId'];
}
mysql_select_db($database_webshop, $webshop);
$query_showitemMidRec = sprintf("SELECT * FROM compclass WHERE ClassId=%s",
                               GetSQLValueString($cloume_showitemClassId, "int"));
$showitemMidRec = mysql_query($query_showitemMidRec, $webshop) or die(mysql_error());
$row_showitemMidRec = mysql_fetch_assoc($showitemMidRec);
$totalRows_showitemMidRec = mysql_num_rows($showitemMidRec);
?>
<h3 class=ttl01 >編輯網頁中類</h3>
<!---------------------新增類別--------------------------------->
<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">

   <form action="<?php echo $editFormAction; ?>" name="additem" method="POST"enctype="multipart/form-data" id="additem">
      <tr align="left">
        <td width="100%">名稱:
          <input id="MidCode" name="MidCode" type="text" class="sizeM" value="<?php echo $row_showitemMidRec['MidCode']; ?>"/>
        </td>
      </tr>

      <tr align="left">
        <td width="100%">排序:
          <input type="int" name="upd_MidSeq" id="upd_MidSeq" class="sizeSss" value="<?php echo $row_showitemMidRec['MidSeq']; ?>"/>
          [不能與同一大類下其它中類的排序號重複]
        </td>
      </tr>

      <tr align="left">
        <td width="100%">直接超聯結:http://
          <input type="text" name="url" id="url" class="sizeML" value="<?php echo $row_showitemMidRec['url']; ?>"/>
        </td>
      </tr>

      <tr align="left">
        <td width="100%">寫'0'值,則'前台網頁'中類選項只出現單頁不出現中類下之細類選項；寫'1'值,則反:<input type="int" name="snum"  class="sizeSss" value="<?php echo $row_showitemMidRec['snum']; ?>"/>
          <input name="ClassId" type="hidden" value="<?php echo $row_showitemMidRec['ClassId']; ?>" />
        </td>
      </tr>
      <!----------------------------圖片---------------------------->
      <tr>
        <td width="12%" height="10%" align="left">
          <img src="../images/app/<?php echo $row_showitemMidRec['pic']; ?>" alt="" name="image"
           width="78px" height="65px" id="image" align="center" style="padding:5px;"/>
           <input name="pic" type="hidden" value="<?php echo $row_showitemMidRec['pic']; ?>" />
        </td>
      </tr>
     <!----------------------------上傳圖片---------------------------->
  	  <tr>
        <td width="10%" height="10%" align="left">圖片[有手機板APP才需上傳圖片]
            <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/>
        </td>
      </tr>

      <tr align="left">
        <td width="100%">
          <input type="submit" name="update_item" id="update_item" value="更新" style="font-size:16px;width:50px;height:30px"/>
        </td>
      </tr>
<!-------------------------------------------------------------->
   </form>
</table>
<!---------------------網頁程式碼結束--------------------------------->
</div>
</div>
</div>
</div>
</body>

