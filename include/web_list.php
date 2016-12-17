 <form>
 <select style="background-color:#FFF;color:#767676;width:120px;margin-top:5px;" onChange='location = this.options[this.selectedIndex].value;'>
<?php
echo "<option disabled='disabled' selected>選擇項目</option>"; 
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
      <option value="compshow.php?LarCode=<?php echo $rs['LarCode']; ?>&MidCode=<?php echo $rs['MidCode']; ?>&pnum=0"><?php echo $rs['LarCode']; ?></option>
    <?php
	}
	else
	{
	?>
      <option value="complist.php?LarCode=<?php echo $rs['LarCode']; ?>&pnum=1"><?php echo $rs['LarCode']; ?></option>
    <?php
	}
	$LarSeq_num=$rs['LarSeq'];
    if(isset($pnum) && $pnum==1)
	{
      $whereClause = "LarSeq='".$LarSeq_num."'";
      $result_Mid = selectAll($webshop,"*","compclass",$whereClause,"MidSeq ASC");
	  echo '<ul class="nav nav-pills nav-stacked">';
      while($rs2 = mysql_fetch_array($result_Mid))
	  { 
	    if(isset($rs2['url']) && $rs2['url']!="")
		{
	?>		
		  <option value="http://<?php echo $rs2['url']; ?>"><?php echo $rs2['MidCode']; ?></option>
    <?php
		}
	    else
		{
		  if($rs2['snum']=="0")
		  { 
		    $rs_comp = selectOne($webshop,"*","compmain","LarCode='".$rs2['LarCode']."' AND MidCode='".$rs2['MidCode']."'","AddDate DESC");
			
    ?>    
            <option value="compshow.php?ProdId=<?php echo $rs_comp['ProdId']; ?>&LarCode=<?php echo $rs_comp['LarCode']; ?>&MidCode=<?php echo $rs_comp['MidCode']; ?>&snum=0&pnum=<?php echo $rs2['pnum']; ?>"><?php echo $rs2['MidCode']; ?></option>
<?php
		  }
		  else
		  {
?>			  
            <option value="complist.php?LarCode=<?php echo $rs2['LarCode']; ?>&MidCode=<?php echo $rs2['MidCode']; ?>&snum=1&pnum=<?php echo $rs2['pnum']; ?>"><?php echo $rs2['MidCode']; ?></option>
<?php		  
		  }
		}
	  }
      
	}
  }
}
?>
          </select>
          </form>