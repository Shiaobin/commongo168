<?php
$Name=$_POST['name'];
$Email=$_POST['email'];
$subject=$_POST['subject'];
$body=$_POST['body'];


$query="select * from mailbox_setup where set_open='1'";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs = mysql_fetch_array($result)){
$access=$rs['Access'];
$password=$rs['Password'];
$fromname=$rs['FromName'];
$replymail=$rs['ReplyMail'];
}

$mailto=$Name." <".$Email.">";
$mailFrom="=?UTF-8?B?"  .  base64_encode($fromname)  .
"?= <".$replymail.">";
$mailSubject="=?UTF-8?B?"  .  base64_encode($subject).
"?=";
$mailHeader="From:".$mailFrom."\r\n";
$mailHeader.="Content-type:text/html;charset=UTF-8";
mail($mailto,$mailSubject,$body,$mailHeader);
?>