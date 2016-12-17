<?php  //-----------------------------取出所有選項類別------------------------------//
  mysql_select_db($database_webshop, $webshop);
  $query_showlistRec = "SELECT * FROM shop_item";
  $showlistRec = mysql_query($query_showlistRec, $webshop) or die(mysql_error());
  $row_showlistRec = mysql_fetch_assoc($showlistRec);
  $totalRows_showlistRec = mysql_num_rows($showlistRec);
?>
<!------------------------------------------------------------------------------>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<link href="../../SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<title>商品列表</title>
<!---------------------------商品分類-------------------------->
<script src="../../SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<table width="100%" height="100%" border="0">
  <tr>
    <td width="25%" valign="top">
    <div id="Accordion1" class="Accordion" tabindex="1">
    <?php $no = 0;?>
      <?php do { ?>
        <div class="AccordionPanel">
          <div class="AccordionPanelTab" align="center"><?php echo $row_showlistRec["item_name"]; ?></div>
          <div class="AccordionPanelContent">
            <table width="100%" border="0" cellpadding="4" cellspacing="0">
              <?php
	              $query_showsublistRec = sprintf("SELECT * FROM shop_end_item WHERE item_id = %s", GetSQLValueString($row_showlistRec['item_id'], "text"));
		          $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		          $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		          $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
		          if ($totalRows_showsublistRec > 0) {
				  do {?>  
				    <tr style="background-image:url(../../images/button/menubg.png)">
    				  <td width="40%" align="left"><img src="../../images/list/icon.png" width="8" height="8"  hspace="8" align="middle"/></td>
                      <td width="60%" align="left">
                        <a style="text-decoration: none" href="goods.php?item_id=<?php echo $row_showsublistRec['item_id']; ?>&end_item_id=<?php echo $row_showsublistRec['end_item_id']; ?>&tabindex=<?php echo $no;?>">
                          <?php echo $row_showsublistRec['end_item_name']; ?>
                        </a>
                      </td>	
  					</tr>  
				  <?php }while($row_showsublistRec = mysql_fetch_assoc($showsublistRec));}?>   
			</table>
          </div>
        </div>
      <?php $no = $no+1;?>
	  <?php } while ($row_showlistRec = mysql_fetch_assoc($showlistRec)); ?>
    </div>
    </td>
  </tr>
</table>
<script type="text/javascript">
var Accordion1 = new Spry.Widget.Accordion("Accordion1", { defaultPanel: <?php if(isset($_GET['tabindex'])) echo $_GET['tabindex']; else echo "0"; ?> });
</script>
