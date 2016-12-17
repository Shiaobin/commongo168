<?php 
/* <%if Session("estore_userid")<>"" then %>

<%
sqlinfo = "select * from UserMain where UserId='"&session("estore_userid")&"'"
set rsinfo=Server.Createobject("ADODB.RecordSet")
rsinfo.Open sqlinfo,conn,1,1
%> */
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
	 <center>
	  <form method="post" name="loginbox" action="../../userlogin.php" onsubmit="return checkform();">
		 <TABLE width="100%" class="formTable" ><tr ><td>
          <font size=3>帳&nbsp;號:<input type="text" class=sizeSs name="userid" size="20">
		  <input type=hidden value=j name=whereurl>
		  </td>
		</tr>
		<tr >
		  <td>
          <font size=3>密&nbsp;碼:<input type="password" class=sizeSs name="password" size="20"> 
			<input type="hidden" name="Userlogin" value="True">		  
			</td>
		</tr>

		<tr><td>
		<input type="submit" name="submit" value="登錄" style="font-size:16px;width:60px;height:30px;cursor:hand;">
        <input type="button" value="註冊" onclick="javascript:location.href='reg_preview.php'" style="font-size:16px;width:60px;height:30px;cursor:hand;">
          </td></tr></table>
		</form>
       </center>
<?php
}
?>

<!--%end if%-->