<!-----------------------------------------------------分頁功能---------------------------------------------------------->
<?php
$currentPage = $_SERVER["PHP_SELF"];//獲取當前頁面的地址

$maxRows_showmemRec = 30;
$pageNum_showmemRec = 0;

if (isset($_GET['pageNum_showmemRec'])) {//確定變數是否有被設置，簡單講就是判斷是不是null
  $pageNum_showmemRec = $_GET['pageNum_showmemRec'];
}
$startRow_showmemRec = $pageNum_showmemRec * $maxRows_showmemRec;

$column = "*";
$table_usermain		= SYS_DBNAME . ".usermain";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}", 
		'mssql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}",
		'oci8'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}"
);
$row_showmemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
//
//mysql_select_db($database_webshop, $webshop);
//$query_showmemRec = "SELECT * FROM usermain ORDER BY SignDate DESC";
//$query_limit_showmemRec = sprintf("%s LIMIT %d, %d", $query_showmemRec, $startRow_showmemRec, $maxRows_showmemRec);
//$showmemRec = mysql_query($query_limit_showmemRec, $webshop) or die(mysql_error());
//$row_showmemRec = mysql_fetch_assoc($showmemRec);//從資料集取得的陣列，索引值只能是字串(關聯索引)


//$totalPages_showmemRec_pages總頁數 $pageNum_showmemRec+1當次頁數


if (isset($_GET['totalRows_showmemRec'])) {
  $totalRows_showmemRec = $_GET['totalRows_showmemRec'];
} else {
  $all_showmemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_showmemRec = sizeof($all_showmemRec);//取得結果中列的數目
}
$totalPages_showmemRec = ceil($totalRows_showmemRec/$maxRows_showmemRec)-1;//取得大於指定數的最小整數值(可變成兩頁)
$totalPages_showmemRec_pages = ceil($totalRows_showmemRec/$maxRows_showmemRec);

