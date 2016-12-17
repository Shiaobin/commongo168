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
<script>
function click_submit()
{
	var x = document.getElementById("editpages1");
    var txt = "";
    var i;
    for (i = 0; i < x.length; i++) {
        txt = txt + x.elements[i].value + "<br>";
    }
    alert(txt);
	//document.getElementById("editpages").submit();
}	
</script>
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
<?php  //-----------------------------更新商品資訊------------------------------------//
//$sysConnDebug = true;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if( isset($_POST ) )
{
	echo "";
	//print_r($_POST);
}
else
{
	echo "";	
}
if ((isset($_POST["update_pages"])) && ($_POST["update_pages"] == "更新")) {	
  //move_uploaded_file($_FILES["pages_img"]["tmp_name"], "..\webimg\pagesimg\\".$_FILES["pages_img"]["name"].".jpg");
  $img_string = array();
  //print_r($_POST['post_spec1_text']);
  //上傳圖片
  foreach ($_FILES["goods_img"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {	 
       //echo"$error_codes[$error]";
	   $num =  date('his') + $key;
	   $type = explode("/",$_FILES["goods_img"]["type"][$key]);
	   $img_string[$key] = $num.".".$type[1];

       move_uploaded_file(
         $_FILES["goods_img"]["tmp_name"][$key], 
         //"/var/www/html/sample/images/webimg/".$img_string[$key]
         "../images/goodsimg/".$img_string[$key]
       ) or die("Problems with upload");

       resize_goods_image($img_string[$key]);
    }
  }
 /////////////////////////////ebooks////////////////////
  //上傳圖片
  ////////////////////////////////////////1//////////////////////////
  if($_FILES['ebook_imgfull1']['name'] != "" ) 
  {
    $img_ebook_1 = $_GET['ProdId']."_imgfull1.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull1"]["tmp_name"]), "../images/goodsimg/".$img_ebook_1);
        resize_goods_image($img_ebook_1);
  }
  else 
  {
    $img_ebook_1 = $_POST['imgfull1'];
  }
  ////////////////////////////////////////2//////////////////////////
  if($_FILES['ebook_imgfull2']['name'] != "" ) 
  {
    $img_ebook_2 = $_GET['ProdId']."_imgfull2.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull2"]["tmp_name"]), "../images/goodsimg/".$img_ebook_2);
        resize_goods_image($img_ebook_2);
  }
  else 
  {
    $img_ebook_2 = $_POST['imgfull2'];
  }
  ////////////////////////////////////////3//////////////////////////
  if($_FILES['ebook_imgfull3']['name'] != "" ) 
  {
    $img_ebook_3 = $_GET['ProdId']."_imgfull3.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull3"]["tmp_name"]), "../images/goodsimg/".$img_ebook_3);
        resize_goods_image($img_ebook_3);
  }
  else 
  {
    $img_ebook_3 = $_POST['imgfull3'];
  }
  ////////////////////////////////////////4//////////////////////////
  if($_FILES['ebook_imgfull4']['name'] != "" ) 
  {
    $img_ebook_4 = $_GET['ProdId']."_imgfull4.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull4"]["tmp_name"]), "../images/goodsimg/".$img_ebook_4);
        resize_goods_image($img_ebook_4);
  }
  else 
  {
    $img_ebook_4 = $_POST['imgfull4'];
  }
  ////////////////////////////////////////5//////////////////////////
  if($_FILES['ebook_imgfull5']['name'] != "" ) 
  {
    $img_ebook_5 = $_GET['ProdId']."_imgfull5.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull5"]["tmp_name"]), "../images/goodsimg/".$img_ebook_5);
        resize_goods_image($img_ebook_5);
  }
  else 
  {
    $img_ebook_5 = $_POST['imgfull5'];
  }
  ////////////////////////////////////////6//////////////////////////
  if($_FILES['ebook_imgfull6']['name'] != "" ) 
  {
    $img_ebook_6 = $_GET['ProdId']."_imgfull2.jpg";
	move_uploaded_file(($_FILES["ebook_imgfull6"]["tmp_name"]), "../images/goodsimg/".$img_ebook_6);
        resize_goods_image($img_ebook_6);
  }
  else 
  {
    $img_ebook_6 = $_POST['imgfull6'];
  }
  
    
  //取得首張圖片資訊
  if($_POST["img_num"] > 0) {
	$cloume_showImgRec = "%";
	if (isset($_GET['ProdId'])) {
      $cloume_showImgRec = $_GET['ProdId'];
    }
	$column = "*";
	$table_prod_img		= SYS_DBNAME . ".prod_img";
	$whereClause = "ProdId='{$cloume_showImgRec}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
	);
	$row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

	$img = $row_showimgRec["img_name"];
  }
  else if(count($img_string) > 0)  $img = $img_string[0];
  else                             $img = "";    
  
  
  
  //預設圖片
  if($img == ""){
	  $table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  
		  'PriceList' => $_POST['PriceList'],
		 
		  'ProdDisc' => $_POST['ProdDisc'],
		 
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia'],
		  'new' => $_POST['new'],
		  'ImgFull' => $img_ebook_1,
		  'Model' => $_POST['Model'],
		  'Quantity' => $_POST['Quantity'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'imgfull1' => $img_ebook_1,
				'imgfull2' => $img_ebook_2,
				'imgfull3' => $img_ebook_3,
				'imgfull4' => $img_ebook_4,
				'imgfull5' => $img_ebook_5
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );

  //商品選項
  /*$post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  //echo "rows_count>0 ";
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  //echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
	
	  }
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );

	  }
  }*/
  
  $table_prod_img = SYS_DBNAME . ".prod_img";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'img_name' => 'none.gif'
	  );
		  
	  $is_update = dbInsert( $table_prod_img, $record );

  //未上傳新圖片
  }else if(isset($img)){  
  
  $table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  
		  'PriceList' => $_POST['PriceList'],
		 
		  'ProdDisc' => $_POST['ProdDisc'],
		 'Imgfull' => $img_ebook_1,
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia'],
		  'new' => $_POST['new'],
		  'Model' => $_POST['Model'],
		  'Quantity' => $_POST['Quantity'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'imgfull1' => $img_ebook_1,
				'imgfull2' => $img_ebook_2,
				'imgfull3' => $img_ebook_3,
				'imgfull4' => $img_ebook_4,
				'imgfull5' => $img_ebook_5
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );

  //商品選項
  /*$post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  //echo "rows_count>0 ";
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  //echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );

	  }
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );

	  }
  }*/
  //有上傳新圖片 
  }else{   
  //更新商品資訊
  //echo"33333333333";
  	$table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  
		  'PriceList' => $_POST['PriceList'],
		 
		  'ProdDisc' => $_POST['ProdDisc'],
		  'Imgfull' => $img_ebook_1,
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia'],
		  'new' => $_POST['new'],
		  'ImgFull' => $img_string[0],
		  'Model' => $_POST['Model'],
		  'Quantity' => $_POST['Quantity'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'imgfull1' => $img_ebook_1,
				'imgfull2' => $img_ebook_2,
				'imgfull3' => $img_ebook_3,
				'imgfull4' => $img_ebook_4,
				'imgfull5' => $img_ebook_5
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );

  //商品選項
  /*$post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  echo "rows_count>0 ";
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );

	  }
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );

	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodspec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );

	  }
  }*/
  }


  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	  $table_prod_img = SYS_DBNAME . ".prod_img";
	  $index_ProSerial_2 = $i + 1;
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'img_name' => $img_string[$i]
	  );
		  
	  $is_update = dbInsert( $table_prod_img, $record );

  }
  
  //商品選項

  @$post_spec1_text = $_POST['pro_spec1_text'];
  @$post_spec1_num = $_POST['num_spec1_text'];
  @$post_spec1_price = $_POST['price_spec1_text'];  
  @$post_upd = $_POST['upd'];
  /*echo "count:".sizeof($post_spec1_text);
  echo "count:".sizeof($post_upd);
  print_r($post_spec1_text);
  print_r($post_upd);*/
  //$post_spec2_text = $_POST['post_spec2_text'];
  $session=NULL;
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodspec";
	  if(!empty($post_upd[$i]))
	  {
		  $index_ProSerial_1 = $post_upd[$i];
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'number' => $post_spec1_num[$i],
			  'price' => $post_spec1_price[$i],			  
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
		  $session=$post_upd[$i];
	  }
	  else
	  {
		  if($session==NULL) $session=1;
		  else $session+=1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $session,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'number' => $post_spec1_num[$i],
			  'price' => $post_spec1_price[$i],	
			  'created_date' => NOW(),
			  'updated_date' => NOW(),
			  'opertor' => "admin"
		  );
			  
		  $is_insert = dbInsert( $table_prodSpec, $record );
		  
	  }
  }
  
  
  $updateGoTo = "admineditgoods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showpagesRec = "-1";
