<?php  //-----------------------------取得中類資訊------------------------------------//
$cloume_showitemLarRec = "-1";
$cloume_showitemMidRec = "-1";
if ((isset($_GET['LarSeq']) && ($_GET['MidSeq']))) {
  $cloume_showitemLarRec = $_GET['LarSeq'];
  $cloume_showitemMidRec = $_GET['MidSeq'];
}
$table_compclass		= SYS_DBNAME . ".compclass";
$whereClause = "LarSeq='{$cloume_showitemLarRec}' AND MidSeq='{$cloume_showitemMidRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause}"
		);
$row_showitemMidRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showitemMidRec = sprintf("SELECT * FROM compclass WHERE LarSeq=%s AND MidSeq=%s",
                               GetSQLValueString($cloume_showitemLarRec, "int"),
							   GetSQLValueString($cloume_showitemMidRec, "int"));
$showitemMidRec = mysql_query($query_showitemMidRec, $webshop) or die(mysql_error());
$row_showitemMidRec = mysql_fetch_assoc($showitemMidRec);
$totalRows_showitemMidRec = mysql_num_rows($showitemMidRec);
*/
?>
<?php  //--------------------------新增分頁類別(中類)-----------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['MidCode'] != "")) {
	$table_compclass		= SYS_DBNAME . ".compclass";
	$whereClause = "LarSeq='{$cloume_showitemLarRec}'";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
			'mssql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
			'oci8'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
			);
	$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showgoodsRec = sizeof($row_showgoodsRec);
/*
	    mysql_select_db($database_webshop, $webshop);
        $query_showgoodsRec = sprintf("SELECT * FROM compclass WHERE LarSeq = %s ORDER BY MidSeq ASC",
                                       GetSQLValueString($cloume_showitemLarRec, "int"));
        $showgoodsRec = mysql_query($query_showgoodsRec, $webshop) or die(mysql_error());
        $row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
        $totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);
		$newMidSeq = $totalRows_showgoodsRec+1;
  */

  $newMidSeq = $totalRows_showgoodsRec+1;
  $table_compclass		= SYS_DBNAME . ".compclass";
  $record = array(
  				'LarSeq' => $cloume_showitemLarRec,
				'LarCode' => $_POST['LarCode'],
				'MidSeq' => $newMidSeq,
				'MidCode' => $_POST['MidCode']
				);
  dbInsert( $table_compclass, $record );
  /*
  $insertSQL = sprintf("INSERT INTO compclass (LarSeq, LarCode, MidSeq, MidCode) VALUES (%s, %s, '$newMidSeq', %s)",
  					   GetSQLValueString($cloume_showitemLarRec, "int"),
					   GetSQLValueString($_POST['LarCode'], "text"),
					   GetSQLValueString($_POST['MidCode'], "text"));

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
<!---------------------新增類別----------------------------------------------------------->
<h3 class=ttl01 >新增網頁中類</h3>

<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
	<form action="<?php echo $editFormAction; ?>" name="additem" method="POST" enctype="multipart/form-data" id="additem">

          <tr align="left">
            <td width="100%"><?php echo $row_showitemMidRec['LarCode']; ?></td>
          </tr>

          <?php
			  $table_compclass		= SYS_DBNAME . ".compclass";
			  $whereClause = "LarSeq='{$cloume_showitemLarRec}'";
			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
					  'mssql'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
					  'oci8'	=> "SELECT * FROM {$table_compclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
					  );
			  $row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
			  $totalRows_showgoodsRec = sizeof($row_showgoodsRec);

            /*mysql_select_db($database_webshop, $webshop);
            $query_showgoodsRec = sprintf("SELECT * FROM compclass WHERE LarSeq = %s ORDER BY MidSeq ASC",
                                           GetSQLValueString($cloume_showitemLarRec, "int"));
            $showgoodsRec = mysql_query($query_showgoodsRec, $webshop) or die(mysql_error());
            $row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
            $totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);*/
            if ($totalRows_showgoodsRec > 0) {
            foreach ($row_showgoodsRec as $key => $array){  ?>
          <tr align="left">
            <td width="100%"><?php echo $array['MidSeq']." - ".$array['MidCode']; ?></td>
          </tr>
          <?php
            }}?>

<!-------------------------------------------------------------->
      <tr>
        <td>名稱:
          <input type="text" name="MidCode" id="MidCode"  class=sizeS />

          <input name="LarCode" type="hidden" value="<?php echo $row_showitemMidRec['LarCode']; ?>" /><font color="#0000FF">[建議：中類名稱字數控制在8個字以內]</font>

        </td>
      </tr>

      <tr>
        <td>
          <input type="submit" name="MM_insert" id="MM_insert" value="新增" style="font-size:16px;width:60px;height:30px"/>
        </td>
      </tr>
<!-------------------------------------------------------------->
   </form>
</table>
