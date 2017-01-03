<?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){
echo "<table>
 <tr><th ><font size=4px>
 會 員 中 心:&nbsp;&nbsp;";?>
 <a href="my_info.php">個人資料</a> |&nbsp; <a href="my_order.php">個人訂單 |&nbsp; <a href="userlogout.php">登出</a></font>
 </th></tr>

  <tr>
    <td>

      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];


$UserName=$_POST['Username'];
$UserPassword=$_POST['pw1'];
$UserMail=$_POST['UserMail'];
$UserQQ=$_POST['UserQQ'];
if(isset($_POST['Sex'])) {
	$Sex=$_POST['Sex'];
}
else{
    $Sex="2";
}
if(isset($_POST['MaritalStatus'])) {
	$Maritalstatus=$_POST['MaritalStatus'];
}
else{
    $Maritalstatus="2";
}
$Birthday=$_POST['Birthday'];
$D1=$_POST['D1'];
$D2=$_POST['D2'];
$Occupation=$_POST['Occupation'];
$CompanyName=$_POST['CompanyName'];
$HomePhone=$_POST['HomePhone'];
$CompPhone=$_POST['CompPhone'];
$Address=$_POST['Address'];
$ZipCode=$_POST['ZipCode'];
$Memo=$_POST['Memo'];
$WantMessage=$_POST['WantMessage'];
?>

以下是您修改後的個人資料，確認無誤後單擊「完成修改」：</td></tr>
        <tr>
          <td >單位名稱:<?php echo $UserName; ?>　</td>
        </tr>
        <tr>
          <td >密&nbsp; 碼:<?php echo $UserPassword; ?>　</td>
        </tr>
        <tr>
          <td >LINE_ID:  <?php echo $UserQQ; ?>　</td>
        </tr>
        <tr>
          <td >性&nbsp; 別:
		  <?php if($Sex==1){ echo "男";} ?> <?php if($Sex==0){ echo "女";} ?>
        </td></tr>
		<tr>
          <td >婚&nbsp; 否:
		  <?php if($Maritalstatus==1){ echo "未婚";} ?> <?php if($Maritalstatus==0){ echo "已婚";} ?>
        </td></tr>
        <tr>
          <td >生&nbsp; 日:<?php echo $Birthday; ?>年<?php echo $D1; ?>月<?php echo $D2; ?>日</td>
        </tr>
        <tr>
          <td >職&nbsp; 業:<?php echo $Occupation; ?>　</td>
        </tr>
        <tr>
          <td >公&nbsp; 司:<?php echo $CompanyName; ?>　</td>
        </tr>
        <tr>
          <td >電&nbsp; 話:<?php echo $HomePhone; ?>　</td>
        </tr>
        <tr>
          <td height="25" >手&nbsp; 機:<?php echo $CompPhone; ?>　</td>
        </tr>
        <tr>
          <td >郵&nbsp; 箱:<?php echo $UserMail; ?>　</td>
        </tr>
        <tr>
          <td >地&nbsp; 址::<?php echo $Address; ?>　</td>
        </tr>
        <tr>
          <td >郵&nbsp; 編::<?php echo $ZipCode; ?>　</td>
        </tr>
		 <tr>
          <td >備&nbsp; 忘<br><?php echo $Memo; ?> </td>
        </tr>
        <tr>
          <td >是否接收郵件通知:<?php if($WantMessage==1){ echo "願意"; ?> <?php }else echo "不願意"; ?></td>
        </tr>
        <tr>
          <td >
          <?php

		  $Birthday_String=$Birthday."-".$D1."-".$D2;
		  $query="UPDATE usermain set UserName='".$UserName."',UserPassword='".$UserPassword."',UserQQ='".$UserQQ."',Sex='".$Sex."',Maritalstatus='".$Maritalstatus."',Birthday='".$Birthday_String."',Occupation='".$Occupation."',CompanyName='".$CompanyName."',HomePhone='".$HomePhone."',CompPhone='".$CompPhone."',UserMail='".$UserMail."',Address='".$Address."',ZipCode='".$ZipCode."',Memo='".$Memo."',WantMessage='".$WantMessage."' where UserId='".$userid."' and UserPassword='".$password."'";
          $result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));

		  $_SESSION['ypassword']=$UserPassword;
		  ?>
            <input name="Submit2" type="Submit" value="繼續修改" onClick="javascript:window.location.href='my_info.php';self.refresh">&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Submit" value="完成修改" onClick="javascript:window.location.href='my_accounts.php'">
   </td>
        </tr>


</TABLE>
<?php
}else{
include("../usererror.php");
}
?>

