<?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){ 
echo "<table>
 <tr><th ><font size=4px>
 會 員 中 心:&nbsp;&nbsp;";?>
 <a href="my_info.php">個人資料</a> |&nbsp; <a href="my_order.php">個人訂單 |&nbsp; <a href="userlogout.php">登出</a></font>
 </th></tr>
   
  <tr> 
    <td>
    </table>
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];
$username=$_SESSION['username'];


$query="select * from usermain where UserId='".$userid."' and UserPassword='".$password."'";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs = mysql_fetch_array($result)){ ?>
<table  width="100%">
<tr> <td>以下是您的個人資料，修改完成後單擊「確認修改」：</td></tr>

        <form name="myinfo" action="my_info_save.php" method="post">
        <tr> 
            <td >姓名:<input type="text" name="Username" value="<?php echo $rs['UserName']; ?>"  class="sizeS" size="20" ></td>
        </tr>
	<tr> 
            <td >密 碼:<input type="password" name="pw1" value="<?php echo $rs['UserPassword']; ?>" class="sizeS" size="20" ></td>
        </tr>

        <tr> 
            <td >信 箱:<input type="text" name="UserMail" value="<?php echo $rs['UserMail']; ?>" class="sizeM" size="20" ></td>
        </tr>
		<tr> 
            <td >LINE_ID:<input type="text" name="UserQQ" value="<?php echo $rs['UserQQ']; ?>" class="sizeS" size="20" ></td>
        </tr>
		<tr> 
            <td >性 別:<input name="Sex" type="radio" value="1" <?php if($rs['Sex']==1) echo "checked"; ?>>男<input type="radio" name="Sex" value="0" <?php if($rs['Sex']==0) echo "checked"; ?>>女		  
        </td></tr>
		<tr> 
            <td >婚 姻:<input name="Maritalstatus" type="radio" value="1" <?php if($rs['MaritalStatus']==1) echo "checked"; ?>>未婚<input type="radio" name="Maritalstatus" value="0" <?php if($rs['MaritalStatus']==0) echo "checked"; ?>>已婚		  
        </td></tr>
        <?php
		$Date= $rs['Birthday'];
		$Ym=explode('-',$Date);   
        $day=explode('-',$Ym[2]); 
		?>
		
        <tr> 
            <td >生 日:<input type="text" name="Birthday" value="<?php echo $Ym[0];?>" class="sizeSss" size="20" >年<select size="1" name="D1">
  <option value="<?php echo $Ym[1];?>"><?php echo $Ym[1];?></option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  </select>月<select size="1" name="D2">
  <option value="<?php echo $day[0];?>"><?php echo $day[0];?></option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  </select>日</td>
        </tr>
<!--input type="hidden" name="IncomeRange" value="<%=rsinfo("IncomeRange")%>" class="sizeS" -->
        <tr> 
            <td >職 業:<input type="text" name="Occupation" value="<?php echo $rs['Occupation']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr> 
            <td >公 司:<input type="text" name="CompanyName" value="<?php echo $rs['CompanyName']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr> 
            <td >電 話:<input type="text" name="HomePhone" value="<?php echo $rs['HomePhone']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr> 
            <td height="25" >手 機:<input type="text" name="CompPhone" value="<?php echo $rs['CompPhone']; ?>" class="sizeM" size="20" ></td>
        </tr>
        <tr> 
            <td >地 址:<input type="text" name="Address" value="<?php echo $rs['Address']; ?>" class="sizeML" size="20" ></td>
        </tr>
        <tr> 
            <td >郵遞區號:<input type="text" name="ZipCode" value="<?php echo $rs['ZipCode']; ?>" class="sizeSss" size="20" ></td>
        </tr>
		 <tr> 
            <td >備 忘 錄:<br><TEXTAREA type="text" name="Memo"  ROWS="3" COLS="30"><?php echo $rs['Memo']; ?></TEXTAREA></td>
        </tr>
        <tr> 
            <td >是否接收郵件通知:<?php if($rs['WantMessage']==1) ?><input name="WantMessage" type="radio" value="1" <?php if($rs['WantMessage']==1) echo "checked"; ?>>
            願意 
            <input type="radio" name="WantMessage" value="0" <?php if($rs['WantMessage']==0) echo "checked"; ?>>
            暫時不要
			
       </td> </tr>

 <tr> <td>
		  <input type="submit" name="Submit" value="確認修改">&nbsp;&nbsp;&nbsp;&nbsp;    
          <input name="Submit2" type="reset" value="不做修改">
        </form>        
	</td></tr> </table> 
<?php    
}
}else{
include("../usererror.php");
}
?>