if (isset($_GET['ProdId'])) {
  $cloume_showpagesRec = $_GET['ProdId'];
}
$cloume_showpagesRec2 = "-1";
if (isset($_GET['ProdNum'])) {
  $cloume_showpagesRec2 = $_GET['ProdNum'];
}

if(($_GET['ProdId']) != ""){
	$column = "*";
	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = "ProdId='{$_GET['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}"
	);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof( $row_showpagesRec );

	
	$column = "*";
	$table_prodSpec		= SYS_DBNAME . ".prodspec";
	$whereClause = "ProdId='{$_GET['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2",
			'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2"
	);
	$query_spec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

}else{
	$column = "*";
	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = "ProdNum='{$_POST['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}"
	);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof($row_showpagesRec);

}
?>
<?php  //---------------------------取得商品類別(大類)---------------------------------//
	$column = "DISTINCT LarCode";
	$table_prodclass		= SYS_DBNAME . ".prodclass";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC"
	);
	$row_itemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_itemRec = sizeof($row_itemRec);

?>
<?php  //---------------------------取得商品類別(中類)---------------------------------//
	$column = "*";
	$table_prodclass		= SYS_DBNAME . ".prodclass";
	$whereClause = "LarCode='{$row_showpagesRec['LarCode']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
	);
	$row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_endItemRec = sizeof($row_endItemRec);

