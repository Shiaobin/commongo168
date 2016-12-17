<?php  //-----------------------------取出所有選項類別------------------------------//
  mysql_select_db($database_webshop, $webshop);
  $query_showlistRec = "SELECT * FROM index_item";
  $showlistRec = mysql_query($query_showlistRec, $webshop) or die(mysql_error());
  $row_showlistRec = mysql_fetch_assoc($showlistRec);
  $totalRows_showlistRec = mysql_num_rows($showlistRec);
?>
<!-------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />
<title>首頁列表</title>
<!---------------------------首頁分類-------------------------->
<table width="100%" border="0">
  <tr>
    <td width="25%" valign="top">
    <?php do { ?>
       <table id="item" width="100%" border="0">
       <!-------------------------------------------------------------->
         <tr>
           <td align="left">
             <img src="../../images/list/icon.png" width="15" height="15" hspace="3" align="middle"/>
			   <?php echo $row_showlistRec["index_item_name"]; ?>
               </a>
           </td>
         </tr>
         <!-------------------------------------------------------------->
         <tr>
            <td bgcolor="#EFEFF8" align="left">
              <table width="100%" border="0" cellpadding="0" cellspacing="0" id="goods">
                <?php
	              $query_showsublistRec = sprintf("SELECT * FROM index_end_item WHERE index_item_id = %s", GetSQLValueString($row_showlistRec['index_item_id'], "text"));
		          $showsublistRec = mysql_query($query_showsublistRec, $webshop) or die(mysql_error());
		          $row_showsublistRec = mysql_fetch_assoc($showsublistRec);
		          $totalRows_showsublistRec = mysql_num_rows($showsublistRec);
		          if ($totalRows_showsublistRec > 0) {
		          do {?>  
                    <?php 
			          $query_showsetRec = sprintf("SELECT set_new FROM index_pages WHERE index_item_id=%s && index_end_item_id=%s" , GetSQLValueString($row_showsublistRec['index_item_id'], "text"), GetSQLValueString($row_showsublistRec['index_end_item_id'], "text"));
		              $showsetRec = mysql_query($query_showsetRec, $webshop) or die(mysql_error());
		              $row_showsetRec = mysql_fetch_assoc($showsetRec);
			        ?> 
				    <tr>
    				  <td width="10%"><img src="../../images/list/icon.png" width="8" height="8"  hspace="8" align="middle"/></td>
                      <td width="90%">
                        <?php if($row_showsetRec["set_new"] == 1) { ?>
                          <a href="indexpage.php?index_item_id=<?php echo $row_showsublistRec["index_item_id"]; ?>&index_end_item_id=<?php echo $row_showsublistRec["index_end_item_id"]; ?>" target="_blank"><?php echo $row_showsublistRec["index_end_item_name"]; ?>
                          </a>
                        <?php }else { ?>
                          <a href="indexpage.php?index_item_id=<?php echo $row_showsublistRec["index_item_id"]; ?>&index_end_item_id=<?php echo $row_showsublistRec["index_end_item_id"]; ?>"><?php echo $row_showsublistRec["index_end_item_name"]; ?>
                          </a>
			            <?php }?>
                      </td>	
  					</tr>  
			      <?php }while($row_showsublistRec = mysql_fetch_assoc($showsublistRec));}?>   
			  </table>
            </td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td height="10%"></td>
          </tr>
       <!-------------------------------------------------------------->
       </table>  
    <?php } while ($row_showlistRec = mysql_fetch_assoc($showlistRec)); ?>
    </td>
  </tr>
</table>
<?php
mysql_free_result($showlistRec);
mysql_free_result($showsublistRec);
mysql_free_result($showsetRec);
?>