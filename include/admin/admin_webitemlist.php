<?php  //---------------------------新增修改分頁類別(大類)---------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_item"])) && ($_POST["update_item"] == "更新")) {
  //更新大項內容
  $table_index_item = SYS_DBNAME . ".index_item";
	  $whereClause = "index_item_id={$_POST['index_item_id']}";
	  $record = array
	  (	
		  'index_item_id' => $_POST['upd_index_item_id'],
		  'index_item_name' => $_POST['index_item_name']
	  );
		  
	  $is_update = dbUpdate( $table_index_item, $record, $whereClause );
	/*  
  $updateSQL = sprintf("UPDATE index_item SET index_item_id=%s, index_item_name=%s WHERE index_item_id=%s",
                       GetSQLValueString($_POST['upd_index_item_id'], "int"),
                       GetSQLValueString($_POST['index_item_name'], "text"),
                       GetSQLValueString($_POST['index_item_id'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  
  //更新中項內容
  $table_index_end_item = SYS_DBNAME . ".index_end_item";
  $whereClause = "index_item_id={$_POST['index_item_id']}";
  $record = array
  (	
	  'upd_index_item_id' => $_POST['upd_index_item_id']
  );
	  
  $is_update = dbUpdate( $table_index_end_item, $record, $whereClause );
	/*  
  $updateSQL = sprintf("UPDATE index_end_item SET index_item_id=%s WHERE index_item_id=%s",
                       GetSQLValueString($_POST['upd_index_item_id'], "int"),
                       GetSQLValueString($_POST['index_item_id'], "int"));

  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
 */
  $updateGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>"; 
}

//-----------------------------新增分頁類別(大類)--------------------------------//
if ((isset($_POST["add_item"])) && ($_POST["add_item"] == "新增")) {
	/*
  $insertSQL = sprintf("INSERT INTO index_end_item (index_item_id) VALUES (%s)",
                       GetSQLValueString($_POST['index_item_id'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());*/
  
  $table_index_end_item = SYS_DBNAME . ".index_end_item";
  $record = array
  (	
	  'index_item_id' => $_POST['index_item_id']
  );
	  
  $is_update = dbInsert( $table_index_end_item, $record );

  $insertGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$insertGoTo'";
  echo "</script>"; 
}

//------------------------------刪除分頁類別(大類)--------------------------------//
if ((isset($_POST["del_item"])) && ($_POST["del_item"] == "刪除")) {
	/*
  $deleteSQL = sprintf("DELETE FROM index_item WHERE index_item_id=%s",
                       GetSQLValueString($_POST['index_item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());
  */
  $table_index_item		= SYS_DBNAME . ".index_item";
  $whereClause = "index_item_id={$_POST['index_item_id']}";
  dbDelete( $table_index_item, $whereClause );

  $deleteGoTo = "adminwebitem.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>"; 
}
?>
<?php  //---------------------------新增修改分頁類別(中類)---------------------------------//
if ((isset($_POST["update_end_item"])) && ($_POST["update_end_item"] == "更新")) {
	/*
  $updateSQL = sprintf("UPDATE index_end_item SET index_end_item_id=%s,index_end_item_name=%s WHERE index_end_item_id=%s",
                       GetSQLValueString($_POST['upd_index_end_item_id'], "int"),
                       GetSQLValueString($_POST['index_end_item_name'], "text"),
                       GetSQLValueString($_POST['index_end_item_id'], "int"));		   

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  $table_index_end_item = SYS_DBNAME . ".index_end_item";
  $whereClause = "index_end_item_id={$_POST['index_end_item_id']}";
  $record = array
  (	
	  'index_end_item_id' => $_POST['upd_index_end_item_id'],
	  'index_end_item_name' => $_POST['index_end_item_name']
  );
	  
  $is_update = dbUpdate( $table_index_end_item, $record, $whereClause );


  $updateGoTo = "adminwebitem.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  
  $url = $updateGoTo;
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>"; 
}

//------------------------------刪除分頁類別(中類)--------------------------------//
if ((isset($_POST["del_end_item"])) && ($_POST["del_end_item"] == "刪除")) {
	
	/*
   $deleteSQL = sprintf("DELETE FROM index_end_item WHERE index_end_item_id=%s",
                       GetSQLValueString($_POST['index_end_item_id'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($deleteSQL, $webshop) or die(mysql_error());
  */
  $table_index_end_item		= SYS_DBNAME . ".index_end_item";
  $whereClause = "index_end_item_id={$_POST['index_end_item_id']}";
  dbDelete( $table_index_end_item, $whereClause );

  $deleteGoTo = "adminwebitem.php";
  /*if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }*/
  $url = $deleteGoTo;
  echo "<script type='text/javascript'>";
  echo "window.location.href='$url'";
  echo "</script>"; 
}
?>
<?php  //----------------------------------取出分頁類別資訊-----------------------------------//

