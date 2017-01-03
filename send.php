<?php
$Name=$_POST['name'];
$Email=$_POST['email'];
$Telphone=$_POST['tel'];
$Address=$_POST['address'];
$Message=$_POST['meno'];
$ImgFull="none.png";
$ReplyId="";

$query_add = "INSERT INTO contact_msg (Name, Email, Telphone, Address, Message, ImgFull) VALUES ('".$Name."','".$Email."','".$Telphone."','".$Address."','".$Message."','".$ImgFull."')";
$result_add=mysql_query($query_add, $webshop) or die("cannot connect to table" . mysql_error( ));


$query="select * from mailbox_setup where set_open='1'";
$result=mysql_query($query, $webshop) or die("cannot connect to table" . mysql_error( ));
while($rs = mysql_fetch_array($result)){
$access=$rs['Access'];
$password=$rs['Password'];
$fromname=$rs['FromName'];
$replymail=$rs['ReplyMail'];
$subject=$rs['Subject'];
$body=$rs['Body'];
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
