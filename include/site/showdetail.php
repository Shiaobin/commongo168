<?php  //-----------------------------顯示商品資訊------------------------------------//

$currentPage = $_SERVER["PHP_SELF"];

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

$table_prodmain		= SYS_DBNAME . ".prodmain";
$column = "*";
$whereClause = "LarCode='{$LarCode}' && MidCode='{$MidCode}' && ProdNum={$ProdNum} && Online='1'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		'mssql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC",
		'oci8'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC"
);
$row_webRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_webRec = sprintf("SELECT * FROM prodmain
LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId
WHERE LarCode=%s && MidCode=%s && ProdNum=%s && Online='1'
order by img_no ASC",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"),GetSQLValueString($ProdNum, "int"));
$webRec = mysql_query($query_webRec, $webshop) or die(mysql_error());
$row_webRec = mysql_fetch_assoc($webRec);
*/
?>
<?php //-------------------------------更新人氣值------------------------------------//
//print_r($row_webRec);
if (isset($_GET['LarCode']) && ($_GET['MidCode'])) {
	$whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}'";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT ClickTimes FROM {$table_prodmain} WHERE {$whereClause}",
			'mssql'	=> "SELECT ClickTimes FROM {$table_prodmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT ClickTimes FROM {$table_prodmain} WHERE {$whereClause}"
	);
	$cktimes = dbGetOne($sql['list']['select'][SYS_DBTYPE]);

	$record = array( 'ClickTimes' => $cktimes + 1);
	dbUpdate($table_prodmain, $record, $whereClause);
	/*
  $updateSQL = sprintf("UPDATE prodmain SET ClickTimes=ClickTimes+1 where LarCode=%s AND MidCode=%s",
					    GetSQLValueString($_GET['LarCode'], "text"),
						GetSQLValueString($_GET['MidCode'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
}
?>
<?php  //----------------------------取得設置資訊--------------------------------//
$table_shopsetup		= SYS_DBNAME . ".shopsetup";
$column = "*";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shopsetup} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_shopsetup} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_shopsetup} WHERE {$whereClause}"
);
$row_showconfigRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

  //mysql_select_db($database_webshop, $webshop);
  //$query_showconfigRec = "SELECT * FROM shopsetup";
  //$showconfigRec = mysql_query($query_showconfigRec, $webshop) or die(mysql_error());
  //$row_showconfigRec = mysql_fetch_assoc($showconfigRec);
  $totalRows_showconfigRec = sizeof($row_showconfigRec);
?>
<?php  //------------------------------取得網頁大項資訊------------------------------//
$table_prodclass		= SYS_DBNAME . ".prodclass";
$column = "*";
$whereClause = "LarCode='{$LarCode}' AND MidCode='{$MidCode}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}"
);
$row_showClassRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showClassRec = sprintf("SELECT * FROM prodclass WHERE LarCode=%s AND MidCode=%s",GetSQLValueString($LarCode, "text"),GetSQLValueString($MidCode, "text"));
$showClassRec = mysql_query($query_showClassRec, $webshop) or die(mysql_error());
*/
//$row_showClassRec = sizeof($showClassRec);
?>
<?php  //-----------------------------新增商品至購物車----------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//-----------------------------新增商品選項----------------------------------//
$table_prodSpec		= SYS_DBNAME . ".prodSpec";
$column = "*";
$whereClause = "ProdId='{$row_webRec['ProdId']}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}"
);
$query_spec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = sprintf("SELECT * FROM prodSpec
WHERE ProdId=%s", GetSQLValueString($row_webRec['ProdId'], "text"));
$query_spec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
*/
$arr_pro_spec_1 = array(); $arr_pro_spec_2 = array();
foreach ($query_spec as $key => $row_showgoodsRec)
{
	if( $row_showgoodsRec['ProSerial_1'] == 0 )
	{
		array_push( $arr_pro_spec_2, $row_showgoodsRec['SpecName'] );
	}
	else if( $row_showgoodsRec['ProSerial_2'] == 0 )
	{
		array_push( $arr_pro_spec_1, $row_showgoodsRec['SpecName'] );
	}
}
// -------------------------------------------------------------------------------//
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "addgoods")) {
  if( true ) {
	  /*
      $insertSQL = sprintf("INSERT INTO shop_car (ord_id, mem_no, goods_id, goods_name, goods_price, goods_stand, ord_sum, goods_img) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                            GetSQLValueString($_POST['ord_id'], "text"),
					        GetSQLValueString($_SESSION['MM_Username'], "text"),
                            GetSQLValueString($_POST['goods_id'], "text"),
                            GetSQLValueString($_POST['goods_name'], "text"),
                            GetSQLValueString($_POST['goods_price'], "int"),
                            GetSQLValueString($_POST['goods_stand'], "text"),
					        GetSQLValueString($_POST['goods_price'], "int"),
							GetSQLValueString($_POST['goods_img'], "int"));

      mysql_select_db($database_webshop, $webshop);
      $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  	*/
	  $ord_id = $_POST['ord_id'];
	  $MM_Username = isset( $_SESSION['MM_Username'] )? $_SESSION['MM_Username'] : "guest";
	  $goods_id = $_POST['goods_id'];
	  $goods_name = $_POST['goods_name'];
	  $goods_price = $_POST['goods_price'];
	  $goods_stand = $_POST['goods_stand'];
	  $goods_price = $_POST['goods_price'];
	  $goods_spec_1 = $_POST['select_spec_1'];
	  $goods_spec_2 = $_POST['select_spec_2'];
	  echo "1: " . $_POST['select_spec_1'];
	  echo "2: " . $_POST['select_spec_2'];


	  //判斷購物車裡是否有相同的商品和選項
	  $car_items = $Cart->getAllItems();
	  $is_exits = false;
	  foreach ($car_items as $key => $car_item )
	  {
		  if( strcmp( $car_item->_goods_spec_1, $goods_spec_1 ) == 0 && strcmp( $car_item->_goods_spec_2, $goods_spec_2 ) == 0 )
		  {
			  $is_exits = true;
		  }
	  }
	  if( !$is_exits )
	  {
		  $Cart->addItem($ord_id, $MM_Username, $goods_id, $goods_name, $goods_price, $goods_stand, $goods_img, $goods_spec_1, $goods_spec_2);
	  }



      $insertGoTo = "car.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }

      $url = $insertGoTo;

      echo "<script type='text/javascript'>";
      echo "window.location.href='$url'";
      echo "</script>";
	  /**/
  }
  else {
	echo "<script language=\"javascript\">";
    echo "window.alert(\"請先登入會員\");";
    echo "</script>";
  }
}
?>
<!--------------------------------------------------------------------------------->
<script type="text/javascript" src="include/thickbox/jquery.js"></script>
<script type="text/javascript" src="include/thickbox/thickbox.js"></script>
<link rel="stylesheet" href="include/thickbox/thickbox.css" type="text/css" media="screen" />
<script>
$( document ).ready(function()
{
	<?php for( $i = 0; $i < sizeof( $arr_pro_spec_1 ); $i++ ){?>
		$("#select_spec_1").append("<option value='<?php echo $arr_pro_spec_1[$i]?>'><?php echo $arr_pro_spec_1[$i]?></option>")
	<?php } ?>
	<?php for( $i = 0; $i < sizeof( $arr_pro_spec_2 ); $i++ ){?>
		$("#select_spec_2").append("<option value='<?php echo $arr_pro_spec_2[$i]?>'><?php echo $arr_pro_spec_2[$i]?></option>")
	<?php } ?>

});
</script>
<form action="<?php echo $editFormAction; ?>" name="addgoods" method="POST" enctype="multipart/form-data" id="addgoods">

