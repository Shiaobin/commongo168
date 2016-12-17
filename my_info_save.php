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
$WantMessage="0";
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
        <!--tr> 
          <td >是否接收郵件通知:<?php if($WantMessage==1){ echo "願意"; ?> <?php }else echo "不願意"; ?></td>
        </tr-->
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