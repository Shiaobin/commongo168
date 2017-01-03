<?php  //-----------------------------顯示網頁資訊------------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
//$sysConnDebug = true;
$LarCode = "-1";
if (isset($_GET['LarCode'])) {
  $LarCode = $_GET['LarCode'];
}
$MidCode = "-1";
if (isset($_GET['MidCode'])) {
  $MidCode = $_GET['MidCode'];
}
$ProdNum = "-1";
if (isset($_GET['ProdNum'])) {
  $ProdNum = $_GET['ProdNum'];
}
$snum = "-1";
if (isset($_GET['snum'])) {
  $snum = $_GET['snum'];
}
if(($ProdNum)=="-1"){
  $column = "*";
  $table_compmain		= SYS_DBNAME . ".compmain";
  $whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}' AND Online='1'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC"
  );

  $row_webRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
  mysql_select_db($database_webshop, $webshop);
  $query_webRec = sprintf("SELECT * FROM compmain
  LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId
  WHERE LarCode=%s && MidCode=%s && Online='1'
  order by img_no ASC",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"));
  $webRec = mysql_query($query_webRec, $webshop) or die(mysql_error());
  $row_webRec = mysql_fetch_assoc($webRec);
  */

}else{
  $column = "*";
  $table_compmain		= SYS_DBNAME . ".compmain";
  $whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}' AND ProdNum={$ProdNum} AND Online='1'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_compmain} LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC"
  );

  $row_webRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
  mysql_select_db($database_webshop, $webshop);
  $query_webRec = sprintf("SELECT * FROM compmain
  LEFT JOIN comp_img ON comp_img.ProdId = compmain.ProdId
  WHERE LarCode=%s && MidCode=%s && ProdNum=%s && Online='1'
  order by img_no ASC",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"),GetSQLValueString($ProdNum, "int"));
  $webRec = mysql_query($query_webRec, $webshop) or die(mysql_error());
  $row_webRec = mysql_fetch_assoc($webRec);
  */
}

?>
<?php  //------------------------------取得網頁大項資訊------------------------------//
  $column = "*";
  $table_compclass		= SYS_DBNAME . ".compclass";
  $whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'mssql'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}",
		  'oci8'	=> "SELECT {$column} FROM {$table_compclass} WHERE {$whereClause}"
  );

  $row_showClassRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
mysql_select_db($database_webshop, $webshop);
$query_showClassRec = sprintf("SELECT * FROM compclass WHERE LarCode=%s AND MidCode=%s",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"));
$showClassRec = mysql_query($query_showClassRec, $webshop) or die(mysql_error());
$row_showClassRec = mysql_fetch_assoc($showClassRec);
*/
?>
<!--------------------------------------------------------------------------------->
<script type="text/javascript" src="include/thickbox/jquery.js"></script>
<script type="text/javascript" src="include/thickbox/thickbox.js"></script>
<link rel="stylesheet" href="include/thickbox/thickbox.css" type="text/css" media="screen" />

<h3 class="ttl01">目前位置:<a href="index.php">首頁</a>>><?php echo $row_showClassRec["LarCode"];?>>><?php echo $row_showClassRec["MidCode"];?></h3>

<table width="100%" height="94%" cellpadding="0" border="0" class="tableLayout02" >

  <tr>
    <td>
    <!--------------------------------------------------------------------------------->
    	<table width="100%" height="100%" cellpadding="5" border="0">
             <!--------------------------------------------------------------------------------->
             <tr align="center">
             	<td>
                <?php if (($row_webRec["Online"] == 0) || ($row_webRec["MemoSpec"] == "")) {?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
    				<tr align="center">
    					<td>對不起，沒有相關資料</td>
        			</tr>
    			</table>
                </td>
             </tr>
             <!----------------------------------------出現簡述(ProdDisc!=0)----------------------------------------->
                <?php }else{ ?>
             <tr>
                <td>
					<?php if(($row_webRec["ProdDisc"] != "0") && ($snum != 1)){ ?>
                        <table width="100%" height="250px" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <td><?php echo $row_webRec["ProdDisc"];?></td>
                           <?php if(($row_webRec["img_name"] != "")){ ?>
                           <td width="300px">
                           	<img src="../../images/webimg/medium/<?php echo $row_webRec["ImgFull"]; ?>" alt="" name="image" width="300px" id="image" align="center" style="padding:5px;"/>
                           </td>
                           <?php } ?>
                        </tr>
                        </table>
                        <?php echo $row_webRec["MemoSpec"];?>
             <!----------------------------------------出現簡述(ProdDisc=0)----------------------------------------->
                    <?php }else{
                            echo $row_webRec["MemoSpec"];
                          } ?>
				<?php }?>
                </td>
            </tr>
        </table>

<?php  //-----------------------------取得商品圖片------------------------------------//
$id = $row_webRec["ProdId"];
  $column = "*";
  $table_comp_img		= SYS_DBNAME . ".comp_img";
  $whereClause = "ProdId='{$id}'";

  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'mssql'	=> "SELECT {$column} FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_comp_img} WHERE {$whereClause} ORDER BY img_no ASC"
  );

  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
$query_showimgRec = sprintf("SELECT * FROM comp_img WHERE ProdId='$id' order by img_no ASC", GetSQLValueString($cloume_showImgRec, "text"));
$showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
$row_showimgRec = mysql_fetch_assoc($showimgRec);
*/
$totalRows_showimgRec = sizeof($row_showimgRec);
?>

<?php if($totalRows_showimgRec > 0) { ?>

        <?php foreach ($row_showimgRec as $key => $array){ ?>

<span class="TB_Image"><a href='../../showwebpic.php?pic=<?php echo $array['img_name']; ?>&keepThis=true&TB_iframe=true&height=500&width=600' class='thickbox' >
<img src="../../images/webimg/small/<?php echo $array['img_name']; ?>" alt="<?php echo $array['ProdDisc']; ?>" name="image" id="image" style="padding:2px;"/></a></span>

        <?php } ?>

  <?php } ?>
    <!--------------------------------------------------------------------------------->
    </td>
  </tr>
</table>
<?php
//mysql_free_result($webRec);
//mysql_free_result($showClassRec);
?>
