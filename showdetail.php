<?php  //-----------------------------顯示商品資訊------------------------------------//
if(isset($_SESSION['yuserid']) && isset($_SESSION['ypassword'])){
$_SESSION['MM_Username']=$_SESSION['yuserid'];
}
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
$table_prodSpec		= SYS_DBNAME . ".prodspec";
$column = "*";
$PID=$row_webRec['ProdId'];
$whereClause = "ProdId='{$PID}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}"
);
$query_spec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$query_spec_num = dbGetOne($sql['list']['select'][SYS_DBTYPE]);


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
  if( true )
  {
	  if(isset($_POST['select_spec_1']))
	  {
	  	$table_prodSpec		= SYS_DBNAME . ".prodspec";
	  	$column = "*";
	  	$PID=$_POST['select_spec_1'];
	  	$whereClause = "SpecNum='{$PID}'";
	  	$sql['list']['select'] = array(
				'mysql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
				'mssql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}",
				'oci8'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause}"
			);
	  	$query_spec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
		$goods_price = $query_spec['price'];
		$goods_spec_1 = $query_spec['SpecName'];
	  }
	  else
	  {
		$goods_price = $_POST['goods_price'];
	  }
	  $ord_id = $_POST['ord_id'];
	  $MM_Username = isset( $_SESSION['MM_Username'] )? $_SESSION['MM_Username'] : "guest";
	  $goods_id = $_POST['goods_id'];
	  $goods_name = $_POST['goods_name'];
	  $goods_stand = $_POST['goods_stand'];
	  @$goods_spec_2 = $_POST['select_spec_2'];
	  if($_POST['sgoods_quantity']==0) $goods_quantity = $_POST['goods_quantity'];
	  else $goods_quantity = $_POST['sgoods_quantity'];
	  //echo "1: " . $_POST['select_spec_1'];
	  //echo "2: " . $_POST['select_spec_2'];


	  //判斷購物車裡是否有相同的商品和選項
	  $car_items = $Cart->getAllItems();
	  $is_exits = true;
	  foreach ($car_items as $key => $car_item )
	  {
		  if( strcmp( $car_item->_goods_id, $goods_id ) == 0 && strcmp( $car_item->_goods_spec_1, $goods_spec_1 ) == 0)
		  {
			  $is_exits = false;
		  }
	  }
	  if( $is_exits )
	  {

		  @$Cart->addItem($ord_id, $MM_Username, $goods_id, $goods_name, $goods_price, $goods_stand, $goods_img, $goods_spec_1, $goods_spec_2, $goods_quantity);

          ?>
          <script>
		  alert('已放入購物車');
		  </script>
          <?php
	  }



      $insertGoTo = "car.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
      }

      $url = $insertGoTo;

      echo "<script> location.replace(\"{$url}\"); </script>";

  }
  else {
	echo "<script language=\"javascript\">";
    echo "window.alert(\"請先登入會員\");";
    echo "</script>";
  }
}
?>
<!------------------------------------------------------------------------------- -->
<?php
//-----------------------------新增商品選項----------------------------------
$table_prodSpec		= SYS_DBNAME . ".prodspec";
$column = "*";
$PID=$row_webRec['ProdId'];
$whereClause = "ProdId='{$PID}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1 ASC",
		'mssql'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1 ASC",
		'oci8'	=> "SELECT * FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1 ASC"
);
$query_spec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$num=sizeof($query_spec);
?>

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

<!--h2>目前位置:<a href="index.php">首頁</a>><?php echo $row_showClassRec["LarCode"];?>>><?php echo $row_showClassRec["MidCode"];?>
</h2-->



<?php if($row_webRec["Online"] == 0) {?>
<h3 class="ttl01">對不起，沒有相關資料</h3>

<!----------------------------------------出現簡述(ProdDisc!=0)--------------------------------------- -->
<?php }else if(($row_webRec["ProdDisc"] != "0")){ ?>


<style>
select#soflow, select#soflow-color {
   border: 1px solid #AAA;
   color: #555;
   font-size: inherit;
   margin: 0px;
   overflow: hidden;
   padding: 5px 10px;
   text-overflow: ellipsis;
   white-space: nowrap;
   width: 180px;
}
input.radiobox{
	width:20px;
	height:20px;
}

</style>
<br>
<?php if($num>0){ ?>
<?php foreach($query_spec as $key => $option){ ?>
<input class="radiobox" type="radio" name="select_spec_1" value="<?php echo $option['SpecNum']; ?>" onclick="addinput('<?php echo $option['number']; ?>');"><?php echo $option['SpecName']; ?></br>
<?php } ?>

<?php } ?>
<div id="addinput_area" style="display:none;">
<br><br>
數量:
<input type='button' value='-' class='sqtyminus' field='sgoods_quantity' /><input type='text' name='sgoods_quantity' value='0' class='qty' id='sqty' /><input type='button' value='+' class='sqtyplus' field='sgoods_quantity' />
</div>
<div id="numinput_area" style="display:block;">
<br><br>
數量:
<input type='button' value='-' class='qtyminus' field='goods_quantity' /><!--
    --><input type='text' name="goods_quantity" value='1' class='qty' id='qty' /><!--
--><input type='button' value='+' class='qtyplus' field='goods_quantity' />
</div>
<br><br>
<button type="button" class="btn btn-default btn-block btn-specialcolor" id="p_addcart" colorid="ffffff" gid="MKC-01" imgurl=".jpg" price="1800" onClick="send();">放入購物車</button>
<!--input type="submit" name="buy" id="buy" value="立即購買" style="font-size:16px;width:150px;height:30px"/-->


 <?php }  ?>
<script>
snum=0;
function addinput(num)
{
	snum=num;
	if(snum>0)
	{
		$('#addinput_area').css('display','');
		$('#numinput_area').css('display','none');
		$('#sqty').val(snum);
	}else
	{
		$('#addinput_area').css('display','none');
		$('#numinput_area').css('display','');
		$('#sqty').val(0);
	}
}
function send()
{
	qty=$("#qty").val();
	sqty=$("#sqty").val();
	if(isNaN(qty) || qty<=0)
	{
		$("#qty").val(1);
	}
	else if(isNaN(sqty) || parseInt(sqty) < parseInt(snum))
	{
		alert('數量最少為'+snum+"斤");
		$("#sqty").val(snum);
	}
	else
	{

		document.addgoods.submit();

	}
}
</script>

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
