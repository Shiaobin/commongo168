<?php

if(isset($_POST['userid']) && isset($_POST['name']) && isset($_POST['UserMail']) && isset($_POST['submit']))
{	
	$userid=mysql_real_escape_string($_POST['userid']);
	$UserName=mysql_real_escape_string($_POST['name']);
	$UserMail=mysql_real_escape_string($_POST['UserMail']);  
	$query="select * from usermain where UserId='".$userid."' AND UserName='".$UserName."' AND UserMail='".$UserMail."'";
	$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
	$num=mysql_num_rows($result);
	if($num==1)
	{
		$rs=mysql_fetch_array($result);
		$password=$rs['UserPassword'];
		echo "<script>";
		echo "alert('您的密碼為: [ ".$password." ] 。');";
		echo "</script>";
	}
	else
	{
		echo "<script>";
		echo "alert('對不起，查無資料。');";
		echo "</script>";		 
	}
}
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
?>
<TABLE width="100%" class="tableLayout01" >
<TR><TD>歡迎會員<br>
如需修改個人資料、請到會員中心！<br>
                                &nbsp;&nbsp; >><a href="my_accounts.php">會員中心</a><font color="#000000"> | </font>
                                 <a href="userlogout.php">登出</a></td>
		</tr></table>
<?php
}else{
	//<% else %>
?>

	  <script language="JavaScript" src="jsroot/checklogin.js"></script>
	  <h3>忘記密碼查詢</h3>
      </br>
	  <form method="post" name="forgetbox" action="my_accounts.php?forget=true" onsubmit="return checkform();">
		 <TABLE width="100%" class='table table-bordered table-striped' ><tr ><td>
          <font size=3>請輸入註冊帳號:<input type="text" class="sizeSs" name="userid" size="20">
		  </td>
		</tr>
		<tr >
		  <td>
          <font size=3>用戶姓名:<input type="text" class="sizeSs" name="name" size="20"> 
			  
			</td>
		</tr>
		<tr >
		  <td>
          <font size=3>信箱:<input type="text" class="sizeSs" name="UserMail" size="20">   
			</td>
		</tr>

		<tr><td>
		<input type="submit" name="submit" value="查詢" style="font-size:16px;width:60px;height:30px;cursor:hand;">

          </td></tr></table>
		</form>
<?php
}
?>