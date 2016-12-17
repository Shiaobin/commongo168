<?php include("small.php"); ?>
<?php  //-----------------------------更新商品資訊------------------------------------//
//$sysConnDebug = true;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if( isset($_POST ) )
{
	echo "";
	//print_r($_POST);
}
else
{
	echo "";	
}
if ((isset($_POST["update_pages"])) && ($_POST["update_pages"] == "更新")) {	
  //move_uploaded_file($_FILES["pages_img"]["tmp_name"], "..\webimg\pagesimg\\".$_FILES["pages_img"]["name"].".jpg");
  $img_string = array();
  //print_r($_POST['post_spec1_text']);
  //上傳圖片
  foreach ($_FILES["goods_img"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {	 
       //echo"$error_codes[$error]";
	   $num =  date('his') + $key;
	   $img_string[$key] = $num.".jpg";

       move_uploaded_file(
         realpath($_FILES["goods_img"]["tmp_name"][$key]), 
         //"/var/www/html/sample/images/webimg/".$img_string[$key]
         "../images/goodsimg/".$img_string[$key]
       ) or die("Problems with upload");

       resize_goods_image($img_string[$key]);
    }
  }
  
  //取得首張圖片資訊
  if($_POST["img_num"] > 0) {
	$cloume_showImgRec = "%";
	if (isset($_GET['ProdId'])) {
      $cloume_showImgRec = $_GET['ProdId'];
    }
	$column = "*";
	$table_prod_img		= SYS_DBNAME . ".prod_img";
	$whereClause = "ProdId='{$cloume_showImgRec}'";

	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
	);
	$row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	/*  
    mysql_select_db($database_webshop, $webshop);
    $query_showimgRec = sprintf("SELECT * FROM prod_img WHERE ProdId=%s order by img_no ASC",GetSQLValueString($cloume_showImgRec, "text"));
    $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
    $row_showimgRec = mysql_fetch_assoc($showimgRec);
	*/
	$img = $row_showimgRec["img_name"];
  }
  else if(count($img_string) > 0)  $img = $img_string[0];
  else                             $img = "";    
  
  
  
  //預設圖片
  if($img == ""){
	  $table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'PriceList' => $_POST['PriceList'],
		  'Quantity' => $_POST['Quantity'],
		  'ProdDisc' => $_POST['ProdDisc'],
		  'Model' => $_POST['Model'],
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia'],
		  'ImgFull' => 'none.gif'
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );
	/*  
  $updateSQL = sprintf("UPDATE prodmain SET ProdId=%s, ProdName=%s, PriceOrigin=%s, PriceList=%s, Quantity=%s, ProdDisc=%s, Model=%s, MemoSpec=%s, LarCode=%s, MidCode=%s, paybackurl=%s, Remark=%s, tejia=%s, ImgFull='none.gif' WHERE ProdId=%s",
                        GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($_POST['ProdName'], "text"),
                        GetSQLValueString($_POST['PriceOrigin'], "double"),
			GetSQLValueString($_POST['PriceList'], "double"),
			GetSQLValueString($_POST['Quantity'], "int"),
			GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['Model'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
                        GetSQLValueString($_POST['LarCode'], "text"),
			GetSQLValueString($_POST['MidCode'], "text"),
			GetSQLValueString($_POST['paybackurl'], "text"),
			GetSQLValueString($_POST['Remark'], "tinyint"),
			GetSQLValueString($_POST['tejia'], "tinyint"),
                        GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  //商品選項
  $post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  echo "rows_count>0 ";
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
	  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec1_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
		  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec2_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  
  $table_prod_img = SYS_DBNAME . ".prod_img";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'img_name' => 'none.gif'
	  );
		  
	  $is_update = dbInsert( $table_prod_img, $record );
/*	  
  $insertSQL = sprintf("INSERT INTO prod_img (ProdId, img_name) VALUES (%s, 'none.gif')",
                          GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result3 = mysql_query($insertSQL, $webshop) or die(mysql_error());
  */
  //未上傳新圖片
  }else if(@$img_string[0] == ""){  

  $table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'PriceList' => $_POST['PriceList'],
		  'Quantity' => $_POST['Quantity'],
		  'ProdDisc' => $_POST['ProdDisc'],
		  'Model' => $_POST['Model'],
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia']
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );
	/*  
  $updateSQL = sprintf("UPDATE prodmain SET ProdId=%s, ProdName=%s, PriceOrigin=%s, PriceList=%s,Quantity=%s, ProdDisc=%s, Model=%s, MemoSpec=%s, LarCode=%s, MidCode=%s, paybackurl=%s, Remark=%s, tejia=%s WHERE ProdId=%s",
                        GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($_POST['ProdName'], "text"),
                        GetSQLValueString($_POST['PriceOrigin'], "double"),
			GetSQLValueString($_POST['PriceList'], "double"),
			GetSQLValueString($_POST['Quantity'], "int"),
			GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['Model'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
                        GetSQLValueString($_POST['LarCode'], "text"),
			GetSQLValueString($_POST['MidCode'], "text"),
			GetSQLValueString($_POST['paybackurl'], "text"),
			GetSQLValueString($_POST['Remark'], "tinyint"),
			GetSQLValueString($_POST['tejia'], "tinyint"),
                        GetSQLValueString($_POST['ProdId'], "text"));
						
  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error()); 
  */
  //商品選項
  $post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
	  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec1_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
		  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec2_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  //有上傳新圖片 
  }else{   
  //更新商品資訊
  
  	$table_prodmain = SYS_DBNAME . ".prodmain";
	  $whereClause = "ProdId='{$_POST['ProdId']}'";
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'ProdName' => $_POST['ProdName'],
		  'PriceOrigin' => $_POST['PriceOrigin'],
		  'PriceList' => $_POST['PriceList'],
		  'Quantity' => $_POST['Quantity'],
		  'ProdDisc' => $_POST['ProdDisc'],
		  'Model' => $_POST['Model'],
		  'MemoSpec' => $_POST['MemoSpec'],
		  'LarCode' => $_POST['LarCode'],
		  'MidCode' => $_POST['MidCode'],
		  'Remark' => $_POST['Remark'],
		  'tejia' => $_POST['tejia'],
		  'ImgFull' => $img_string[0]
	  );
		  
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );
/*	  
  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, ProdName=%s, PriceOrigin=%s, PriceList=%s,Quantity=%s, ProdDisc=%s, Model=%s, MemoSpec=%s, LarCode=%s, MidCode=%s, paybackurl=%s, Remark=%s, tejia=%s, ImgFull=%s WHERE ProdId=%s",
                        GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($_POST['ProdName'], "text"),
                        GetSQLValueString($_POST['PriceOrigin'], "double"),
			GetSQLValueString($_POST['PriceList'], "double"),
			GetSQLValueString($_POST['Quantity'], "int"),
			GetSQLValueString($_POST['ProdDisc'], "text"),
                        GetSQLValueString($_POST['Model'], "text"),
                        GetSQLValueString($_POST['MemoSpec'], "text"),
                        GetSQLValueString($_POST['LarCode'], "text"),
			GetSQLValueString($_POST['MidCode'], "text"),
			GetSQLValueString($_POST['paybackurl'], "text"),
			GetSQLValueString($_POST['Remark'], "tinyint"),
			GetSQLValueString($_POST['tejia'], "tinyint"),
			GetSQLValueString($img_string[0], "text"),
                        GetSQLValueString($_POST['ProdId'], "text"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  //商品選項
  $post_spec1_text = $_POST['post_spec1_text'];
  $post_spec2_text = $_POST['post_spec2_text'];
  for( $i = 0; $i < sizeof($post_spec1_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_1 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  
	  if($rows_count>0)
	  {
		  echo "rows_count>0 ";
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_1={$index_ProSerial_1}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec1_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
	  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_1=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec1_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  echo "rows_count=0 ";
		  
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_1 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => $index_ProSerial_1,
			  'ProSerial_2' => "0",
			  'SpecName' => $post_spec1_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  for( $i = 0; $i < sizeof($post_spec2_text); $i++ )
  {
	  $column = "*";
	  $table_prodSpec		= SYS_DBNAME . ".prodSpec";
	  $index_ProSerial_2 = $i + 1;
	  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause}"
	  );
	  $row_result = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  /*
	  $selectSQL = sprintf("SELECT * FROM prodSpec WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($i + 1, "text")
						);
	  mysql_select_db($database_webshop, $webshop);
	  $result1_select = mysql_query($selectSQL, $webshop) or die(mysql_error());
	  */
	  $rows_count = sizeof($row_result);
	  if($rows_count>0)
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $whereClause = "ProdId='{$_POST['ProdId']}' AND ProSerial_2={$index_ProSerial_2}";
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'SpecName' => $post_spec2_text[$i],
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbUpdate( $table_prodSpec, $record, $whereClause );
		  /*
		  $updateSQL = sprintf("UPDATE prodSpec SET ProdId=%s, SpecName=%s, updated_date=%s, opertor=%s WHERE ProdId=%s AND ProSerial_2=%s",
  						GetSQLValueString($_POST['ProdId'], "text"),
                        GetSQLValueString($post_spec2_text[$i], "text"),
						GetSQLValueString(now(), "date"),
						GetSQLValueString("admin", "text"),
						GetSQLValueString($_POST['ProdId'], "text"),
						GetSQLValueString($i + 1, "text")
						);
		  mysql_select_db($database_webshop, $webshop);
		  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
		  */
	  }
	  else
	  {
		  $table_prodSpec = SYS_DBNAME . ".prodSpec";
		  $index_ProSerial_2 = $i + 1;
		  $record = array
		  (	
			  'ProdId' => $_POST['ProdId'],
			  'ProSerial_1' => "0",
			  'ProSerial_2' => $index_ProSerial_2,
			  'SpecName' => $post_spec2_text[$i],
			  'created_date' => now(),
			  'updated_date' => now(),
			  'opertor' => "admin"
		  );
			  
		  $is_update = dbInsert( $table_prodSpec, $record );
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
  }
  }


  //更新圖片資訊
  for($i=0; $i<count($img_string); $i++){
	  $table_prod_img = SYS_DBNAME . ".prod_img";
	  $index_ProSerial_2 = $i + 1;
	  $record = array
	  (	
		  'ProdId' => $_POST['ProdId'],
		  'img_name' => $img_string[$i]
	  );
		  
	  $is_update = dbInsert( $table_prod_img, $record );
	/*	  
      $insertSQL = sprintf("INSERT INTO prod_img (ProdId, img_name) VALUES (%s, %s)",
                            GetSQLValueString($_POST['ProdId'], "text"),
		        			GetSQLValueString($img_string[$i], "text"));

      mysql_select_db($database_webshop, $webshop);
      $Result3 = mysql_query($insertSQL, $webshop) or die(mysql_error());
	  */
  }
  
  
  
  
  $updateGoTo = "admingoods.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //echo "<script type='text/javascript'>";
  //echo "window.location.href='$updateGoTo'";
  //echo "</script>";
}
?>
<?php  //-----------------------------取得商品資訊------------------------------------//
$cloume_showpagesRec = "-1";
if (isset($_GET['ProdId'])) {
  $cloume_showpagesRec = $_GET['ProdId'];
}
$cloume_showpagesRec2 = "-1";
if (isset($_GET['ProdNum'])) {
  $cloume_showpagesRec2 = $_GET['ProdNum'];
}

