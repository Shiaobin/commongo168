<?php  //---------------------------取出網頁資訊---------------------------------//
if((!isset($_GET['class'])) && (!isset($_GET['name'])) && (!isset($_GET['type']))){
$_SESSION['search']="";
}
$clause="";
$maxRows_showpagesRec = 10;
$pageNum_showpagesRec = 0;
if (isset($_GET['pageNum_showpagesRec'])) {
  $pageNum_showpagesRec = $_GET['pageNum_showpagesRec'];
}
$startRow_showpagesRec = $pageNum_showpagesRec * $maxRows_showpagesRec;
mysql_select_db($database_webshop, $webshop);
$query_showpagesRec = "SELECT * FROM compmain
LEFT JOIN compclass
ON compclass.LarCode = compmain.LarCode AND compclass.MidCode = compmain.MidCode ORDER BY AddDate DESC";
$query_limit_showpagesRec = sprintf("%s LIMIT %d, %d", $query_showpagesRec, $startRow_showpagesRec, $maxRows_showpagesRec);
$showpagesRec = mysql_query($query_limit_showpagesRec, $webshop) or die(mysql_error());
$row_showpagesRec = mysql_fetch_assoc($showpagesRec);

if (isset($_GET['totalRows_showpagesRec'])) {
  $totalRows_showpagesRec = $_GET['totalRows_showpagesRec'];
} else {
  $all_showpagesRec = mysql_query($query_showpagesRec);
  $totalRows_showpagesRec = mysql_num_rows($all_showpagesRec);
}
$totalPages_showpagesRec = ceil($totalRows_showpagesRec/$maxRows_showpagesRec)-1;

