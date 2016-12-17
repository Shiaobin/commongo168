<?php require('../utility/init.php'); ?>

<?php // ** initialize the session ** 
if (!isset($_SESSION)) {
  session_start();
}

//$sysConnDebug = true;
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
<?php  //-----------------------------取得索引標籤------------------------------------//
$tabindex = "%";
if (isset($_GET['tabindex'])) {
  $tabindex = $_GET['tabindex'];
}
?>
<?php  //-----------------------------更新商品資訊------------------------------------//
if ((isset($_POST["update_slide"])) && ($_POST["update_slide"] == "更新")) {	

  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['slide_img']=="none.gif" ) $img = date('his').".jpg"; 
	else                     $img = $_POST['slide_img'];
	
	move_uploaded_file( ($_FILES["upload_img"]["tmp_name"]), "../images/slideimg/".$img);
        resize_slide_image($img);
  }
  else {
    $img = $_POST['slide_img'];
  }
  
  //更新商品資訊
  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
  $record = array(
  				'slide_index' => $_POST['slide_index'],
				'slide_img' => $img,
				'slide_url' => $_POST['slide_url'],
				'slide_text' => $_POST['slide_text']
				);
  $whereClause = "slide_no='{$_POST['slide_no']}'";
		
  dbUpdate( $table_index_image_slide, $record, $whereClause );
				/*
  $updateSQL = sprintf("UPDATE index_image_slide SET slide_index=%s, slide_img=%s, slide_url=%s, slide_text=%s WHERE slide_no=%s",
                        GetSQLValueString($_POST['slide_index'], "int"),
                        GetSQLValueString($img, "text"),
						GetSQLValueString($_POST['slide_url'], "text"),
						GetSQLValueString($_POST['slide_text'], "text"),
						GetSQLValueString($_POST['slide_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
	*/
  $updateGoTo = sprintf("adminimageslide.php?tabindex=%s",$tabindex);
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>"; 
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showbannerRec = "%";
if (isset($_GET['slide_no'])) {
  $cloume_showbannerRec = $_GET['slide_no'];
}

$table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
$whereClause = "slide_no='{$cloume_showbannerRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}"
		);
$row_showbannerRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showbannerRec = sizeof($row_showbannerRec);
/*	
mysql_select_db($database_webshop, $webshop);
$query_showbannerRec = sprintf("SELECT * FROM index_image_slide WHERE slide_no=%s", GetSQLValueString($cloume_showbannerRec, "text"));
$showbannerRec = mysql_query($query_showbannerRec, $webshop) or die(mysql_error());
$row_showbannerRec = mysql_fetch_assoc($showbannerRec);
$totalRows_showbannerRec = mysql_num_rows($showbannerRec);
*/
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >修改廣告圖片資訊</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editslide" action="" method="POST" enctype="multipart/form-data" id="editslide">
  <tr>
    <td>1.顯示順序:
      <input id="slide_index" name="slide_index" type="text" class=sizeSss 
       value="<?php echo $row_showbannerRec['slide_index']; ?>" />
    </td>
  </tr>
  <!----------------------------廣告圖片---------------------------->
  <tr>
    <td>2.廣告圖片:
      <img src="../../images/slideimg/<?php echo $row_showbannerRec['slide_img']; ?>" alt="" name="image" 
       width="300px" height="150px" id="image" align="center" style="padding:5px;"/>
       <input name="slide_img" type="hidden" value="<?php echo $row_showbannerRec['slide_img']; ?>" />
    </td>
  </tr>
  <!----------------------------更新圖片---------------------------->
  <tr>
    <td>3.更新圖片:
      <input type="file" name="upload_img" style="width:50%; height:90%; margin: 3px"/>
    </td>
  </tr>
  <!---------------------------圖片連結網址-------------------------->
  <tr>
    <td>4.連結網址:
      <input id="slide_url" name="slide_url" type="text" class=sizeL 
       value="<?php echo $row_showbannerRec['slide_url']; ?>" />
    </td>
  </tr>
  <!---------------------------說明文字-------------------------->
  <tr>
    <td>5.說明文字:
      <input id="slide_text" name="slide_text" type="text" class=sizeML 
       value="<?php echo $row_showbannerRec['slide_text']; ?>" />
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="slide_no" type="hidden" value="<?php echo $row_showbannerRec['slide_no']; ?>" />
      <input type="submit" name="update_slide"  value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showbannerRec);
?>


<!---------------------網頁程式碼結束--------------------------------->

</div>
</div>
</div>
</div>
</body>
