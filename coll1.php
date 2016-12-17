<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php 

require('utility/init.php'); 
require("include/classes/Car.class.php");
include("indexconfig.php");


?>

</head>
  <body>
    <div id="wrapper-box"> 
     <?php include("include/topmenu2.php"); ?>  


<div id="header-box" class="row">
        <div class="jumbotron col-sm-10 col-sm-offset-1">
     <?php include("include/banner.php"); ?>     
          
          <!--頁頭flash end.captioned-gallery-->
          <div class="jumbotron-box"><!-- 導覽列：會員登入前 -->
            <nav class="navbar navbar-default" role="navigation">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <!-- <a class="navbar-brand" href="#">57</a>-->
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
           
              </div><!-- /.container-fluid -->
            </nav>
          </div> <!-- end.jumbotron-box 導覽列：會員登入前-->

        </div>
        
        <!--頁頭flash end.jumbotron-->
          <ol class="breadcrumb col-sm-10 col-sm-offset-1" id="p_breadcrumb">
            <li class="font-small"><a href="index.php">首頁</a></li>
            <li class="font-small">聯絡我們</li>
      
          </ol>
        </div>
        
        <!-- end#header-box-->
        <div class="row" id="content-box">
        
          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
<script language="JavaScript">
function CheckForm()
{
	if (document.payment.name.value.length == 0) {
		alert("請輸入姓名.");
		document.payment.name.focus();
		return false;
	}
	
	if (document.payment.email.value.length == 0) {
		alert("請輸入EMAIL.");
		document.payment.email.focus();
		return false;
	}
		
	if (document.payment.email.value.length > 0 && !document.payment.email.value.match( /^.+@.+$/ ) ) {
	    alert("EMAIL 錯誤！請重新輸入");
	    document.payment.email.focus();
		return false;
	}

   	if (document.payment.tel.value.length < 5 ) {
	    alert("電話 錯誤！請重新輸入");
	    document.payment.tel.focus();
		return false;
	}
      if (document.payment.address.value.length == 0) {
		alert("請輸入地址.");
		document.payment.address.focus();
		return false;
	}
      if (document.payment.chk.value.length == 0) {
		alert("請輸入驗證碼.");
		document.payment.chk.focus();
		return false;
	}
      if(document.payment.chk.value != document.payment.chke.value){
      alert("驗證碼輸入錯誤！請重新輸入.");
		document.payment.chk.focus();
		return false;
        }
      if (document.payment.meno.value.length == 0) {
		alert("請輸入內容.");
		document.payment.meno.focus();
		return false;
	}
      if (document.payment.meno.value.length < 10) {
		alert("請詳細說明內容.");
		document.payment.meno.focus();
		return false;
	}
	return true;
}

 </script>         
          <?php
/*<%
Page=request("page")
pagecount=page
SubLar=request("LarCode")
SubMid=request("MidCode")
Dim pageurl
pageurl="sublistcomp0.asp"
%>
*/
$password_len = 5;
$password = '';

$word = '0123456789';
$len = strlen($word);

for ($i = 0; $i < $password_len; $i++) {
  $password = $password.$word[rand() % $len];
}

?>
<form method="post" action="contactus_send.php" name="payment" onSubmit="return CheckForm();">
   <div align="center">
     <center>
   <table  class="table table-bordered table-striped" width="100%">
<tr>
       <td style="border-collapse:collapse;text-align:center;">
       <font size="4" color="#FF0000"><b>※請詳細敘述您想詢問事項!!我們會盡速與您聯絡!!※
      </b></font></td>
     </tr>  

  <tr>
    <td><font size="3">姓名：</font><input name="name" type="text" class="sizeSs">
    </td>
  </tr>
  <tr>
    <td><font size="3">E-mail：</font><input type="text" class="sizeS" name="email"></td>
  </tr>
  <tr>
    <td><font size="3">電話：</font><input type="text" class="sizeS" name="tel"></td>
  </tr>
    <tr>
    <td><font size="3">地址：</font><input type="text" class="sizeM" name="address"></td>
  </tr>
  <tr>
  <td><font size="3"> 請輸入驗證碼*<input name="chk" type="text" class="sizeSs"> <font size="3" color="#0000FF"><?php echo $password;?></font>
<input name="chke" type="hidden" value="<?php echo $password;?>" > 
 </td></tr>
  <tr>
    <td><font size="3">留言訊息：</font><br><textarea name="meno" rows="5" cols="30"></textarea></td>
  </tr>


     <tr>
       <td>
           <input type="submit" name="submit" value="送出">
          <input type="reset" name="reset" value="重填"></center>   
       </td>
     </tr> 
   </table>
     </center>
   </div>
</form>  
          
           
          </div><!--內容 end#content-->
          

<div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_comp.php"); ?>     
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->


     

<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>        
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->
  
 </body></html>