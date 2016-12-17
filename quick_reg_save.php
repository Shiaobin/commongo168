<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php include("indexconfig.php"); ?>
</head>
  <body>
    <div id="wrapper-box"> 
      


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
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <?php include("include/topmenu.php"); ?>           
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
          </div> <!-- end.jumbotron-box 導覽列：會員登入前-->

        </div>
        
        <!--頁頭flash end.jumbotron-->
          <ol class="breadcrumb col-sm-10 col-sm-offset-1" id="p_breadcrumb">
            <li class="font-small"><a href="index.php">首頁</a></li>
          <?php 
			 @$LarCode = $_GET['LarCode'];			 
			?>
            <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>"><?php echo $LarCode; ?></a></li>
            <?php 
			 @$MidCode = $_GET['MidCode'];
			 if(isset($MidCode) && (isset($LarCode)))
			 {			 
			?>
                <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>&MidCode=<?php echo $MidCode; ?>"><?php echo $MidCode; ?></a></li>
            <?php
			 }
			?>
          </ol>
        </div>
        
        <!-- end#header-box-->


        <div class="row" id="content-box">
          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
            <div class="row" id="p_usagetip" style="display: none;">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-14 content-productList-item">
                <p class="content-productList-tag-hint">顯示具有<span class="" id="p_usage"> "產品系列" </span>標籤的產品。</p>
              </div>
            </div><!--提示 end.row-->
            <div class="row" id="p_productlist">
  
<?php
$UserId=$_POST['UserId'];
$UserPassword=$_POST['pw1'];
$UserName=$_POST['UserName'];

$query_UserId= "SELECT UserId FROM usermain";
$result_UserId = mysql_query($query_UserId, $webshop) or die("cannot connect to table" . mysql_error( ));
$pass=1;
while($rs_UserId= mysql_fetch_array($result_UserId)){

 if($rs_UserId['UserId']==$UserId)
  { 

	  $pass=0;
	  break;
  } 
}
if($pass==0){
?>
    <TABLE  class='table table-bordered table-striped' width="100%"><TR>
	<Td width=20% valign='top' align=center><br><font color=red><b>對不起！</b>
	<br><br>該帳號已經有人使用，請另外選擇用戶號!</font><BR><BR>
    <a href='javascript:history.go(-1)'><b>返回上一頁</b></a></td></tr></table>
<?php
}
if($pass==1){
 $query_Add= "INSERT into usermain(UserId,UserPassword,UserName,UserKou) values('".$UserId."','".$UserPassword."','".$UserName."','".$thiskou."')";
 $result_Add = mysql_query($query_Add, $webshop) or die("cannot connect to table" . mysql_error( ));
 $_SESSION['yuserid']=$UserId;
 $_SESSION['ypassword']=$UserPassword;
 $_SESSION['username']=$UserName;
 $_SESSION['MM_Username']=$UserId;
  if(isset($_SESSION['go']))
  {
	   $go=$_SESSION['go'];
	   unset($_SESSION['go']);
	   header('Location:'.$go.".php");
  }
?>


<TABLE class='table table-bordered table-striped' width="100%">
<TR><Td align=center >註冊成功,如果需要修改,請到<a href="my_accounts.php">用戶中心</a>修改您的個人資料</td></tr>
</table>
<?php
}
?>            
            

            </div><!--產品列表 end.row-->

          </div><!--內容 end#content-->
          

<div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_prod.php"); ?>     
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->


     

<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>        
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->
  
 </body></html>