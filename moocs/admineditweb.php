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
<!---------------------網頁程式碼結束--------------------------------->
<?php include("small.php"); ?>
<?php  //-----------------------------更新網頁資訊------------------------------------//
//$sysConnDebug = true;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_pages"])) && ($_POST["update_pages"] == "更新")) {
  //move_uploaded_file($_FILES["pages_img"]["tmp_name"], "..\webimg\pagesimg\\".$_FILES["pages_img"]["name"].".jpg");
  $img_string = array();

  //上傳圖片
  foreach ($_FILES["goods_img"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
       //echo"$error_codes[$error]";
	   $type = $_FILES["goods_img"]["type"][$key];
	   $img_type = explode("/",$type);

	   $num =  date('ymdhis') + $key;
	   $img_string[$key] = $num.".".$img_type[1];

       move_uploaded_file(
          ($_FILES["goods_img"]["tmp_name"][$key]),
         //"/var/www/html/sample/images/webimg/".$img_string[$key]
         "../images/webimg/".$img_string[$key]
       ) or die("Problems with upload");

       resize_web_image($img_string[$key]);
    }
  }

  //取得首張圖片資訊
  if($_POST["img_num"] > 0) {
	$cloume_showImgRec = "%";
	if (isset($_GET['ProdId'])) {
      $cloume_showImgRec = $_GET['ProdId'];
    }

	$table_comp_img		= SYS_DBNAME . ".comp_img";
	$whereClause = "ProdId='{$cloume_showImgRec}'";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} order by img_no ASC",
			'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} order by img_no ASC",
			'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} order by img_no ASC"
			);
	$row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
    mysql_select_db($database_webshop, $webshop);
    $query_showimgRec = sprintf("SELECT * FROM comp_img WHERE ProdId=%s order by img_no ASC", GetSQLValueString($cloume_showImgRec, "text"));
    $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
    $row_showimgRec = mysql_fetch_assoc($showimgRec);
	*/
	$img = $row_showimgRec["img_name"];
  }
  else if(count($img_string) > 0)  $img = $img_string[0];
  else                             $img = "";

  //預設圖片
  if($img == ""){
	  $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
  				'LarCode' => $_POST['LarCode'],
				'MidCode' => $_POST['MidCode'],
				'ProdName' => $_POST['MidCode'],
				'paybackurl' => $_POST['paybackurl'],
				'ProdDisc' => $_POST['ProdDisc'],
				'MemoSpec' => $_POST['MemoSpec'],
				'ImgFull' => 'none.gif'
				);
  $whereClause = "ProdId={$_POST['ProdId']}";

  dbUpdate( $table_compmain, $record, $whereClause );

  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'img_name' => 'none.gif'
				);
  dbInsert( $table_comp_img, $record );

  //未上傳新圖片
  }else if($img_string[0] == ""){
	   $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
  				'LarCode' => $_POST['LarCode'],
				'MidCode' => $_POST['MidCode'],
				'ProdName' => $_POST['MidCode'],
				'paybackurl' => $_POST['paybackurl'],
				'ProdDisc' => $_POST['ProdDisc'],
				'MemoSpec' => $_POST['MemoSpec']
				);
  $whereClause = "ProdId={$_POST['ProdId']}";

  dbUpdate( $table_compmain, $record, $whereClause );

  //有上傳新圖片
  }else{
  //更新網頁資訊
  $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
  				'LarCode' => $_POST['LarCode'],
				'MidCode' => $_POST['MidCode'],
				'ProdName' => $_POST['MidCode'],
				'paybackurl' => $_POST['paybackurl'],
				'ProdDisc' => $_POST['ProdDisc'],
				'MemoSpec' => $_POST['MemoSpec'],
				'ImgFull' => $img_string[0]
				);
  $whereClause = "ProdId={$_POST['ProdId']}";

  dbUpdate( $table_compmain, $record, $whereClause );

  }

  /////////////////////////////ebooks////////////////////
  //上傳圖片
  if($_FILES['ebook_img']['name'] != "" ) {

    if($_POST['pic_url']=="none.gif" ) $img_ebook = date('his').".jpg";
	else                      $img_ebook = $_POST['pic_url'];

	move_uploaded_file(($_FILES["ebook_img"]["tmp_name"]), "../images/webimg/".$img_ebook);
        resize_web_image($img_ebook);
  }
  else {
    $img_ebook = $_POST['pic_url'];
  }

  if($_FILES['pdf_url']['name'] != "" )
  {
	  if( $_FILES["pdf_url"]["type"] == "application/pdf" )
	  {
		  	$pdf_ebook = date('his').".pdf";
			move_uploaded_file(($_FILES["pdf_url"]["tmp_name"]), "../files/ebooks/pdf/".$pdf_ebook);
	  }
	  else
	  {
		  	  echo "<script type='text/javascript'>";
			  echo "alert('請選擇PDF檔案上傳')";
			  echo "</script>";
			  return;
	  }
  }
  else
  {
	  $pdf_ebook = $_POST['pdf_url_post'];
  }

  if( isset( $_POST['youtube_url'] ) )
  {
	  parse_str( parse_url( $_POST['youtube_url'], PHP_URL_QUERY ), $my_array_of_vars );
  }
  if( isset( $_POST['youtube_url_2'] ) )
  {
	  parse_str( parse_url( $_POST['youtube_url_2'], PHP_URL_QUERY ), $my_array_of_vars_2 );
  }
  if( isset( $_POST['youtube_url_3'] ) )
  {
	  parse_str( parse_url( $_POST['youtube_url_3'], PHP_URL_QUERY ), $my_array_of_vars_3 );
  }

  $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
				'youtube_url' => $_POST['youtube_url'],
				'youtube_id' => array_key_exists('v', $my_array_of_vars)? $my_array_of_vars['v'] : "",
				'youtube_url_2' => $_POST['youtube_url_2'],
				'youtube_id_2' => array_key_exists('v', $my_array_of_vars_2)? $my_array_of_vars_2['v'] : "",
				'youtube_url_3' => $_POST['youtube_url_3'],
				'youtube_id_3' => array_key_exists('v', $my_array_of_vars_3)? $my_array_of_vars_3['v'] : "",
				'pdf_url' => $pdf_ebook,
				'pic_url' => $img_ebook,
				);
  $whereClause = "ProdId={$_POST['ProdId']}";

  dbUpdate( $table_compmain, $record, $whereClause );



  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	   $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'img_name' => $img_string[$i]
				);
  dbInsert( $table_comp_img, $record );

  }




  $updateGoTo = "adminweb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }

  header("location:$updateGoTo");
}
?>
<?php  //-----------------------------取得網頁資訊------------------------------------//
$cloume_showpagesRec = "-1";
if (isset($_GET['ProdId'])) {
  $cloume_showpagesRec = $_GET['ProdId'];
}
$cloume_showpagesRec2 = "-1";
if (isset($_GET['ProdNum'])) {
  $cloume_showpagesRec2 = $_GET['ProdNum'];
}

