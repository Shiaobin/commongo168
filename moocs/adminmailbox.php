<?php require('../utility/init.php');
include("../connections/webshop.php");
?>

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
<!---------------------網頁程式碼開始--------------------------------->
<?php  //---------------------------取出留言資訊---------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_showmsgRec = 10;
$pageNum_showmsgRec = 0;
if (isset($_GET['pageNum_showmsgRec'])) {
  $pageNum_showmsgRec = $_GET['pageNum_showmsgRec'];
}
$startRow_showmsgRec = $pageNum_showmsgRec * $maxRows_showmsgRec;

$column = "*";
$table_contact_msg		= SYS_DBNAME . ".contact_msg";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}"
);
$row_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = "SELECT * FROM contact_msg ORDER BY MessageDate DESC";
$query_limit_showmsgRec = sprintf("%s LIMIT %d, %d", $query_showmsgRec, $startRow_showmsgRec, $maxRows_showmsgRec);
$showmsgRec = mysql_query($query_limit_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
*/
if (isset($_GET['totalRows_showmsgRec'])) {
  $totalRows_showmsgRec = $_GET['totalRows_showmsgRec'];
} else {
  $sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC",
		'mssql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC",
		'oci8'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC"
  );
  $all_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showmsgRec = sizeof($all_showmsgRec);
}
$totalmsg_showmsgRec = ceil($totalRows_showmsgRec/$maxRows_showmsgRec)-1;

$queryString_showmsgRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showmsgRec") == false &&
        stristr($param, "totalRows_showmsgRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showmsgRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showmsgRec = sprintf("&totalRows_showmsgRec=%d%s", $totalRows_showmsgRec, $queryString_showmsgRec);
?>
<?php  //---------------------------搜尋功能---------------------------------//
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
  $name = trim($_POST["search_name"]);
  $open = $_POST["search_type"];

  $string = "";
  if($open == 0)
      $string = $string."set_open = '0'";
  else if($open == 1)
      $string = $string."set_open = '1'";
  else if($open == 2)
      $string = $string."(set_open = '0' || set_open = '1')";
  else if($open == 3)
      $string = $string."Reply = '0'";
  else if($open == 4)
      $string = $string."Reply = '1'";

  if($name != "") {
    //$string = $string." && "."locate(ProdDisc,'$name') > 0";
	$string = $string." && Message LIKE '%$name%'"." || Name LIKE '%$name%'"." || Email LIKE '%$name%'";
  }


  $maxRows_showmsgRec = 10;
$pageNum_showmsgRec = 0;
if (isset($_GET['pageNum_showmsgRec'])) {
  $pageNum_showmsgRec = $_GET['pageNum_showmsgRec'];
}
$startRow_showmsgRec = $pageNum_showmsgRec * $maxRows_showmsgRec;

$column = "*";
$table_contact_msg		= SYS_DBNAME . ".contact_msg";
$whereClause = "$string";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC LIMIT {$startRow_showmsgRec}, {$maxRows_showmsgRec}"
);
$row_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

if (isset($_GET['totalRows_showmsgRec'])) {
  $totalRows_showmsgRec = $_GET['totalRows_showmsgRec'];
} else {
  $sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC",
		'mssql'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC",
		'oci8'	=> "SELECT {$column} FROM {$table_contact_msg} WHERE {$whereClause} ORDER BY MessageDate DESC"
  );
  $all_showmsgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showmsgRec = sizeof($all_showmsgRec);
}
$totalmsg_showmsgRec = ceil($totalRows_showmsgRec/$maxRows_showmsgRec)-1;
$queryString_showmsgRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showmsgRec") == false &&
        stristr($param, "totalRows_showmsgRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showmsgRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showmsgRec = sprintf("&totalRows_showmsgRec=%d%s", $totalRows_showmsgRec, $queryString_showmsgRec);
}

