<script type="text/javascript">
$(function(){
	var pathname = location.pathname.split("\/");
	var jsp      = pathname[pathname.length -1];

	var $a = $("#nav").find("a[href='"+ php +"']");
	$a.parent("li").addClass("active");
});
</script>

<div id="nav">
<?php
$result_Comp_Lar = selectAll_no_where($webshop,"*","compclass","LarSeq ASC");
$LarSeq_num = "";
while($rs = mysql_fetch_array($result_Comp_Lar))
{
  if($LarSeq_num!=$rs['LarSeq'] && $rs['LarSeq']<=100)
  {
	$pnum=$rs['pnum'];
	if($pnum=="0")
	{
?>
      <a href="compshow.php?LarCode=<?php echo urlencode($rs['LarCode']); ?>&MidCode=<?php echo urlencode($rs['MidCode']); ?>&pnum=0" style="text-decoration:none;"><label class="control-label label-title" style="cursor: pointer;"><?php echo $rs['LarCode']; ?></label></a>
    <?php
	}
	else
	{
	?>
      <a href="complist.php?LarCode=<?php echo urlencode($rs['LarCode']); ?>&pnum=1" style="text-decoration:none;"><label class="control-label label-title" style="cursor: pointer;"><?php echo $rs['LarCode']; ?></label></a>
    <?php
	}
	$LarSeq_num=$rs['LarSeq'];
    if(isset($pnum) && $pnum==0){ echo '</ul>'; }
	else
	{
      $whereClause = "LarSeq='".$LarSeq_num."'";
      $result_Mid = selectAll($webshop,"*","compclass",$whereClause,"MidSeq ASC");
	  echo '<ul class="nav nav-pills nav-stacked">';
      while($rs2 = mysql_fetch_array($result_Mid))
	  {
	    if(isset($rs2['url']) && $rs2['url']!="")
		{
	?>
		  <li class="text-left"><a href="http://<?php echo $rs2['url']; ?>"><?php echo $rs2['MidCode']; ?></a></li>
    <?php
		}
	    else
		{
		  if($rs2['snum']=="0")
		  {
		    $rs_comp = selectOne($webshop,"*","compmain","LarCode='".$rs2['LarCode']."' AND MidCode='".$rs2['MidCode']."'","AddDate DESC");

    ?>
            <li class="text-left"><a href="compshow.php?ProdId=<?php echo $rs_comp['ProdId']; ?>&LarCode=<?php echo urlencode($rs_comp['LarCode']); ?>&MidCode=<?php echo urlencode($rs_comp['MidCode']); ?>&snum=0&pnum=<?php echo $rs2['pnum']; ?>"><?php echo $rs2['MidCode']; ?></a></li>
<?php
		  }
		  else
		  {
?>
            <li class="text-left"><a href="complist.php?LarCode=<?php echo urlencode($rs2['LarCode']); ?>&MidCode=<?php echo urlencode($rs2['MidCode']); ?>&snum=1&pnum=<?php echo $rs2['pnum']; ?>"><?php echo $rs2['MidCode']; ?></a></li>
<?php
		  }
		}
	  }
      echo '</ul>';
	}
  }
}
?>

            </div>