if(($_GET['ProdId']) != ""){
	$column = "*";
	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = "ProdId='{$_GET['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}"
	);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof( $row_showpagesRec );
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_showpagesRec = sprintf("SELECT * FROM prodmain
	WHERE ProdId=%s", GetSQLValueString($cloume_showpagesRec, "text"));
	$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
	$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
	$totalRows_showpagesRec = mysql_num_rows($showpagesRec);	
	*/
	
	$column = "*";
	$table_prodSpec		= SYS_DBNAME . ".prodSpec";
	$whereClause = "ProdId='{$_GET['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2",
			'oci8'	=> "SELECT {$column} FROM {$table_prodSpec} WHERE {$whereClause} ORDER BY ProSerial_1,ProSerial_2"
	);
	$query_spec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_showpagesRec = sprintf("SELECT * FROM prodSpec
	WHERE ProdId=%s ORDER BY ProSerial_1,ProSerial_2", GetSQLValueString($cloume_showpagesRec, "text"));
	$query_spec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
	*/
}else{
	$column = "*";
	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = "ProdNum='{$_POST['ProdId']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}",
			'oci8'	=> "SELECT {$column} FROM {$table_prodmain} WHERE {$whereClause}"
	);
	$row_showpagesRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_showpagesRec = sizeof($row_showpagesRec);
	/*
	mysql_select_db($database_webshop, $webshop);
	$query_showpagesRec = sprintf("SELECT * FROM prodmain
	WHERE ProdNum=%s", GetSQLValueString($cloume_showpagesRec2, "text"));
	$showpagesRec = mysql_query($query_showpagesRec, $webshop) or die(mysql_error());
	$row_showpagesRec = mysql_fetch_assoc($showpagesRec);
	$totalRows_showpagesRec = mysql_num_rows($showpagesRec);
	echo 'ProdId == ""';
	*/
}
?>
<?php  //---------------------------取得商品類別(大類)---------------------------------//
	$column = "DISTINCT LarCode";
	$table_prodclass		= SYS_DBNAME . ".prodclass";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY LarSeq ASC"
	);
	$row_itemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_itemRec = sizeof($row_itemRec);
