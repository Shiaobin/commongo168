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

<link rel="stylesheet" href="/colorbox/colorbox.css" />
      <div class="row" id="content-box">
        <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
         <?php
		 if(isset($LarCode) && isset($MidCode) && isset($pnum) && $pnum=="0")
		 {
		   $rs_comp = selectOne($webshop,"*","compmain","LarCode='".$LarCode."' AND MidCode='".$MidCode."'","AddDate DESC");
		   if(empty($rs_comp)) echo "<center>對不起,目前無相關資料</center>";
		   else
		   {
		   ?>
           <h4 class="content-product-down-title"><?php echo $rs_comp['ProdName']; ?></h4>
           <?php
		   if($rs_comp['ProdDisc']!="0") echo $rs_comp['ProdDisc'];
		   echo $rs_comp['MemoSpec'];
		   $ProdId = $rs_comp['ProdId'];?>
           <ul class="lNavi clearfix">
           <?php
		   $result_img = selectAll($webshop,"*","comp_img","ProdId='".$ProdId."'","ProdId ASC");
		     while($rs_img = mysql_fetch_array($result_img))
		     {
		       if($rs_img['img_name']!="none.png" && $rs_img['img_name']!="none.gif" && $rs_img['img_name']!="none.jpg")
			   {
		 ?>
			   <a class="group4" href='images/webimg/medium/<?php echo $rs_img['img_name']; ?>'>
                <img src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
         <?php
			   }
		     }


		   }
		 }
		 else if(isset($_GET['ProdId']) && (!empty($_GET['ProdId'])))
		 {
			$rs_comp = selectOne($webshop,"*","compmain","ProdId='".$_GET['ProdId']."'","AddDate DESC");
			if(empty($rs_comp)) echo "<center>對不起,目前無相關資料</center>";
			else
		    {
		  ?>
          <h4 class="content-product-down-title"><?php echo $rs_comp['ProdName']; ?></h4>
          <?php
		     if($rs_comp['ProdDisc']!="0") echo $rs_comp['ProdDisc'];
		     echo $rs_comp['MemoSpec'];
		     $ProdId = $rs_comp['ProdId'];?>
             <ul class="lNavi clearfix">
		<?php
		     $result_img = selectAll($webshop,"*","comp_img","ProdId='".$ProdId."'","ProdId ASC");
		     while($rs_img = mysql_fetch_array($result_img))
		     {
		        if($rs_img['img_name']!="none.png" && $rs_img['img_name']!="none.gif" && $rs_img['img_name']!="none.jpg")
			    {
             ?>
             <a class="group4" href='images/webimg/medium/<?php echo $rs_img['img_name']; ?>'>
                <img src="images/webimg/small/<?php echo $rs_img['img_name']; ?>"></a>
             <?php
			    }
		     }
			}
		 }else{ echo "<center>對不起,目前無相關資料</center>";  }
		 ?>
         </ul>
        </div><!--內容 end#content-->
 <script src="colorbox/jquery.colorbox.js"></script>
 <script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".group4").colorbox({rel:'group4', slideshow:false});
				//Example of preserving a JavaScript event for inline calls.
				});
</script>


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