<h2>目前位置:<a href="index.php">首頁</a>><?php echo $row_showClassRec["LarCode"];?>>><?php echo $row_showClassRec["MidCode"];?>
</h2>
 <div id="productArea">


                <?php if (($row_webRec["Online"] == 0) || ($row_webRec["MemoSpec"] == "")) {?>
<h3 class="ttl01">對不起，沒有相關資料</h3>

<!----------------------------------------出現簡述(ProdDisc!=0)----------------------------------------->
<?php }else{ ?>
<?php if(($row_webRec["ProdDisc"] != "0")){ ?>
<h3 class="ttl01"><?php echo $row_webRec["ProdName"]; ?></h3>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<tr>
<th>產品名稱</th>
<td><?php echo $row_webRec["ProdName"];?></td>
</tr>
<tr>
<th>編號</th>
<td><?php echo $row_webRec["ProdId"];?></td>
</tr>
<tr>
<th>產品</th>
<td><?php echo $row_webRec["ProdDisc"];?></td>
</tr>
<tr>
<th>價格:</th>
<td>NT$<?php echo $row_webRec["PriceList"];?></td>
</tr>
<tr>
<th>選項:</th>
<td><select name="select_spec_1" id="select_spec_1"></select><select name="select_spec_2" id="select_spec_2"></select></td>

</tr>

<tr>
<th></th>
<td><input type="submit" name="buy" id="buy" value="立即購買" style="font-size:16px;width:150px;height:30px"/></td>
</tr>
</table>


<?php  //-----------------------------取得商品圖片------------------------------------//
$id = $row_webRec["ProdId"];
$table_prod_img		= SYS_DBNAME . ".prod_img";
$column = "*";
$whereClause = "ProdId='{$id}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}"
);
$row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

/*
$query_showimgRec = sprintf("SELECT * FROM prod_img WHERE ProdId='$id' order by img_no ASC", GetSQLValueString($cloume_showImgRec, "text"));
$showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
$row_showimgRec = mysql_fetch_assoc($showimgRec);
*/
$totalRows_showimgRec = sizeof($row_showimgRec);
?>

<?php if($totalRows_showimgRec > 0) { ?>

        <?php foreach ($row_showimgRec as $key => $array) { ?>

<span class="TB_Image"><a href='../../showpic.php?pic=<?php echo $array['img_name']; ?>&keepThis=true&TB_iframe=true&height=500&width=600' class='thickbox' >
<img src="../../images/goodsimg/small/<?php echo $array['img_name']; ?>" alt="$row_showimgRec['ProdDisc']" name="image" id="image" style="padding:2px;"/></a></span>

        <?php }  ?>

  <?php } ?>

<?php if(($row_webRec["img_name"] != "")){ ?>

<input name="goods_img" type="hidden" value="<?php echo $row_webRec['img_name']; ?>" />

<?php } ?>



<p>  <?php echo $row_webRec["MemoSpec"];?>
                    <?php }else{
                            echo $row_webRec["MemoSpec"];
                          } ?>
				<?php }?></p>
<p class="txt">本商品瀏覽次數: <?php echo $row_webRec["ClickTimes"];?> 次 </p>


      <input name="goods_id" type="hidden" id="goods_id" value="<?php echo $row_webRec['ProdId']; ?>" />
      <input name="goods_name" type="hidden" id="goods_name" value="<?php echo $row_webRec['ProdName']; ?>" />
      <input name="goods_stand" type="hidden" id="goods_stand" value="<?php echo $row_webRec['ProdDisc']; ?>" />
      <input name="goods_price" type="hidden" id="goods_price" value="<?php echo $row_webRec['PriceList']; ?>" />
      <input name="ord_id" type="hidden" id="ord_id" value="<?php if(isset($_SESSION['MM_Username'])) echo date('Ymdhis').$_SESSION['MM_Username'];
							                                      else echo $_SESSION['tempord_id'];?>" />
      <input type="hidden" name="MM_insert" value="addgoods" />

</form>

<?php
//mysql_free_result($webRec);
//mysql_free_result($showClassRec);
?>
