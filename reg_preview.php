<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="expires" content="0">
<?php include("indexconfig.php"); ?>
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
          <?php 
			 @$LarCode = $_GET['LarCode'];			 
			?>
            <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>"><?php echo $LarCode; ?></a></li>
            <?php 
			 @$MidCode = $_GET['MidCode'];
			 if(isset($MidCode) && (isset($LarCode)))
			 {			 
			?>
                <li class="font-small"><a href="prodlist.php?LarCode=<?php echo $LarCode; ?>&MidCode=<?php echo $MidCode; ?>"><?php echo $MidCode; ?></a></li>
            <?php
			 }
			?>
            
          </ol>
        </div>
        
        <!-- end#header-box-->


        <div class="row" id="content-box">
          <div class="col-sm-8 col-sm-push-3 col-xs-12" id="content">
            <div class="row" id="p_usagetip" style="display: none;">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-14 content-productList-item">
                <p class="content-productList-tag-hint">顯示具有<span class="" id="p_usage"> "產品系列" </span>標籤的產品。</p>
              </div>
            </div><!--提示 end.row-->
            <div class="row" id="p_productlist">
<script language="JavaScript">
function JM_sh(ob){
if (ob.style.display=="none"){ob.style.display=""}else{ob.style.display="none"};
}
//函數名：fucPWDchk 
//功能介紹：檢查是否含有非數字或字母 
//參數說明：要檢查的字符串 
//返回值：0：含有 1：全部為數字或字母 
function fucPWDchk(str) 
{ 
var strSource ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
var ch; 
var i; 
var temp; 

for (i=0;i<=(str.length-1);i++) 
{ 

ch = str.charAt(i); 
temp = strSource.indexOf(ch); 
if (temp==-1) 
{ 
return 0; 
} 
} 
if (strSource.indexOf(ch)==-1) 
{ 
return 0; 
} 
else 
{ 
return 1; 
} 
} 
function jtrim(str) 
{ while (str.charAt(0)==" ") 
{str=str.substr(1);} 
while (str.charAt(str.length-1)==" ") 
{str=str.substr(0,str.length-1);} 
return(str); 
} 
//判斷表單輸入正誤
function Checkreg()
{
	var re1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9])+$/; 


 	if (re1.exec(ADDUser.UserId.value) == null){              
		alert("請檢查您填寫的信箱格式。");
		document.ADDUser.UserId.focus();    	
		return false;                
 		}
 	if (document.ADDUser.UserId.value.length > 50){              
		alert("信箱長度超過限制");
		document.ADDUser.UserId.focus();    	
		return false;                
 		}
	if (document.ADDUser.UserName.value.length < 2 || document.ADDUser.UserName.value.length >=20) {
		alert("請檢查您填寫的真實姓名。");
		document.ADDUser.UserName.focus();
		return false;
	}

	if (document.ADDUser.pw1.value.length <5 || document.ADDUser.pw1.value.length >10) {
		alert("請輸入密碼,長度在5-10之間。");
		document.ADDUser.pw1.focus();
		return false;
	}
	
	if (document.ADDUser.pw1.value != document.ADDUser.pw2.value) {
		alert("您兩次輸入的密碼不一樣！請重新輸入。");
		document.ADDUser.pw2.focus();
		return false;
	}
	if (document.ADDUser.UserMail.value.length <8 || document.ADDUser.UserMail.value.length >=50) {
		alert("請輸入有效的電子信箱。");
		document.ADDUser.UserMail.focus();
		return false;
	}
	if (document.ADDUser.Address.value.length <3 || document.ADDUser.Address.value.length >=50) {
		alert("請輸入有效的聯絡地址。");
		document.ADDUser.Address.focus();
		return false;
	}
	if (document.ADDUser.ZipCode.value.length !=3) {
		alert("請輸入正確的郵遞區號，長度為3位數字。");
		document.ADDUser.ZipCode.focus();
		return false;
	}
	if (document.ADDUser.HomePhone.value.length <6 || document.ADDUser.HomePhone.value.length >13) {
		alert("請輸入有效的電話號碼例(02-25879966)。");
		document.ADDUser.HomePhone.focus();
		return false;
	}
	if (document.ADDUser.CompPhone.value.length <10 || document.ADDUser.CompPhone.value.length >12) {
		alert("請輸入有效的手機號碼例(0912-799660)。");
		document.ADDUser.HomePhone.focus();
		return false;
	}
}
</script> 
<script>
function myFunction() {
	window.open('reg_detectname.php?UserId='+document.ADDUser.UserId.value,"_self");
	myWindow.document.write("<p>I replaced the current window.</p>");
    
}
</script>

