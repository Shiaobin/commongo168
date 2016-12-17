<?php			  	
			  $result_prod = selectAll($webshop,"*","prodmain","new=1 && online=1","Model ASC limit 6");
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