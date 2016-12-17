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
if(isset($_GET['Del'])){
$Del=$_GET['Del'];
$query_Del=   " UPDATE orderlist set Status='自行取消' where OrderNum='".$Del."'";
$result_Del=mysql_query($query_Del, $webshop) or die("cannot connect to table" . mysql_error( ));
	
}

/*
<%
sqlinfo = "select A.OrderNum,A.OrderTime,A.RecName,A.OrderSum,A.RecName,A.Status,B.StatusDefine"&_
          " from OrderList A,OrderStatustype B "&_
		  " where A.UserId='"&session("estore_userid")&"' and A.Status = B.Status order by A.OrderTime desc"
set rsorder=Server.Createobject("ADODB.RecordSet")
rsorder.Open sqlinfo,conn,1,1
%>*/
$query=   " select A.OrderNum,A.OrderTime,A.RecName,A.OrderSum,A.RecName,A.Status,B.StatusDefine,B.Status 
           from orderlist A,orderstatustype B 
		   where A.UserId='".$userid."' and A.Status = B.StatusDefine order by A.OrderTime desc";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
$num=mysql_num_rows($result);
?>
<table width="100%" >
<tr><td>訂單號</td><td>下單時間</td><td>總金額</td><td>收貨人</td><td>訂單狀態</td></tr>
<?php
if($num==0){
echo "<tr><td colspan=5 height=50 align=center><b>您暫時沒有有效的訂單!</b></TD></TR></TABLE>";	
}
else{
while($rs = mysql_fetch_array($result)){ 

 /*<%if rsorder.eof and rsorder.bof  then
 response.write "<tr><td colspan=5 height=50 align=center><b>您暫時沒有有效的訂單!</b></TD></TR></TABLE>"
 else 
 do while not rsorder.eof 
 %>*/
?>
<tr> <td><a href="my_order_detail.php?OrderNum=<?php echo $rs['OrderNum'];?>"><?php echo $rs['OrderNum'];?></a>　</td>
  <td ><?php echo $rs['OrderTime'];?></td><td width="128"><?php echo $rs['OrderSum'];?>　</td>
  <td><?php echo $rs['RecName'];?>　</td>
<td>
<?php
echo $rs['StatusDefine'];

if($rs['Status']==0){
?>
<a href="my_order.php?Del=<?php echo $rs['OrderNum'];?>"><br>[取消訂單]</a>
<?php
}
?>



</td></tr>
<?php
}
?>
 </table>


<?php
}
}else{
include("../usererror.php");
}
?>

