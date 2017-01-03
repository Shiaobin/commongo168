

    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
	<?php
		$result_banner = selectAll_no_where($webshop,"*","banner","po ASC");
		$i=0;
		while($rs_banner = mysql_fetch_array($result_banner)){
			if($i==0){
	?>
        	<li data-target="#myCarousel" data-slide-to="<?php echo $i++; ?>" class="active"></li>
            <?php }else{ ?>
            <li data-target="#myCarousel" data-slide-to="<?php echo $i++; ?>" class=""></li>
            <?php } ?>
    <?php } ?>

      </ol>
      <div class="carousel-inner" role="listbox">
        <!--p class="fixed-text">不捲動的文字</p-->
    <?php
		$result_banner = selectAll_no_where($webshop,"*","banner","po ASC");
		$i=0;
		while($rs_banner = mysql_fetch_array($result_banner)){
		if($i==0){
	?>
        <div class="item active">
    <?php }else{ ?>
    	<div class="item">
    <?php } ?>
          <img src="./images/bannerimg/<?php echo $rs_banner['banner']; ?>" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <!--h1>Example headline.</h1>
              <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p-->
            </div>
          </div>
        </div>
      <?php
	  		$i++;
	   		}
	  ?>
      </div>
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div><!-- /.carousel -->





