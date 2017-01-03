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
if(isset($_GET['go'])) $_SESSION['go']=$_GET['go'];
if(isset($_SESSION['yuserid']) and $_SESSION['ypassword']){

echo "<table  class='table table-bordered table-striped'>
 <tr><th ><h4>
 會 員 中 心:&nbsp;&nbsp;";?>
<?php
include("Comm/m_menu.php");
 ?>
 </h4>
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
echo "<h6>歡迎您，".$username."！您本次登入IP為：".$ip;
echo "<br>";
echo "您的會員級別為 <font color=red>".$rs['UserType']."</font></font>";
}
echo "</td></tr></table>";
?>
<?php
}else if(isset($_GET['forget']) && $_GET['forget']==true){
	include("forgetbox.php");
}else{
	include("loginbox.php");
}
?>

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