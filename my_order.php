<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php include("indexconfig.php"); ?>
</head>
  <body>
    <div id="wrapper-box"> 
      <?php include("include/topmenu2.php"); ?>


<div id="header-box" class="row">
        <div class="jumbotron col-sm-10 col-sm-offset-1">
     <?php include("include/banner.php"); ?>     
          
          <!--頁頭flash end.captioned-gallery-->
          <div class="jumbotron-box"><!-- 導覽列：會員登入前 -->
            <nav class="navbar navbar-default" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <!-- <a class="navbar-brand" href="#">57</a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
               
              </div><!-- /.container-fluid -->
            </nav>
          </div> <!-- end.jumbotron-box 導覽列：會員登入前-->

        </div>
        
        <!--頁頭flash end.jumbotron-->
          <ol class="breadcrumb col-sm-10 col-sm-offset-1" id="p_breadcrumb">
            <li class="font-small"><a href="index.php">首頁</a></li>
          <li class="font-small">會員專區</li>
          
          </ol>
        </div>
        
        <!-- end#header-box-->

      <div class="row" id="content-box">
        <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
 <?php
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){ 
echo "<table  class='table table-bordered table-striped'>
 <tr><th ><h4>
 會 員 中 心:&nbsp;&nbsp;";?>
<?php 
include("Comm/m_menu.php");
 ?> 
 </h4>
 </th></tr>
   </table> 
      <?php
$userid=$_SESSION['yuserid'];
$password=$_SESSION['ypassword'];
if(isset($_GET['Del'])){
$Del=$_GET['Del'];
$query_Del=   " UPDATE orderlist set Status='自行取消' where OrderNum='".$Del."'";
$result_Del=mysql_query($query_Del, $webshop) or die("cannot connect to table" . mysql_error( ));
	
}

$query=   " select A.OrderNum,A.OrderTime,A.RecName,A.OrderSum,A.RecName,A.Status,A.thiskou,A.fei,A.PayStatus,B.StatusDefine,B.Status 
           from orderlist A,orderstatustype B 
		   where A.UserId='".$userid."' and A.Status = B.StatusDefine order by A.OrderTime desc";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
$num=mysql_num_rows($result);
?>
<table  class='table table-bordered table-striped' >
<tr><td>訂單號</td><td>下單時間</td><td>總金額</td><td>收貨人</td><td>訂單狀態</td><td>付款狀態</td></tr>
<?php
if($num==0){
echo "<tr><td colspan=5 height=50 align=center><b>您暫時沒有有效的訂單!</b></TD></TR></TABLE>";	
}
else{
while($rs = mysql_fetch_array($result)){ 

?>
<tr> <td><a href="my_order_detail.php?OrderNum=<?php echo $rs['OrderNum'];?>"><?php echo $rs['OrderNum'];?></a>　</td>
  <td ><?php echo $rs['OrderTime'];?></td><td ><?php echo $rs['OrderSum']*($rs['thiskou']/10)+$rs['fei'];?>　</td>
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

</td>
<td>
<?php if($rs['PayStatus']==1) echo "已付款";else echo "未付款"; ?>
</td>
</tr>
<?php
}
?>
 </table>


<?php
}
}else{
include("usererror.php");
}
?>
          
        </div><!--內容 end#content-->
        


       <div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_comp.php"); ?>     
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->


     

<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>        
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->
  
 </body></html>