/*	
mysql_select_db($database_webshop, $webshop);
$query_itemRec = "SELECT DISTINCT LarCode FROM prodclass ORDER BY LarSeq ASC";
$itemRec = mysql_query($query_itemRec, $webshop) or die(mysql_error());
$row_itemRec = mysql_fetch_assoc($itemRec);
$totalRows_itemRec = mysql_num_rows($itemRec);
*/
?>
<?php  //---------------------------取得商品類別(中類)---------------------------------//
	$column = "*";
	$table_prodclass		= SYS_DBNAME . ".prodclass";
	$whereClause = "LarCode='{$row_showpagesRec['LarCode']}'";
	
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC", 
			'mssql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC",
			'oci8'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC"
	);
	$row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	$totalRows_endItemRec = sizeof($row_endItemRec);
/*	
mysql_select_db($database_webshop, $webshop);
$query_endItemRec = sprintf("SELECT * FROM prodclass WHERE LarCode=%s ORDER BY MidSeq ASC",GetSQLValueString($row_showpagesRec['LarCode'], "text"));
$endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
$row_endItemRec = mysql_fetch_assoc($endItemRec);
$totalRows_endItemRec = mysql_num_rows($endItemRec);
*/
?>
<?php  //---------------------------更新商品類別(中類)---------------------------------//
if(isset($_POST['LarCode'])){
  $class = $_POST['LarCode'];
  $column = "*";
  $table_prodclass		= SYS_DBNAME . ".prodclass";
  $whereClause = "LarCode='{$_POST['LarCode']}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prodclass} ORDER BY MidSeq ASC"
  );
  $row_endItemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_endItemRec = sizeof($row_endItemRec);
	/*
  mysql_select_db($database_webshop, $webshop);
  $query_endItemRec = sprintf("SELECT * FROM prodclass where LarCode = %s ORDER BY MidSeq ASC",
                               GetSQLValueString($_POST['LarCode'], "text"));
  $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
  $row_endItemRec = mysql_fetch_assoc($endItemRec);
  $totalRows_endItemRec = mysql_num_rows($endItemRec);
  */
}
else{
  $class = $row_showpagesRec['LarCode'];
}
?>
<?php  //-----------------------------取得商品圖片------------------------------------//
$cloume_showImgRec = "%";
if (isset($_GET['ProdId'])) {
  $cloume_showImgRec = $_GET['ProdId'];
}
  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
  );
  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof($row_showimgRec);
