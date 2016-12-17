<?php

/*
提供其他網域寄信的功能
*/
if(isset($_GET['name']) && isset($_GET['email']) && isset($_GET['fromname']) && isset($_GET['replymail']) && isset($_GET['subject']) && isset($_GET['body']) && isset($_GET['back'])){
$Name=$_GET['name'];
$Email=$_GET['email'];
$fromname=$_GET['fromname'];
$replymail=$_GET['replymail'];
$subject=$_GET['subject'];
$body=$_GET['body'];
$back=$_GET['back']; //往返的頁面

$mailto=$Name." <".$Email.">";
$mailFrom="=?UTF-8?B?"  .  base64_encode($fromname)  .
"?= <".$replymail.">";
$mailSubject="=?UTF-8?B?"  .  base64_encode($subject).
"?=";
$mailHeader="From:".$mailFrom."\r\n";
$mailHeader.="Content-type:text/html;charset=UTF-8";
mail($mailto,$mailSubject,$body,$mailHeader);

header("location:$back");
}

?>