<?php    
  class Banner {
     //Declare variables
	 private $banner;
	 private $banner1;
	 private $show_banner;
	 private $totalRows_banner;
	 private $connection;
	 private $bannerArray = array(); 
	 
	 //Initialize
	 function Banner($connection){
		$this->connection = $connection;
		$this->getBanner();
	 }
	 
	 //Get config
     function getBanner() {
		 $query = "SELECT * FROM banner ORDER BY Notice_ID ASC";
		 $this->banner = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->banner1 = mysql_query($query, $this->connection) or die(mysql_error());
		 $this->show_banner = mysql_fetch_assoc($this->banner1);
		 $this->totalRows_banner = mysql_num_rows($this->banner);
	
         $this->setBanner();
     }
	 
	 function getImage() {
	     echo $this->show_banner["banner"];
	 }
	 
	 function setBanner() {
		 $number = 0;
         if ($this->totalRows_banner > 0) { 
             while ($row = mysql_fetch_assoc($this->banner)) {
	           $this->bannerArray[$number] = $row["banner"];
	           $number ++;
             }
         }
	 }
	 
	 function fetchBanner() {
	     if($this->show_banner = mysql_fetch_assoc($this->banner1)) return true;
		 else return false;
	 }
	 
	 function showBanner() {
		 echo json_encode($this->bannerArray);
	 }
	 
	 function showTotal() {
		 echo $this->totalRows_banner;
	 }
	 
	 function checkIfNull() {
		 if($this->totalRows_banner > 0) return true;
		 else return false;
	 }
  }
?>