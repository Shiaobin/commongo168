<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php 

require('utility/init.php'); 
require("include/classes/Car.class.php");
include("indexconfig.php");
$Cart = new Cart();
$car_items = $Cart->getAllItems();

?>
<script type="text/javascript">
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
</script>

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
             <li class="font-small">最新消息</li>
        	 
          </ol>
        </div>
        
        <!-- end#header-box-->
        <div class="row" id="content-box">
        
          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
  <?php 

$query= "SELECT * FROM news where NewsID='".$_GET['NewsID']."' and online=1 order by PubDate desc"; 
$result = mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( )); 
$num = mysql_num_rows($result); 
if($num==0){
echo "對不起，文章內容不存在,或者已經過期！";
}
else{
while($rs = mysql_fetch_array($result)){
$ckt = $rs['cktimes']+1;
$query_ckt = "UPDATE news set cktimes='".$ckt."'where NewsID='".$_GET['NewsID']."'";
$result_ckt = mysql_query($query_ckt, $webshop) or die("cannot connect to table" . mysql_error( )); 
?>
<TABLE width=100% class="table table-bordered table-striped" >
<TR> <TD><h4><?php echo $rs['NewsTitle'];?></h4>
<p class="img">
<A href="http://www.facebook.com/sharer.php?u=<?php echo $siteurl; ?>/news_detail.php?NewsID=<?php echo $rs['NewsID'];?>"><IMG border=0 src="rwd-img/img/fb.png"></A>
<A href="http://line.naver.jp/R/msg/text/<?php echo $siteurl; ?>/news_detail.php?NewsID=<?php echo $rs['NewsID'];?>"><IMG border=0 src="rwd-img/img/line.png"></A>
<A href="news_home.php"><IMG border=0 src="images/more.gif"></A>          

<a href="index.php">來源:<?php echo $rs['Source'];?></a> | 日期：<?php echo $rs['PubDate'];?> | 瀏覽次數：<?php echo $ckt;?></TD> </TR>

 <TR><TD><h6><?php echo $rs['NewsContain'];?></h6></TD></TR>

 <?php if($rs['imgfull']!='none.png' && $rs['imgfull']!='none.gif'){ ?>         
 <TR><TD><img border="0" src="Images/newsimg/medium/<?php echo $rs['imgfull']; ?>"></TD></TR>
          <!--% end if %-->

<?php
 }}} ?>
</TABLE>
           
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