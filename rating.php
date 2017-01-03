<?php
require_once 'connections/Data/db_config.php';

    try{

        $db_con = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_DATABASE,DB_USER,DB_PASSWORD);
        $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo $e->getMessage();
    }

	if($_POST)
	{
		$OrderNum = $_POST['OrderNum'];
		$SellerRating = $_POST['rating'];

		$stmt = $db_con->prepare("UPDATE orderlist SET SellerRating=:SellerRating WHERE OrderNum=:OrderNum");
		$stmt->bindParam(":SellerRating", $SellerRating);
		$stmt->bindParam(":OrderNum", $OrderNum);

		if($stmt->execute())
		{
			echo "Successfully updated";
		}
		else{
			echo "Query Problem";
		}
	}

?>