$queryString_showpagesRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_showpagesRec") == false && 
        stristr($param, "totalRows_showpagesRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_showpagesRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showpagesRec = sprintf("&totalRows_showpagesRec=%d%s", $totalRows_showpagesRec, $queryString_showpagesRec);
?>
<?php  //------------------------取出網頁類別資訊------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
mysql_select_db($database_webshop, $webshop);
$query_showClassRec = "SELECT * FROM compclass  
ORDER BY LarSeq ASC";
$showClassRec = mysql_query($query_showClassRec, $webshop) or die(mysql_error());
$row_showClassRec = mysql_fetch_assoc($showClassRec);
$totalRows_showClassRec = mysql_num_rows($showClassRec);
?>
<?php  //---------------------------搜尋功能---------------------------------//
if (isset($_SESSION['search']) && $_SESSION['search']!="") {
  if(isset($_GET['class'])) $class = $_GET['class'];
  if(isset($_GET['name'])) $name = $_GET['name'];
  if(isset($_GET['type'])) $open = $_GET['type'];
  $maxRows_showpagesRec = 10;
  $pageNum_showgoodsRec = 0;

  if($class != "-1") {
	 mysql_select_db($database_webshop, $webshop);
     $query_endItemRec = "SELECT * FROM compclass where ClassId = '$class'";
     $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
	 $row_endItemRec = mysql_fetch_assoc($endItemRec);
	 
	 //$LarCode = $row_endItemRec["LarCode"];
	 //$MidCode = $row_endItemRec["MidCode"];
	
  }
  $string = $_SESSION['search'];
  $maxRows_showpagesRec = 10;
  $pageNum_showpagesRec = 0;
  if (isset($_GET['pageNum_showpagesRec'])) {
    $pageNum_showpagesRec = $_GET['pageNum_showpagesRec'];
  }
  $startRow_showpagesRec = $pageNum_showpagesRec * $maxRows_showpagesRec;

  mysql_select_db($database_webshop, $webshop);
  $query_showpagesRec = "SELECT * FROM compmain 
	                    LEFT JOIN compclass
                        ON compclass.LarCode = compmain.LarCode
                        AND compclass.MidCode = compmain.MidCode
	                    WHERE CONCAT($string) ORDER BY AddDate DESC";
  $query_limit_showpagesRec = sprintf("%s LIMIT %d, %d", $query_showpagesRec, $startRow_showpagesRec, $maxRows_showpagesRec);
  $showpagesRec = mysql_query($query_limit_showpagesRec, $webshop) or die(mysql_error());
  $row_showpagesRec = mysql_fetch_assoc($showpagesRec);
  $totalRows_showpagesRec = mysql_num_rows($showpagesRec);

  $all_showpagesRec = mysql_query($query_showpagesRec);
  $totalRows_showpagesRec = mysql_num_rows($all_showpagesRec);
    

 
  $totalPages_showpagesRec = ceil($totalRows_showpagesRec/$maxRows_showpagesRec)-1;
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
    //$string = $string." && "."locate(ProdDisc,'$name') > 0";
	$string = $string." && "."ProdDisc LIKE '%$name%'";
  }
  
  if($class != "-1") {
	 mysql_select_db($database_webshop, $webshop);
     $query_endItemRec = "SELECT * FROM compclass where ClassId = '$class'";
     $endItemRec = mysql_query($query_endItemRec, $webshop) or die(mysql_error());
	 $row_endItemRec = mysql_fetch_assoc($endItemRec);
	 
	 $LarCode = $row_endItemRec["LarCode"];
	 $MidCode = $row_endItemRec["MidCode"];
	 
	 $string = $string." && "."compmain.LarCode = '$LarCode' && compmain.MidCode = '$MidCode'";
  }
  
  $maxRows_showpagesRec = 10;
  $pageNum_showpagesRec = 0;

  $startRow_showpagesRec = $pageNum_showpagesRec * $maxRows_showpagesRec;

  mysql_select_db($database_webshop, $webshop);
  $query_showpagesRec = "SELECT * FROM compmain 
	                    LEFT JOIN compclass
                        ON compclass.LarCode = compmain.LarCode
                        AND compclass.MidCode = compmain.MidCode
	                    WHERE CONCAT($string) ORDER BY AddDate DESC";
  $query_limit_showpagesRec = sprintf("%s LIMIT %d, %d", $query_showpagesRec, $startRow_showpagesRec, $maxRows_showpagesRec);
  $showpagesRec = mysql_query($query_limit_showpagesRec, $webshop) or die(mysql_error());
  $row_showpagesRec = mysql_fetch_assoc($showpagesRec);
  $totalRows_showpagesRec = mysql_num_rows($showpagesRec);
  
  $all_showpagesRec = mysql_query($query_showpagesRec);
  $totalRows_showpagesRec = mysql_num_rows($all_showpagesRec);
  
  $totalPages_showpagesRec = ceil($totalRows_showpagesRec/$maxRows_showpagesRec)-1;
  
  $whereClause=$string;
  $_SESSION['search']=$whereClause;
  $clause="&class=".$class."&name=".$name."&type=".$open;
}
?>
<?php  //---------------------------上架功能---------------------------------//
if ((isset($_POST["open_btn"])) && ($_POST["open_btn"] == "上架")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ProdId='".$_POST['select_page'][$i]."'";
      }
	  
	  $updateSQL = "UPDATE compmain SET Online='1' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  
	  $updateGoTo = "adminweb.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------下架功能---------------------------------//