/*  
mysql_select_db($database_webshop, $webshop);
$query_showimgRec = sprintf("SELECT * FROM prod_img WHERE ProdId=%s order by img_no ASC", GetSQLValueString($cloume_showImgRec, "text"));
$showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
$row_showimgRec = mysql_fetch_assoc($showimgRec);
$totalRows_showimgRec = mysql_num_rows($showimgRec);
*/
?>
<?php  //---------------------------刪除圖片---------------------------------//
if ((isset($_POST["delete_img"])) && ($_POST["delete_img"] == "刪除")) {
  //刪除圖片
  //echo $_POST['img_no'];
  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "img_no='{$_POST['img_no']}'";
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause}"
  );
  $row_showimgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
  /*
  mysql_select_db($database_webshop, $webshop);
  $query_showimgRec = sprintf("SELECT * FROM prod_img WHERE img_no=%s", GetSQLValueString($_POST['img_no'], "int"));
  $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
  $row_showimgRec = mysql_fetch_assoc($showimgRec);
  */
  if($row_showimgRec['img_name'] != "none.gif"){
  unlink("../images/goodsimg/medium/".$row_showimgRec["img_name"]);
  unlink("../images/goodsimg/small/".$row_showimgRec["img_name"]);
  }
  
	
  //刪除圖片資訊
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "img_no='{$_POST['img_no']}'";
  dbDelete( $table_prod_img, $whereClause );
	/*  
  mysql_select_db($database_webshop, $webshop);	
  $deleteSQL = sprintf("DELETE FROM prod_img WHERE img_no=%s", GetSQLValueString($_POST['img_no'], "int"));
  $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
  */
  //重新取得圖片資訊
  $cloume_showImgRec = "%";
  if (isset($_GET['ProdId'])) $cloume_showImgRec = $_GET['ProdId'];
	/*
  mysql_select_db($database_webshop, $webshop);
  $query_showimgRec = sprintf("SELECT * FROM prod_img WHERE ProdId=%s", GetSQLValueString($cloume_showImgRec, "text"));
  $showimgRec = mysql_query($query_showimgRec, $webshop) or die(mysql_error());
  $row_showimgRec = mysql_fetch_assoc($showimgRec);
  $totalRows_showimgRec = mysql_num_rows($showimgRec);
  */
  $column = "*";
  $table_prod_img		= SYS_DBNAME . ".prod_img";
  $whereClause = "ProdId='{$cloume_showImgRec}'";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC", 
		  'mssql'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC",
		  'oci8'	=> "SELECT {$column} FROM {$table_prod_img} WHERE {$whereClause} ORDER BY img_no ASC"
  );
  $row_showimgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showimgRec = sizeof( $row_showimgRec );
  
}
?>
<h3 class=ttl01 >修改上架商品資訊</h3>
<script>
$( document ).ready(function() 
{
  	$('#editpages1').submit(function()
  	{
		$.each( document.getElementsByName("pro_spec1_text[]"), function( i, param )
		{
			$('<input />').attr('type', 'hidden')
				.attr( 'name', "post_spec1_text[]" )
				.attr( 'value', param.value )
				.appendTo('#editpages1' );
		});
		$.each( document.getElementsByName("pro_spec2_text[]"), function( i, param )
		{
			$('<input />').attr('type', 'hidden')
				.attr( 'name', "post_spec2_text[]" )
				.attr( 'value', param.value )
				.appendTo('#editpages1' );
		});
   		return true;
	});
	 
	 document.getElementsByName("pro_spec1_plus[]")[document.getElementsByName("pro_spec1_text[]").length - 1].style.visibility = "visible";
	 document.getElementsByName("pro_spec2_plus[]")[document.getElementsByName("pro_spec2_text[]").length - 1].style.visibility = "visible";
	 
});

