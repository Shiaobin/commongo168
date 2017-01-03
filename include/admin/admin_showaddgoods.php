<?php include("small.php"); ?>
<?php  //-----------------------------新增商品資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "新增") && ($_POST['ProdId'] != "") && ($_POST['ProdName'] != "") && ($_POST['PriceList'] != "") && ($_POST['LarCode'] != "") && ($_POST['MidCode'] != "")) {

  $img_string = array();

  //上傳圖片
  foreach ($_FILES["ImgPrev"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
     // echo"$error_codes[$error]";
	  $num =  date('ymdhis') + $key;
	  //$num1 = $key + $num + $key*2 + date('ymdhis');
	  $img_string[$key] = $num.".jpg";

      move_uploaded_file(
        realpath($_FILES["ImgPrev"]["tmp_name"][$key]),
         "../images/goodsimg/".$img_string[$key]
         //"/var/www/html/sample/images/webimg/".$img_string[$key]
      ) or die("Problems with upload");

      resize_goods_image($img_string[$key]);
    }
  }
  print_r($_POST);
  //未上傳圖片使用預設(none.gif)imgfull
  if($num == ""){
  //更新商品資訊
  $table_prodmain		= SYS_DBNAME . ".prodmain";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'ProdName' => $_POST['ProdName'],
				'PriceOrigin' => $_POST['PriceOrigin'],
				'Quantity' => $_POST['Quantity'],
				'ProdDisc' =>  $_POST['ProdDisc'],
				'Model' =>  $_POST['Model'],
				'MemoSpec' =>  $_POST['MemoSpec'],
				'LarCode' =>  $_POST['LarCode'],
				'MidCode' =>  $_POST['MidCode'],
				'paybackurl' =>  $_POST['paybackurl'],
				'Remark' =>  $_POST['Remark'],
				'tejia' =>  $_POST['tejia'],
				'ImgFull' =>  'none.gif'
				);
  dbInsert( $table_prodmain, $record );
  /*
  $insertSQL = sprintf("INSERT INTO prodmain (ProdId, ProdName, PriceOrigin, PriceList,  Quantity, ProdDisc, Model, MemoSpec,
                        LarCode, MidCode,  paybackurl, Remark, tejia, ImgFull) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 'none.gif')",
                        GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($_POST['ProdName'], "text"),
                        GetSQLValueString($_POST['PriceOrigin'], "int"),
					    GetSQLValueString($_POST['PriceList'], "int"),
					    GetSQLValueString($_POST['Quantity'], "int"),
					    GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['Model'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
                        GetSQLValueString($_POST['LarCode'], "text"),
					    GetSQLValueString($_POST['MidCode'], "text"),
					    GetSQLValueString($_POST['paybackurl'], "text"),
					    GetSQLValueString($_POST['Remark'], "tinyint"),
					    GetSQLValueString($_POST['tejia'], "tinyint"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  $post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  echo "post_spec1_text size: " . sizeof($post_spec1_text);
  echo "post_spec2_text size: " . sizeof($post_spec2_text);
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'ProSerial_1' => $i + 1,
					'ProSerial_2' => "0",
					'SpecName' => $post_spec1_text[$i],
					'created_date' =>  now(),
					'updated_date' => now(),
					'opertor' =>  "admin"
					);
	  dbInsert( $table_prodSpec, $record );
	  /*
	  $updateSQL = sprintf("INSERT INTO prodSpec (ProdId, ProSerial_1, ProSerial_2, SpecName, created_date, updated_date, opertor) VALUES (%s, %s, %s, %s, %s, %s, %s)",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text"),
                        GetSQLValueString("0", "text"),
                        GetSQLValueString($post_spec1_text[$i], "text"),
                        GetSQLValueString(now(), "date"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'ProSerial_1' => "0",
					'ProSerial_2' => $i + 1,
					'SpecName' => $post_spec2_text[$i],
					'created_date' =>  now(),
					'updated_date' => now(),
					'opertor' =>  "admin"
					);
	  dbInsert( $table_prodSpec, $record );
	  /*
	  $updateSQL = sprintf("INSERT INTO prodSpec (ProdId, ProSerial_1, ProSerial_2, SpecName, created_date, updated_date, opertor) VALUES (%s, %s, %s, %s, %s, %s, %s)",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString("0", "text"),
						GetSQLValueString($i + 1, "text"),
						GetSQLValueString($post_spec2_text[$i], "text"),
                        GetSQLValueString(now(), "date"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  */
  }

  $table_prod_img		= SYS_DBNAME . ".prod_img";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'img_name' => 'none.gif'
					);
	  dbInsert( $table_prod_img, $record );
	/*
  $insertSQL = sprintf("INSERT INTO prod_img (ProdId, img_name) VALUES (%s, 'none.gif')",
                          GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  //有上傳圖片
  }else{
	  $table_prodmain		= SYS_DBNAME . ".prodmain";
  $record = array(
  				'ProdId' => $_POST['ProdId'],
				'ProdName' => $_POST['ProdName'],
				'PriceOrigin' => $_POST['PriceOrigin'],
				'Quantity' => $_POST['Quantity'],
				'ProdDisc' =>  $_POST['ProdDisc'],
				'Model' =>  $_POST['Model'],
				'MemoSpec' =>  $_POST['MemoSpec'],
				'LarCode' =>  $_POST['LarCode'],
				'MidCode' =>  $_POST['MidCode'],
				'paybackurl' =>  $_POST['paybackurl'],
				'Remark' =>  $_POST['Remark'],
				'tejia' =>  $_POST['tejia'],
				'ImgFull' =>  $img_string[0]
				);
  dbInsert( $table_prodmain, $record );
  /*
  $insertSQL = sprintf("INSERT INTO prodmain (ProdId, ProdName, PriceOrigin, PriceList,  Quantity, ProdDisc, Model, MemoSpec,
                        LarCode, MidCode,  paybackurl, Remark, tejia, ImgFull) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                        GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($_POST['ProdName'], "text"),
                        GetSQLValueString($_POST['PriceOrigin'], "int"),
					    GetSQLValueString($_POST['PriceList'], "int"),
					    GetSQLValueString($_POST['Quantity'], "int"),
					    GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['Model'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
                        GetSQLValueString($_POST['LarCode'], "text"),
					    GetSQLValueString($_POST['MidCode'], "text"),
					    GetSQLValueString($_POST['paybackurl'], "text"),
					    GetSQLValueString($_POST['Remark'], "tinyint"),
					    GetSQLValueString($_POST['tejia'], "tinyint"),
						GetSQLValueString($img_string[0], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  $post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'ProSerial_1' => $i + 1,
					'ProSerial_2' => "0",
					'SpecName' => $post_spec1_text[$i],
					'created_date' =>  now(),
					'updated_date' => now(),
					'opertor' =>  "admin"
					);
	  dbInsert( $table_prodSpec, $record );
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'ProSerial_1' => "0",
					'ProSerial_2' => $i + 1,
					'SpecName' => $post_spec2_text[$i],
					'created_date' =>  now(),
					'updated_date' => now(),
					'opertor' =>  "admin"
					);
	  dbInsert( $table_prodSpec, $record );

  }
  }

  if($_POST['LarCode']=="") $_POST['LarCode'] = 0;
  if(count($img_string) > 0) $img = $img_string[0];
  else                       $img = "";





  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	  $table_prod_img		= SYS_DBNAME . ".prod_img";
	  $record = array(
					'ProdId' => $_POST['ProdId'],
					'img_name' => $img_string[$i]
					);
	  dbInsert( $table_prod_img, $record );
	 /*
    $insertSQL = sprintf("INSERT INTO prod_img (ProdId, img_name) VALUES (%s, %s)",
                          GetSQLValueString($_POST['ProdId'], "text"),
		     			  GetSQLValueString($img_string[$i], "text"));

    mysql_select_db($database_webshop, $webshop);
    $Result2 = mysql_query($insertSQL, $webshop) or die(mysql_error());
	*/
  }


  $insertGoTo = "admingoods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header('Location:'.$insertGoTo);
}

