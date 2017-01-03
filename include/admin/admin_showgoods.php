<?php  //---------------------------取出商品資訊---------------------------------//
//$sysConnDebug = true;
if((!isset($_GET['class'])) && (!isset($_GET['name'])) && (!isset($_GET['type']))){
$_SESSION['search']="";
}
$clause="";
$maxRows_showgoodsRec = 10;
$pageNum_showgoodsRec = 0;
if (isset($_GET['pageNum_showgoodsRec'])) {
  $pageNum_showgoodsRec = $_GET['pageNum_showgoodsRec'];
}
$startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;

$column = "*";
$table_prodmain		= SYS_DBNAME . ".prodmain";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
		'mssql'	=> "SELECT {$column} FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}"
);
$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);




    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC "
);
    $all_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_showgoodsRec = sizeof($all_showgoodsRec);


$totalPages_showgoodsRec = ceil($totalRows_showgoodsRec/$maxRows_showgoodsRec)-1;

$queryString_showgoodsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showgoodsRec") == false &&
        stristr($param, "totalRows_showgoodsRec") == false &&
		stristr($param, "class") == false &&
		stristr($param, "name") == false &&
		stristr($param, "type") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showgoodsRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showgoodsRec = sprintf("&totalRows_showgoodsRec=%d%s", $totalRows_showgoodsRec, $queryString_showgoodsRec);
?>
<?php  //------------------------取出商品類別資訊------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
$table_prodclass		= SYS_DBNAME . ".prodclass";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY prodclass.LarSeq ASC",
		'mssql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY prodclass.LarSeq ASC",
		'oci8'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause} ORDER BY prodclass.LarSeq ASC"
		);
$row_showClassRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

