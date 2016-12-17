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
            <li class="font-small">搜尋結果</li>
            <?php if(isset($_GET['key'])){ ?>
			<li class="font-small"><?php echo $_GET['key']; ?></li>	
			<?php } ?>
			
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

			if(isset($_GET['key'])) $whereClause="Online='1' AND ProdName LIKE '%".$_GET['key']."%'";
			
			$per_page = 18; //每頁顯示的筆數
             if(isset($_GET['page'])){
	         $page=$_GET['page'];
             }else{
	         $page=1;
             }
			

			  $query_total = "SELECT * FROM prodmain where ".$whereClause;
 			  $result = mysql_query($query_total, $webshop) or die("cannot connect to table" . mysql_error( ));
 			  $I=mysql_num_rows($result);
 			  $total=$I; //總產品數
  			  $pages=ceil($total/$per_page); //pages總頁數 page當前頁數
  			  if($page>$pages && $pages!=0) $page=$pages;
  			  $start = ($page-1)*$per_page;
			  	
			  $result_prod = selectAll($webshop,"*","prodmain",$whereClause,"Model ASC limit ".$start.",".$per_page);
			  $count = mysql_num_rows($result_prod);
			  if($count>0)
			  {
				
			    while($rs_prod = mysql_fetch_array($result_prod))
			    {
				 
			?>
                  <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 content-productList-item">
                  <a href="prodshow.php?ProdId=<?php echo $rs_prod['ProdId']; ?>&ProdNum=<?php echo $rs_prod['ProdNum']; ?>&LarCode=<?php echo urlencode($rs_prod['LarCode']); ?>&MidCode=<?php echo urlencode($rs_prod['MidCode']);?>">
                  <?php 
				  $rs_img = selectOne($webshop,"*","prod_img","ProdId='".$rs_prod['ProdId']."'","img_no ASC");
				 
				  ?>
                  <img class="media-object img-thumbnail img-center" src="images/goodsimg/medium/<?php echo $rs_img['img_name']; ?>"></a>
                  <a class="text-productlist-title" href="prodshow.php?ProdId=<?php echo $rs_prod['ProdId']; ?>&ProdNum=<?php echo $rs_prod['ProdNum']; ?>&LarCode=<?php echo urlencode($rs_prod['LarCode']); ?>&MidCode=<?php echo urlencode($rs_prod['MidCode']);?>"><?php echo $rs_prod['ProdName']; ?></a><p style="background-color:#099;text-align:center;margin-top:8px;color:#FFF;"><?php if($remai!='0') echo $remai; ?><?php if($rs_prod['PriceList']!=0) echo $rs_prod['PriceList']."元<span class='small_words'>起</span>";else echo "請諮詢客服"; ?></p></div>
            <?php 
			    }
			  }
			  else
			  { 
			    echo "<center>對不起，目前無相關資料</center>"; 
			  }
			

			?>
            
            
            

            </div><!--產品列表 end.row-->
            <div id="page">
              <ul class="pagination">
              <?php 
			 
			  
	            for($i=1;$i<=$pages;$i++)
			    {	
			  ?>
                <li <?php if($page==$i) echo "class='active'"; ?>><a href="prodlist.php?page=<?php echo $i; if(isset($LarCode)) echo "&LarCode=".urlencode($LarCode); if(isset($MidCode)) echo "&MidCode=".urlencode($MidCode);?>"><?php echo $i;?></a></li>
               <?php
			    }
			  
			   ?>
      
              </ul>
            </div><!--頁碼 end#page-->
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