$queryString_showmemRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);//切割字串並放入Array陣列中
  $newParams = array();
  foreach ($params as $param) {//將所有資料列出
    if (stristr($param, "pageNum_showmemRec") == false && 
        stristr($param, "totalRows_showmemRec") == false) {
      array_push($newParams, $param);//不分大小寫找出字串第一次出現的地方
    }//一個或多個單元加入陣列末尾
  }
  if (count($newParams) != 0) {
    $queryString_showmemRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_showmemRec = sprintf("&totalRows_showmemRec=%d%s", $totalRows_showmemRec, $queryString_showmemRec);

?>
<!-----------------------------------------------------搜尋功能---------------------------------------------------------->
<?php
if ((isset($_POST["search_btn"])) && ($_POST["search_btn"] == "搜尋")) {
	/*mysql_select_db($database_webshop, $webshop);
	$sql="CREATE TABLE shop_temp AS SELECT * FROM usermain;";
	mysql_query($sql); */
	
	
  $nameID = trim($_POST["search_nameID"]);//去除字符串首尾空白等特殊符號或指定字符序列
  $name = trim($_POST["search_name"]);
  $date = $_POST["search_type"];
  
  $date_yesterday = date("Y-m-d", strtotime('-1 day'));
  $date_today = date("Y-m-d", strtotime('0 day'));
  $date_tomorrow = date("Y-m-d", strtotime('1 day'));


  $string = "";
  		if($date == "0")
      		$string = $string."SignDate >= '$date_yesterday' && SignDate <= '$date_today'";
  		else if($date == "1")
      		$string = $string."SignDate >= '$date_today' ";
  		else if($date == "2")
      		$string = $string."SignDate <= '$date_tomorrow'";
  
  

  if($nameID != "") {
    $string = $string." && "."UserId LIKE '%$nameID%'";
  }
  if($name != "") {
    $string = $string." && "."UserName LIKE '%$name%'";
  }

  
  
  $maxRows_showmemRec = 30;
  $pageNum_showmemRec = 0;//確定變數是否有被設置，簡單講就是判斷是不是null
  if (isset($_GET['pageNum_showmemRec'])) {
     $pageNum_showmemRec = $_GET['pageNum_showmemRec'];
  }
  $startRow_showmemRec = $pageNum_showmemRec * $maxRows_showmemRec;

  $column = "*";
  $table_usermain		= SYS_DBNAME . ".usermain";
  $whereClause = "CONCAT($string)";
  
  $sql['list']['select'] = array(
		  'mysql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}", 
		  'mssql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}",
		  'oci8'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause} ORDER BY SignDate DESC LIMIT {$startRow_showmemRec}, {$maxRows_showmemRec}"
  );
  $row_showmemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
  $totalRows_shownewsRec = sizeof($row_showmemRec);
/*	
  mysql_select_db($database_webshop, $webshop);
  $query_showmemRec = "SELECT * FROM usermain WHERE CONCAT($string) ORDER BY SignDate DESC";
  $query_limit_showmemRec = sprintf("%s LIMIT %d, %d", $query_showmemRec, $startRow_showmemRec, $maxRows_showmemRec);
  $showmemRec = mysql_query($query_limit_showmemRec, $webshop) or die(mysql_error());
  $row_showmemRec = mysql_fetch_assoc($showmemRec);//從資料集取得的陣列，索引值只能是字串(關聯索引)
 */
  if (isset($_GET['totalRows_showmemRec'])) {
     $totalRows_showmemRec = $_GET['totalRows_showmemRec'];
  } else {
     $all_showmemRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
     $totalRows_showmemRec = sizeof($all_showmemRec);//取得結果中列的數目
  }
  $totalPages_showmemRec = ceil($totalRows_showmemRec/$maxRows_showmemRec)-1;//取得大於指定數的最小整數值(可變成兩頁)

	//$drop="DROP TABLE shop_temp;";
	//mysql_query($drop);
}
?>
<!------------------------------------------------------刪除客戶---------------------------------------------------------------->
<?php 
if ((isset($_POST["delete_btn"])) && ($_POST["delete_btn"] == "刪除")) {
    if(isset($_POST['select_member'])){
      $select_num = count($_POST['select_member']);
	  $delete_string = "";
      for($i=0;$i<$select_num;$i++){
		if($delete_string != "") $delete_string = $delete_string." || ";
		$delete_string = $delete_string."UserId='".$_POST['select_member'][$i]."'";
      }
	  
	  $table_usermain		= SYS_DBNAME . ".usermain";
	  $whereClause = "CONCAT($delete_string)";
					
	  dbDelete( $table_usermain, $whereClause );
	  /*
	  $deleteSQL = "DELETE FROM usermain WHERE CONCAT($delete_string)";
      mysql_select_db($database_webshop, $webshop);
      $Result = mysql_query($deleteSQL, $webshop) or die(mysql_error());
	  */
	  $deleteGoTo = "adminclient.php";
	  echo "<script type='text/javascript'>";
      echo "window.location.href='$deleteGoTo'";
      echo "</script>";
    }
}
?>
<!--------------------------------------------------------------------------------------------------------------------------------->

<script>
function check_all(obj,cName) 
{ 
    var checkboxs = document.getElementsByName(cName); 
    for(var i=0;i<checkboxs.length;i++){checkboxs[i].checked = obj.checked;} 
} 
</script>

<h3 class=ttl01 >客戶會員管理</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout01">
  <tr>
  <td width="100%" height="35%" colspan="8" bgcolor="#cfcfcf" >
    <table width="100%" border="0">
    <form action="" method="POST" name="search_member" id="search_member" enctype="multipart/form-data">
      <tr>
        <td width="30%" align="left">按會員ID搜索 <input name="search_nameID" type="text" class=sizeS /></td>
        <td width="30%" align="left">按會員姓名搜索 <input name="search_name" type="text" class=sizeS /></td>
        <td width="30%" align="left">註冊時間
          <label>
            <input type="radio" name="search_type" value="0" id="search_type_0" />
            昨天</label>
          <label>
            <input type="radio" name="search_type" value="1" id="search_type_1" />
            今天</label>
          <label>
            <input type="radio" name="search_type" value="2" id="search_type_2" checked/>
            所有</label>
        </td>
        <td width="10%" align="left"><input type="submit" name="search_btn"  value="搜尋"/></td>
      </tr>
    </form>  
    </table>
  </td>
  </tr>
