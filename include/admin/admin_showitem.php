<?php //------------------------------取出分頁類別資訊-----------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//------------------------------------------------------------//
$column = "DISTINCT LarCode, LarSeq";
$table_prodclass		= SYS_DBNAME . ".prodclass";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC", 
		'mssql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC",
		'oci8'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC"
);
$row_showitemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showitemRec = sizeof($row_showitemRec);
/*
mysql_select_db($database_webshop, $webshop);
$query_showitemRec = "SELECT DISTINCT LarCode, LarSeq FROM prodclass ORDER BY LarSeq ASC";
$showitemRec = mysql_query($query_showitemRec, $webshop) or die(mysql_error());
$row_showitemRec = mysql_fetch_assoc($showitemRec);
$totalRows_showitemRec = mysql_num_rows($showitemRec);
*/
//------------------------------------刪除分頁類別(大類)---------------------------------//
//------------------------------------刪除分頁類別(中類)---------------------------------//
$action= isset( $_GET["action"] )? $_GET["action"] : ""; 
switch ($action){ 
 case "delLar": 
 	delLar();
 break; 
 case "delMid": 
 	delMid();
 break; 
}

function delLar(){
  $cloume_showitemLarRec = "-1";
  //if (isset($_GET['LarSeq'])) {
  	$cloume_showitemLarRec = $_GET['LarSeq'];
 // }
  
   $table_compclass		= SYS_DBNAME . ".prodclass";
	  $whereClause = "LarSeq='".$cloume_showitemLarRec."'";
	  dbDelete( $table_compclass, $whereClause );
   
  /* $deleteSQL = sprintf("DELETE FROM prodclass WHERE LarSeq=%s",
                       GetSQLValueString($cloume_showitemLarRec, "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($deleteSQL) or die(mysql_error()); */
  	
  $deleteGoTo = "adminitem.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>";
}

function delMid(){ 
  $cloume_showitemClassId = "-1";
  //if ((isset($_GET['LarSeq']) && ($_GET['MidSeq']))) {
  	$cloume_showitemClassId = $_GET['ClassId'];
  //}

   $table_compclass		= SYS_DBNAME . ".prodclass";
	  $whereClause = "ClassId='".$cloume_showitemClassId."'";
	  dbDelete( $table_compclass, $whereClause );
  
/*  $deleteSQL = sprintf("DELETE FROM prodclass WHERE LarSeq=%s AND MidSeq=%s",
                       GetSQLValueString($cloume_showitemLarRec, "int"),
					   GetSQLValueString($cloume_showitemMidRec, "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($deleteSQL) or die(mysql_error()); */
  
  $deleteGoTo = "adminitem.php";
  echo "<script type='text/javascript'>";
  echo "window.location.href='$deleteGoTo'";
  echo "</script>"; 
}
?>
<!-------------------------------------網頁開始------------------------------------------------------------>
<h3 class=ttl01 >商品分類管理</h3>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">

    <tr>
      <td colspan="3" align="left"><font color="blue">重要提示：分類名稱中不能有空格或其它特殊符號；不同大類的排序號不能相同；<font color="red">請慎了解前台選單大類中類之呈現狀態之設定。</font></font></td>
    </tr>
<!---------------------------------------------------------------------------------------------------------->

    <?php if($totalRows_showitemRec == 0){?>
    		<tr align="center">
            	<td><a href="adminadditemLar.php?&LarSeq=<?php echo $row_showitemRec['LarSeq']; ?>">新增大類別</a></td>
            </tr>
    <?php }else{?>
        <?php foreach ($row_showitemRec as $key => $array){   ?>
            <tr bgcolor='#999999'>
              <td align="left" width="77%">&nbsp;
                <?php echo $array['LarSeq']." - ".$array['LarCode']; ?>
              </td>
              <td align="center" width="23%">
                <a href="adminedititemLar.php?&LarSeq=<?php echo $array['LarSeq']; ?>">修改</a> |
                <a href="adminadditemLar.php?&LarSeq=<?php echo $array['LarSeq']; ?>">增加</a> |
                <a href="adminitem.php?action=delLar&LarSeq=<?php echo $array['LarSeq']; ?>">刪除</a>
              </td>
            </tr>
            <!-------------------------------------------------------------->
            <?php
				$column = "*";
				$table_prodclass		= SYS_DBNAME . ".prodclass";
				$whereClause = "LarSeq='{$array['LarSeq']}'";
				
				$sql['list']['select'] = array(
						'mysql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC", 
						'mssql'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
						'oci8'	=> "SELECT {$column} FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
				);
				$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
				$totalRows_showgoodsRec = sizeof($row_showgoodsRec);
/*
                mysql_select_db($database_webshop, $webshop);
                $query_showgoodsRec = sprintf("SELECT * FROM prodclass WHERE LarSeq = %s ORDER BY MidSeq ASC", 
                                                    GetSQLValueString($row_showitemRec['LarSeq'], "int"));
                $showgoodsRec = mysql_query($query_showgoodsRec, $webshop) or die(mysql_error());
                $row_showgoodsRec = mysql_fetch_assoc($showgoodsRec);
                $totalRows_showgoodsRec = mysql_num_rows($showgoodsRec);
				*/
                if ($totalRows_showgoodsRec > 0) {
					//print_r($row_showgoodsRec); 
                foreach ($row_showgoodsRec as $key => $array1){ ?> 
            <tr align="left" >
                <td align="left" width="77%">&nbsp;&nbsp;&nbsp;
                     <?php 
					 echo $array1['MidSeq']." - ".$array1['MidCode']; ?>
                </td>
                <td align="center" width="23%">
                	<a href="adminedititemMid.php?ClassId=<?php echo $array1['ClassId']; ?>">修改</a> |
                	<a href="adminadditemMid.php?MidSeq=<?php echo $array1['MidSeq']; ?>&LarSeq=<?php echo $array['LarSeq']; ?>">增加</a> |
                    <a href="adminitem.php?action=delMid&ClassId=<?php echo $array1['ClassId']; ?>">刪除</a>
                </td>
            </tr>
            <?php 
                }}?>
          <?php }}?>
            <!-------------------------------------------------------------->
            <tr>
                <td colspan="2" height="10%" align="right"><p>共<?php echo $totalRows_showitemRec; ?> 種分類</p></td>
            </tr>
  
	</form>
</table>
<!------------------------------------------------------------------------------------------------------>