$totalRows_showClassRec = sizeof($row_showClassRec);
?>
<?php  //---------------------------搜尋功能---------------------------------//
if (isset($_SESSION['search']) && $_SESSION['search']!="") {
  if(isset($_GET['class'])) $class = $_GET['class'];
  if(isset($_GET['name'])) $name = $_GET['name'];
  if(isset($_GET['type'])) $open = $_GET['type'];
  $maxRows_showgoodsRec = 10;
  $pageNum_showgoodsRec = 0;
  if (isset($_GET['pageNum_showgoodsRec'])) {
    $pageNum_showgoodsRec = $_GET['pageNum_showgoodsRec'];
  }
  $startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;

	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = $_SESSION['search'];
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
			'mssql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
			'oci8'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}"
			);
	$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);


  $totalRows_showgoodsRec = sizeof($row_showgoodsRec);


	  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		  'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		  'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC "
  );
  $all_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  $totalRows_showgoodsRec = sizeof($all_showgoodsRec);



  $totalPages_showgoodsRec = ceil($totalRows_showgoodsRec/$maxRows_showgoodsRec)-1;
  if(isset($_GET['class']) && isset($_GET['name']) && isset($_GET['type'])) $clause="&class=".$class."&name=".$name."&type=".$open;
}
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
  $class = ($_POST["search_class"]);
  $name = trim($_POST["search_name"]);
  $open = $_POST["search_type"];

  $string = "";
  if($open == 0)
      $string = $string."Online = '0'";
  else if($open == 1)
      $string = $string."Online = '1'";
  else if($open == 2)
      $string = $string."(Online = '0' || Online = '1')";

  if($name != "") {
    //$string = $string." && "."locate(ProdName,'$name') > 0";
	$string = $string." && "."ProdName LIKE '%$name%'";
  }

  if($class != "-1") {
	  $table_prodclass		= SYS_DBNAME . ".prodclass";
	  $whereClause = "ClassId = '$class'";
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
			  'mssql'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}",
			  'oci8'	=> "SELECT * FROM {$table_prodclass} WHERE {$whereClause}"
			  );
	  $row_endItemRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);


	 $class_LarCode = $row_endItemRec["LarCode"];
	 $class_MidCode = $row_endItemRec["MidCode"];

	 $string = $string." && "."prodmain.LarCode = '$class_LarCode' && prodmain.MidCode = '$class_MidCode'";
  }

  $maxRows_showgoodsRec = 10;
  $pageNum_showgoodsRec = 0;

  $startRow_showgoodsRec = $pageNum_showgoodsRec * $maxRows_showgoodsRec;

	$table_prodmain		= SYS_DBNAME . ".prodmain";
	$whereClause = "CONCAT($string)";
	$sql['list']['select'] = array(
			'mysql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
			'mssql'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}",
			'oci8'	=> "SELECT * FROM {$table_prodmain} LEFT JOIN prodclass ON prodclass.LarCode = prodmain.LarCode AND prodclass.MidCode = prodmain.MidCode WHERE {$whereClause} ORDER BY AddDate DESC LIMIT {$startRow_showgoodsRec}, {$maxRows_showgoodsRec}"
			);
	$row_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);


  $totalRows_showgoodsRec = sizeof($row_showgoodsRec);


	  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		  'mssql'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC ",
		  'oci8'	=> "SELECT * FROM {$table_prodmain} WHERE {$whereClause} ORDER BY AddDate DESC "
  );
  $all_showgoodsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	  $totalRows_showgoodsRec = sizeof($all_showgoodsRec);



  $totalPages_showgoodsRec = ceil($totalRows_showgoodsRec/$maxRows_showgoodsRec)-1;
  $_SESSION['search']=$whereClause;
  $clause="&class=".$class."&name=".$name."&type=".$open;
}
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "上架")) {
    if(isset($_POST['select_good'])){
      $select_num = count($_POST['select_good']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ProdId='".$_POST['select_good'][$i]."'";
      }

	  $table_prodmain		= SYS_DBNAME . ".prodmain";
	  $record = array( 'Online' => '1' );
	  $whereClause = "CONCAT($update_string)";
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );


	  $updateGoTo = "admingoods.php";
	  header("location:$updateGoTo");
	  /*echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";*/
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "下架")) {
    if(isset($_POST['select_good'])){
      $select_num = count($_POST['select_good']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ProdId='".$_POST['select_good'][$i]."'";
      }

	  $table_prodmain		= SYS_DBNAME . ".prodmain";
	  $record = array( 'Online' => '0' );
	  $whereClause = "CONCAT($update_string)";
	  $is_update = dbUpdate( $table_prodmain, $record, $whereClause );

	  $updateGoTo = "admingoods.php";
	  header("location:$updateGoTo");
	  /*echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";*/
    }
}
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_good'])){
      $select_num = count($_POST['select_good']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
	if($delete_string != "") $delete_string = $delete_string." || ";
	$delete_string = $delete_string."ProdId='".$_POST['select_good'][$i]."'";
      }
      //delete from goods list
	  $table_prodmain		= SYS_DBNAME . ".prodmain";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_prodmain, $whereClause );

      //delete good images
	  $table_prod_img		= SYS_DBNAME . ".prod_img";
	  $whereClause = "CONCAT($delete_string)";
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}",
			  'mssql'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}",
			  'oci8'	=> "SELECT * FROM {$table_prod_img} WHERE {$whereClause}"
			  );
	  $row_searchImg = dbGetAll($sql['list']['select'][SYS_DBTYPE]);


	  //delete from goods spec


	  $table_prodspec		= SYS_DBNAME . ".prodspec";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_prodspec, $whereClause );


	  foreach($row_searchImg as $key => $searchImg){
      if($searchImg['img_name'] != "none.gif"){
          //delete images
       unlink("../images/goodsimg/medium/".$searchImg["img_name"]);
       unlink("../images/goodsimg/small/".$searchImg["img_name"]);}
	  }

      $table_prod_img		= SYS_DBNAME . ".prod_img";
	  $whereClause = "CONCAT($delete_string)";
	  dbDelete( $table_prod_img, $whereClause );





      $deleteGoTo = "admingoods.php";
      header("location:$deleteGoTo");
    }
}
?>
<?php  //---------------------------加商品功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "加商品")) {
	$addGoTo = "adminaddgoods.php";
	header("location:$addGoTo");
   /* echo "<script type='text/javascript'>";
    echo "window.location.href='$addGoTo'";
    echo "</script>"; */
}
?>

<script>
function check_all(obj,cName) {
    var checkboxs = document.getElementsByName(cName);
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;}
}
</script>