</script>
<table id="table_goods" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<input type="hidden" name="ProdId" id="ProdId" value="<?php echo $row_showpagesRec['ProdId']; ?>"/>
  <!----------------------------商品圖片---------------------------->
  <?php if($totalRows_showimgRec > 0) { ?>
  <tr>
  	<td>1.商品圖片:
    	<table border="0" height="100%">
        <tr>
        <?php foreach ($row_showimgRec as $key => $array){ ?>
        <form name="editpages" action="" method="POST" enctype="multipart/form-data" id="editpages">
            <td align="center">
 <a href="../../images/goodsimg/medium/<?php echo $array['img_name']; ?>" target=_blank >
<img src="../../images/goodsimg/small/<?php echo $array['img_name']; ?>" alt="" name="image" id="image" align="center" style="padding:5px;"/></a><br />
                <input name="img_no" type="hidden" value="<?php echo $array['img_no']; ?>"/> 
                <input name="delete_img" type="submit" value="刪除"/><br />
            </td>
        </form>
        <?php } ?>
        </tr>
        <!-------------------------------------------------------------->
        </table>
  	</td>
  </tr>
  <?php } ?>
  <!----------------------------圖片上傳---------------------------->
<form name="editpages1" action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" id="editpages1">
  <tr>
    <td>2.上傳圖片:
      <input name="img_num" type="hidden" value="<?php echo $totalRows_showimgRec;?>" /> 
      <input name="goods_img_first" type="hidden" value="<?php echo $row_showimgRec['img_name']; ?>" /> 
      <input type="file" name="goods_img[]" style="width:50%; height:90%; margin: 2px" multiple/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td>3.所屬大類:
      <select id="LarCode" name="LarCode" onchange="this.form.submit()" style="width:20%; height:90%; margin: 3px">
      <option value="0"></option>
        <?php
        foreach ($row_itemRec as $key => $array){  
        ?>
          <option value="<?php echo $array['LarCode']?>" <?php if($array['LarCode'] == $class) {echo "selected=\"selected\"";} ?>>
		  <?php echo $array['LarCode']?></option>
        <?php
        }
        $rows = sizeof($row_itemRec);
        if($rows > 0) {
          //mysql_data_seek($itemRec, 0);
	      //$row_itemRec = mysql_fetch_assoc($itemRec);
        }
        ?>
      </select>
    </td>
  </tr>
  <!----------------------------所屬中類---------------------------->
  <tr>
    <td>4.所屬中類:
      <select id="MidCode" name="MidCode" style="width:30%; height:90%; margin: 3px"> 
        <option value="0"></option>
        <?php
        foreach ($row_endItemRec as $key => $array){  
        ?>
        <option value="<?php echo $array['MidCode']?>"<?php if (!(strcmp($array['MidCode'], $row_showpagesRec['MidCode']))) {echo "selected=\"selected\"";} ?>><?php echo $array['MidCode']?></option>
        <?php
        }
        $rows = mysql_num_rows($row_endItemRec);
        if($rows > 0) {
          //mysql_data_seek($endItemRec, 0);
	      //$row_endItemRec = mysql_fetch_assoc($endItemRec);
        }
        ?>
      </select>
    </td>
  </tr>
  <!----------------------------商品編號---------------------------->
  <tr>
    <td>5.商品編號:<?php echo $row_showpagesRec['ProdId']; ?>
      <input id="ProdId" name="ProdId" type="hidden" value="<?php echo $row_showpagesRec['ProdId']; ?>"/>
    </td>
  </tr>
  <!----------------------------商品名稱---------------------------->
  <tr>
    <td>6.商品名稱:
      <input id="ProdName" name="ProdName" type="text" class=sizeM value="<?php echo $row_showpagesRec['ProdName']; ?>"/></td>
  </tr>
  <!----------------------------商品型號---------------------------->
  <tr>
    <td>7.商品型號:
      <input id="Model" name="Model" type="text" class=sizeSs value="<?php echo $row_showpagesRec['Model']; ?>"/>
    </td>
  </tr>
  <!----------------------------市場價---------------------------->
  <tr>
    <td>8.市場價:
      <input id="PriceOrigin" name="PriceOrigin" type="text" class=sizeSss value="<?php echo $row_showpagesRec['PriceOrigin']; ?>"/>元 [如'0' 則不顯示]</td>
  </tr>
  <!----------------------------熱賣價---------------------------->
  <tr>
    <td>9.熱賣價:
      <input id="PriceList" name="PriceList" type="text" class=sizeSss value="<?php echo $row_showpagesRec['PriceList']; ?>"/>元 [如'0' 則顯示：請咨詢客服]</td>
  </tr>
  <!----------------------------庫存數---------------------------->
  <tr>
    <td>10.庫存數:
      <input id="Quantity" name="Quantity" type="text" class=sizeSss value="<?php echo $row_showpagesRec['Quantity']; ?>"/>個 [如'0' 則顯示：已售完]</td>
  </tr>
  <!----------------------------商品簡介---------------------------->
  <tr>
    <td>11.商品簡介:<br>
       <textarea id="ProdDisc" name="ProdDisc" cols="50" rows="5" ><?php echo $row_showpagesRec['ProdDisc']; ?></textarea>
     </td>
  </tr>
  
  <!----------------------------商品說明---------------------------->
  <tr>
   <td>12.商品說明:
