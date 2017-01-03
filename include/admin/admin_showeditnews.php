<?php //include("small.php"); ?>
<?php  //-----------------------------更新商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_news"])) && ($_POST["update_news"] == "更新")) {
  //move_uploaded_file($_FILES["news_img"]["tmp_name"], "newsimg\\".$_FILES["news_img"]["name"].".jpg");


  //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

    if($_POST['imgfull']=="none.gif" ) $img = date('his').".jpg";
	else                      $img = $_POST['imgfull'];

	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/newsimg/".$img);
        resize_new_image($img);
  }
  else {
    $img = $_POST['imgfull'];
  }

  $table_index_msg		= SYS_DBNAME . ".news";
  $record = array(
  				'NewsClass' => $_POST['NewsClass'],
				'NewsContain' => $_POST['NewsContain'],
				'Source' => $_POST['Source'],
				'PubDate' => $_POST['PubDate'],
				'OffDate' => $_POST['OffDate'],
				'NewsTitle' => $_POST['NewsTitle'],
				'Online' => $_POST['Online'],
				'uup' => $_POST['uup'],
				'imgfull' => $img
				);
  $whereClause = "NewsID={$_POST['NewsID']}";

  dbUpdate( $table_index_msg, $record, $whereClause );

  /*
  $updateSQL = sprintf("UPDATE news SET NewsClass=%s, NewsContain=%s, Source=%s, PubDate=%s, OffDate=%s, NewsTitle=%s, Online=%s, uup=%s, imgfull=%s where NewsID=%s",
					   GetSQLValueString($_POST['NewsClass'], "text"),
					   GetSQLValueString($_POST['NewsContain'], "text"),
					   GetSQLValueString($_POST['Source'], "text"),
					   GetSQLValueString($_POST['PubDate'], "text"),
					   GetSQLValueString($_POST['OffDate'], "text"),
					   GetSQLValueString($_POST['NewsTitle'], "text"),
                       GetSQLValueString($_POST['Online'], "tinyint"),
					   GetSQLValueString($_POST['uup'], "int"),
					   GetSQLValueString($img, "text"),
					   GetSQLValueString($_POST['NewsID'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminnews.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}

//---------------news img-------------------//
function resize_new_image($file) {
$imM = new Imagick("../images/newsimg/".$file);
$imS = new Imagick("../images/newsimg/".$file);

foreach ($imM as $frameM) {
$frameM->thumbnailImage(600, 500);
$frameM->setImagePage(600, 500, 0, 0);
}

foreach ($imS as $frameS) {
$frameS->thumbnailImage(120, 100);
$frameS->setImagePage(120, 100, 0, 0);
}

$imM->writeimages("../images/newsimg/medium/".$file, true);
$imS->writeimages("../images/newsimg/small/".$file, true);
unlink("../images/newsimg/".$file);
}
?>
<?php  //-----------------------------取得最新消息------------------------------------//
$cloume_shownewsRec = "%";
if (isset($_GET['NewsID'])) {
  $cloume_shownewsRec = $_GET['NewsID'];
}
$table_news		= SYS_DBNAME . ".news";
$whereClause = "NewsID='{$cloume_shownewsRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_news} WHERE {$whereClause}"
		);
$row_shownewsRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_shownewsRec = sprintf("SELECT * FROM news WHERE NewsID=%s",
                               GetSQLValueString($cloume_shownewsRec, "text"));
$shownewsRec = mysql_query($query_shownewsRec, $webshop) or die(mysql_error());
$row_shownewsRec = mysql_fetch_assoc($shownewsRec);
$totalRows_shownewsRec = mysql_num_rows($shownewsRec);
*/
?>

<Script>
  function changeNewsNewsClass(){
    var NewsClass;
    NewsClass=document.adminRec.NewsClass.value;
	location.href="adminaddnews.php?NewsClass="+NewsClass;
  }
