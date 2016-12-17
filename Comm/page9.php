<?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){ 
echo "<table>
 <tr><th ><font size=4px>
 會 員 中 心:&nbsp;&nbsp;";?>
 <a href="my_info.php">個人資料</a> |&nbsp; <a href="my_order.php">個人訂單 |&nbsp; <a href="memo.php">學員課程查詢</a> |&nbsp; <a href="userlogout.php">登出</a></font>
 </th></tr>
   
  <tr> 
    <td>
   </table> 
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];

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
<table width="100%"><tr><td colspan="7">

<img src="rwd-img/img/icon31.jpg" /></td></tr>
<tr><td>姓名</td><td>課程</td><td>電話</td><td>行動電話</td><td></td><td></td><td>編輯</td></tr>
  <%
    for i = 1 To rs.PageSize
      %>
       <tr>
            <td><%=rs.Fields("name")%></font></td>
            <td><%=rs.Fields("f1")%></font></td>
            <td><%=rs.Fields("tel")%></td>
            <td><%=rs.Fields("cellphone")%></td>
            <td><%=datevalue(rs.Fields("Notice_Date"))%></td>
            <td><img src="rwd-img/img/<%=rs.Fields("f2")%>.jpg"/></td>
            <td><a href="memomodify.asp?Notice_ID=<%=rs.Fields("Notice_ID")%>"><img src="rwd-img/img/icon06.jpg" width="100" height="37" /></a></td>
           
       </tr>   
  <% 
	   rs.movenext
	   if rs.eof then
	      exit for
	   end if		
	next						
  %>
       <tr>
           <td colspan="7" height="39">
           	<center><font size="2">
           	   &nbsp;   
				<%  if Page = 1 and rs.PageCount = 1 then '如果是第一頁  %>
				    第一頁&nbsp;   
				    上一頁&nbsp;   
				    下一頁&nbsp;   
					最後一頁&nbsp;   
				    
				<%  elseif Page = 1 and rs.PageCount > 1 then %>
					第一頁&nbsp;   
				    上一頁&nbsp;   
					<a Href="memo.asp?Page=<%=(Page+1)%>">下一頁&nbsp;</a>
					<a Href="memo.asp?Page=<%=rs.PageCount%>">最後一頁&nbsp;</a>   
				<%	elseif Page = rs.PageCount then '如果是最後一頁  %>   
					<a Href="memo.asp?Page=1">第一頁&nbsp;</a>   
					<a Href="memo.asp?Page=<%=(Page-1)%>">上一頁&nbsp;</a>   
					下一頁&nbsp;   
					最後一頁&nbsp;   
				<%  else  %>	
				    <a Href="memo.asp?Page=1">第一頁&nbsp;</a>   
					<a Href="memo.asp?Page=<%=(Page-1)%>">上一頁&nbsp;</a>   
					<a Href="memo.asp?Page=<%=(Page+1)%>">下一頁&nbsp;</a>   
					<a Href="memo.asp?Page=<%=rs.PageCount%>">最後一頁&nbsp;</a>   
				<%  end if  %>   

				選擇頁次：第   
				<select name="Page" onChange="location.href=this.options[this.selectedIndex].value;" size="1">&gt;
					<option>-</option>
					<%  for iPageNumber=1 to rs.PageCount  %>
					<option value="memo.asp?Page=<%=iPageNumber%>"><%=iPageNumber%></option>
					<%  next  %>
				</select>頁&nbsp;   
				
				頁次:&nbsp;<b><font color="red"><%=Page%><font color="black">&nbsp;/&nbsp;</font><%=rs.PageCount%></font>
				</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">目前共有<b><font color="#FF0000">&nbsp; <%=rs.RecordCount%>&nbsp;</font></b>筆資料</font></center>

           </td>
       </table>



<?php

}else{
include("../usererror.php");
}
?>

