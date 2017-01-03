<?php include("small.php"); ?>
<?php  //-----------------------------新增網頁資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['ProdDisc'] != "") && ($_POST['LarCode'] != "") && ($_POST['MidCode'] != "")) {

  $img_string = array();

  /*if($_POST["ImgPrev[]"] == ""){
    $num1 = $key + $num + $key*2 + date('his');
  }else{*/
	//上傳圖片
  foreach ($_FILES["ImgPrev"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
      echo"$error_codes[$error]";
	  $num =  date('his') + $key;
	  $num1 = $key + $num + $key*2 + date('his');
	  $type = explode("/",$_FILES["ImgPrev"]["type"][$key]);
	  $img_string[$key] = $num.".".$type[1];

      move_uploaded_file(
        $_FILES["ImgPrev"]["tmp_name"][$key],
         "../images/webimg/".$img_string[$key]
         //"/var/www/html/sample/images/webimg/".$img_string[$key]
      ) or die("Problems with upload");

      resize_web_image($img_string[$key]);
    }
  }
  if($num1 == ""){
	  $num1 = $key + $img + $key*2 + date('his');

	  $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
  				'LarCode' => $_POST['LarCode'],
				'MidCode' => $_POST['MidCode'],
				'ProdName' => $_POST['MidCode'],
				'ProdDisc' => $_POST['ProdDisc'],
				'MemoSpec' => $_POST['MemoSpec'],
				'ProdId' => $num1,
				'ImgFull' => 'none.gif'
				);
  dbInsert( $table_compmain, $record );
  /*
	  $insertSQL = sprintf("INSERT INTO compmain (LarCode, MidCode, ProdName, ProdDisc, MemoSpec, ProdId, ImgFull) VALUES (%s, %s, %s, %s, %s, %s, 'none.gif')",
                       GetSQLValueString($_POST['LarCode'], "text"),
                       GetSQLValueString($_POST['MidCode'], "text"),
                       GetSQLValueString($_POST['MidCode'], "text"),
					   GetSQLValueString($_POST['ProdDisc'], "text"),
					   GetSQLValueString($_POST['MemoSpec'], "text"),
					   GetSQLValueString($num1, "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $num1,
				'img_name' => 'none.gif'
				);
  dbInsert( $table_comp_img, $record );
  /*
  	  $insertSQL = sprintf("INSERT INTO comp_img (ProdId, img_name) VALUES (%s, 'none.gif')",
                          GetSQLValueString($num1, "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());
	*/
  }else{
	  $table_compmain		= SYS_DBNAME . ".compmain";
  $record = array(
  				'LarCode' => $_POST['LarCode'],
				'MidCode' => $_POST['MidCode'],
				'ProdName' => $_POST['MidCode'],
				'ProdDisc' => $_POST['ProdDisc'],
				'MemoSpec' => $_POST['MemoSpec'],
				'ProdId' => $num1,
				'ImgFull' => $img_string[0]
				);
  dbInsert( $table_compmain, $record );
  /*
	  $insertSQL = sprintf("INSERT INTO compmain (LarCode, MidCode, ProdName, ProdDisc, MemoSpec, ProdId, ImgFull) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['LarCode'], "text"),
                       GetSQLValueString($_POST['MidCode'], "text"),
                       GetSQLValueString($_POST['MidCode'], "text"),
					   GetSQLValueString($_POST['ProdDisc'], "text"),
					   GetSQLValueString($_POST['MemoSpec'], "text"),
					   GetSQLValueString($num1, "text"),
					   GetSQLValueString($img_string[0], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
	  */
  }


  if($_POST['LarCode']=="") $_POST['LarCode'] = 0;
  if(count($img_string) > 0) $img = $img_string[0];
  else                       $img = "";



  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $record = array(
  				'ProdId' => $num1,
				'img_name' => $img_string[$i]
				);
  dbInsert( $table_comp_img, $record );
  /*
    $insertSQL = sprintf("INSERT INTO comp_img (ProdId, img_name) VALUES (%s, %s)",
                          GetSQLValueString($num1, "text"),
		     			  GetSQLValueString($img_string[$i], "text"));

    mysql_select_db($database_webshop, $webshop);
    $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());*/
  }


  $insertGoTo = "adminweb.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------重設網頁資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
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

<?php  //---------------------------更新網頁類別(中類)---------------------------------//
$row_endItemRec = -1;
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
  $class = 0;
}
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >測試後台網頁新增</h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="addpages" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="addpages">
  <!----------------------------所屬大類---------------------------->
  <tr>
    <td><font color=#0000FF>1.所屬大類</font><font color="#FF3333">  *</font>
      <select id="LarCode" name="LarCode" onchange="this.form.submit()"
              style="width:20%; height:90%; margin: 3px">
      <option value="0"></option>
      <?php
	     foreach ($row_itemRec as $key => $array){
	  ?>
        <option value="<?php echo $array['LarCode']?>" <?php if($array['LarCode'] == $class) {echo "selected=\"selected\"";} ?>>
		<?php echo $array['LarCode']?></option>
      <?php
      }
      $rows = sizeof($totalRows_endItemRec);
      if($rows > 0) {
        /*mysql_data_seek($itemRec, 0);
	    $row_itemRec = mysql_fetch_assoc($itemRec);*/
      }
      ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>
    <td><font color=#0000FF>2.所屬中類</font><font color="#FF3333">  *</font>
      <select id="MidCode" name="MidCode" style="width:50%; height:90%; margin: 3px">
      <?php
	    foreach ($row_endItemRec as $key => $array){
	  ?>
        <option value="<?php echo $array['MidCode']?>"><?php echo $array['MidCode']?></option>
      <?php
      }
      $rows = sizeof($row_endItemRec);
      if($rows > 0) {
        /*mysql_data_seek($endItemRec, 0);
	    $row_endItemRec = mysql_fetch_assoc($endItemRec);*/
      }
      ?>
      </select>
    </td>
  </tr>
  <!----------------------------網頁上傳---------------------------->
  <tr>
    <td ><font color=#0000FF>3.網頁圖片</font>
      <input name="ImgPrev[]" type="file" value="none.gif" style="width:50%; height:90%; margin: 3px" multiple/>
    </td>
  </tr>
  <!----------------------------文章簡述---------------------------->
  <tr>
    <td><font color=#0000FF>4.文章簡述</font><font color="#FF3333">  *</font><br>
      <textarea id="ProdDisc" name="ProdDisc" cols="" rows="5" >0</textarea><br />
      <font color="#FF0000">[若前台不想出現文章簡述 內容，則輸入 0 值即可。]</font>
    </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
    <td><font color=#0000FF>5.詳細說明</font><br>
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
      <textarea id="MemoSpec" name="MemoSpec" cols="" rows="20">
	  <?php
	  if( !empty($_POST['MemoSpec']) )
		echo stripslashes($_POST['MemoSpec']);
	  else
		echo "請在此輸入文字";
      ?>
     </textarea>
     <script type="text/javascript">
       CKEDITOR.replace( 'MemoSpec' );
     </script>
   </td>
  </tr>

  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
</form>
</table>
<!--------------------------release--------------------------->
<?php
/*mysql_free_result($itemRec);
if(isset($endItemRec)) mysql_free_result($endItemRec);*/
?>
