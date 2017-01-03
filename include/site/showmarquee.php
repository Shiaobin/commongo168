<?php  //-----------------------------取得跑馬燈資訊------------------------------------//
  $column = "*";
  $table_ggg		= SYS_DBNAME . ".ggg";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_ggg}",
		  'mssql'	=> "SELECT {$column} FROM {$table_ggg}",
		  'oci8'	=> "SELECT {$column} FROM {$table_ggg}"
  );

  $row_showmarqueeRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
//$query_showmarqueeRec = "SELECT * FROM ggg";
//$showmarqueeRec = mysql_query($query_showmarqueeRec, $webshop) or die(mysql_error());
//$row_showmarqueeRec = mysql_fetch_assoc($showmarqueeRec);
//$totalRows_showmarqueeRec = mysql_num_rows($showmarqueeRec);
?>
<marquee align="middle" onmouseout="this.start()" onmouseover="this.stop()" scrolldelay="140">
  <a style="text-decoration: none" href="<?php echo $row_showmarqueeRec["zimulink"];?>"><?php echo $row_showmarqueeRec["zimu"];?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <a style="text-decoration: none" href="<?php echo $row_showmarqueeRec["zimu2link"];?>"><?php echo $row_showmarqueeRec["zimu2"];?></a>
</marquee>
<?php
//mysql_free_result($showmarqueeRec);
?>
