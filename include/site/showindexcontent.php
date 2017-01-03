<?php  //------------------------------取得首頁圖片資訊------------------------------//
$column = "*";
  $table_index_image_slide		= SYS_DBNAME . ".index_image_slide";
  $whereClause = "1=1";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_index_image_slide} WHERE {$whereClause} ORDER BY slide_index ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_index_image_slide} WHERE {$whereClause} ORDER BY slide_index ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_index_image_slide} WHERE {$whereClause} ORDER BY slide_index ASC"
  );

  $row_showpagesRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
 /*
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = "SELECT * FROM index_image_slide ORDER BY slide_index ASC";
$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
*/
?>
<?php foreach ($row_showpagesRec as $key => $array) { ?>
	<a href="http://<?php echo $array['slide_url']; ?>" target="_blank"><img src="../../images/slideimg/<?php echo $array['slide_img']; ?>" alt="" name="image" width="140px" height="75px" id="image" align="center" style="padding:5px;"/></a>

<?php } ?>
