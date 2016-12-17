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
           <table width="100%" class="table table-bordered table-striped">

<?php 

$per_page = 10; //每頁顯示的筆數 
if(isset($_GET['page'])){ 
$page=$_GET['page']; 
}else{ 
$page=1; 
} 
 
 
  $query_total = "SELECT * FROM news where online=1"; 
  $result = mysql_query($query_total, $webshop) or die("cannot connect to table" . mysql_error( )); 
  $I=0; 
  while ( $row = mysql_fetch_array($result) ) { 
$I++; 
  } 
  $total=$I; //總產品數 
  $pages=ceil($total/$per_page); //pages總頁數 page當前頁數 
  if($page>$pages && $pages!=0) $page=$pages; 
  $start = ($page-1)*$per_page; 
if($I==0){
echo "對不起，目前無最新消息。";
	}
else{
?>
<tr><th width=15% ><center>日期</td>
<th width=75% ><center>消息公告</td>
<th width=10% ><center>人氣</td></tr>
<?php 
$query= "SELECT * FROM news where online=1 order by PubDate desc limit ".$start.", ".$per_page; 
$result = mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( )); 
while($rs = mysql_fetch_array($result)){
	$Date=$rs['PubDate'];
	$Ym=explode('-',$Date); 
	$day=explode(' ',$Ym[2]); 							   
?> 
<tr><td width=15% ><center><?php echo $Ym[0]; ?>/<?php echo $Ym[1]; ?>/<?php echo $day[0]; ?> </td>
<td width=75% ><a href="news_detail.php?NewsID=<?php echo $rs['NewsID']; ?>&NewsTitle=<?php echo $rs['NewsTitle']; ?>"><?php echo $rs['NewsTitle']; ?></a></td>
<td width=10%  ><center><?php echo $rs['cktimes']; ?></td></tr>
<?php
}}
?>

                <tr>
                  <td width="100%" colspan="3" >
           	  <center>
				<!--%  if Page = 1 and rsnews.PageCount = 1 then '如果是第一頁  %-->
                <?php if($page==1 and $pages==1){ ?>
               第一頁&nbsp; 上一頁&nbsp; 下一頁&nbsp; 最後一頁&nbsp; 
				<?php } ?>    
				<!--%  elseif Page = 1 and rsnews.PageCount > 1 then %-->
                <?php if($page==1 and $pages>1){ ?>
                 第一頁&nbsp; 上一頁&nbsp; 
					<a Href="news_home.php?page=<?php echo $page+1; ?>">下一頁&nbsp;</a>
					<a Href="news_home.php?page=<?php echo $pages; ?>">最後一頁&nbsp;</a>
                <?php } ?>     
				<!--%	elseif Page = rsnews.PageCount then '如果是最後一頁  %--> 
                <?php if($page==$pages and $pages!=1){  ?>
					<a Href="news_home.php?page=1">第一頁&nbsp;</a> 
					<a Href="news_home.php?page=<?php echo $page-1; ?>">上一頁&nbsp;</a> 下一頁&nbsp; 
            最後一頁&nbsp; 
                <?php } ?>
				<!--%  else  %-->	
                <?php if($page<$pages && $page>1){ ?>
				    <a Href="news_home.php?page=1">第一頁&nbsp;</a> 
					<a Href="news_home.php?page=<?php echo $page-1; ?>">上一頁&nbsp;</a> 
					<a Href="news_home.php?page=<?php echo $page+1; ?>">下一頁&nbsp;</a> 
					<a Href="news_home.php?page=<?php echo $pages; ?>">最後一頁&nbsp;</a> 
                <?php } ?>
				<!--%  end if  %--> 

				選擇頁次：第 
				<select  class="input-mini" name="Page" onChange="location.href=this.options[this.selectedIndex].value;" size="1">&gt;
					<option>-</option>
					<!--%  for iPageNumber=1 to rsnews.PageCount  %-->
                    <?php for($x=1;$x<=$pages;$x++){ ?>
					<option value="news_home.php?page=<?php echo $x;?>"><?php echo $x;?></option>
                    <?php } ?>
					<!--%  next  %-->
				</select>頁&nbsp; 頁次:&nbsp;<?php echo $page; ?>&nbsp;/&nbsp;<?php echo $pages; ?> </td>
                </tr>
              </table>
           
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