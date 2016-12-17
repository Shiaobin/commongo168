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
<?php  //---------------------------取出廣告資訊---------------------------------//
$maxRows_showgoodsRec = 20;
$pageNum_showgoodsRec = 0;
if (isset($_GET['pageNum_showgoodsRec'])) {
  $pageNum_showgoodsRec = $_GET['pageNum_showgoodsRec'];
}
$startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;


$table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause} LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}", 
		'mssql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause} LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
		'oci8'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause} LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}"
		);
$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showgoodsRec = "SELECT * FROM index_image_slide ORDER BY slide_index ASC";
$query_limit_showgoodsRec = sprintf("%s LIMIT %d, %d", $query_showgoodsRec, $startRow_showgoodsRec, $maxRows_showgoodsRec);
$showgoodsRec = mysql_query($query_limit_showgoodsRec, $webshop) or die(mysql_error());
$row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
*/
if (isset($_GET['totalRows_showgoodsRec'])) {
  $totalRows_showgoodsRec = $_GET['totalRows_showgoodsRec'];
} else {
  $all_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showgoodsRec = sizeof($all_showgoodsRec);
}
$totalPages_showgoodsRec = ceil($totalRows_showgoodsRec/$maxRows_showgoodsRec)-1;

$queryString_showgoodsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showgoodsRec") == false && 
        stristr($param, "totalRows_showgoodsRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showgoodsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showgoodsRec = sprintf("&totalRows_showgoodsRec=%d%s", $totalRows_showgoodsRec, $queryString_showgoodsRec);
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_banner'])){
      $select_num = count($_POST['select_banner']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."slide_no='".$_POST['select_banner'][$i]."'";
      }
	  
	  //刪除圖片
	  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
	  $whereClause = "CONCAT($delete_string)";
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}",
			  'oci8'	=> "SELECT * FROM {$table_index_image_slide} WHERE {$whereClause}"
			  );
	  $row_searchImg = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  
      /*mysql_select_db($database_webshop, $webshop);
      $searchSQL = "SELECT * FROM index_image_slide WHERE CONCAT($delete_string) ";
      $searchImg = mysql_query($searchSQL, $webshop) or die(mysql_error());
	  $row_searchImg = mysql_fetch_assoc($searchImg); */

      foreach ($row_searchImg as $key => $array){    
	  if(($array['slide_img'] != "none.gif")){ 
          unlink("../images/slideimg/".$array["slide_img"]);}
  		  //unlink("../images/newsimg/small/".$row_searchImg["imgfull"]);}
      }
	  
	  
	  //刪除廣告資料
	  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_index_image_slide, $whereClause );
	  /*
	  mysql_select_db($database_webshop, $webshop);
	  $deleteSQL = "DELETE FROM index_image_slide  WHERE CONCAT($delete_string)";
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  //$deleteGoTo = sprintf("adminimageslide.php");
	  $deleteGoTo = "adminimageslide.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>

<script>
function check_all(obj,cName) { 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
}

function editSlide(btn) {
  location.href="admineditimageslide.php?slide_no="+btn.name;
}

function addSlide(btn) {
  location.href="adminaddimageslide.php";
}
</script>
<h3 class=ttl01 >首頁圖片管理</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">

      <form action="" name="edit_banner" method="POST" id="edit_banner" enctype="multipart/form-data">
      <tr>
        <td colspan="5">
        </td>
        <td align="center">
          <input id="<?php echo $no;?>" name="<?php //echo $row_showImgClassRec["img_class_id"]; ?>" type="button" value="新增連結圖片" onclick="addSlide(this);" style="margin:5px">
        </td>
      </tr>
      <!-------------------------------------------------------------->
      <tr align="center" bgcolor="#CCCCCC">
        <td width="3%"><p>選擇</p></td>
        <td width="6%">順序</td>
        <td width="15%">圖片</td>
        <td width="38%">連結網址</td>
        <td width="23%">文字</td>
        <td width="15%">編輯</td>
      </tr>
      <!-------------------------------------------------------------->
      <?php foreach ($row_showgoodsRec as $key => $array){    ?>
      <?php if ($totalRows_showgoodsRec > 0) { // Show if recordset not empty ?>
      <tr align="center">
        <td><input name="select_banner[]" type="checkbox" value="<?php echo $array['slide_no']; ?>" /></td>
        <td><?php echo $array['slide_index']; ?></td>
        <td>
          <img src="../../images/slideimg/<?php echo $array['slide_img']; ?>" alt="" name="image" 
           width="100px" height="50px" id="image" align="center" style="padding:5px;"/>
        </td>
        <td align="left"><?php echo $array['slide_url']; ?></td>
        <td align="left"><?php echo $array['slide_text']; ?></td>
        <td><input id="<?php echo $no;?>" name="<?php echo $array['slide_no']; ?>" type="button" value="編輯" onclick="editSlide(this);" /></td>
      </tr>
      <?php } // Show if recordset not empty ?>
      <?php }?>
      <!-------------------------------------------------------------->
      <tr>
        <td colspan="5" align="left">
          <input type="checkbox" name="all" onclick="check_all(this,'select_banner[]')" />全選
          <input name="delete_btn" type="submit" value="刪除" />
        </td>
        <td align="center"><input id="<?php //echo $no;?>" name="<?php //echo $row_showImgClassRec["img_class_id"]; ?>" type="button" value="新增連結圖片" onclick="addSlide(this);" style="margin:5px"></td>
      </tr>
    <!-----------------------------page control----------------------------->
    <tr> 
      <td colspan="7" align="right" bgcolor="#cfcfcf" >
        <table border="0">
          <tr>
            <td>共<?php echo $totalRows_showgoodsRec ?> 種商品</td>
            <td align="right">
              <?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, 0, $queryString_showgoodsRec); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
              <?php } // Show if not first page ?>
              <?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, max(0, $pageNum_showgoodsRec - 1), $queryString_showgoodsRec); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
              <?php } // Show if not first page ?>
              <?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, min($totalPages_showgoodsRec, $pageNum_showgoodsRec + 1), $queryString_showgoodsRec); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
              <?php } // Show if not last page ?>
              <?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s", $currentPage, $totalPages_showgoodsRec, $queryString_showgoodsRec); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
              <?php } // Show if not last page ?>
            </td>
          </tr>
        </table>
      </td>
    </tr>
	</form>
</table>
<!--------------------------------------------------------------------------------->
<?php
//mysql_free_result($showbannerRec);
?>

<!---------------------網頁程式碼結束--------------------------------->


</div>
</div>
</div>
</div>
</body>
