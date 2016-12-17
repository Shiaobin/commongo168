<?php    
  class IndexList{
     //Declare variables
	 private $indexlist;
	 private $show_indexlist;
	 private $totalRows_indexlist;
	 private $sublist;
	 private $show_sublist;
	 private $totalRows_sublist;
	 private $connection;
	 
	 //Initialize
	 function IndexList($connection){
		$this->connection = $connection;
		$this->getIndexList();
	 }
	 
     function getIndexList() {
		 $query = "SELECT * FROM compclass";
		 $this->indexlist = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->show_indexlist = mysql_fetch_assoc($this->indexlist);
		 $this->totalRows_indexlist = mysql_num_rows($this->indexlist);
     }
	 
	 function getSubIndexList($index_id) {
		 $query = sprintf("SELECT * FROM compclass WHERE LarSeq = %s", GetSQLValueString($index_id, "text"));
		 $this->sublist = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->show_sublist = mysql_fetch_assoc($this->sublist);
		 $this->totalRows_sublist = mysql_num_rows($this->sublist);		 
     }
	 
	 function fetchIndexlist() {
	     if($this->show_indexlist = mysql_fetch_assoc($this->indexlist)) return true;
		 else return false;
	 }
	 
	 function fetchSubIndexlist() {
	     if($this->show_sublist = mysql_fetch_assoc($this->sublist)) return true;
		 else return false;
	 }
	 
	 function checkIfNull() {
		 if($this->totalRows_sublist > 0) return true;
		 else return false;
	 }
	 
	 function showItemName() {
		 echo $this->show_indexlist["LarCode"];
	 }
	 
	 function showItemId() {
		 return $this->show_indexlist["LarSeq"];
	 }
	 
	 function showSubItemId() {
		 echo $this->show_sublist["LarSeq"];
	 }
	 
	 function showSubEndItemId() {
		 echo $this->show_sublist["MidSeq"];
	 }
	 
	 function showSubEndItemName() {
		 echo $this->show_sublist["MidCode"];
	 }
	 
	 function showTotaRowIndexlist() {
	     return $this->totalRows_indexlist;
	 }
  }
?>