<h3 class=ttl01 >商品上架管理</h3>
<table width="100%" border="0" class="formTable1">
    <form action="" method="POST" name="search_goods" id="search_goods" enctype="multipart/form-data">
      <tr>
        <td align="center">
          <select name="search_class" style="width:200px">
          <option value="-1">-----------------所有類別--------------------</option>
          <?php
          foreach ($row_showClassRec as $key => $array){
          ?>
            <option value="<?php echo $array['ClassId'];?>" <?php  if(isset($class) && $array['ClassId']==$class) echo "selected='selected'";?>>
		      <?php
			      echo $array['LarCode']." - ".$array['MidCode']
			  ?>
            </option>
          <?php
          }
          $rows = sizeof($showClassRec);
          if($rows > 0) {
            mysql_data_seek($showClassRec, 0);
	        $row_showClassRec = mysql_fetch_assoc($showClassRec);
          }
          ?>
          </select>
        </td>
        <td align="center">關鍵字 <input name="search_name" type="text" style="width:100px" value="<?php if(isset($name)) echo $name; ?>"/></td>
        <td align="center">
          <label>
            <input type="radio" name="search_type" value="0" id="search_type_0" <?php  if(isset($open) && $open==0) echo "checked";?>/>
            離線</label>
          <label>
            <input type="radio" name="search_type" value="1" id="search_type_1" <?php  if(isset($open) && $open==1) echo "checked";?>/>
            在線</label>
          <label>
            <input type="radio" name="search_type" value="2" id="search_type_2" <?php  if(!isset($open) || $open==2) echo "checked";?>/>
            全部</label>
        </td>
        <td align="center" ><input type="submit" name="search_btn"  value="搜尋"/></td>
      </tr>
    </form>
    </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<!-------------------------------------------------------------->
<form action="" name="edit_goods" method="POST" id="edit_goods" enctype="multipart/form-data">
<tr>
  <td align="left"colspan="6"><font color="blue">提示：利用上面的搜索功能，可快速找到相關商品。</font></td>
  <td align="center"><input name="add_btn" type="submit" value="加商品" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#EBEBEB">
  <td width="6%" >選擇</td>
  <td width="13%" ><p>商品貨號</p></td>
  <td width="20%" >商品名稱</td>
  <td width="9%" >商品圖片</td>
  <td width="30%" >商品分類</td>
  <td width="9%" >在(離)線</td>
  <td width="13%" >日期</td>
</tr>
<!-------------------------------------------------------------->
<?php foreach ($row_showgoodsRec as $key => $array){   ?>
  <?php if ($totalRows_showgoodsRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td ><input name="select_good[]" type="checkbox" value="<?php echo $array['ProdId']; ?>" /></td>
      <td ><a href="admineditgoods.php?ProdId=<?php echo $array['ProdId']; ?>"><?php echo $array['ProdId']; ?></a></td>
      <td >
        <a href="admineditgoods.php?ProdId=<?php echo $array['ProdId']; ?>">
	      <?php echo $array['ProdName']; ?>
        </a>
      </td>
      <td >
      <?php
			  $table_prodmain		= SYS_DBNAME . ".prodmain";
			  $column = "*";
			  $whereClause = "ProdNum={$array['ProdNum']}";

			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ",
					  'mssql'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ",
					  'oci8'	=> "SELECT * FROM {$table_prodmain} INNER JOIN prod_img ON prod_img.ProdId = prodmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC "
			  );
			  $row_showsublistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

	  ?>
   <a href="admineditgoods.php?ProdId=<?php echo $array['ProdId']; ?>"><img src="../../images/goodsimg/small/<?php echo $row_showsublistRec['img_name']; ?>" alt="" name="image"
         height="75px" id="image" align="center" style="padding:5px;"/></a>
      </td>
      <td ><?php echo $array['LarCode'].'/'.$array['MidCode']; ?></td>
      <td ><?php if($array['Online'] == 0) echo "離線"; else echo "上線";?></td>
      <td ><?php echo $array['AddDate']; ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } ?>
<!-------------------------------------------------------------->
<tr>
  <td  colspan="6" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_good[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="下架" />
    <input name="open_btn" type="submit" value="上架" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="加商品" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr>
  <td colspan="7" align="right" bgcolor="#cfcfcf" >
    <table border="0">
      <tr>
        <td>共<?php echo $totalRows_showgoodsRec ?> 種商品 <?php echo ($pageNum_showgoodsRec+1);?>/<?php echo ($totalPages_showgoodsRec+1);?></td>
        <td align="right">
		  <?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s%s", $currentPage, 0, $queryString_showgoodsRec, $clause); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showgoodsRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s%s", $currentPage, max(0, $pageNum_showgoodsRec - 1), $queryString_showgoodsRec, $clause); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s%s", $currentPage, min($totalPages_showgoodsRec, $pageNum_showgoodsRec + 1), $queryString_showgoodsRec, $clause); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showgoodsRec < $totalPages_showgoodsRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showgoodsRec=%d%s%s", $currentPage, $totalPages_showgoodsRec, $queryString_showgoodsRec, $clause); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
          <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>
<!-------------------------------------------------------------->
</table>

