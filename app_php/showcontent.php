<?php
require_once("DBconfig.php");
require_once("DB_Class.php");
$db = new DB();
$db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
$sql="select * from compmain where ProdId=".$_GET["goods_id"];
$db->query($sql);
if($result=$db->fetch_array()){
	$content=$result["MemoSpec"];
}
$db->close();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../style.css" rel="stylesheet" type="text/css" />
<title>顯示商品詳細內容</title>
<font color="#CC3300"><b>商品說明</b></font>
<p><?php echo $content;?></p>