?>
<?php  //-----------------------------重設商品資訊------------------------------------//
if ((isset($_POST["MM_reset"])) && ($_POST["MM_reset"] == "重設")) {
  $endItemRec = "";
}
?>
<?php  //---------------------------取得商品類別(大類)---------------------------------//
/*
  mysql_select_db($database_webshop, $webshop);
  $query_itemRec = "SELECT DISTINCT LarCode FROM prodclass ORDER BY LarSeq ASC";
  $itemRec = mysql_query($query_itemRec, $webshop) or die(mysql_error());
  $row_itemRec = mysql_fetch_assoc($itemRec);
  $totalRows_itemRec = mysql_num_rows($itemRec);
  */
  $table_prodclass		= SYS_DBNAME . ".prodclass";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT DISTINCT LarCode FROM {$table_prodclass} ORDER BY LarSeq ASC",
		  'mssql'	=> "SELECT DISTINCT LarCode FROM {$table_prodclass} ORDER BY LarSeq ASC",
		  'oci8'	=> "SELECT DISTINCT LarCode FROM {$table_prodclass} ORDER BY LarSeq ASC"
		  );
  $row_itemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_itemRec = sizeof($row_itemRec);

?>

<?php  //---------------------------更新商品類別(中類)---------------------------------//
$row_endItemRec = -1;
if(isset($_POST['LarCode'])){
  $class = $_POST['LarCode'];
/*
  mysql_select_db($database_webshop, $webshop);
  $query_endItemRec = sprintf("SELECT * FROM prodclass where LarCode = %s ORDER BY MidSeq ASC",
                               GetSQLValueString($_POST['LarCode'], "text"));
  $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
  $row_endItemRec = mysql_fetch_assoc($endItemRec);
  $totalRows_endItemRec = mysql_num_rows($endItemRec);
  */
  $table_prodclass		= SYS_DBNAME . ".prodclass";
$whereClause = "LarCode='{$_POST['LarCode']}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'mssql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC",
		'oci8'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY MidSeq ASC"
		);
