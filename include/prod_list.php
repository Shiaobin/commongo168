<style>
[disabled="disabled"] {
    color: #FFF;
    
}
</style>            
          <form>
          <select style="width:240px;margin-top:5px;" onChange='location = this.options[this.selectedIndex].value;'>
<?php 
$result_Prod_Lar = selectAll_no_where($webshop,"*","prodclass","LarSeq ASC");
$LarSeq_num = "";
echo "<option>選擇項目</option>";
while($rs = mysql_fetch_array($result_Prod_Lar))
{
  if($LarSeq_num!=$rs['LarSeq'] && $rs['LarSeq']<=100)
  {
	@$LarCode_list = $rs['LarCode'];
?>
    <option style="background-color:#284C80;color:#FFF" value="prodlist.php?LarCode=<?php echo $LarCode_list; ?>" disabled="disabled"><?php echo $LarCode_list; ?>
    <?php
	$LarSeq_num=$rs['LarSeq'];
    $whereClause = "LarSeq='".$LarSeq_num."'";
    $result_Mid = selectAll($webshop,"*","prodclass",$whereClause,"MidSeq ASC");
	echo '</option>';
    while($rs2 = mysql_fetch_array($result_Mid))
	{
	  @$MidCode_list = $rs2['MidCode'];
	  @$Get_MidCode=urldecode($_GET['MidCode']);
    ?>
      <option style="background-color:#FFF;color:#767676" value="prodlist.php?LarCode=<?php echo $LarCode_list; ?>&MidCode=<?php echo $MidCode_list; ?>"><?php echo $MidCode_list; ?></option>
<?php
	}
    
  }
}
?>
          </select>
          </form>