?>
<?php  //---------------------------更新商品類別(中類)---------------------------------//
if(isset($_POST['LarCode'])){
  $class = $_POST['LarCode'];
  $column = "*";
  $table_prodclass		= SYS_DBNAME . ".prodclass";
  $whereClause = "LarCode='{$_POST['LarCode']}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
  );
  $row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_endItemRec = sizeof($row_endItemRec);

}
else{
  $class = $row_showpagesRec['LarCode'];
}
?>
<?php  //-----------------------------取得商品圖片------------------------------------//
$cloume_showImgRec = "%";
if (isset($_GET['ProdId'])) {
  $cloume_showImgRec = $_GET['ProdId'];
}
  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
  );
  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof($row_showimgRec);

?>
<?php  //---------------------------刪除圖片---------------------------------//
if ((isset($_POST["delete_img"])) && ($_POST["delete_img"] == "刪除")) {
  //刪除圖片
  //echo $_POST['img_no'];
  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "img_no='{$_POST['img_no']}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}"
  );
  $row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

  if(($row_showimgRec['img_name'] != "none.gif")){
  unlink("../images/goodsimg/medium/".$row_showimgRec["img_name"]);
  unlink("../images/goodsimg/small/".$row_showimgRec["img_name"]);
  }
  
	
  //刪除圖片資訊
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "img_no='{$_POST['img_no']}'";
  dbDelete( $table_prod_img, $whereClause );

  //重新取得圖片資訊
  $cloume_showImgRec = "%";
  if (isset($_GET['ProdId'])) $cloume_showImgRec = $_GET['ProdId'];

  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
  );
  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof( $row_showimgRec );
  
}
?>
<h3 class=ttl01 >修改上架商品資訊</h3>
<script>
  function del_spec_1(num,id,me)
  {

	var index=$("input[name='del']").index(me);
	$.ajax
 	({
  		url:"ajax.php", //接收頁
  		type:"POST", //POST傳輸
  		data:{status:'spec_1',prod:id,num:num}, // key/value
  		dataType:"text", //回傳形態
  		success:function(i) //成功就....
  		{
   			//alert(i);
   			//$("#dis1"+num).remove();
			//$("#del1"+num).remove();
			$("#table_pro_spec_1 tr:eq("+index+")").remove();
			//document.getElementById('dis1'+num).style.visibility="hidden";
			//document.getElementById('del1'+num).style.visibility="hidden";
			document.getElementById('SpecName1'+num).value="";

  		},
  		error:function()//失敗就...
  		{
  			alert("刪除失敗"); 
 		}
		
 	});
	  
  }
</script>
<table id="table_goods" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

