<button id="slideshow_toggle" class="btn btn-xs btn-danger" type="button">關閉看板</button>
        <div id="slideshow" class="container padding-none center-block">
          <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 padding-none slideshow-margin-fix">
            <div id="slider" class="swipe" style="visibility: visible;">
              <div class="swipe-wrap" style="width: 5700px;">

              <?php
			  $result_banner = selectAll_no_where($webshop,"*","banner","po ASC");
			  while($rs_banner = mysql_fetch_array($result_banner))
			  {
			  ?>
                <figure  style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./images/bannerimg/<?php echo $rs_banner['banner'];?>" width="910" height="525" alt="">
                </figure>
              <?php
			  }
			  ?>

                <!--figure  style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./pic/小切圖-03.jpg" width="910" height="525" alt="">
                </figure>
                <figure  style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./pic/小切圖-36.jpg" width="910" height="525" alt="">
                </figure>
                <figure  style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./pic/年菜廣告-01.jpg" width="910" height="525" alt="">
                </figure>
                <figure style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./pic/小切圖-35.jpg" width="910" height="525" alt="">
                </figure>
                <figure  style="transition-duration: 0ms; -webkit-transition-duration: 0ms;">
                  <img class="img-responsive" typeof="foaf:Image" src="./pic/小切圖-04.jpg" width="910" height="525" alt="">
                </figure-->
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 padding-none">
            <nav>
              <ul id="position">
              <?php
			  $result_banner = selectAll_no_where($webshop,"*","banner","po ASC");
			  $i=0;
			  while($rs_banner = mysql_fetch_array($result_banner))
			  {

			  ?>
                <li id="slideshow_selector_<?php echo $i; ?>" class="row">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./images/bannerimg/small/<?php echo $rs_banner['banner'];?>" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./images/bannerimg/small/<?php echo $rs_banner['banner'];?>" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p><?php echo $rs_banner['title'];?></p>
                  </div>
                </li>
              <?php
			  $i++;
			  }
			  ?>

                <!--li id="slideshow_selector_1" class="row ">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-03(1).jpg" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-03(2).jpg" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p>鄧師傅獲得眾多獎項的肯定</p>
                  </div>
                </li>
                <li id="slideshow_selector_2" class="row">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-36(1).jpg" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-36(2).jpg" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p>鄧師傅感謝國內外媒體一致推薦</p>
                  </div>
                </li>
                <li id="slideshow_selector_3" class="row">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./pic/年菜廣告-01(1).jpg" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./pic/年菜廣告-01(2).jpg" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p>開運年菜就在鄧師傅</p>
                  </div>
                </li>
                <li id="slideshow_selector_4" class="row">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-35(1).jpg" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-35(2).jpg" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p>所有食材皆來自安心合格供應商</p>
                  </div>
                </li>
                <li id="slideshow_selector_5" class="row">
                  <span class="arrow_left visible-md visible-lg"></span><span class="arrow_top visible-sm"></span>
                  <div class="slideshow_selector_image hidden-xs col-sm-12 col-md-12 col-lg-6 padding-none">
                    <img class="res_4x3 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-04(1).jpg" width="300" height="225" alt="">
                    <img class="res_16x9 img-rounded img-responsive" typeof="foaf:Image" src="./pic/小切圖-04(2).jpg" width="320" height="180" alt="">
                  </div>
                  <div class="slideshow_selector_text hidden-xs hidden-sm hidden-md col-lg-6 padding-none">
                    <p>榮獲媒體評薦爲亞洲特色餐廳</p>
                  </div>
                </li-->






<script src="./cssjs/swipe.js"></script>
        <script type="text/javascript">
          jQuery("button#slideshow_toggle").click(function() {
            if (jQuery("div#slideshow").css('display') === "none") {
              jQuery("button#slideshow_toggle").text('關閉看板');
            } else {
              jQuery("button#slideshow_toggle").text('開啟看板');
            };

            jQuery("div#slideshow").slideToggle();
          });

          var slider = Swipe(document.getElementById('slider'), {
            auto: 0,
            continuous: true,
            callback: function(pos) {

              var i = bullets.length;
              while (i--) {
                bullets[i].className = 'row';
              }
              bullets[pos].className = 'row on';

            }
          });

          var bullets = document.getElementById('position').getElementsByTagName('li');

          jQuery(document).ready(function() {
            jQuery("li[id^=slideshow_selector_]").click(function() {
              jQuery("ul#position > li").each(function() {
                jQuery(this).removeClass("on");
              });
              slider.slide(parseInt(jQuery(this).attr("id").substr(19, 1)));
              jQuery(this).addClass("on");
            });
          });
        </script>