<h3>填寫基本資料</h3>
<form name="ADDUser" method="POST" action="reg_save.php" onSubmit="return Checkreg();" class="form-horizontal">
<TABLE class="table table-bordered table-striped" width="100%">
 
<tr> 
<td>登入信箱<font color=red>*</font>:<input name="UserId" type="text" value="<?php if(isset($_GET['UserId'])){ echo $_GET['UserId']; }else{}?>" class="input-medium" >
              <INPUT TYPE="button" onClick="myFunction()" value="檢測帳號"><?php if(isset($_GET['Message'])) echo "<font color=red>".$_GET['Message']."</font>"; ?></td>
          </tr>
<tr><td>真實姓名<font color=red>*</font>:<input name="UserName" type="text"  class="input-medium"  >
              請輸入您的真實姓名</td></tr>
<tr><td>登入密碼<font color=red>*</font>:<input name="pw1" type="password" class="input-medium"  >
              長度：5至10個字符 </td>
          </tr>
<tr><td>確認密碼<font color=red>*</font>:<input name="pw2" type="password" size="25" maxlength="12" class="input-medium">
              確認您剛才輸入的密碼 </td>
          </tr>
<tr> <td>電子信箱<font color=red>*</font>:<input name="UserMail" type="text" class="input-medium" value=""  >
              非常重要，必須填寫</td>
          </tr>
<tr><td>聯絡地址<font color=red>*</font>:<input name="Address" type="text" value="" class="input-xlarge"  > 非常重要，必須填寫</td>
            </tr>
<tr><td>郵遞區號<font color=red>*</font>:<input name="ZipCode" type="text" value="" class="input-mini"  > 非常重要，必須填寫</td>
            </tr>
<tr><td>聯絡電話<font color=red>*</font>:<input name="HomePhone" type="text" value="" class="input-medium"  > 非常重要，必須填寫</td>
            </tr>            
<tr><td>手 機:<font color=red>*</font><input name="CompPhone" type="text" value="" size="25" class="input-medium" >  非常重要，必須填寫</td>
            </tr>
<tr><td>Line_ID:<input name="UserQQ" type="text" class="input-medium"  > 建議填寫，便於聯絡</td>
           </tr>
<input name="pst" type="hidden" value="0">
<tr><td>性 別:<input name="Sex" type="radio" value="1">
                男 
                <input type="radio" name="Sex" value="0">
                女 </td>
            </tr>
<!--tr><td>婚 否:<input name="MaritalStatus" type="radio" value=1>
                已婚 
                <input type="radio" name="MaritalStatus" value=0>
                未婚 </td>
            </tr-->
<!--tr><td><div class="controls">生 日:<input type="text" name="Birthday" value=""  class="input-mini"  >年

<select class="input-mini" id="select01" name="D1">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  </select>

  月 
  <select class="input-mini" id="select01" name="D2">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
  <option value="25">25</option>
  <option value="26">26</option>
  <option value="27">27</option>
  <option value="28">28</option>
  <option value="29">29</option>
  <option value="30">30</option>
  <option value="31">31</option>
  </select>日</div> </td>
            </tr-->
<input type="hidden" name="IncomeRange" value=""  >            
<!--tr><td>職 業:<input name="Occupation" type="text" value="" class="input-xlarge" ></td-->
            </tr>
<!--tr><td>公 司:<input name="CompanyName" type="text" value="" class="input-xlarge"  ></td-->
            </tr>
<tr><td>備 忘:<textarea name="Memo"  class="input-xlarge" id="textarea" ></textarea></td>
            </tr>
<!--tr><td>電子報:<input name="WantMessage" type="radio" value="1" checked>
                願意接收 
                <input type="radio" name="WantMessage" value="0">
                請勿打擾</td>
            </tr-->
<tr><td> 
<input type="hidden" name="adduser" value="true"> 
<input type="submit" value=" 提 交 " name="ok" >
<input type="reset" value=" 清 除 " name="Reset" ></td>
          </tr>      
      </table>  
      </form>      
            
            

            </div><!--產品列表 end.row-->

          </div><!--內容 end#content-->
          

<div class="col-sm-2 col-sm-offset-1 col-sm-pull-8 col-xs-12" id="nav-box">
<?php include("include/leftmenu_prod.php"); ?>     
          </div><!--導覽 end#nav-box-->
        </div><!--內容 end#content-box-->
     </div><!--頁尾以外 end#wrapper-box-->


     

<div id="footer-box">
      <div id="footer" class="row">
  <?php include("include/bottom.php"); ?>        
      </div><!--頁尾 end#footer-->
    </div><!--頁尾 end#footer-box-->
  
 </body></html>