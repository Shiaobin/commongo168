<?php  //--------------------------新增修改分頁類別(大類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "additem") && ($_POST['LarCode'] != "")&& ($_POST['LarSeq'] != "")) { 

 $table_compclass		= SYS_DBNAME . ".compclass";
  $record = array(
  				'LarSeq' => $_POST['LarSeq'],
				'LarCode' => $_POST['LarCode']
				);
  dbInsert( $table_compclass, $record );
  /*
  $insertSQL = sprintf("INSERT INTO compclass (LarSeq, LarCode) VALUES (%s, %s)",
                       GetSQLValueString($_POST['LarSeq'], "int"),
					   GetSQLValueString($_POST['LarCode'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
*/
  $insertGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>";
}
?>

<!---------------------新增類別--------------------------------->
<h3 class=ttl01 >新增網頁大類</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="<?php echo $editFormAction; ?>" name="additem" method="POST" enctype="multipart/form-data" id="additem"/>
  <tr>
    <td width="100%">名稱:
   	  <input type="text" name="LarCode" id="LarCode" class=sizeS />
    </td>
  </tr>
  
  <tr>
    <td width="100%">排序:
   	  <input type="int" name="LarSeq" id="Larseq" class=sizeSss />
   	  <font color="#FF3333">  *</font>[不能與其它大類的排序號重複，否則會出錯]    </td>
  </tr>
  
  <tr>
    <td >	  
   	  <input type="submit" name="add" id="add" value="新增" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!-------------------------------------------------------------->
    <input type="hidden" name="MM_insert" value="additem" />
  </form>
</table>
