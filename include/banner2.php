<div id="captioned-gallery">
            <figure class="slider"><!--兩張圖：12121；三張圖：1231-->
            <?php
			 $result_banner = selectAll_no_where($webshop,"*","banner","po ASC");
			 $i=0;
			 while($rs_banner = mysql_fetch_array($result_banner))
			 {
			  if($i<3)
			  {
			?>
              <figure>
                <img src="./images/bannerimg/<?php echo $rs_banner['banner']; ?>" alt="">
              </figure>
             <?php
			   $i++;
			   if($i==1) $img1=$rs_banner['banner'];
			   if($i==2) $img2=$rs_banner['banner'];
			   if($i==3) $img3=$rs_banner['banner'];
			  }
			 }
			 if($i==1)
			 {
		     ?>
              <figure>
                <img src="./images/bannerimg/<?php echo $img1; ?>" alt="">
              </figure>
              <figure>
                <img src="./images/bannerimg/<?php echo $img1; ?>" alt="">
              </figure>
              <figure>
                <img src="./images/bannerimg/<?php echo $img1; ?>" alt="">
              </figure>
             <?php
			 }
			 if($i==2)
			 {
		     ?>
              <figure>
                <img src="./images/bannerimg/<?php echo $img1; ?>" alt="">
              </figure>
              <figure>
                <img src="./images/bannerimg/<?php echo $img2; ?>" alt="">
              </figure>
             <?php
			 }
			 if($i==3)
			 {
		     ?>
              <figure>
                <img src="./images/bannerimg/<?php echo $img1; ?>" alt="">
              </figure>
             <?php
			 }
			 ?>

            </figure>
          </div>


