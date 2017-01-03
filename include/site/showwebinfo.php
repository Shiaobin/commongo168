
<?php  //-----------------------------取出網頁設置資訊------------------------------//
  $column = "*";
  $table_shopsetup		= SYS_DBNAME . ".shopsetup";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
		  'mssql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
		  'oci8'	=> "SELECT {$column} FROM {$table_shopsetup} "
  );
  $row_showconfigRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

  $title = $row_showconfigRec["sitename"]."-".$row_showconfigRec["siteurl"];
?>
