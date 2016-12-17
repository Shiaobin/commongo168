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
$result_Prod_Lar = selectAll_no_where($webshop,"*","prodclass","LarSeq ASC");
$LarSeq_num = "";
while($rs = mysql_fetch_array($result_Prod_Lar))
{
  if($LarSeq_num!=$rs['LarSeq'] && $rs['LarSeq']<=100)
  {
	@$LarCode = $rs['LarCode'];
?>
    <label class="control-label label-title"><?php echo $rs['LarCode']; ?></label>
    <?php
	$LarSeq_num=$rs['LarSeq'];
    $whereClause = "LarSeq='".$LarSeq_num."'";
    $result_Mid = selectAll($webshop,"*","prodclass",$whereClause,"MidSeq ASC");
	echo '<ul class="nav nav-pills nav-stacked">';
    while($rs2 = mysql_fetch_array($result_Mid))
	{
	  @$MidCode = $rs2['MidCode'];
    ?>
      <li class="text-left"><a href="prodlist.php?LarCode=<?php echo urlencode($LarCode); ?>&MidCode=<?php echo urlencode($MidCode); ?>"><?php echo $rs2['MidCode']; ?></a></li>
<?php
	}
    echo '</ul>';
  }
}
?>
</div>
