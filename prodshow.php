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
if(!isset($_SESSION['MM_Username'])){
  if(!isset($_SESSION['tempord_id']) || $_SESSION['tempord_id'] == ""){


	$column = "MAX(user_id)";
	$table_shop_user		= SYS_DBNAME . ".shop_user";
	dbInsert( $table_shop_user, array('created_date' => now()) );

  	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_shop_user} ",
			'mssql'	=> "SELECT {$column} FROM {$table_shop_user} ",
			'oci8'	=> "SELECT {$column} FROM {$table_shop_user} "
	);
	$Id = dbGetOne($sql['list']['select'][SYS_DBTYPE]);

    $_SESSION['tempord_id']=date('Ymdhis').$Id;
  }
}
?>
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
        <?php
		  @$ProdId = $_GET['ProdId'];
		  $rs_prod = selectOne($webshop,"*","prodmain","ProdId='".$ProdId."'","ProdNum ASC");
		?>
          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
            <div>
              <div class=" col-lg-5 col-md-4 col-sm-4 content-product-top-img">
              <?php
			    $result_img = selectAll($webshop,"*","prod_img","ProdId='".$ProdId."'","img_no ASC");
				$one="";
				while($rs_img = mysql_fetch_array($result_img))
				{
			  ?>
               <?php if($one==""){ ?><img class="media-object img-thumbnail img-responsive" id="bechange" src="./images/goodsimg/medium/<?php echo $rs_img['img_name']; ?>" alt="<?php echo $rs_img['ProdId'];?>"><?php } ?>
               <?php if($one==""){ ?><ul class="content-product-color" id="p_color"><?php } ?>
                <li class="product-color01" img="" amount_msg="充足" amount="100" colorid="ffffff" gid="MKC-01" listimg="" style="background-image: url('./images/goodsimg/small/<?php echo $rs_img['img_name']; ?>'); background-size:48px 48px;" onClick="change('./images/goodsimg/medium/<?php echo $rs_img['img_name']; ?>');"></li>

              <?php
			     $one="1";
				}
			  ?>
              </ul>


              </div>

<script>
function change(img)
{
	$('#bechange').attr('src',img);
}
</script>
              <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1 content-product-top-intro">
                <p class="text-product-p" id="p_gid">產品編號：<?php echo $rs_prod['ProdId'];?></p>
                <h3 class="text-product-title" id="p_name" product="<?php echo $rs_prod['ProdName'];?>"><?php echo $rs_prod['ProdName'];?></h3>

                <div class="content-product-top-button">
                <?php if($rs_prod['PriceOrigin']!="0"){ ?>
                  <h3 class="text-product-price" id="p_price">售價：NT.<?php echo $rs_prod['PriceOrigin'];?></h3>
                <?php } ?>
                  <h3 class="text-product-discount" id="p_discount"><?php if($remai!='0') echo $remai.":"; ?><?php if($rs_prod['PriceList']=="0"){ echo "請諮詢客服";}else{ echo "NT.".$rs_prod['PriceList']."<span class='small_words'>起</span>"; }?></h3>
                  <p class="text-product-discountTime" id="p_discountTime" style="display:none">優惠時間：<span>2014.01.01 00:00am - 2014.12.31 23:59pm</span></p>
                  <div class="row form-group">
                    <!--div class="col-md-5 col-sm-5" id="p_reserve">庫存：<?php if($rs_prod['Quantity']>0) echo "充足"; else echo "進貨中";?></div-->
                    <!--div class="col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1">
                      購買數量：
                      <select class="" id="p_amount"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>
                    </div-->
                  </div><!--end.row .form-group-->
                  <div class="row">
                    <div class="col-sm-12 btn-footer">

                      <?php include("showdetail.php");?>


                    </div>


                    <div class="col-sm-12 btn-footer">
<!--                       <button type="reset" class="btn btn-default btn-block btn-defautcolor" id="p_cancel">加入追蹤</button> -->
                    </div>
                  </div><!--end.row-->
                </div> <!--end.content-product-top-button-->
              </div> <!--end.content-product-top-intro-->
            </div>
            <div class="row">
              <div class="col-sm-11 content-product-down">
              	<h4 class="content-product-down-title">產品描述</h4>
              	<p class="text-product-p"><?php echo $rs_prod['ProdDisc'];?></p>
                <h4 class="content-product-down-title">產品介紹</h4>
                <h4 class="text-product-intro-title"></h4>
                <p class="text-product-p" id="p_content"><p style="text-align:center">
                <?php echo $rs_prod['MemoSpec'];?>
                </p>

<p style="text-align:center">&nbsp;</p>


              </div>
            </div>
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