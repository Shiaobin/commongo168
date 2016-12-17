<?php
include("../connections/webshop.php");
$whereclause="Reply=0 && set_open=1";
$query= "SELECT Reply FROM contact_msg where ".$whereclause;
$result = mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
$count=mysql_num_rows($result);
echo "(".$count.")";
?>