$row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
$totalRows_endItemRec = sizeof($row_endItemRec);
}
else{
  $class = 0;
}
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >新增上架商品</h3>
<script>
$( document ).ready(function()
{
  	$('#addgoods').submit(function()
  	{
		$.each( document.getElementsByName("pro_spec1_text[]"), function( i, param )
		{
			$('<input />').attr('type', 'hidden')
				.attr( 'name', "post_spec1_text[]" )
				.attr( 'value', param.value )
				.appendTo('#addgoods' );
		});
		$.each( document.getElementsByName("pro_spec2_text[]"), function( i, param )
		{
			$('<input />').attr('type', 'hidden')
				.attr( 'name', "post_spec2_text[]" )
				.attr( 'value', param.value )
				.appendTo('#addgoods' );
		});
   		return true;
	});
});

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">

<form name="addgoods" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="addgoods">
  <tr>
    <td>1.所屬大類<font color="#FF3333">  *</font>
      <select id="LarCode" name="LarCode" onchange="this.form.submit()"
              style="width:20%; height:90%; margin: 3px">
      <option value="0"></option>
      <?php
	    foreach ($row_itemRec as $key => $array){
	  ?>
        <option value="<?php echo $array['LarCode']?>" <?php if($array['LarCode'] == $class) {echo "selected=\"selected\"";} ?>>
		<?php echo $array['LarCode']?></option>
      <?php
      }

      ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>
    <td>2.所屬中類<font color="#FF3333">  *</font>
      <select id="MidCode" name="MidCode" style="width:50%; height:90%; margin: 3px">
      <?php
	     foreach ($row_endItemRec as $key => $array){
	  ?>
        <option value="<?php echo $array['MidCode']?>"><?php echo $array['MidCode']?></option>
      <?php
      }
      ?>
      </select>
    </td>
  </tr>
  <!----------------------------商品上傳---------------------------->
  <tr>
    <td>3.商品圖片:
      <input name="ImgPrev[]" type="file" value="Select a File..." style="width:50%; height:90%; margin: 3px" multiple/>
    </td>
  </tr>
  <!----------------------------商品編號---------------------------->
  <tr>
    <td>4.商品編號:<font color="#FF3333">  *</font>
      <input id="ProdId" name="ProdId" type="text" class=sizeS value="<?php echo date('ymdhis'); ?>" />[一旦確定將不能修改且不可重複]</td>
  </tr>
  <!----------------------------商品名稱---------------------------->
  <tr>
    <td>5.商品名稱:<font color="#FF3333">  *</font>
      <input id="ProdName" name="ProdName" type="text" class=sizeM /></td>
  </tr>
  <!----------------------------商品型號---------------------------->
  <tr>
    <td>6.商品型號:
      <input id="Model" name="Model" type="text" class=sizeS value="<?php echo date('ymdhis'); ?>" />
    </td>
  </tr>
  <!----------------------------市場價---------------------------->
  <tr>
    <td>7.市場價:
      <input id="PriceOrigin" name="PriceOrigin" type="text" class=sizeSss value=0 />元 [如'0' 則不顯示]</td>
  </tr>
  <!----------------------------熱賣價---------------------------->
  <tr>
    <td>8.熱賣價:<font color="#FF3333">  *</font>
      <input id="PriceList" name="PriceList" type="text" class=sizeSss value=0 />元 [如'0' 則顯示：請咨詢客服]</td>
  </tr>
  <!----------------------------庫存數---------------------------->
  <tr>
    <td>9.庫存數:
      <input id="Quantity" name="Quantity" type="text" class=sizeSss value=99999 />個 [如'0' 則顯示：已售完]</td>
  </tr>
  <!----------------------------商品簡介---------------------------->
  <tr>
    <td>10.商品簡介:<br>
       <textarea id="ProdDisc" name="ProdDisc" cols="50" rows="10" ></textarea>
     </td>
  </tr>
  <!----------------------------詳細說明---------------------------->
  <tr>
    <td>11.詳細說明:
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>
      <textarea id="MemoSpec" name="MemoSpec" cols="50" rows="20" >
	  <?php
	  if( !empty($_POST['MemoSpec']) )
		echo stripslashes($_POST['MemoSpec']);
	  else
		echo "請在此輸入文字";
      ?>
     </textarea>
     <script type="text/javascript">
       CKEDITOR.replace( 'MemoSpec' );
     </script>
   </td>
  </tr>
  <!----------------------------支付返回---------------------------->
  <tr>
    <td>12.支付返回:
      <input id="paybackurl" name="paybackurl" type="text" class=sizeM />[在線支付後的返回頁面]</td>
  </tr>
  <!----------------------------設為推薦商品---------------------------->
  <tr>
    <td>13.設為推薦商品:
      <label>
        <input type="radio" name="Remark" value="0" id="Remark_0" style="margin-left: 3px" checked/>
        否</label>
      <label>
        <input type="radio" name="Remark" value="1" id="Remark_1" style="margin-left: 3px" />
        是</label>
    </td>
  </tr>
  <!----------------------------設為特價商品---------------------------->
  <tr>
    <td>14.設為特價商品:
      <label>
        <input type="radio" name="tejia" value="0" id="tejia _0" style="margin-left: 3px" checked/>
        否</label>
      <label>
        <input type="radio" name="tejia" value="1" id="tejia _1" style="margin-left: 3px"/>
        是</label>
    </td>
  </tr>
  <!----------------------------設定類型1---------------------------->
  <tr>
    <td>15.設定類型1
    <table id="table_pro_spec_1" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable"  name="table_pro_spec_1">
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec1_text[]" style="margin-left: 3px"/>
            </label>
            <label>
              <input type="button" name="pro_spec1_plus[]" value="+" onClick="addTableField(this)" style="width: 20px;"/>
            </label>
            </td>
         </tr>
    </table>
    </td>
  </tr>
  <!----------------------------設定類型2---------------------------->
  <tr>
    <td>16.設定類型2
      <table id="table_pro_spec_2" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" name="table_pro_spec_2">
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec2_text[]" style="margin-left: 3px"/>
            </label>
            <label>
              <input type="button" name="pro_spec2_plus[]" value="+" onClick="addTableField(this)" style="width: 20px;"/>
            </label>
            </td>
         </tr>
      </table>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input type="submit" name="MM_insert"  value="新增" style="font-size:16px;width:60px;height:30px" />
      <input type="reset" name="MM_reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
</form>
</table>
<!--------------------------release--------------------------->
<script>
function addTableField( aContext )
{
	aContext.style.visibility = "hidden";
	var table_id = "";
	var parent = aContext.parentNode;
	while (parent) //find table id
	{ //Loop through until you find the desired parent tag name
		if (parent.tagName && parent.tagName.toLowerCase() == "table")
		{
			table_id = parent.id;
			break;
		}
		else
		{
			parent = parent.parentNode;
		}
	}
	var table = document.getElementById(table_id);

	var langth = table.getElementsByTagName("tr").length;
	var row = table.insertRow(langth);
	var cell1 = row.insertCell(0);

	// Add some text to the new cells:
	cell1.innerHTML = '<label><input type="text" name="pro_spec' + table_id.split("_")[3] + '_text[]" style="margin-left: 3px"/>' +
						'</label><label><input type="button" name="pro_spec' + table_id.split("_")[3] + '_plus2" value="+" onClick="addTableField(this)" style="margin-left: 3px; width: 20px;"/> </label>';
	var h = 'name="pro_spec' + table_id.split("_")[3] + '_text[]"';
}
</script>
<?php

?>