<!---------------------------------------------------------------------------------------------------------------------------------->
  <tr align="center">
   	<td width="7%" height="10%" bgcolor="#DFDFDF">編號</td>
   	<td width="20%" height="10%" bgcolor="#DFDFDF">會員ID</td>
    <td width="17%" height="10%" bgcolor="#DFDFDF">會員姓名</td>
    <td width="14%" height="10%" bgcolor="#DFDFDF">會員等級</td>
    <td width="27%" height="10%" bgcolor="#DFDFDF">註冊日期</td>
    <td width="10%" height="10%" bgcolor="#DFDFDF">狀態</td>
    <td width="5%" height="10%" bgcolor="#DFDFDF">點選</td>
  </tr>
<!---------------------------------------------------------------------------------------------------------------------------------->
<form action="" name="editord" method="POST" id="editord" enctype="multipart/form-data">
  <?php foreach ($row_showmemRec as $key => $array){ ?>
    <?php if ($totalRows_showmemRec > 0) { // Show if recordset not empty ?>
	<tr align="center">
	 
        <td height="20%"><?php echo $array['usernum']; ?></td>
        <td height="10%"><!--用於上傳檔案表單傳送編碼方式+標記對象名稱-->
          <a href="admineditclient.php?UserId=<?php echo $array['UserId']; ?>">
		    <?php echo $array['UserId']; ?>
          </a></td>
        <td height="15%"><?php echo $array['UserName']; ?></td>
        
        <td height="15%"><?php echo $array['UserType']; ?></td>
        <td height="15%"><?php echo $array['SignDate']; //*?></td>
        <td height="15%"><?php if($array['Status']==0) echo "正常";
		                       else echo "凍結";?></td>
        <td height="10%" align="center"><input name="select_member[]" type="checkbox"  value="<?php echo $array['UserId'];?>"/></td>

	</tr>
    <?php } // Show if recordset not empty ?>
  <?php } ?>
<!---------------------------------------------------------------------------------------------------------------------------------->
  <tr>
  	<td width="100%" height="20%" colspan="6" align="right"><input name="delete_btn" type="submit" value="刪除" /></td>
    <td align="center"><input type="checkbox" name="all" onclick="check_all(this,'select_member[]')" /></td>
  </tr>
</form>

<!-------------------------------------------------------------------------------------------------------------------------------->   
  <tr>
    <td width="100%" height="20%" colspan="7" align="right" bgcolor="#cfcfcf">
	  <table  border="0">
      	<tr>
            <td>
            	<table border="0">
                    <tr>
                      <td height="54">
                        <?php if ($pageNum_showmemRec > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_showmemRec=%d%s", $currentPage, 0, $queryString_showmemRec); ?>">
                          <img src="../images/symbol/First.gif" class="img"/>
                        </a>
                        <?php } // Show if not first page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showmemRec > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_showmemRec=%d%s", $currentPage, max(0, $pageNum_showmemRec - 1), $queryString_showmemRec); ?>">
                          <img src="../images/symbol/Previous.gif" class="img"/>
                        </a>
                        <?php } // Show if not first page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showmemRec < $totalPages_showmemRec) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_showmemRec=%d%s", $currentPage, min($totalPages_showmemRec, $pageNum_showmemRec + 1), $queryString_showmemRec); ?>">
                          <img src="../images/symbol/Next.gif" class="img"/>
                        </a>
                        <?php } // Show if not last page ?>
                      </td>
                      <td>
                        <?php if ($pageNum_showmemRec < $totalPages_showmemRec) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_showmemRec=%d%s", $currentPage, $totalPages_showmemRec, $queryString_showmemRec); ?>">
                          <img src="../images/symbol/Last.gif" class="img"/>
                        </a>
                        <?php } // Show if not last page ?>
                      </td>
                    </tr> 
                 </table> 
			</td>
            <td width="100%" height="20%" align="left">總:<?php echo $pageNum_showmemRec+1 ?>/<?php echo $totalPages_showmemRec_pages ?>頁　　總共:<?php echo $totalRows_showmemRec ?>個客戶 [<?php echo $maxRows_showmemRec ?>個/頁]</td>
      	</tr>
      </table>
    </td>
  </tr>
</table>
<?php
//mysql_free_result($showmemRec);
?>