if(($_GET['ProdId']) != ""){
	$table_compmain		= SYS_DBNAME . ".compmain";
	$whereClause = "compmain.ProdId='{$cloume_showpagesRec}'";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}",
			'mssql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}"
			);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof($row_showpagesRec);

}else{
	$table_compmain		= SYS_DBNAME . ".compmain";
	$whereClause = "compmain.ProdNum='{$cloume_showpagesRec2}'";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}",
			'mssql'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT * FROM {$table_compmain} WHERE {$whereClause}"
			);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof($row_showpagesRec);

}
?>
<?php  //---------------------------取得網頁類別(大類)---------------------------------//
$table_compclass		= SYS_DBNAME . ".compclass";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT DISTINCT LarCode FROM {$table_compclass} WHERE {$whereClause} ORDER BY LarSeq ASC",
		'mssql'	=> "SELECT DISTINCT LarCode FROM {$table_compclass} WHERE {$whereClause} ORDER BY LarSeq ASC",
		'oci8'	=> "SELECT DISTINCT LarCode FROM {$table_compclass} WHERE {$whereClause} ORDER BY LarSeq ASC"
		);
$row_itemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

?>
<?php  //---------------------------取得網頁類別(中類)---------------------------------//
$table_compclass		= SYS_DBNAME . ".compclass";
$whereClause = "compclass.LarCode='{$row_showpagesRec['LarCode']}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'mssql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'oci8'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
		);
$row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
?>
<?php  //---------------------------更新網頁類別(中類)---------------------------------//
if(isset($_POST['LarCode'])){
  $class = $_POST['LarCode'];
  $table_compclass		= SYS_DBNAME . ".compclass";
$whereClause = "LarCode='{$_POST['LarCode']}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'mssql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'oci8'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
		);
$row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

}
else{
  $class = $row_showpagesRec['LarCode'];
}
?>
<?php  //-----------------------------取得網頁圖片------------------------------------//
$cloume_showImgRec = "%";
if (isset($_GET['ProdId'])) {
  $cloume_showImgRec = $_GET['ProdId'];
}

$table_comp_img		= SYS_DBNAME . ".comp_img";
$whereClause = "ProdId='{$cloume_showImgRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC"
		);
