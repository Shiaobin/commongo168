<nav>
  <ul class="list-unstyled main-menu">

    <!--Include your navigation here-->
    <li class="text-right"><a href="#" id="nav-close">X</a></li>
<?php
$result_Prod_Lar = selectAll_no_where($webshop,"*","prodclass","LarSeq ASC");
$LarSeq_num = "";
while($rs = mysql_fetch_array($result_Prod_Lar))
{
  if($LarSeq_num!=$rs['LarSeq'] && $rs['LarSeq']<=100)
  {
	@$LarCode = $rs['LarCode'];
?>
    <li><a style="color:#284C80"><?php echo $rs['LarCode']; ?></a>
      <ul class="list-unstyled">
   <?php
	$LarSeq_num=$rs['LarSeq'];
    $whereClause = "LarSeq='".$LarSeq_num."'";
    $result_Mid = selectAll($webshop,"*","prodclass",$whereClause,"MidSeq ASC");
    while($rs2 = mysql_fetch_array($result_Mid))
	{
	  @$MidCode = $rs2['MidCode'];
    ?>
          <li class="sub-nav"><a href="prodlist.php?LarCode=<?php echo urlencode($LarCode); ?>&MidCode=<?php echo urlencode($MidCode); ?>"><?php echo $rs2['MidCode']; ?><span class="icon"></span></a></li>
    <?php } ?>
      </ul>

    </li>
            <?php } ?>
 	 <?php } ?>
  </ul>
</nav>

<div class="navbar navbar-inverse navbar-fixed-top">

    <!--Include your brand here-->
    <ul>
	<li class="aabbc" name="list">
    <span class="icon_more"></span>
    <ul class="smlist_video">
    <li><a class="hreflist_video" href="index.php">首 &nbsp;頁</a></li>

    <li><a class="hreflist_video" href="prodlist.php">產品區</a></li>
    <li><a class="hreflist_video" href="my_accounts.php?go=my_accounts">會員專區</a></li>
    <li><a class="hreflist_video" href="car.php">購物車</a></li>

	</ul>
    </li>
    </ul>

    <span class="icon_search" id="icon_search"></span>

    <input class="navbar-brand input-st" id="inputsearch" type="text" placeholder="搜尋">


    <div class="navbar-header pull-right">
      <a id="nav-expander" class="nav-expander fixed">
        MENU &nbsp;<i class="fa fa-bars fa-lg white"></i>
      </a>
    </div>
</div>
