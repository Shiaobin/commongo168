<?php //include("small.php"); ?>
<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['NewsClass'] != "") && ($_POST['Source'] != "") && ($_POST['NewsTitle'] != "")) {  
  
    //上傳圖片
  if($_FILES['upload_img']['name'] != "" ) {

	$img = date('his').".jpg";
	move_uploaded_file(realpath($_FILES["upload_img"]["tmp_name"]), "../images/newsimg/".$img
        ) or die("Problems with upload");
        resize_new_image($img);
  }
  else {
	$img = "none.gif";
  }
  
  $table_news		= SYS_DBNAME . ".news";
  $record = array(
  				'NewsClass' => $_POST['NewsClass'],
				'NewsContain' => $_POST['NewsContain'],
				'Source' => $_POST['Source'],
				'PubDate' => $_POST['PubDate'],
				'OffDate' => $_POST['OffDate'],
				'NewsTitle' => $_POST['NewsTitle'],
				'Online' => $_POST['Online'],
				'imgfull' => $img
				);
  dbInsert( $table_news, $record );
  
  /*
  $insertSQL = sprintf("INSERT INTO news (NewsClass, NewsContain, Source, PubDate, OffDate, NewsTitle, Online, imgfull) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NewsClass'], "text"),
                       GetSQLValueString($_POST['NewsContain'], "text"),
					   GetSQLValueString($_POST['Source'], "text"),
                       GetSQLValueString($_POST['PubDate'], "text"),
					   GetSQLValueString($_POST['OffDate'], "text"),
					   GetSQLValueString($_POST['NewsTitle'], "text"),
					   GetSQLValueString($_POST['Online'], "tinyint"),
					   GetSQLValueString($img, "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
	*/
  $insertGoTo = "adminnews.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
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
<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>

<Script>    
  function searchclass(){ 
    var NewsClass;
    NewsClass=document.NewsClass.value;
	location.href="adminaddnews.php?NewsClass="+NewsClass;
  }
</Script> 
<!-------------------------------------------------------------->
<h3 class=ttl01 >新增消息</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="addpages" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="addpages">

  <!------------------------最新消息 標題------------------------->
  <tr>
    <td>1.消息標題<font color="#FF3333">  *</font>:
      <input name="NewsTitle" type="text" class=sizeL />
    </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
    <td>2.詳細說明:
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
      <textarea id="NewsContain" name="NewsContain" cols="" rows="" style="width:70%; height:100%; margin:3px">
	  <?php
	  if( !empty($_POST['NewsContain']) )
		echo stripslashes($_POST['NewsContain']);
	  else
		echo "請在此輸入文字";
      ?>
     </textarea>
     <script type="text/javascript">
       CKEDITOR.replace( 'NewsContain' );
     </script>
   </td>
  </tr>  
  <!-----------------------------來源------------------------------>
  <tr>
    <td>3.來源<font color="#FF3333">  *</font>:
      <input id="Source" name="Source" value="牧迪網頁設計" type="text" class=sizeM />
    </td>
  </tr>
  <!----------------------------發佈日期---------------------------->
  <tr>
    <td>4.發佈日期:
      <input id="PubDate" name="PubDate" value="<?php $date=date("YmdHis"); echo date('Y-m-d H:i:s',strtotime($date));?>"  type="text" class=sizeS />
    </td>
  </tr>
  <!----------------------------失效日期---------------------------->
  <tr>
    <td>5.失效日期:
      <input id="OffDate" name="OffDate" value="<?php $date=date("YmdHis",mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")+2)); echo date('Y-m-d H:i:s',strtotime($date));?>" 
       type="text" class=sizeS />
    </td>
  </tr>
  <!----------------------------新聞類別---------------------------->
  <tr>
    <td>6.新聞類別<font color="#FF3333">  *</font>:<!--下拉式選單update MySQL(3)-->
      <select id="NewsClass" name="NewsClass" onchange="searchclass();" style="width:90px">
          <option value="-1" selected>---請選擇---</option>
          <option value="最新消息">最新消息</option>
          <option value="優惠消息">優惠消息</option>
 		  <option value="特價消息">特價消息</option>
          </select>
    </td>
  </tr>
  <!----------------------------是否在線---------------------------->
  <tr>
    <td>7.是否在線:
      <label>
        <input type="radio" name="Online" value="1" id="Online_1" checked/>是</label>
      <label>
        <input type="radio" name="Online" value="0" id="Online_0" />否</label>
    </td>
  </tr>
  <!----------------------------上傳圖片---------------------------->
  <tr>
     <td>6.圖片:
       <input name="upload_img" type="file" value="Select a File..." style="width:50%; height:100%; margin: 3px"/> 
     </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
</form>
</table>
<?php
//mysql_free_result($showClassRec);
?>
