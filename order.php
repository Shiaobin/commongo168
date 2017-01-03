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
          <?php
			 @$LarCode = $_GET['LarCode'];
			?>
            <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>"><?php echo $LarCode; ?></a></li>
            <?php
			 @$MidCode = $_GET['MidCode'];
			 if(isset($MidCode) && (isset($LarCode)) && (isset($_GET['ProdId'])))
			 {
			?>
                <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>&MidCode=<?php echo $MidCode; ?>"><?php echo $MidCode; ?></a></li>
                <li class="font-small"><?php echo $_GET['ProdId']; ?></li>
			<?php
			 }
			?>

          </ol>
        </div>

        <!-- end#header-box-->
        <div class="row" id="content-box">

          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">

          <?php

		   if(isset($_SESSION['yuserid'])) include("include/site/sendorder.php");
		   else{ ?><iframe src="choice.php" frameborder="0" style="width:100%;height:700px;"></iframe>
           <?php } ?>

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