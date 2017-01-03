<?php  //-----------------------------取出所有選項類別------------------------------//
  $column = "Distinct LarCode, LarSeq, pnum";
  $table_compclass		= SYS_DBNAME . ".compclass";
  $whereClause = "LarSeq<100";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC"
  );

  $row_showlistRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showlistRec = sizeof($row_showlistRec);
?>

<!---------------------------aside分類-------------------------->
      <?php $no = 0;
	  		foreach ($row_showlistRec as $key => $array) { ?>
<!------------------------------顯示大項名(pnum=0)------------------------------------->
<?php if(($array["pnum"] == 0)){ ?>
<?php
  $column = "*";
  $table_compclass		= SYS_DBNAME . ".compclass";
  $whereClause = "LarSeq='{$array['LarSeq']}'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause} order by LarSeq ASC"
  );
  $row_showsublistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showsublistRec = sizeof($row_showsublistRec);


				if(($row_showsublistRec["url"] != "")){
					$url = $row_showsublistRec["url"];
					$url_test = $array["LarCode"];


echo "<a href='http://".$url."' target='_blank'></dl><h3><img src=img/services.png align=absmiddle>$url_test</h3><dl></a>";


?>

<?php }else if(($row_showsublistRec["snum"] == 1)){ ?>

<a href="indexpageMid.php?LarCode=<?php echo $row_showsublistRec["LarCode"]; ?>&MidCode=<?php echo $row_showsublistRec["MidCode"]; ?>&tabindex=<?php echo $no;?>">

</dl><h3><img src=img/services.png align=absmiddle><?php echo $array["LarCode"]; ?></h3><dl></a>

<?php }else{ ?>

<a href="indexpage.php?LarCode=<?php echo $row_showsublistRec["LarCode"]; ?>&MidCode=<?php echo $row_showsublistRec["MidCode"]; ?>&tabindex=<?php echo $no;?>">

</dl><h3><img src=img/services.png align=absmiddle><?php echo $array["LarCode"]; ?></h3><dl></a>


<?php }?>
<?php }else{ ?>

</dl><h3><img src=img/services.png  align=absmiddle><?php echo $array["LarCode"]; ?></h3><dl>

<?php
  $column = "*";
  $table_compclass		= SYS_DBNAME . ".compclass";
  $whereClause = "LarSeq='{$array['LarSeq']}'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}"
  );
  $row_showsublistRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showsublistRec = sizeof($row_showsublistRec);

		      if (($totalRows_showsublistRec > 0)) {
		      foreach ($row_showsublistRec as $key => $array_sublistRec) {
			  $column = "url";
			  $whereClause = "LarSeq={$array_sublistRec['LarSeq']} AND MidSeq={$array_sublistRec['MidSeq']}";
				  $sql['list']['select'] = array(
						  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
						  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
						  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}"
				  );
				  $row_showsetRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

					//print_r($row_showsetRec);
				  if(($array_sublistRec["url"] != "")){
					$url = $row_showsetRec["url"];
					$url_test = $row_showsublistRec["MidCode"];
echo "<a href='http://".$url."' target='_blank'>

<dt></dt><dd><img src=img/icon.png align=absmiddle>$url_test</dd></a>";

				  }else if(($array_sublistRec["snum"] == 1)){ ?>
 <a href="indexpageMid.php?LarCode=<?php echo $array_sublistRec["LarCode"]; ?>&MidCode=<?php echo $array_sublistRec["MidCode"]; ?>&tabindex=<?php echo $no;?>">


<dt></dt><dd><img src=img/icon.png align=absmiddle><?php echo $array_sublistRec["MidCode"]; ?></dd></a>


			<?php }else{ ?>

<a href="indexpage.php?LarCode=<?php echo $array_sublistRec["LarCode"]; ?>&MidCode=<?php echo $array_sublistRec["MidCode"]; ?>&tabindex=<?php echo $no;?>">


<dt></dt><dd><img src=img/icon.png align=absmiddle><?php echo $array_sublistRec["MidCode"]; ?></dd></a>



            <?php }?>

	   	<?php }}
	   		}
				  $no = $no+1;
			}//row_showlistRec end foreach ?>

<?php

?>
