<?php  //---------------------------更新帳密資訊---------------------------------//
if ((isset($_POST["update_access"])) && ($_POST["update_access"] == "確認")) {
  //move_uploaded_file($_FILES["news_img"]["tmp_name"], "newsimg\\".$_FILES["news_img"]["name"].".jpg");

	$table_admin		= SYS_DBNAME . ".admin";
  $record = array(
  				'name' => $_POST['name'],
				'password' => $_POST['password']
				);
  $whereClause = "ID='1'";

  dbUpdate( $table_admin, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE admin SET name=%s, password=%s WHERE ID='1'",
					   GetSQLValueString($_POST['name'], "text"),
					   GetSQLValueString($_POST['password'], "text"));

  echo $_POST['name']."_".$_POST['password'];

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminaccess.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //---------------------------取出帳密資訊---------------------------------//

$table_admin		= SYS_DBNAME . ".admin";
$whereClause = "1=1";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_admin} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_admin} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_admin} WHERE {$whereClause}"
		);
$row_showaccessRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showaccessRec = "SELECT * FROM admin";
$showaccessRec = mysql_query($query_showaccessRec, $webshop) or die(mysql_error());
$row_showaccessRec = mysql_fetch_assoc($showaccessRec);*/
?>
<!-------------------------------------------------------------------------------->
<h3 class=ttl01 >管理員密碼修改</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="" name="updateAdmin" method="POST" enctype="multipart/form-data" id="updateAdmin">
  <tr>
    <td>用戶名稱:
   <input type="text" name="name" id="name" value="<?php echo $row_showaccessRec["name"];?>" class=sizeS />
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td>用戶密碼:
   <input type="text" name="password" id="password" value="<?php echo $row_showaccessRec["password"];?>" class=sizeS />
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td>
   <input type="submit" name="update_access" id="update_access" value="確認" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="reset" id="reset" value="復原" style="font-size:16px;width:60px;height:30px" />
    </td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>
<?php
//mysql_free_result($showaccessRec);
?>
