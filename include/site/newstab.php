<?php  //-----------------------------取得最新消息資訊----------------------------------//
$currentPage = $_SERVER["PHP_SELF"];
            // $sysConnDebug = true;
//$NewsClass = 1;

$maxRows_NewsRec = 6;
$pageNum_NewsRec = 0;
if (isset($_GET['pageNum_NewsRec'])) {
    $pageNum_NewsRec = $_GET['pageNum_NewsRec'];
}
$startRow_NewsRec = $pageNum_NewsRec * $maxRows_NewsRec;
       /*
$query_NewsRec = "SELECT * FROM news WHERE Online='1' ORDER BY uup, PubDate DESC";   //設置NewsClass的值來取得不同新聞
$query_limit_NewsRec = sprintf("%s LIMIT %d, %d", $query_NewsRec, $startRow_NewsRec, $maxRows_NewsRec);
$newsRec = mysql_query($query_limit_NewsRec, $webshop) or die(mysql_error());
$row_newsRec = mysql_fetch_assoc($newsRec);
$total_newsRec = mysql_num_rows($newsRec);
*/
$table_news		= SYS_DBNAME . ".news";
$column = "*";
$whereClause = "Online='1'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC LIMIT {$startRow_NewsRec}, {$maxRows_NewsRec} ",
		'mssql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC LIMIT {$startRow_NewsRec}, {$maxRows_NewsRec} ",
		'oci8'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC LIMIT {$startRow_NewsRec}, {$maxRows_NewsRec} "
);
$row_newsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);

//print_r($row_newsRec);
if(isset($_GET['totalRows_NewsRec'])){
    $totalRows_NewsRec = $_GET['totalRows_NewsRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC ",
		'mssql'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC ",
		'oci8'	=> "SELECT * FROM {$table_news} WHERE {$whereClause} ORDER BY uup, PubDate DESC "
);
$row_newsRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_NewsRec = sizeof($row_newsRec);
}

$totalPages_NewsRec = ceil($totalRows_NewsRec/$maxRows_NewsRec)-1;

$queryString_NewsRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
    $params = explode("&", $_SERVER['QUERY_STRING']);
    $newParams = array();
    foreach ($params as $param) {
        if (stristr($param, "pageNum_NewsRec") == false && stristr($param, "totalRows_NewsRec") == false) {
            array_push($newParams, $param);
        }
	}
        if (count($newParams) != 0) {
            $queryString_NewsRec = "&" . htmlentities(implode("&", $newParams));
        }
}
$queryString_NewsRec = sprintf("&totalRows_NewsRec=%d%s", $totalRows_NewsRec, $queryString_NewsRec);
?>
<!--------------------------------------------------------------------------------->
 <dl id="newsList">
<table width="96%" border="0" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0" class="tableLayout02">
<!-------------------------------------------------------------->

<?php if (sizeof( $row_newsRec ) > 0) { // Show if recordset not empty ?>

<form name="updatePop" id="updatePop" action="" method="post">
<?php
foreach ($row_newsRec as $key => $array) {
?>

	<tr>
    <td width="10%" align="left">
		<img src="../../images/newsimg/small/<?php echo $array['imgfull']; ?>" alt="" name="image" width="35px" id="image" align="center" style="padding:5px;"/>
    </td>
<!-------------------------------------------------------------->
    <td width="17%" align="left">
		<font color=#0000ff><?php echo date('Y-m-d',strtotime($array["PubDate"]));?></font>
    	<input type="hidden" name="NewsID" id="NewsID" value="<?php echo $array['NewsID']; ?>"/>
    </td>
<!-------------------------------------------------------------->
    <td width="58%" align="left">
    <a href="shownewsdetail.php?NewsID=<?php echo $array['NewsID']; ?>">
		<?php echo $array['NewsTitle']; ?>
    </a>
    </td>
<!-------------------------------------------------------------->
    <td width="15%" align="left">人氣值:<?php echo $array["cktimes"];?></td>
    </tr>

<?php
} ?>
</form>
<?php } // Show if recordset not empty ?>
<!-------------------------------------------------------------->
	<tr>
    <td><p></p></td>
    </tr>

    <tr>
    <td colspan="4" align="right">
        <a href="news.php"><img src="images/button/btn_more.gif" class="img"/></a>
    </td>
    </tr>
</table>
</dl>
<?php
     //mysql_free_result($newsRec);
?>