$row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showimgRec = sizeof($row_showimgRec);

?>
<?php  //---------------------------刪除圖片---------------------------------//
if ((isset($_POST["delete_img"])) && ($_POST["delete_img"] == "刪除")) {
  //刪除圖片
  //echo $_POST['img_no'];
  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "img_no={$_POST['img_no']}";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC"
		  );
  $row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof($row_showimgRec);

  if(($row_showimgRec['img_name'] != "none.gif")){
  unlink("../images/webimg/medium/".$row_showimgRec["img_name"]);
  unlink("../images/webimg/small/".$row_showimgRec["img_name"]);
  }

  //刪除圖片資訊
  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "img_no={$_POST['img_no']}";
  dbDelete( $table_comp_img, $whereClause );

  //重新取得圖片資訊
  $cloume_showImgRec = "%";
  if (isset($_GET['ProdId'])) $cloume_showImgRec = $_GET['ProdId'];

   $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "ProdId={$cloume_showImgRec}";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause}",
		  'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause}",
		  'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause}"
		  );
  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof($row_showimgRec);

  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC",
		  'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC",
		  'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC"
		  );
  $row = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	if( sizeof( $row ) > 0 )
	{
		//刪除圖片資訊
		  $table_compmain		= SYS_DBNAME . ".compmain";
		  $record = array(
						'imgFull' => $row[0]['img_name']
						);
		  $whereClause = "ProdId='{$cloume_showImgRec}'";
		  dbUpdate( $table_compmain, $record, $whereClause );
	}
  	else
	{
		$table_compmain		= SYS_DBNAME . ".compmain";
		  $record = array(
						'imgFull' => "none.gif"
						);
		  $whereClause = "ProdId='{$cloume_showImgRec}'";
		  dbUpdate( $table_compmain, $record, $whereClause );
	}

}
?>
<?php  //---------------------------刪除圖片---------------------------------//
if ((isset($_POST["ebook_delete"])) && ($_POST["ebook_delete"] == "刪除")) {
  //刪除圖片
  //echo $_POST['img_no'];
  $cloume_showImgRec = "%";
  if (isset($_GET['ProdId'])) $cloume_showImgRec = $_GET['ProdId'];
  $pic = $_POST['pic_url'];

  unlink("../images/webimg/medium/".$pic );
  unlink("../images/webimg/small/".$pic );

  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC",
		  'mssql'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC",
		  'oci8'	=> "SELECT * FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no DESC"
		  );
  $row = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	if( sizeof( $row ) > 0 )
	{
		//刪除圖片資訊
		  $table_compmain		= SYS_DBNAME . ".compmain";
		  $record = array(
						'pic_url' => $row[0]['img_name']
						);
		  $whereClause = "ProdId='{$cloume_showImgRec}'";
		  dbUpdate( $table_compmain, $record, $whereClause );
	}
  	else
	{
		$table_compmain		= SYS_DBNAME . ".compmain";
		  $record = array(
						'pic_url' => "none.gif"
						);
		  $whereClause = "ProdId='{$cloume_showImgRec}'";
		  dbUpdate( $table_compmain, $record, $whereClause );
	}

}
?>
<h3 class=ttl01 >編輯網頁資訊</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<input type="hidden" name="ProdId" id="ProdId" value="<?php echo $row_showpagesRec['ProdId']; ?>"/>
  <!----------------------------網頁圖片---------------------------->
  <?php if($totalRows_showimgRec > 0) { ?>
  <tr>

  	<td align="left" valign="bottom">
    	<table border="0" >
        <tr>
        <?php foreach ($row_showimgRec as $key => $array){   ?>
        <form name="editpages" action="" method="POST" enctype="multipart/form-data" id="editpages">
            <td width=50>
<a href="../../images/webimg/medium/<?php echo $array['img_name']; ?>" target=_blank >
<img src="../../images/webimg/small/<?php echo $array['img_name']; ?>" alt="" name="image" width="120px"  id="image" align="center" style="padding:5px;"/></a><br />
                <input name="img_no" type="hidden" value="<?php echo $array['img_no']; ?>"/>
                <input name="delete_img" type="submit" value="刪除"/><br />
            </td>
        </form>
        <?php } ?>
        </tr>
        <!-------------------------------------------------------------->
        </table>
  	</td>
  </tr>
  <?php } ?>
  <!----------------------------圖片上傳---------------------------->
