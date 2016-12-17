<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php 
include("indexconfig.php"); 
?>
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
          </ol>
         
        </div>
        
        <!-- end#header-box-->

      <div class="row" id="content-box">
        <div class="col-sm-10 col-sm-offset-1" id="content"> 
		<?php include('include/bar01.php'); ?>
          <div class="row">
          <?php
		  $result_slide = selectAll_no_where($webshop,"*","index_image_slide","slide_index ASC");
		  while($rs_slide = mysql_fetch_array($result_slide))
		  {
		  ?>
            <div class="col-md-4 col-sm-4 col-xs-12 index-item">
              <a href="<?php echo $rs_slide['slide_url']; ?>" class="content-index-title-a">
              <img class="media-object img-thumbnail img-center"  src="./images/slideimg/<?php echo $rs_slide['slide_img']; ?>" alt="">
              <div class=""></div></a>
              <a href="<?php echo $rs_slide['slide_url']; ?>"><div class="content-index-title" style="color: rgb(102, 102, 102); background-color: rgba(255, 255, 255, 0.4);"><?php echo $rs_slide['slide_text']; ?></div></a>
              
              
            </div>
          <?php
		  }
		  ?> 
            
            
          
            
          </div>
        </div><!--內容 end#content-->
      </div><!--內容 end#content-box-->
    </div><!--頁尾以外 end#wrapper-box-->

    

<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>        
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->
  
 </body></html>