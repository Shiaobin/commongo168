<?php

if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
?>
<TABLE  class='table table-bordered table-striped' >
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

	  <form method="post" name="loginbox" action="userlogin.php" onsubmit="return checkform();">
		 <TABLE  class='table table-bordered table-striped' ><tr ><td>
          <font size=3>帳&nbsp;號:<input type="text"  name="userid"  class="input-medium">

		  </td>
		</tr>
		<tr >
		  <td>
          <font size=3>密&nbsp;碼:<input type="password"  name="password"  class="input-medium">
			<input type="hidden" name="Userlogin" value="True">
			</td>
		</tr>

		<tr><td>
		<input type="submit" name="submit" value="登錄" >
        <input type="button" value="註冊" onclick="javascript:location.href='reg_preview.php'" >
        <input type="button" value="忘記密碼" onclick="javascript:location.href='my_accounts.php?forget=true'" style="width:90px;cursor:hand;">
          </td></tr></table>
		</form>
<?php
}
?>

<!--%end if%-->