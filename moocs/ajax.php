<?php
require_once('../utility/init.php');
if(isset($_POST['status']) && $_POST['status']=="spec_1")
{
	$ProdId=$_POST['prod'];
	$ProSerial_1=$_POST['num'];
	$table_prodspec		= SYS_DBNAME . ".prodspec";
	$whereClause = "ProdId='{$ProdId}' AND ProSerial_1='{$ProSerial_1}'";
  	dbDelete( $table_prodspec, $whereClause );
	echo "刪除成功";
}
if(isset($_POST['status']) && $_POST['status']=="spec_2")
{
	$ProdId=$_POST['prod'];
	$ProSerial_2=$_POST['num'];
	$table_prodspec		= SYS_DBNAME . ".prodspec";
	$whereClause = "ProdId='{$ProdId}' AND ProSerial_2='{$ProSerial_2}'";
  	dbDelete( $table_prodspec, $whereClause );
	echo "刪除成功";
}
if(isset($_POST['city']))
{
	@$id = $_POST['city'];
 	$table_area		= SYS_DBNAME . ".area";
 	$column = "*";
	$where = "city_id='{$id}'";
 	$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_area} WHERE {$where}",
		'mssql'	=> "SELECT * FROM {$table_area} WHERE {$where}",
		'oci8'	=> "SELECT * FROM {$table_area} WHERE {$where}"
	 );
 	$all_area = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	foreach($all_area as $rs)
    {
		echo "<option value='".$rs['id']."'>".$rs['area']."</option>";
	}
}
?>
