<center><table width="80%" height="200" border="0" BORDERCOLOR="#000000" cellpadding="5" cellspacing="0" >
	<tr>
    <td align="center">
		<a href="../checkorder.php"><img src="../images/loginfield/member.jpg" width="78px" height="65px"/><br>遊客查詢</a>
    </td>
    <?php //$member->getMemberInfo($_SESSION['MM_Username']);?>
    <td align="center">
    	<a href="../chkordlist.php?mem_no=<?php echo $_SESSION['MM_Usernum'];?>"><img src="../images/loginfield/member.jpg" width="78px" height="65px"/><br>會員查詢</a>
    </td>
    </tr>
</table>
r