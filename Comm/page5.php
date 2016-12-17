<?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){ 
echo "<table  class='table table-bordered table-striped'>
 <tr><th ><font size=4px>
 會 員 中 心:&nbsp;&nbsp;";?>
 <a href="my_info.php">個人資料</a> |&nbsp; <a href="my_order.php">個人訂單 |&nbsp; <a href="userlogout.php">登出</a></font>
 </th></tr>
   
  <tr> 
    <td>
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];
$username=$_SESSION['username'];
if (!empty($_SERVER["HTTP_CLIENT_IP"])){
    $ip = $_SERVER["HTTP_CLIENT_IP"];
}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}else{
    $ip = $_SERVER["REMOTE_ADDR"];
}

$query="select * from usermain where UserId='".$userid."' and UserPassword='".$password."'";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs = mysql_fetch_array($result)){
echo "<font size=4px>歡迎您，".$username."！您本次登入IP為：".$ip;
echo "<br>";
echo "您的會員級別為 <font color=red>".$rs['UserType']."</font></font>";
}
echo "</td></tr></table>";
?> 
<?php
}else{
include("loginbox.php");
}
?>
</td></tr>    </table>