<script type="text/javascript" src="../../ckeditor/ckeditor.js"></script>    
    <textarea id="MemoSpec" name="MemoSpec" class="ckeditor" cols="50" rows="20" ><?php echo $row_showpagesRec['MemoSpec']; ?></textarea></td>
  </tr>  
  <!----------------------------支付返回---------------------------->
  <tr>
    <td>13.支付返回:
      <input id="paybackurl" name="paybackurl" type="text" style="width:50%; height:90%; margin: 2px" value="<?php echo $row_showpagesRec['paybackurl']; ?>"/>[在線支付後的返回頁面]</td>
  </tr>
  <!----------------------------設為推薦商品---------------------------->
  <tr>
    <td>14.設為推薦商品:
      <label>
        <input type="radio" name="Remark" value="0" id="Remark_0" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="Remark" value="1" id="Remark_1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['Remark'] == '1'): ?>checked='checked'<?php endif; ?>/>
        是</label>
    </td>
  </tr>
  <!----------------------------設為特價商品---------------------------->
  <tr>
    <td>15.設為特價商品
      <label>
        <input type="radio" name="tejia" value="0" id="tejia _0" style="margin-left: 3px"
		<?php if ($row_showpagesRec['tejia'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="tejia" value="1" id="tejia _1" style="margin-left: 3px"
        <?php if ($row_showpagesRec['tejia'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <!----------------------------設定類型1---------------------------->
  <tr>
    <td>16.設定類型1
    <?php $arr_pro_spec_1 = array(); $arr_pro_spec_2 = array();?>
    <table id="table_pro_spec_1" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable"  name="table_pro_spec_1">
    <?php foreach ($query_spec as $key => $row_showgoodsRec){  
		if( $row_showgoodsRec['ProSerial_1'] == 0 ) {array_push( $arr_pro_spec_2, $row_showgoodsRec['SpecName'] ); continue;} else array_push( $arr_pro_spec_1, $row_showgoodsRec['SpecName'] )?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec1_text[]" style="margin-left: 3px" value="<?php echo $row_showgoodsRec['SpecName'];?>"/>
            </label>
            <label>
              <input type="button" name="pro_spec1_plus[]" value="+" onClick="addTableField(this)" style="width: 20px; visibility:hidden"/>
            </label>
            </td>
         </tr>
	<?php } ?>
    <?php if( sizeof( $arr_pro_spec_1 ) == 0 ){ ?>
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
      <?php } ?>
    </table>
    </td>
  </tr>
  <!----------------------------設定類型2---------------------------->
  <tr>
    <td>17.設定類型2
      <table id="table_pro_spec_2" width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable" name="table_pro_spec_2">
      <?php while ( list ($key, $val) = each ($arr_pro_spec_2)  ){ ?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec2_text[]" style="margin-left: 3px"  value="<?php echo $val;?>"/>
            </label>
            <label>
              <input type="button" name="pro_spec2_plus[]" value="+" onClick="addTableField(this)" style="width: 20px; visibility:hidden"/>
            </label>
            </td>
         </tr>
      <?php } ?>
      <?php if( sizeof( $arr_pro_spec_2 ) == 0 ){ ?>
    	<tr>
        	<td>
            <label>
              <input type="text" name="pro_spec2_text[]" style="margin-left: 3px"  value="<?php echo $val;?>"/>
            </label>
            <label>
              <input type="button" name="pro_spec2_plus[]" value="+" onClick="addTableField(this)" style="width: 20px;"/>
            </label>
            </td>
         </tr>
      <?php } ?>
      </table>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="ProdId" type="hidden" value="<?php echo $row_showpagesRec['ProdId']; ?>" />
      <input type="submit" name="update_pages" value="更新" style="font-size:16px;width:60px;height:30px"/>
      <input type="reset" name="reset"  value="重設" style="font-size:16px;width:60px;height:30px"/>
    </td>
  </tr>
  
  <!----------------------------------------------------------->
</form>
</table>
<script>

function addTableField1( aContext )
{
	//aContext.style.visibility = "hidden";
	
	console.log( document.getElementsByName("pro_spec1_text[]").length );
	console.log( document.getElementsByName("pro_spec1_text[]")[1].value);
	
	/*$.each(document.getElementsByName("pro_spec1_text[]"), function( index, value ) {
	  alert( index + ": " + value.value);
	});
	*/
	
	var table = document.getElementById("table_pro_spec_1");
	 var length = table.getElementsByTagName("tr").length;
	 var cell = table.rows[length - 1].cells[0];
	 var input = cell.getElementsByTagName( 'input' );
	 for ( var z = 0; z < input.length; z++ ) {
		 console.log( input[z].name ) ;
		 //document.getElementsByName( "pro_spec1_plus[]" )[0].style.display = "none"; 
        //document.getElementById( input[z].name ).style.visibility = "hidden"; 
    } 
	var s1 = document.getElementsByName("pro_spec1_plus[]")[3];//Get the first and only button in your case
    s1.style.visibility = "visible";
}

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
//mysql_free_result($showpagesRec);
//mysql_free_result($itemRec);
//mysql_free_result($endItemRec);
//mysql_free_result($showimgRec);
?>
