<li><a href="indexpage.php?LarCode=公司介紹&MidCode=公司地圖&tabindex=0">公司地圖</a></li>
<li><a href="recruit.php">聯絡我們</a></li>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td width="100%" align=center >
<?php require('include/site/showwebinfo.php'); ?>
<link href="../../style.css" rel="stylesheet" type="text/css" />
CopyRight © <?php echo $row_showconfigRec["sitename"];?>&nbsp;&nbsp;<a href="admin/admineditconfig.php" >管理</a></br>電話：<?php echo $row_showconfigRec["adm_tel"];?>&nbsp;&nbsp;&nbsp;傳真：<?php echo $row_showconfigRec["adm_qq"];?>&nbsp;&nbsp;&nbsp;地址：<?php echo $row_showconfigRec["adm_address"];?>&nbsp;&nbsp;&nbsp;郵件：<?php echo $row_showconfigRec["adm_mail"];?> <br>共有<a href="http://www.voxeo.com"><img src="http://www.hot-hit-counter.com/counter?id=2916935F-4979-4A26-8F17-A870A7397B67&style=d_m-bluemb,ml_6" border="0" alt="click here" align="center"/></a><font size="2"></font>人訪問本站    Powerd by:<a href="http://www.hotdogfamily.com.tw/index.asp"  target="_blank">mudi</a>

<?php
//mysql_free_result($showconfigRec);
?>
 </td>
                                </tr>
                              </table>