<input type="hidden" name="ProdId" id="ProdId" value="<?php echo $row_showpagesRec['ProdId']; ?>"/>
  <!----------------------------商品圖片---------------------------->
  <?php if($totalRows_showimgRec > 0) { ?>
  <tr>
  	<td>1.商品圖片:
    	<table border="0" height="100%">
        <tr>
        <?php foreach ($row_showimgRec as $key => $array){ ?>
        <form name="editpages" action="" method="POST" enctype="multipart/form-data" id="editpages">
            <td align="center">
 <a href="../../images/goodsimg/medium/<?php echo $array['img_name']; ?>" target=_blank >
<img src="../../images/goodsimg/small/<?php echo $array['img_name']; ?>" alt="" name="image" id="image" align="center" style="padding:5px;"/></a><br />
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
</table>
  <!----------------------------圖片上傳---------------------------->
<form name="editpages1" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editpages1">
<table id="table_goods" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <tr>
    <td>2.上傳圖片:
      <input name="img_num" type="hidden" value="<?php echo $totalRows_showimgRec;?>" /> 
      <input name="goods_img_first" type="hidden" value="<?php echo $row_showimgRec['img_name']; ?>" /> 
      <input type="file" name="goods_img[]" style="width:50%; height:90%; margin: 2px" multiple/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td>3.所屬大類:
      <select id="LarCode" name="LarCode" onChange="this.form.submit()" style="width:20%; height:90%; margin: 3px">
      <option value="0"></option>
        <?php
        foreach ($row_itemRec as $key => $array){  
        ?>
          <option value="<?php echo $array['LarCode']?>" <?php if($array['LarCode'] == $class) {echo "selected=\"selected\"";} ?>>
		  <?php echo $array['LarCode']?></option>
        <?php
        }
        $rows = sizeof($row_itemRec);
        if($rows > 0) {
          //mysql_data_seek($itemRec, 0);
	      //$row_itemRec = mysql_fetch_assoc($itemRec);
        }
        ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>
    <td>4.所屬中類:
      <select id="MidCode" name="MidCode" style="width:30%; height:90%; margin: 3px"> 
        <option value="0"></option>
        <?php
        foreach ($row_endItemRec as $key => $array){  
        ?>
        <option value="<?php echo $array['MidCode']; ?>"<?php if (!(strcmp($array['MidCode'], $row_showpagesRec['MidCode']))) {echo "selected=\"selected\"";} ?>><?php echo $array['MidCode']; ?></option>
        <?php
        }
        //$rows = mysql_num_rows($row_endItemRec);
        //if($rows > 0) {
          //mysql_data_seek($endItemRec, 0);
	      //$row_endItemRec = mysql_fetch_assoc($endItemRec);
        //}
        ?>
      </select>
    </td>
  </tr>
  <!----------------------------商品編號---------------------------->
  <tr>
    <td>5.商品編號:<?php echo $row_showpagesRec['ProdId']; ?>
      <input id="ProdId" name="ProdId" type="hidden" value="<?php echo $row_showpagesRec['ProdId']; ?>"/>
    </td>
  </tr>
  <!----------------------------商品名稱---------------------------->
  <tr>
    <td>6.商品名稱:
      <input id="ProdName" name="ProdName" type="text" class=sizeM value="<?php echo $row_showpagesRec['ProdName']; ?>"/></td>
  </tr>
  <!----------------------------商品型號---------------------------->
  <tr>
    <td>7.商品型號:
      <input id="Model" name="Model" type="text" class=sizeSs value="<?php echo $row_showpagesRec['Model']; ?>"/>
    </td>
  </tr>
  <!----------------------------市場價---------------------------->
  <tr>
    <td>8.市場價:
      <input id="PriceOrigin" name="PriceOrigin" type="text" class=sizeSss value="<?php echo $row_showpagesRec['PriceOrigin']; ?>"/>元 [如'0' 則不顯示]</td>
  </tr>
  <!----------------------------熱賣價---------------------------->
  <tr>
    <td>9.熱賣價:
      <input id="PriceList" name="PriceList" type="text" class=sizeSss value="<?php echo $row_showpagesRec['PriceList']; ?>"/>元 [如'0' 則顯示：請咨詢客服]</td>
  </tr>
  <!----------------------------庫存數--------------------------->
  <tr>
    <td>10.庫存數:
      <input id="Quantity" name="Quantity" type="text" class=sizeSss value="<?php echo $row_showpagesRec['Quantity']; ?>"/>個 [如'0' 則顯示：已售完]</td>
  </tr>
  <!----------------------------商品簡介---------------------------->
  <tr>
    <td>11.商品簡介:<br>
       <textarea id="ProdDisc" name="ProdDisc" cols="50" rows="5" ><?php echo $row_showpagesRec['ProdDisc']; ?></textarea>
     </td>
  </tr>
  
  <!----------------------------商品說明---------------------------->
  <tr>
   <td>12.商品說明:<br>
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>    
    <textarea id="MemoSpec" name="MemoSpec" class="ckeditor" cols="50" rows="20" ><?php echo $row_showpagesRec['MemoSpec']; ?></textarea></td>
  </tr>  
  <!----------------------------支付返回---------------------------->
  <tr>
    <td>13.支付返回:
      <input id="paybackurl" name="paybackurl" type="text" style="width:50%; height:90%; margin: 2px" value="<?php echo $row_showpagesRec['paybackurl']; ?>"/>[在線支付後的返回頁面]</td>
  </tr>
  <!----------------------------設為推薦商品---------------------------->
  <tr>
    <td>14.設為推薦商品:
      <label>
        <input type="radio" name="Remark" value="0" id="Remark_0" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="Remark" value="1" id="Remark_1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '1'): ?>checked='checked'<?php endif; ?>/>
        是</label>
    </td>
  </tr>
  <!----------------------------設為熱賣商品---------------------------->
  <tr>
    <td>15.設為熱賣商品
      <label>
        <input type="radio" name="tejia" value="0" id="tejia _0" style="margin-left: 3px"
		<?php if ($row_showpagesRec['tejia'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="tejia" value="1" id="tejia _1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['tejia'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <tr>
     <td>5.PHOTO URL1:<img src="../../images/goodsimg/small/<?php echo $row_showpagesRec['imgfull1']; ?>" alt="" name="image" 
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull1" type="text" value="<?php echo $row_showpagesRec['imgfull1']; ?>" />
       <input name="ebook_imgfull1" type="file" value="Select a File..." style="width:300px; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>6.PHOTO URL2:<img src="../../images/goodsimg/small/<?php echo $row_showpagesRec['imgfull2']; ?>" alt="" name="image" 
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull2" type="text" value="<?php echo $row_showpagesRec['imgfull2']; ?>" />
       <input name="ebook_imgfull2" type="file" value="Select a File..." style="width:300px; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>7.PHOTO URL3:<img src="../../images/goodsimg/small/<?php echo $row_showpagesRec['imgfull3']; ?>" alt="" name="image" 
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull3" type="text" value="<?php echo $row_showpagesRec['imgfull3']; ?>" />
       <input name="ebook_imgfull3" type="file" value="Select a File..." style="width:300px; height:100%; margin: 3px"/> </p> 
     </td>
  </tr>
	<!----------------------------上傳圖片---------------------------->
  <tr>
     <td>8.PHOTO URL4:<img src="../../images/goodsimg/small/<?php echo $row_showpagesRec['imgfull4']; ?>" alt="" name="image" 
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull4" type="text" value="<?php echo $row_showpagesRec['imgfull4']; ?>" />
       <input name="ebook_imgfull4" type="file" value="Select a File..." style="width:300px; height:100%; margin: 3px"/> </p>
       
     </td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>9.PHOTO URL5:<img src="../../images/goodsimg/small/<?php echo $row_showpagesRec['imgfull5']; ?>" alt="" name="image" 
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull5" type="text" value="<?php echo $row_showpagesRec['imgfull5']; ?>" />
       <input name="ebook_imgfull5" type="file" value="Select a File..." style="width:300px; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------設為最新商品---------------------------->
   <tr>
    <td>14.設為推薦商品:
      <label>
        <input type="radio" name="Remark" value="0" id="Remark_0" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="Remark" value="1" id="Remark_1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '1'): ?>checked='checked'<?php endif; ?>/>
        是</label>
    </td>
  </tr>
  <!----------------------------設為特價商品---------------------------->
  <tr>
    <td>15.設為特價商品
      <label>
        <input type="radio" name="tejia" value="0" id="tejia _0" style="margin-left: 3px"
		<?php if ($row_showpagesRec['tejia'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="tejia" value="1" id="tejia _1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['tejia'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <tr>
    <td>16.設為最新商品
      <label>
        <input type="radio" name="new" value="0" id="new _0" style="margin-left: 3px"
		<?php if ($row_showpagesRec['new'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="new" value="1" id="new _1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['new'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <!----------------------------設定類型1---------------------------->
  <tr>
    <td>17.設定類型 <input type="button" name="pro_spec1_plus[]" id="btn" value="+" style="width: 20px;"/>
    <?php $arr_pro_spec_1 = array(); $arr_pro_spec_2 = array(); $arr_ProSerial_2 = array();?>
    <table id="table_pro_spec_1" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable"  name="table_pro_spec_1">
    <?php foreach ($query_spec as $key => $row_showgoodsRec){  
		if( $row_showgoodsRec['ProSerial_1'] == 0 ) {array_push( $arr_pro_spec_2, $row_showgoodsRec['SpecName'] );array_push( $arr_ProSerial_2, $row_showgoodsRec['ProSerial_2'] ); continue;} else array_push( $arr_pro_spec_1, $row_showgoodsRec['SpecName'] )?>
    	<tr>
        	<td>
            <label id="dis1<?php echo $row_showgoodsRec['ProSerial_1'];?>">
              <input type="text" name="pro_spec1_text[]" id="SpecName1<?php echo $row_showgoodsRec['ProSerial_1'];?>"  style="margin-left: 3px;width: 350px;" value="<?php echo $row_showgoodsRec['SpecName'];?>" placeholder="文字說明" />
              <input type="hidden" name="upd[]" value="<?php echo $row_showgoodsRec['ProSerial_1'];?>">
            </label>
            <label>
              <input type="text" name="num_spec1_text[]" class="sizeSss" placeholder="數量" value="<?php echo $row_showgoodsRec['number'];?>" />
            </label>
            <label>
              <input type="text" name="price_spec1_text[]" class="sizeSss" placeholder="單價" value="<?php echo $row_showgoodsRec['price'];?>" />
            </label>
            <label id="dellabel<?php echo $row_showgoodsRec['ProSerial_1'];?>">
              <input type="button" name="del" id="del1<?php echo $row_showgoodsRec['ProSerial_1'];?>" value="x" onClick="del_spec_1(<?php echo $row_showgoodsRec['ProSerial_1'];?>,<?php echo $_GET['ProdId'];?>,this);" style="width: 20px;"/>
            </label>               
            </td>
         </tr>
	<?php } ?>
    <?php if( sizeof( $arr_pro_spec_1 ) == 0 ){ ?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec1_text[]" style="margin-left: 3px;width:350px;" placeholder="文字說明"/>
              <input type="hidden" name="upd[]" value="">
            </label>
            <label>
              <input type="text" name="num_spec1_text[]" class="sizeSss" placeholder="數量" />
            </label>
            <label>
              <input type="text" name="price_spec1_text[]" class="sizeSss" placeholder="單價" />
            </label>         
            </td>
         </tr>
      <?php } ?>
    </table>
    </td>
  </tr>
  <!----------------------------設定類型2---------------------------->
  <!--tr>
    <td>16.設定類型2
      <table id="table_pro_spec_2" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" name="table_pro_spec_2">
      <?php while ( list ($key, $val) = each ($arr_pro_spec_2)  ){ ?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec2_text[]" style="margin-left: 3px"  value="<?php echo $val;?>"/>
            </label>
            <label>
              <input type="button" name="pro_spec2_plus[]" value="+" onClick="addTableField(this)" style="width: 20px; visibility:hidden"/>
            </label>
            </td>
         </tr>
      <?php } ?>
      <?php if( sizeof( $arr_pro_spec_2 ) == 0 ){ ?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec2_text[]" style="margin-left: 3px"  value="<?php echo $val;?>"/>
            </label>
            <label>
              <input type="button" name="pro_spec2_plus[]" value="+" onClick="addTableField(this)" style="width: 20px;"/>
            </label>
            </td>
         </tr>
      <?php } ?>
      </table>
    </td>
  </tr-->
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="ProdId" type="hidden" value="<?php echo $row_showpagesRec['ProdId']; ?>" />
      <input type="submit" name="update_pages" value="更新" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  
  <!----------------------------------------------------------->
</table>
</form>

<script>
		$('#btn').click(function()
		{
			// 取得按鈕事件，取得div的id並在元素最後面插入input輸入框，計算總量3個一組往下新增pro_spec1_text[]
			$('#table_pro_spec_1').append('<tr><td><label><input type="text" name="pro_spec1_text[]" placeholder="文字說明" style="margin-left: 3px;width: 350px;"/>' + '<input type="hidden" name="upd[]" value=""></label>' + '<label><input type="text" name="num_spec1_text[]" class="sizeSss" placeholder="數量" style="margin-left: 3px;"/></label>' + '<label><input type="text" name="price_spec1_text[]" class="sizeSss" placeholder="單價" style="margin-left: 3px"/></label></td></tr>');

		});
</script>
<?php
//mysql_free_result($showpagesRec);
//mysql_free_result($itemRec);
//mysql_free_result($endItemRec);
//mysql_free_result($showimgRec);
?>


<!---------------------網頁程式碼結束--------------------------------->
</div>
</div>
</div>
</div>
</body>