/*mysql_select_db($database_webshop, $webshop);
$query_showitemRec = "SELECT index_item.index_item_id,index_item.index_item_name,count(index_end_item.index_item_id) as num FROM index_item LEFT OUTER JOIN index_end_item ON index_item.index_item_id=index_end_item.index_item_id GROUP BY index_item.index_item_id";
$showitemRec = mysql_query($query_showitemRec, $webshop) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
*/
$column = "index_item.index_item_id,index_item.index_item_name,count(index_end_item.index_item_id) as num";
$table_index_item		= SYS_DBNAME . ".index_item";
$whereClause = "CONCAT($delete_string)";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_index_item} LEFT OUTER JOIN index_end_item ON index_item.index_item_id=index_end_item.index_item_id GROUP BY index_item.index_item_id", 
		'mssql'	=> "SELECT {$column} FROM {$table_index_item} LEFT OUTER JOIN index_end_item ON index_item.index_item_id=index_end_item.index_item_id GROUP BY index_item.index_item_id",
		'oci8'	=> "SELECT {$column} FROM {$table_index_item} LEFT OUTER JOIN index_end_item ON index_item.index_item_id=index_end_item.index_item_id GROUP BY index_item.index_item_id"
		);
$row_showitemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showitemRec = sizeof($row_showitemRec);
	  
?>
<!-------------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>網頁分頁列表</title>
<!---------------------------網頁分頁內容-------------------------->
<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <?php if ($totalRows_showitemRec > 0) {?>
      <td width="25%" colspan="4" valign="top">
      <?php foreach ($row_showitemRec as $key => $array){   ?>
         <table id="item" width="100%" border="0">
           <!-------------------------------------------------------------->
           <tr>
           <form action="<?php echo $editFormAction; ?>" name="edit_item" method="POST" id="edit_item">
             <td width="5%" align="center"><input name="upd_index_item_id" type="text" id="upd_index_item_id" style="width:60%;font-size:20px" value="<?php echo $row_showitemRec['index_item_id']; ?>"/></td>
             <td width="80%" align="center">
               <input name="index_item_name" type="text" id="index_item_name" style="width:99%;font-size:20px" value="<?php echo $row_showitemRec['index_item_name']; ?>" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }"/>
               <input name="index_item_id" type="hidden" value="<?php echo $row_showitemRec['index_item_id']; ?>" />
             </td>
             <td width="5%" align="center">
               <input type="submit" name="add_item" value="新增">
             </td>
             <td width="5%" align="center">
               <input type="submit" name="update_item" value="更新">
             </td>
             <td width="5%" align="center">
			   <?php if($row_showitemRec['num']<=0) {?>
               <input type="submit" name="del_item" value="刪除">
               <?php }?>
             </td>
           </form>
           </tr>
           <!-------------------------------------------------------------->
            <tr>
              <td colspan="5" align="left">
                 <table width="100%" border="0" cellpadding="0" cellspacing="0" id="goods">
                   <?php
				   /*
				     mysql_select_db($database_webshop, $webshop);
				     $query_showgoodsRec = sprintf("SELECT * FROM index_end_item WHERE index_item_id = %s", 
						  						GetSQLValueString($row_showitemRec['index_item_id'], "text"));
				     $showgoodsRec = mysql_query($query_showgoodsRec, $webshop) or die(mysql_error());
				     $row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
				     $totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);
					 */
					 $table_index_end_item		= SYS_DBNAME . ".index_end_item";
					$column = "*";
					$whereClause = "index_item_id={$array['index_item_id']}";
					
					$sql['list']['select'] = array(
							'mysql'	=> "SELECT * FROM {$table_index_end_item} WHERE {$whereClause}", 
							'mssql'	=> "SELECT * FROM {$table_index_end_item} WHERE {$whereClause}",
							'oci8'	=> "SELECT * FROM {$table_index_end_item} WHERE {$whereClause}"
					);
					$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
			  		$totalRows_showgoodsRec = sizeof($row_showgoodsRec);
					
				     if ($totalRows_showgoodsRec > 0) {
					   foreach ($row_showgoodsRec as $key => $array1){?>  
					     <tr>
                         <form action="<?php echo $editFormAction; ?>" name="edit_end_item" method="POST" id="edit_end_item">
    					   <td width="3%">
                             <img src="../../images/list/icon.png" width="8" height="8" hspace="8" align="middle"/>
                           </td> 
                           <td width="5%" align="center"><input name="upd_index_end_item_id" type="text" id="upd_index_end_item_id" style="width:60%;font-size:20px" value="<?php echo $array1['index_end_item_id']; ?>"/></td>
                           <td width="77%">
                             <input name="index_end_item_name" type="text" id="index_end_item_name" style="width:99%;font-size:20px" value="<?php echo $array1['index_end_item_name']; ?>"/>
                             <input name="index_end_item_id" type="hidden" value="<?php echo $array1['index_end_item_id']; ?>" />
                           </td>
               
                           <td width="5%" align="center">
                             <input type="submit" name="update_end_item" value="更新">
                           </td>
                           <td width="5%" align="center">
                             <input type="submit" name="del_end_item" value="刪除">
                           </td>
                           <td width="5%" align="center">
                           </td>
                         </form> 
  					     </tr>  
					   <?php }}?>   
			     </table>
              </td>
            </tr>
            <!-------------------------------------------------------------->
            <tr>
              <td height="10%" colspan="3"></td>
            </tr>
         <!-------------------------------------------------------------->
         </table>  
      <?php }  ?>
      </td>
      <?php }?>
    </tr>
</table>
<!-------------------------------------------------------------->
<?php
//mysql_free_result($showitemRec);
?>

