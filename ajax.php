<?php
require('utility/init.php');
require("include/classes/Car.class.php");

//縣市地區處理
@$id = $_POST['city'];
if($id !="")
{

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