if ((isset($_POST["close_btn"])) && ($_POST["close_btn"] == "下架")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $update_string = "";
      for($i=0;$i<$select_num;$i++){
		if($update_string != "") $update_string = $update_string." || ";
		$update_string = $update_string."ProdId='".$_POST['select_page'][$i]."'";
      }
	  
	  $updateSQL = "UPDATE compmain SET Online='0' WHERE CONCAT($update_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
	  
	  $updateGoTo = "adminweb.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$updateGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------刪除功能---------------------------------//
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_page'])){
      $select_num = count($_POST['select_page']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."ProdId='".$_POST['select_page'][$i]."'";
      }
	  
	  $deleteSQL = "DELETE FROM compmain WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  
	  
	  
	  //delete good images
      mysql_select_db($database_webshop, $webshop);
      $searchSQL = "SELECT * FROM comp_img WHERE CONCAT($delete_string) ";
      $searchImg = mysql_query($searchSQL, $webshop) or die(mysql_error());
	  $row_searchImg = mysql_fetch_assoc($searchImg);
	  
	  
      do{  
	  if(($row_searchImg['img_name'] != "none.gif")){
          //delete images
          unlink("../images/webimg/medium/".$row_searchImg["img_name"]);
  		  unlink("../images/webimg/small/".$row_searchImg["img_name"]);}
      }while ($row_searchImg = mysql_fetch_assoc($searchImg));
	  
	  
	  
	  
	  $deleteImgSQL = "DELETE FROM comp_img WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result2 = mysql_query($deleteImgSQL, $webshop) or die(mysql_error());
	  
	  $deleteGoTo = "adminweb.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<?php  //---------------------------加資料功能-------------------------------//
if ((isset($_POST["add_btn"])) && ($_POST["add_btn"] == "加資料")) { 
	  $addGoTo = "adminaddweb.php";	  
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$addGoTo'";
      echo "</script>"; 
}
?>

<script>
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>
<h3 class=ttl01 >網頁新增及修改管理</h3>
 <form action="" method="POST" name="search_pages" id="search_pages" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable1">
      <tr>
        <td align=center>
          <select name="search_class" style="width:200px">
          <option value="-1" selected>----------------------所有類別-----------------------</option>
          <?php
          do {  
          ?>
            <option value="<?php echo $row_showClassRec['ClassId'];?>" <?php  if(isset($class) && $row_showClassRec['ClassId']==$class) echo "selected='selected'";?>>
		      <?php 
			      echo $row_showClassRec['LarCode']." - ".$row_showClassRec['MidCode']
			  ?>
            </option>
          <?php
          } while ($row_showClassRec = mysql_fetch_assoc($showClassRec));
		  
          /*$rows = mysql_num_rows($showClassRec);
          if($rows > 0) {
            mysql_data_seek($showClassRec, 0);
	        $row_showClassRec = mysql_fetch_assoc($showClassRec);
          }*/
          ?>
          </select>
		  
        </td>
        <td align=center >關鍵字 <input name="search_name" type="text" style="width:100px" value="<?php if(isset($name)) echo $name; ?>"/></td>
        <td align=center >
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
        <td align=center ><input type="submit" name="search_btn"  value="搜尋"/></td>
      </tr>
 </table>
    </form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
<!-------------------------------------------------------------->
<form action="" name="edit_web" method="POST" id="edit_web" enctype="multipart/form-data">
<tr>
  <td height="5%" align="left" colspan="5"><font color="blue">提示：利用上面的搜索功能，可快速找到相關資料。</font></td>
  <td align="center"><input name="add_btn" type="submit" value="加資料" style="margin:5px"></td>
</tr>
<!-------------------------------------------------------------->
<tr align="center" bgcolor="#cococo">
  <td width="6%"  >選擇</td>
  <td width="8%" >圖片</td>
  <td width="20%" >分頁類別</td>
  <td width="44%" >文章簡述</td>
  <td width="10%" >在(離)線</td>
  <td width="12%" >日期</td>
</tr>
<!-------------------------------------------------------------->
<?php do { ?>
  <?php if ($totalRows_showpagesRec > 0) { // Show if recordset not empty ?>
  <tr align="center">
      <td ><input name="select_page[]" type="checkbox" value="<?php echo $row_showpagesRec['ProdId']; ?>" /></td>
       <?php
			  $table_compmain		= SYS_DBNAME . ".compmain";
			  $column = "*";
			  $whereClause = "compmain.ProdId={$row_showpagesRec['ProdId']}";
			  
			  $sql['list']['select'] = array(
					  'mysql'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ", 
					  'mssql'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC ",
					  'oci8'	=> "SELECT * FROM {$table_compmain} INNER JOIN comp_img ON comp_img.ProdId = compmain.ProdId WHERE {$whereClause} ORDER BY img_no ASC "
			  );
			  $row_showsublistRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
			  /*
	 		  $query_showsublistRec = sprintf("SELECT * FROM prodmain 
	                    LEFT JOIN prod_img ON prod_img.ProdId = prodmain.ProdId 
						WHERE ProdNum = %s order by img_no ASC", 
									GetSQLValueString($row_showgoodsRec['ProdNum'], "int"));
		      $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		      $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		      $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
			  */
	  ?>
      
      <td ><a href="admineditweb.php?ProdId=<?php echo $row_showpagesRec['ProdId']; ?>&ProdNum=<?php echo $row_showpagesRec['ProdNum']; ?>">
        <img src="../../images/webimg/small/<?php echo $row_showsublistRec['img_name']; ?>" alt="" name="image" 
         width="90px" height="75px" id="image" align="center" style="padding:5px;"/>
      </td>
      <td ><a href="admineditweb.php?ProdId=<?php echo $row_showpagesRec['ProdId']; ?>&ProdNum=<?php echo $row_showpagesRec['ProdNum']; ?>"><?php echo $row_showpagesRec['LarCode']."/".$row_showpagesRec['MidCode']; ?></a></td>
      <td align="left">
<a href="admineditweb.php?ProdId=<?php echo $row_showpagesRec['ProdId']; ?>&ProdNum=<?php echo $row_showpagesRec['ProdNum']; ?>"><?php echo $row_showpagesRec['ProdDisc']; ?></a>
      </td>
      <td ><?php if($row_showpagesRec['Online'] == 0) echo "離線"; else echo "在線";?></td>
      <td ><?php echo $row_showpagesRec['AddDate']; ?></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_showpagesRec = mysql_fetch_assoc($showpagesRec)); ?>
<!-------------------------------------------------------------->
<tr>
  <td colspan="5" align="left">
    <input type="checkbox" name="all" onclick="check_all(this,'select_page[]')" />全選
    <input name="delete_btn" type="submit" value="刪除" />
    <input name="close_btn" type="submit" value="下架" />
    <input name="open_btn" type="submit" value="上架" />
  </td>
  <td align="center"><input name="add_btn" type="submit" value="加資料" style="margin:5px"></td>
</tr>
<!-----------------------------page control----------------------------->
<tr> 
  <td colspan="6" align="right" valign="top" bgcolor="#cfcfcf">
 <table width="30%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
      <tr>
        <td align="center">共<?php echo $totalRows_showpagesRec ?> 筆資料  <?php echo ($pageNum_showpagesRec+1);?>/<?php echo ($totalPages_showpagesRec+1);?></td>
        <td align="center">
		  <?php if ($pageNum_showpagesRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showpagesRec=%d%s%s", $currentPage, 0, $queryString_showpagesRec, $clause); ?>"><img src="../../images/symbol/First.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showpagesRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_showpagesRec=%d%s%s", $currentPage, max(0, $pageNum_showpagesRec - 1), $queryString_showpagesRec, $clause); ?>"><img src="../../images/symbol/Previous.gif" class="img"/></a>
          <?php } // Show if not first page ?>
		  <?php if ($pageNum_showpagesRec < $totalPages_showpagesRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showpagesRec=%d%s%s", $currentPage, min($totalPages_showpagesRec, $pageNum_showpagesRec + 1), $queryString_showpagesRec, $clause); ?>"><img src="../../images/symbol/Next.gif" class="img"/></a>
          <?php } // Show if not last page ?>
		  <?php if ($pageNum_showpagesRec < $totalPages_showpagesRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_showpagesRec=%d%s%s", $currentPage, $totalPages_showpagesRec, $queryString_showpagesRec, $clause); ?>"><img src="../../images/symbol/Last.gif" class="img"/></a>
          <?php } // Show if not last page ?>
        </td>
      </tr>
    </table>
  </td>
</tr>
</form>

<!-------------------------------------------------------------->
</table>
<?php
mysql_free_result($showpagesRec);
mysql_free_result($showClassRec);
?>
