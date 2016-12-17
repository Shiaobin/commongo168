<?php  //-----------------------------更新跑馬燈資訊------------------------------------//
if ((isset($_POST["update_marquee"])) && ($_POST["update_marquee"] == "更新")) {	
  
  //更新跑馬燈資訊
  $table_ggg		= SYS_DBNAME . ".ggg";
  $record = array(
  				'zimu' => $_POST['zimu'],
				'zimulink' => $_POST['zimulink'],
				'zimu2' => $_POST['zimu2'],
				'zimu2link' => $_POST['zimu2link']
				);
  $whereClause = "1=1";
		
  dbUpdate( $table_ggg, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE ggg SET zimu=%s, zimulink=%s, zimu2=%s, zimu2link=%s",
                        GetSQLValueString($_POST['zimu'], "text"),
                        GetSQLValueString($_POST['zimulink']   , "text"),
						GetSQLValueString($_POST['zimu2'], "text"),
						GetSQLValueString($_POST['zimu2link']   , "text"));

  $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	*/
  $updateGoTo = "admineditmarquee.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>"; 
}
?>
<?php  //-----------------------------取得跑馬燈資訊------------------------------------//

$table_ggg		= SYS_DBNAME . ".ggg";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_ggg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_ggg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_ggg} WHERE {$whereClause}"
		);
$row_showmarqueeRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	  
/*	  
$query_showmarqueeRec = "SELECT * FROM ggg";
$showmarqueeRec = mysql_query($query_showmarqueeRec, $webshop) or die(mysql_error());
$row_showmarqueeRec = mysql_fetch_assoc($showmarqueeRec);
$totalRows_showmarqueeRec = mysql_num_rows($showmarqueeRec);
*/
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >編輯文字跑馬燈</h3>

<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmarquee" action="" method="POST" enctype="multipart/form-data" id="editmarquee">

  <tr>
    <td>跑馬燈字幕一:
      <input id="zimu" name="zimu"  type="text" class=sizeL 
       value="<?php echo $row_showmarqueeRec['zimu']; ?>" />
    </td>
  </tr>
  <!---------------------------字幕一連接------------------------------>
  <tr>
    <td>跑字幕一連接:
      <input id="zimulink" name="zimulink" type="text" class=sizeL  
       value="<?php echo $row_showmarqueeRec['zimulink']; ?>" />
    </td>
  </tr>
  <!---------------------------跑馬燈字幕二---------------------------->
  <tr>
    <td>跑馬燈字幕二:
      <input id="zimu2" name="zimu2" type="text"  class=sizeL  
       value="<?php echo $row_showmarqueeRec['zimu2']; ?>" />
    </td>
  </tr>
  
  <!---------------------------字幕二連接------------------------------>
  <tr>
    <td>跑字幕二連接:
      <input id="zimu2link" name="zimu2link" type="text"  class=sizeL 
       value="<?php echo $row_showmarqueeRec['zimu2link']; ?>" />
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td width="92%" colspan="2" align="center">
      <input type="submit" name="update_marquee" value="更新" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showmarqueeRec);
?>
