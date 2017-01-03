<?php include("small.php"); ?>
<?php  //-----------------------------更新網頁資訊------------------------------------//
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
       echo"$error_codes[$error]";
	   $num =  date('his') + $key;
	   $img_string[$key] = $num.".jpg";

       move_uploaded_file(
         realpath($_FILES["goods_img"]["tmp_name"][$key]),
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
  /*
  $updateSQL = sprintf("UPDATE compmain SET LarCode=%s, MidCode=%s, ProdName=%s, paybackurl=%s,
                        ProdDisc=%s, MemoSpec=%s, ImgFull='none.gif' where ProdId=%s",
					    GetSQLValueString($_POST['LarCode'], "text"),
					    GetSQLValueString($_POST['MidCode'], "text"),
                                            GetSQLValueString($_POST['MidCode'], "text"),
					    GetSQLValueString($_POST['paybackurl'], "text"),
					    GetSQLValueString($_POST['ProdDisc'], "text"),
                                            GetSQLValueString($_POST['MemoSpec'], "text"),
					    GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */

  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'img_name' => 'none.gif'
				);
  dbInsert( $table_comp_img, $record );
  /*
  $insertSQL = sprintf("INSERT INTO comp_img (ProdId, img_name) VALUES (%s, 'none.gif')",
                          GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result3 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
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
/*
  $updateSQL = sprintf("UPDATE compmain SET LarCode=%s, MidCode=%s, ProdName=%s, paybackurl=%s,
                        ProdDisc=%s, MemoSpec=%s where ProdId=%s",
					    GetSQLValueString($_POST['LarCode'], "text"),
					    GetSQLValueString($_POST['MidCode'], "text"),
                                            GetSQLValueString($_POST['MidCode'], "text"),
					    GetSQLValueString($_POST['paybackurl'], "text"),
					    GetSQLValueString($_POST['ProdDisc'], "text"),
                                            GetSQLValueString($_POST['MemoSpec'], "text"),
					    GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
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
  /*
  $updateSQL = sprintf("UPDATE compmain SET LarCode=%s, MidCode=%s, paybackurl=%s,
                        ProdDisc=%s, MemoSpec=%s, ImgFull=%s where ProdId=%s",
					    GetSQLValueString($_POST['LarCode'], "text"),
					    GetSQLValueString($_POST['MidCode'], "text"),
					    GetSQLValueString($_POST['paybackurl'], "text"),
					    GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
						GetSQLValueString($img_string[0], "text"),
					    GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  }



  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	   $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'img_name' => $img_string[$i]
				);
  dbInsert( $table_comp_img, $record );
  /*
      $insertSQL = sprintf("INSERT INTO comp_img (ProdId, img_name) VALUES (%s, %s)",
                            GetSQLValueString($_POST['ProdId'], "text"),
		        			GetSQLValueString($img_string[$i], "text"));

      mysql_select_db($database_webshop, $webshop);
      $Result3 = mysql_query($insertSQL, $webshop) or die(mysql_error());*/
  }




  $updateGoTo = "adminweb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
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
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_showpagesRec = sprintf("SELECT * FROM compmain
	WHERE compmain.ProdId=%s", GetSQLValueString($cloume_showpagesRec, "text"));
	$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
	$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
	$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
	*/
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
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_showpagesRec = sprintf("SELECT * FROM compmain
	WHERE compmain.ProdNum=%s", GetSQLValueString($cloume_showpagesRec2, "text"));
	$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
	$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
	$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
	*/
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
/*
mysql_select_db($database_webshop, $webshop);
$query_itemRec = "SELECT DISTINCT LarCode FROM compclass ORDER BY LarSeq ASC";
$itemRec = mysql_query($query_itemRec, $webshop) or die(mysql_error());
$row_itemRec = mysql_fetch_assoc($itemRec);
$totalRows_itemRec = mysql_num_rows($itemRec);
*/
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
/*
mysql_select_db($database_webshop, $webshop);
$query_endItemRec = sprintf("SELECT * FROM compclass WHERE compclass.LarCode=%s ORDER BY MidSeq ASC",GetSQLValueString($row_showpagesRec['LarCode'], "text"));
$endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
$row_endItemRec = mysql_fetch_assoc($endItemRec);
$totalRows_endItemRec = mysql_num_rows($endItemRec);
*/
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
/*
  mysql_select_db($database_webshop, $webshop);
  $query_endItemRec = sprintf("SELECT * FROM compclass where LarCode = %s ORDER BY MidSeq ASC",
                               GetSQLValueString($_POST['LarCode'], "text"));
  $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
  $row_endItemRec = mysql_fetch_assoc($endItemRec);
  $totalRows_endItemRec = mysql_num_rows($endItemRec);
  */
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
/*
mysql_select_db($database_webshop, $webshop);
$query_showimgRec = sprintf("SELECT * FROM comp_img WHERE ProdId=%s order by img_no ASC", GetSQLValueString($cloume_showImgRec, "text"));
$showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
$row_showimgRec = mysql_fetch_assoc($showimgRec);
$totalRows_showimgRec = mysql_num_rows($showimgRec);
*/
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
/*
  mysql_select_db($database_webshop, $webshop);
  $query_showimgRec = sprintf("SELECT * FROM comp_img WHERE img_no=%s", GetSQLValueString($_POST['img_no'], "int"));
  $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
  $row_showimgRec = mysql_fetch_assoc($showimgRec);
  */
  if(($row_showimgRec['img_name'] != "none.gif")){
  unlink("../images/webimg/medium/".$row_showimgRec["img_name"]);
  unlink("../images/webimg/small/".$row_showimgRec["img_name"]);
  }

  //刪除圖片資訊
  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "img_no={$_POST['img_no']})";
  dbDelete( $table_comp_img, $whereClause );
	/*
  mysql_select_db($database_webshop, $webshop);
  $deleteSQL = sprintf("DELETE FROM comp_img WHERE img_no=%s", GetSQLValueString($_POST['img_no'], "int"));
  $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
  */
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

/*
  mysql_select_db($database_webshop, $webshop);
  $query_showimgRec = sprintf("SELECT * FROM comp_img WHERE ProdId=%s", GetSQLValueString($cloume_showImgRec, "text"));
  $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
  $row_showimgRec = mysql_fetch_assoc($showimgRec);
  $totalRows_showimgRec = mysql_num_rows($showimgRec);
  */
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
<img src="../../images/webimg/medium/<?php echo $array['img_name']; ?>" alt="" name="image" width="120px" height="100px" id="image" align="center" style="padding:5px;"/></a><br />
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
      <select id="LarCode" name="LarCode" onchange="this.form.submit()" style="width:20%; height:90%; margin: 3px">
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
        <option value="<?php echo $array['MidCode']?>"<?php if (!(strcmp($array['MidCode'], $array['MidCode']))) {echo "selected=\"selected\"";} ?>><?php echo $array['MidCode']?></option>
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
    <input name="paybackurl" type="text" style="width:58%; height:90%; margin: 3px" value="<?php echo $row_showpagesRec['paybackurl']; ?>"/>
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
