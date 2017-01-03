<?php
$query_ordsubRec = "SELECT * FROM orderdetail LEFT JOIN prodmain ON orderdetail.ProdId = prodmain.ProdId WHERE OrderNum ='".$_POST['OrderNum']."'";
$ordsubRec = mysql_query($query_ordsubRec, $webshop) or die(mysql_error());
$totalRows_ordsubRec = mysql_num_rows($ordsubRec);
$my_accounts="http://".$_SERVER['HTTP_HOST']."/my_accounts.php";
$body='<html>';
$body.='<title>蔘大王</title>';
$body.='<head>';
$body.='<link rel="stylesheet" type="text/css" href="http://www.v88t.com/admin/css/reset.css" media="all">';
$body.='<link rel="stylesheet" type="text/css" href="http://www.v88t.com/admin/css/fonts.css" media="all">';
$body.='<link rel="stylesheet" type="text/css" href="http://www.v88t.com/admin/css/global.css" media="all">';
$body.='</head>';
$body.='<body>';
$body.='<center>';
$body.='<table width="650" border="1" rules="all" cellspacing="0" cellpadding="0" class="tableLayout01">';
$body.='<tr>';
$body.='<td colspan="4" align="left">訂單編號:';
$body.=$_POST['OrderNum'];
$body.='</td>';
$body.='</tr>';
$body.='<tr>';
$body.='<td colspan="5" align="center" bgcolor="#999999"><font color="#FFFFFF"><p>商品明細</p></font></td>';
$body.='</tr>';
$body.='<tr align="center">';
$body.='<td width="15%" >產品名稱</td>';
$body.='<td width="10%" >購買數量</td>';
$body.='<td width="10%" >單價</td>';
$body.='<td width="20%" >小計</td>';
$body.='</tr>';

while ($row_ordsubRec = mysql_fetch_assoc($ordsubRec)){
$body.='<tr>';
$body.='<td align="center" height="20%">';
$body.=$row_ordsubRec['ProdName'];
$body.='</td>';
/*$body.='<td align="center" height="20%">';

$query_img = "SELECT img_name FROM prod_img WHERE ProdId='".$row_ordsubRec['ProdId']."'";
$result_img = mysql_query($query_img, $webshop) or die(mysql_error());
$rs_img = mysql_fetch_assoc($result_img);

$body.='<img src="http://www.v88t.com/images/goodsimg/small/';
$body.=$rs_img['img_name'];
$body.='" name="image" width="78px" height="65px" id="image" align="center" style="padding:5px;"/>';
$body.='</td>';*/
$body.='<td align="right" height="20%">';
$body.=$row_ordsubRec['ProdUnit'];
$body.='</td>';
$body.='<td align="right" height="20%">';
$body.=$row_ordsubRec['BuyPrice'];
$body.='</td>';
$body.='<td align="right" height="20%">';
$body.=$row_ordsubRec['BuyPrice']*$row_ordsubRec['ProdUnit'];
$body.='</td>';
$body.='</tr>';

}

$query_ordmainRec = "SELECT orderlist.*,usermain.UserId FROM orderlist LEFT JOIN usermain ON orderlist.UserId = usermain.UserId WHERE OrderNum ='".$_POST['OrderNum']."'";
$ordmainRec = mysql_query($query_ordmainRec, $webshop) or die(mysql_error());
$row_ordmainRec = mysql_fetch_assoc($ordmainRec);


$body.='<tr>';
$body.='<td colspan="4" align="left" valign="top">配送費用：';
$body.=$row_ordmainRec['fei'];
$body.='元</td>';
$body.='</tr>';
$body.='<tr>';
$body.='<td colspan="2" align="left" valign="top">總計費用：';
$body.=($row_ordmainRec['OrderSum']*($row_ordmainRec['thiskou']/10))+$row_ordmainRec['fei'];
$body.='元</td>';
$body.='<td colspan="2" align="right" valign="top">共訂購';
$body.=$totalRows_ordsubRec;
$body.='種商品</td>';
$body.='</tr>';
$body.='<tr>';
$body.='<td colspan="4" align="left" valign="top">';
$body.='<p>';
$body.='收貨地址：';
$body.=$row_ordmainRec['RecAddress'];
$body.='</p>';
$body.='<p>';
$body.='收貨人：';
$body.=$row_ordmainRec['RecName'];
$body.='</p>';
$body.='<p>';
$body.='連絡電話：';
$body.=$row_ordmainRec['RecPhone'];
$body.='</p>';
$body.='<p>';
$body.="訂單明細及商品配送狀態請至『<a href='".$my_accounts."' target='_blank' style='text-decoration:none;'>會員中心-個人訂單</a>』查詢";
$body.='</p>';
$body.='</td>';
$body.='</tr>';
$body.='</table>';
$body.='</center>';
$body.='</body>';
$body.='</html>';

  $Name=$_POST['RecName'];
  $Email=$_POST['RecMail'];
  $fromname=$rs_head['sitename'];
  $replymail=$rs_head['adm_mail'];
  $subject="已收到您的訂單，您的訂單編號為".$_POST['OrderNum'];

  $mailto=$Name." <".$Email.">";
  $mailFrom="=?UTF-8?B?"  .  base64_encode($fromname)  .
  "?= <".$replymail.">";
  $mailSubject="=?UTF-8?B?"  .  base64_encode($subject).
  "?=";
  $mailHeader="From:".$mailFrom."\r\n";
  $mailHeader.="Content-type:text/html;charset=UTF-8";
  mail($mailto,$mailSubject,$body,$mailHeader);

//寄給管理人員
  $Name="系統管理員";
  $Email=$rs_head['adm_mail'];
  $fromname=$rs_head['sitename'];
  $replymail=$rs_head['adm_mail'];
  $subject="新訂單，訂單編號為".$_POST['OrderNum'];

  $mailto=$Name." <".$Email.">";
  $mailFrom="=?UTF-8?B?"  .  base64_encode($fromname)  .
  "?= <".$replymail.">";
  $mailSubject="=?UTF-8?B?"  .  base64_encode($subject).
  "?=";
  $mailHeader="From:".$mailFrom."\r\n";
  $mailHeader.="Content-type:text/html;charset=UTF-8";
  mail($mailto,$mailSubject,$body,$mailHeader);
?>
