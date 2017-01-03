<?php
  class Config {
     //Declare variables
	 private $config;
	 private $show_config;
	 private $totalRows_config;
	 private $connection;

	 //Initialize
	 function Config($connection){
		$this->connection = $connection;
		$this->getConfig();
	 }

	 //Get config
     function getConfig() {
         $query = "SELECT * FROM shopsetup";
	     $this->config = mysql_query($query, $this->connection) or die(mysql_error());
	     $this->show_config = mysql_fetch_assoc($this->config);
         $this->totalRows_config = mysql_num_rows($this->config);
     }

	 //Check if allow to pay without join the member
	 function isAllowNotMember() {
	     if($this->show_config["reg"]) return true;
		 else                                 return false;
	 }

	 //Show website title
     function showTitle() {
         echo $this->show_config["sitename"]."-".$this->show_config["siteurl"];
     }

	 //Show website name
     function showName() {
         echo $this->show_config["sitename"];
     }

	 //Show telphone
     function showTel() {
         echo $this->show_config["adm_tel"];
     }

	 //Show fax
     function showFax() {
         echo $this->show_config["adm_qq"];
     }

	 //Show address
     function showAddress() {
         echo $this->show_config["adm_address"];
     }

	  //Show address
     function showMail() {
         echo $this->show_config["adm_mail"];
     }
  }
?>