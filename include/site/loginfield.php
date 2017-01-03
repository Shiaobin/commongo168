<!---------------------------------login成功----------------------------------------------------------->
<?php if(isset($_SESSION['MM_Username'])){ ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableLayout02" background="../images/loginfield/login.png">
<tr><td height=30 ></td></tr>
<tr><td align=center >歡迎會員<font color=red><b><?php
		  echo $_SESSION['MM_Username'];?></b></font><br>如需修改個人資料、<br>查看訂單，請到會員中心！
</td></tr>
<tr><td align=center>>><a href="../../modifymember.php?usernum=<?php echo $_SESSION['MM_Usernum'];?>">會員中心</a> |
  			<a href="../../userlogout.php">退出登入</a></td></tr>
<tr><td></td></tr>
</table>

<!---------------------------------login----------------------------------------------------------->
<?php }else{ ?>
<form id="login" name="login" method="POST" action="include/action/checklogin.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable1"  background="../images/loginfield/login.png">
<tr><td height=52 ></td></tr>
<tr><td align="center"><h3>帳號:<input type="text"  name="UserId"  class="sizeSs"></h3>
</td></tr>
<tr><td align="center"><h3>密碼:<input type="password"  name="UserPassword" class="sizeSs" ></h3>
</td></tr>

<tr><td align="center">
<input name="login" type="submit"  id="login" value="登入" style="font-size:16px;width:50px;height:25px"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input name="create" type="submit" id="create" value="註冊" style="font-size:16px;width:50px;height:25px"/>
</td></tr>
<tr><td height=12></td></tr>
</table>
</form>
<?php } ?>