?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "公開")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ID='".$_POST['select_page'][$i]."'";
      }

	  $record = array( 'set_open' => '1' );
	  $table_contact_msg		= SYS_DBNAME . ".contact_msg";
	  $whereClause = "CONCAT($update_string)";

	  dbUpdate( $table_contact_msg, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE contact_msg SET set_open='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminmailbox.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "隱藏")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ID='".$_POST['select_page'][$i]."'";
      }

	  $record = array( 'set_open' => '0' );
	  $table_contact_msg		= SYS_DBNAME . ".contact_msg";
	  $whereClause = "CONCAT($update_string)";

	  dbUpdate( $table_contact_msg, $record, $whereClause );
	  /*
	  $updateSQL = "UPDATE contact_msg SET set_open='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
	  $updateGoTo = "adminmailbox.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $delete_string = "";
	  $delete_string_re = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."ID='".$_POST['select_page'][$i]."'";
		if($delete_string_re != "") $delete_string_re = $delete_string_re." || ";
		$delete_string_re = $delete_string_re."MessageId='".$_POST['select_page'][$i]."'";
      }

	  $table_contact_msg		= SYS_DBNAME . ".contact_msg";
	  $whereClause = "CONCAT($delete_string)";

	  dbDelete( $table_contact_msg, $whereClause );

	  $table_contact_re	= SYS_DBNAME . ".contact_re";
	  $whereClause = "CONCAT($delete_string_re)";

	  dbDelete( $table_contact_re, $whereClause );
	  /*
	  $deleteSQL = "DELETE FROM contact_msg WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  $deleteGoTo = "adminmailbox.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>

<script>
function check_all(obj,cName)
{
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
</script>
<h3 class=ttl01 >收件匣</h3>
 <form action="" method="POST" name="search_pages" id="search_pages" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable1">
      <tr>
        <td align=left style="width:30%" >關鍵字 <input name="search_name" type="text" style="width:100px"/></td>
        <td align=left  style="width:50%">
          <label>
            <input type="radio" name="search_type" value="3" id="search_type_3" />
            未回覆</label>
          <label>
            <input type="radio" name="search_type" value="4" id="search_type_4" />
            已回覆</label>
          <label>
            <input type="radio" name="search_type" value="0" id="search_type_0" />
            隱藏</label>
          <label>
            <input type="radio" name="search_type" value="1" id="search_type_1" />
            公開</label>
          <label>
            <input type="radio" name="search_type" value="2" id="search_type_2" checked/>
            全部</label>
        </td>
        <td align=center  style="width:20%"><input type="submit" name="search_btn"  value="搜尋"/></td>
      </tr>
 </table>
    </form>



<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01" >
<form action="" name="edit_msg" method="POST" id="edit_msg" enctype="multipart/form-data">
<tr>
  <td height="5%" align="left" colspan="5"><font color="blue">提示：利用上面的搜索功能，可快速找到相關資料。</font></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#DFDFDF">
  <td width="2%"><p>選擇</p></td>
  <td width="12%">寄件者</td>
  <td width="14%">日期</td>
  <td width="14%">狀態</td>
  <td width="5%">顯示</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_showmsgRec as $key => $array){ ?>
  <?php if ($totalRows_showmsgRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td><input name="select_page[]" type="checkbox" value="<?php echo $array['ID']; ?>" /></td>
      <!--td align="left"><a href="admineditmsg.php?ID=<?php echo $array['ID']; ?>"><?php echo str_replace("\r\n","<br />",$array['msg_title']); ?></a></td-->
      <td><a href="admineditmail.php?ID=<?php echo $array['ID']; ?>"><?php echo $array['Name']; ?></a></td>
      <td><?php echo $array['MessageDate']; ?></td>
      <!--td align="left">
	  	<?php echo str_replace("\r\n","<br />",$array['msg_back']); ?>
      </td-->
      <td><?php if(empty($array['Reply'])) echo "<a href=admineditmail.php?ID=".$array['ID']." style='color:red;'>尚未回覆</a>";else echo "已完成回覆"; ?></td>
      <td><?php if($array['set_open'] == 0) echo "隱藏"; else echo "公開";?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td colspan="7" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="隱藏" />
    <input name="open_btn" type="submit" value="公開" />
  </td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="7" align="right" bgcolor="#cfcfcf" >
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showmsgRec ?> 筆資料 <?php echo ($pageNum_showmsgRec+1)."/".($totalmsg_showmsgRec+1); ?></td>
        <td align="right">
		  <?php if ($pageNum_showmsgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, 0, $queryString_showmsgRec); ?>"><img src="../../Images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showmsgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, max(0, $pageNum_showmsgRec - 1), $queryString_showmsgRec); ?>"><img src="../../Images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showmsgRec < $totalmsg_showmsgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, min($totalmsg_showmsgRec, $pageNum_showmsgRec + 1), $queryString_showmsgRec); ?>"><img src="../../Images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showmsgRec < $totalmsg_showmsgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showmsgRec=%d%s", $currentPage, $totalmsg_showmsgRec, $queryString_showmsgRec); ?>"><img src="../../Images/symbol/Last.gif" class="img"/></a>
          <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>
<!-------------------------------------------------------------->
</table>
<?php
//mysql_free_result($showmsgRec);
?>

</div>
</div>
</div>
</div>
</body>
<!---------------------網頁程式碼結束--------------------------------->
