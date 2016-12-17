<?php 
  $rs_slide = selectOne($webshop,"*","index_frame","frame_no='1'","frame_date DESC");
  ?>
 <?php echo $rs_slide['frame_text']; ?>


