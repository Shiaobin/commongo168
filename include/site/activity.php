<?php  //------------------------------取得自助頁面資訊------------------------------//
  $column = "*";
  $table_index_frame		= SYS_DBNAME . ".index_frame";
  $whereClause = "set_open='1'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_index_frame} WHERE {$whereClause} ORDER BY frame_date DESC",
		  'mssql'	=> "SELECT {$column} FROM {$table_index_frame} WHERE {$whereClause} ORDER BY frame_date DESC",
		  'oci8'	=> "SELECT {$column} FROM {$table_index_frame} WHERE {$whereClause} ORDER BY frame_date DESC"
  );

  $row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = "SELECT * FROM index_frame WHERE set_open='1' ORDER BY frame_date DESC";
$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
*/
echo $row_showpagesRec['frame_text'];
?>
