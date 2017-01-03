<?php  //-----------------------------取出所有(商品)選項類別------------------------------//
  $column = "Distinct LarCode, LarSeq, pnum";
  $table_prodclass		= SYS_DBNAME . ".prodclass";
  $whereClause = "LarSeq<100";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} order by LarSeq",
		  'mssql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} order by LarSeq",
		  'oci8'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} order by LarSeq"
  );

  $row_showlistRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showlistRec = sizeof($row_showlistRec);
 /*
  mysql_select_db($database_webshop, $webshop);
  $query_showlistRec = "SELECT Distinct LarCode, LarSeq, pnum FROM prodclass where LarSeq<100 order by LarSeq";
  $showlistRec = mysql_query($query_showlistRec, $webshop) or die(mysql_error());
  $row_showlistRec = mysql_fetch_assoc($showlistRec);
  $totalRows_showlistRec = mysql_num_rows($showlistRec);
  */
?>
<!---------------------------aside分類-------------------------->
      <?php $num = 0;
	  		foreach ($row_showlistRec as $key => $array) {  ?>
<!------------------------------顯示大項名------------------------------------->
</dl><h3><img src=img/services.png align=absmiddle><?php echo $array["LarCode"]; ?></h3><dl>


            <?php

			  $column = "*";
			  $table_prodclass		= SYS_DBNAME . ".prodclass";
			  $whereClause = "LarSeq={$array['LarSeq']}";

			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause}",
					  'mssql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause}",
					  'oci8'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause}"
			  );
			  $row_showsublistRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
			  $totalRows_showsublistRec = sizeof($row_showsublistRec);
			  /*
	          $query_showsublistRec = sprintf("SELECT * FROM prodclass WHERE LarSeq = %s", GetSQLValueString($row_showlistRec['LarSeq'], "text"));
		      $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		      $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		      $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
			  */
		      if (($totalRows_showsublistRec > 0)) {
		      foreach ($row_showsublistRec as $key => $array_sublistRec) {
			?>

                 <a href="subgoods.php?LarCode=<?php echo $array_sublistRec["LarCode"]; ?>&MidCode=<?php echo $array_sublistRec["MidCode"]; ?>&tabindex=<?php echo $num;?>">

<!--------------------顯示中項名並加連結(prodclass(MidCode))-------------------------------->
<dt></dt><dd><img src=img/icon.png align=absmiddle><?php echo $array_sublistRec["MidCode"]; ?></dd></a>


	   	<?php }}
				  $num = $num+1;
			} ?></p>

<?php
//mysql_free_result($showlistRec);
//mysql_free_result($showsublistRec);
//mysql_free_result($showsetRec);
?>
