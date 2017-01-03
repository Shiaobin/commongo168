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
<?php include("include/prod_location.php"); ?>
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
            <a href="special_page.php?id=1" style="text-decoration:none;" ><h3 class="special_title">推薦商品</h3></a>
			<?php include("prodgood.php"); ?>
            </div>
            <div class="row" id="p_productlist">
            <a href="special_page.php?id=2" style="text-decoration:none;" ><h3 class="special_title">熱賣商品</h3></a>
            <?php include("prodhot.php"); ?>
            </div>
            <div class="row" id="p_productlist">
            <a href="special_page.php?id=3" style="text-decoration:none;" ><h3 class="special_title">最新商品</h3></a>
			<?php include("prodnew.php"); ?>
            </div><!--產品列表 end.row-->
            <div id="page">
              <ul class="pagination">


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