</Script>
<h3 class=ttl01 >後台最新消息編輯</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------編輯上架商品--------------------------------->
<form name="editnews" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editnews">

<input type="hidden" name="NewsID" id="NewsID" value="<?php echo $row_shownewsRec['NewsID']; ?>"/>

  <!------------------------最新消息 標題------------------------->
  <tr>
    <td>1.最新消息 標題:<input name="NewsTitle" type="text" value="<?php echo $row_shownewsRec['NewsTitle']; ?>" class=sizeL />.
    </td>
  </tr>

  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>2.圖片:<img src="../../images/newsimg/small/<?php echo $row_shownewsRec['imgfull']; ?>" alt="" name="image"
           width="120px" height="120px" id="image" align="center" style="padding:5px;"/>
       <input name="imgfull" type="hidden" value="<?php echo $row_shownewsRec['imgfull']; ?>" />
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/> </p>
     </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
    <td>3.詳細說明:
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
      <textarea id="NewsContain" name="NewsContain" class="ckeditor" cols="" rows="" style="width:70%; height:100%; margin:3px">
	    <?php echo $row_shownewsRec['NewsContain']; ?>
      </textarea>
   </td>
  </tr>
  <!-----------------------------來源------------------------------>
  <tr>
    <td>4.來源:
      <input  type="text" id="Source" name="Source" value="<?php echo $row_shownewsRec['Source']; ?>" class=sizeM />
    </td>
  </tr>
  <!----------------------------發佈日期---------------------------->
  <tr>
    <td>5.發佈日期:
      <input  type="text" id="PubDate" name="PubDate" value="<?php echo $row_shownewsRec['PubDate'];?>" class=sizeS />
    </td>
  </tr>
  <!----------------------------失效日期---------------------------->
  <tr>
    <td>6.失效日期:
      <input  type="text" id="OffDate" name="OffDate" value="<?php echo $row_shownewsRec['OffDate'];?>" class=sizeS />
    </td>
  </tr>
  <!----------------------------新聞類別---------------------------->
  <tr>
    <td>7.新聞類別:
      <select id="NewsClass" name="NewsClass" onchange="changeNewsNewsClass();" style="width:15%; height:80%; margin: 3px">
          <option value="最新消息" <?php if($row_shownewsRec['NewsClass'] == "最新消息") echo "selected=\"selected\"";?>>最新消息</option>
 		  <option value="優惠消息" <?php if($row_shownewsRec['NewsClass'] == "優惠消息") echo "selected=\"selected\"";?>>優惠消息</option>
		  <option value="特價消息" <?php if($row_shownewsRec['NewsClass'] == "特價消息") echo "selected=\"selected\"";?>>特價消息</option>
       </select>
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td>8.是否在線:
      <label>
        <input type="radio" name="Online" value="1" id="Online_1"
		<?php if ($row_shownewsRec['Online'] == '1'): ?>checked='checked'<?php endif; ?>/>是</label>
      <label>
        <input type="radio" name="Online" value="0" id="Online_0"
        <?php if ($row_shownewsRec['Online'] == '0'): ?>checked='checked'<?php endif; ?>/>否</label>
    </td>
  </tr>
  <!----------------------------是否固頂  ---------------------------->
  <tr>
    <td>9.是否固頂:
      <label>
        <input type="radio" name="uup" value="1" id="uup_1"
        <?php if ($row_shownewsRec['uup'] == '1'): ?>checked='checked'<?php endif; ?>/>是</label>
      <label>
        <input type="radio" name="uup" value="0" id="uup_0"
		<?php if ($row_shownewsRec['uup'] == '0'): ?>checked='checked'<?php endif; ?>/>否</label>
    </td>
  </tr>

  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="NewsID" type="hidden" value="<?php echo $row_shownewsRec['NewsID']; ?>" />
      <input type="submit" name="update_news"  value="更新" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($shownewsRec);
//mysql_free_result($showClassRec);
?>
