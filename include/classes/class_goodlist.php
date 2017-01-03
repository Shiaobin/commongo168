<?php
  class GoodList{
     //Declare variables
	 private $goodlist;
	 private $show_goodlist;
	 private $totalRows_goodlist;
	 private $sublist;
	 private $show_sublist;
	 private $totalRows_sublist;
	 private $connection;

	 //Initialize
	 function goodList($connection){
		$this->connection = $connection;
		$this->getgoodList();
	 }

     function getgoodList() {
		 $query = "SELECT * FROM prodmain";
		 $this->goodlist = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->show_goodlist = mysql_fetch_assoc($this->goodlist);
		 $this->totalRows_goodlist = mysql_num_rows($this->goodlist);
     }

	 function getSubgoodList($good_id) {
		 $query = sprintf("SELECT * FROM prodmain WHERE ProdId = %s", GetSQLValueString($good_id, "text"));
		 $this->sublist = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->show_sublist = mysql_fetch_assoc($this->sublist);
		 $this->totalRows_sublist = mysql_num_rows($this->sublist);
     }

	 function fetchGoodlist() {
	     if($this->show_goodlist = mysql_fetch_assoc($this->goodlist)) return true;
		 else return false;
	 }

	 function fetchSubgoodlist() {
	     if($this->show_sublist = mysql_fetch_assoc($this->sublist)) return true;
		 else return false;
	 }

	 function checkIfNull() {
		 if($this->totalRows_sublist > 0) return true;
		 else return false;
	 }

	 function showItemName() {
		 echo $this->show_goodlist["ProdName"];
	 }

	 function showItemId() {
		 return $this->show_goodlist["ProdId"];
	 }

	 function showSubItemId() {
		 echo $this->show_sublist["ProdId"];
	 }

	 function showSubEndItemId() {
		 echo $this->show_sublist["ProdId"];
	 }

	 function showSubEndItemName() {
		 echo $this->show_sublist["ProdName"];
	 }
  }
?>
