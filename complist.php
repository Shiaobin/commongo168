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
            <?php
			 @$LarCode = $_GET['LarCode'];
			 @$pnum = $_GET['pnum'];
			 @$snum = $_GET['snum'];
			?>
            <li class="font-small"><a href="complist.php?LarCode=<?php echo $LarCode; if(isset($_GET['pnum'])) echo "&pnum=".$pnum;?>"><?php echo $LarCode; ?></a></li>
            <?php
			 @$MidCode = $_GET['MidCode'];
			 if(isset($MidCode) && (isset($LarCode)))
			 {

				if(!isset($pnum) && !isset($snum))
				{
			?>
                <li class="font-small"><a href="complist.php?LarCode=<?php echo $LarCode; ?>&MidCode=<?php echo $MidCode; ?>"><?php echo $MidCode; ?></a></li>

			<?php
				}
			?>
				<li class="font-small"><?php echo $MidCode; ?></li>
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
			$per_page = 12; //每頁顯示的筆數
             if(isset($_GET['page'])){
	         $page=$_GET['page'];
             }else{
	         $page=1;
             }
			if(isset($LarCode) && isset($MidCode) && isset($_GET['snum']) && $_GET['snum']=="1")
		    {
			  $query_total = "SELECT * FROM compmain where LarCode='".$LarCode."' AND MidCode='".$MidCode."' AND online=1";
 			  $result = mysql_query($query_total, $webshop) or die("cannot connect to table" . mysql_error( ));
 			  $I=mysql_num_rows($result);
 			  $total=$I; //總產品數
  			  $pages=ceil($total/$per_page); //pages總頁數 page當前頁數
  			  if($page>$pages && $pages!=0) $page=$pages;
  			  $start = ($page-1)*$per_page;

				$result_comp = selectAll($webshop,"*","compmain","LarCode='".$LarCode."' AND MidCode='".$MidCode."' AND online=1","AddDate DESC limit ".$start.",".$per_page);
				while($rs_comp = mysql_fetch_array($result_comp))
				{
				  $ProdId = $rs_comp['ProdId'];
				  //$rs_class = selectOne($webshop,"*","compclass","LarCode='".$LarCode."' AND MidCode='".$MidCode."'","ClassId ASC");
				  $rs_img = selectOne($webshop,"*","comp_img","ProdId='".$ProdId."'","img_no ASC");
			?>

            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 content-productList-item" align="center">
            <a href="compshow.php?ProdId=<?php echo $ProdId; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=0"><img class="media-object img-thumbnail img-center" src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
            <a class="text-productlist-title" href="compshow.php?ProdId=<?php echo $ProdId; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>"><?php echo $MidCode; ?>-<?php echo $rs_comp['ProdDisc']; ?></a></div>
            <?php
				}
			}
			else if(isset($LarCode) && isset($_GET['pnum']) && $_GET['pnum']=="1")
		    {


				$result_class = selectAll($webshop,"*","compclass","LarCode='".$LarCode."'","ClassId DESC");

				while($rs_class = mysql_fetch_array($result_class))
				{
				  $LarCode = $rs_class['LarCode'];
			      $MidCode = $rs_class['MidCode'];


		    $rs_comp = selectOne($webshop,"*","compmain","LarCode='".$LarCode."' AND MidCode='".$MidCode."' AND online=1","AddDate DESC");
			$rs_img = selectOne($webshop,"*","comp_img","ProdId='".$rs_comp['ProdId']."'","img_no ASC");
			if($rs_class['snum']=="0")
			{

			?>
            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 content-productList-item" align="center">
            <a href="compshow.php?ProdId=<?php echo $rs_comp['ProdId']; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=0"><img class="media-object img-thumbnail img-center" src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
            <?php
			}
			else
			{
		    ?>
            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 content-productList-item" align="center">
            <a href="complist.php?LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=<?php echo $rs_class['snum']; ?>"><img class="media-object img-thumbnail img-center" src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
			<?php
            }
			if($rs_class['snum']=="0")
			{
			?>
            <a class="text-productlist-title" href="compshow.php?ProdId=<?php echo $rs_comp['ProdId']; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=0"><?php echo $MidCode; ?></a>
            <?php
			}
			else
			{
			?>
			<a class="text-productlist-title" href="complist.php?LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=<?php echo $rs_class['snum']; ?>"><?php echo $MidCode; ?></a>
			<?php
            }
			?>

            </div>

            <?php


				}
			}
			else
			{
			  $query_total = "SELECT * FROM compmain where online=1";
 			  $result = mysql_query($query_total, $webshop) or die("cannot connect to table" . mysql_error( ));
 			  $I=mysql_num_rows($result);
 			  $total=$I; //總產品數
  			  $pages=ceil($total/$per_page); //pages總頁數 page當前頁數
  			  if($page>$pages && $pages!=0) $page=$pages;
  			  $start = ($page-1)*$per_page;

				$result_comp = selectAll($webshop,"*","compmain","online=1","AddDate DESC limit ".$start.",".$per_page);
				while($rs_comp = mysql_fetch_array($result_comp))
				{
				  $ProdId = $rs_comp['ProdId'];
				  //$rs_class = selectOne($webshop,"*","compclass","LarCode='".$LarCode."' AND MidCode='".$MidCode."'","ClassId ASC");
				  $rs_img = selectOne($webshop,"*","comp_img","ProdId='".$ProdId."'","img_no ASC");
			?>

            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-6 content-productList-item" align="center">
            <a href="compshow.php?ProdId=<?php echo $ProdId; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=0"><img class="media-object img-thumbnail img-center" src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
            <a class="text-productlist-title" href="compshow.php?ProdId=<?php echo $ProdId; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>"><?php echo $rs_comp['ProdName']; ?></a></div>
            <?php
				}
			}
			?>




            </div><!--產品列表 end.row-->

            <div id="page">
            <ul class="pagination">
                         <?php

	            for($i=1;$i<=@$pages;$i++)
			    {
			  ?>
              <li <?php if($page==$i) echo "class='active'"; ?>><a href="complist.php?page=<?php echo $i;?>&LarCode=<?php echo $LarCode;?>&MidCode=<?php echo $MidCode; ?>&snum=1"><?php echo $i;?></a></li>
              <?php
				}

			  ?>

            </ul>
            </div><!--頁碼 end#page-->

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