<form name="editpages" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editpages">
  <tr>

    <td  align="left" valign="bottom">
      <input name="img_num" type="hidden" value="<?php echo $totalRows_showimgRec;?>" />
      <input name="goods_img_first" type="hidden" value="<?php echo $row_showimgRec['img_name']; ?>" />
      <input type="file" name="goods_img[]" style="width:50%; height:90%; margin: 2px" multiple/>
    </td>
  </tr>

  <!-------------------------------------------------------------->
  <tr>

    <td align="left"><font color=#0000FF>1.所屬大類
      <select id="LarCode" name="LarCode" onChange="this.form.submit()" style="width:20%; height:90%; margin: 3px">
      <option value="0"></option>
        <?php
        foreach ($row_itemRec as $key => $array){
        ?>
          <option value="<?php echo $array['LarCode']?>" <?php if($array['LarCode'] == $class) {echo "selected=\"selected\"";} ?>>
		  <?php echo $array['LarCode']?></option>
        <?php
        }

        ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>

    <td align="left"><font color=#0000FF>2.所屬中類
      <select id="MidCode" name="MidCode" >
        <option value="0"></option>
        <?php
        foreach ($row_endItemRec as $key => $array){
        ?>
        <option value="<?php echo $array['MidCode']?>"<?php if (!(strcmp($row_showpagesRec['MidCode'], $array['MidCode']))) {echo "selected=\"selected\"";} ?>><?php echo $array['MidCode']?></option>
        <?php
        }
        ?>
      </select>
    </td>
  </tr>
  <!----------------------------連結網址---------------------------->
  <!--<tr>
    <td  align="center">連結網址</td>
    <td   align="left">
    <input name="paybackurl" type="text" style="width:58%; height:90%; margin: 3px" value="<?php //echo $row_showpagesRec['paybackurl']; ?>"/>
    </td>
  </tr>-->
  <!----------------------------文章簡述---------------------------->
  <tr>

   <td valign="top"><font color=#0000FF>3.文章簡述<br>
    <textarea id="ProdDisc" name="ProdDisc" cols="80" rows="5"><?php echo $row_showpagesRec['ProdDisc']; ?></textarea><br />
    <font color="#FF0000">[若前台不想出現文章簡述 內容，則輸入 0 值即可。]
    </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>

   <td align="left"><font color=#0000FF>4.詳細說明
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
    <textarea id="MemoSpec" name="MemoSpec" class="ckeditor" cols="80" rows="20" ><?php echo $row_showpagesRec['MemoSpec']; ?></textarea></td>
  </tr>

  <!----------------------------youtube_url1--------------------------
  <tr>
     <td>5.Youtube URL1:
       <input name="youtube_url" type="hidden" value="<?php //echo $row_showpagesRec['youtube_url'];?>" />
     </td>
  </tr>-->
  <!----------------------------youtube_url2--------------------------
  <tr>
     <td>6.Youtube URL2:
       <input name="youtube_url_2" type="hidden" value="<?php //echo $row_showpagesRec['youtube_url_2'];?>" />
     </td>
  </tr>-->
  <!----------------------------youtube_url3--------------------------
  <tr>
     <td>7.Youtube URL3:
       <input name="youtube_url_3" type="hidden" value="<?php //echo $row_showpagesRec['youtube_url_3'];?>" />
     </td>
  </tr>-->
	<!----------------------------youtube_url3--------------------------
  <tr>
     <td>8.PDF URL:
       <input name="pdf_url_post" type="hidden" value="<?php //echo $row_showpagesRec['pdf_url']; ?>" readonly/>
       <input name="pdf_url" type="hidden" value="" style="width:50%; height:100%; margin: 3px"/>

     </td>
  </tr>-->
  <!----------------------------上傳圖片1--------------------------
  <tr>
     <td>9.PHOTO URL:<img src="../../images/webimg/small/<?php //echo $row_showpagesRec['pic_url']; ?>" alt="" name="image"
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="pic_url" type="hidden" value="<?php //echo $row_showpagesRec['pic_url']; ?>" />
       <input name="ebook_delete" type="submit" value="刪除"/>
       <input name="ebook_img" type="file" value="Select a File..." style="width:50%; margin: 3px"/>
     </td>
  </tr>
-->
  <!------------------------新增按鈕---------------------------->
  <tr>

      <input name="ProdId" type="hidden" value="<?php echo $row_showpagesRec['ProdId']; ?>" />
    <td   align="left">
      <input type="submit" name="update_pages"  value="更新" style="font-size:16px;width:50px;height:25px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:50px;height:25px"/>
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
/*mysql_free_result($showpagesRec);
mysql_free_result($itemRec);
mysql_free_result($endItemRec);
mysql_free_result($showimgRec);*/
?>
<!---------------------網頁程式碼結束--------------------------------->
</div>
</div>
</div>
</div>
</body>

>>>>