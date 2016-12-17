<?php    
  class Member {
     //Declare variables
	 private $member;
	 private $show_member;
	 private $totalRows_member;
	 private $connection;
	 
	 //Initialize
	 function Member($connection){
		$this->connection = $connection;
	 }
	 
	 function getMember($member_id, $member_password) {
         $query = sprintf("SELECT * FROM usermain WHERE UserId=%s AND UserPassword=%s", GetSQLValueString($member_id, "text"), GetSQLValueString($member_password, "text"));
	     $this->member = mysql_query($query, $this->connection) or die(mysql_error());
	     $this->show_member = mysql_fetch_assoc($this->member);
         $this->totalRows_member = mysql_num_rows($this->member);
     }
	 
	 function getMemberInfo($member_id) {
         $query = sprintf("SELECT usernum, UserName FROM usermain WHERE usernum=%s", GetSQLValueString($member_id, "text"));
	     $this->member = mysql_query($query, $this->connection) or die(mysql_error());
	     $this->show_member = mysql_fetch_assoc($this->member);
         $this->totalRows_member = mysql_num_rows($this->member);
     }
	 
	 function checkIfMember(){
		 if($this->totalRows_member > 0) return true;
		 else return false;
	 }
	 
	 function showNo() {
         return $this->show_member["usernum"];
     }
	 
	 function showNoStr() {
         echo $this->show_member["usernum"];
     }
	 
     function showName() {
         echo $this->show_member["UserName"];
     }
  }
?>
