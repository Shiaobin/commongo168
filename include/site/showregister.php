<?php //require_once('Connections/webshop.php'); ?>
<?php //require('include/system.php'); ?>
<?php  //------------------------------新增留言----------------------------------//
if (isset($_POST["create"]) && isset($_POST["create"]) == "提交") {

	if(!isset($_POST['Sex'])) $_POST['Sex'] = 2;
	if(!isset($_POST['MaritalStatus'])) $_POST['MaritalStatus'] = 2;

    $insertSQL = sprintf("INSERT INTO usermain (UserId, UserName, UserPassword, HomePhone, UserMail, ZipCode, Address, UserQQ, Sex, MaritalStatus, Birthday, IncomeRange, Occupation, CompanyName, Memo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                          GetSQLValueString($_POST['UserId'], "text"),
						  GetSQLValueString($_POST['UserName'], "text"),
						  GetSQLValueString($_POST['UserPassword'], "text"),
						  GetSQLValueString($_POST['HomePhone'], "text"),
						  GetSQLValueString($_POST['UserMail'], "text"),
						  GetSQLValueString($_POST['ZipCode'], "text"),
						  GetSQLValueString($_POST['Address'], "text"),
						  GetSQLValueString($_POST['UserQQ'], "text"),
						  GetSQLValueString($_POST['Sex'], "tinyint"),
						  GetSQLValueString($_POST['MaritalStatus'], "tinyint"),
						  GetSQLValueString($_POST['Birthday'], "text"),
                          GetSQLValueString($_POST['IncomeRange'], "text"),
                          GetSQLValueString($_POST['Occupation'], "text"),
                          GetSQLValueString($_POST['CompanyName'], "text"),
                          GetSQLValueString($_POST['Memo'], "text"));

    mysql_select_db($database_webshop, $webshop);
    $Result = mysql_query($insertSQL, $webshop) or die(mysql_error());

    $insertGoTo = "index.php";
    //Send information
    //$headers = "Content-Type:text/html; charset = UTF-8";
    //$body = "親愛的顧客 ".$_POST['ord_name']."您好!!<br>";
    //$body = $body."您的訂單編號: ".$_POST['ord_id']."<br>";
    //$body = $body."訂單總金額: ".$_POST['ord_total']."<br>";
    //$body = $body."訂單商品我們會儘快完成出貨!非常感謝您的惠顧!!";
    //mail($_POST['ord_email'],"感謝您的訂購!!",$body,$headers);

    //Show message window
    echo "<script language=\"javascript\">";
    echo "window.alert(\"註冊成功\");";
    echo "window.location.href='$insertGoTo'";
    echo "</script>";
}
?>
<?php //------------------------------檢查帳號----------------------------------//
if (isset($_POST["check"]) && isset($_POST["check"]) == "檢測帳號") {
    mysql_select_db($database_webshop, $webshop);
    $searchSQL = sprintf("SELECT UserId FROM usermain WHERE UserId=%s",
                          GetSQLValueString($_POST['UserId'], "text"));
    $idRec = mysql_query($searchSQL, $webshop) or die(mysql_error());
    $totalRows_showIdRec = mysql_num_rows($idRec);

    if($totalRows_showIdRec > 0) {
		$use = false;
    }
    else {
	   $use = true;
    }
}
?>

<script type="text/javascript">
function checkid(){
  if(document.createMember.UserId.value.length > 0) {
	  if(!checkId(document.createMember.UserId.value))
		alert('帳號只能包含英文或數字');

	  else if(document.createMember.UserId.value.length<2)
		alert('帳號長度過短，請重新輸入');

	  else if(document.createMember.UserId.value.length>15)
		alert('帳號長度過長，請重新輸入');
	  else
	     document.forms["check"].submit();
  }
  else
    alert('請輸入登入帳號');
}
function checkform(form){
  if(document.createMember.UserId.value.length == 0)
    alert('請輸入登入帳號\n');
  else if(!checkId(document.createMember.UserId.value))
		alert('帳號只能包含英文或數字');
  else if(document.createMember.UserId.value.length < 2)
		alert('帳號長度過短，請重新輸入');
  else if(document.createMember.UserId.value.length > 15)
		alert('帳號長度過長，請重新輸入');
  else if(document.createMember.UserPassword.value.length == 0)
    alert('請輸入登入密碼\n');
  else if(!checkId(document.createMember.UserPassword.value))
		alert('密碼只能包含英文或數字');
  else if(document.createMember.UserPassword.value.length < 5)
		alert('密碼長度過短，請重新輸入');
  else if(document.createMember.UserPassword.value.length > 10)
		alert('密碼長度過長，請重新輸入');
  else if(document.createMember.UserPassword_chk.value.length == 0)
    alert('請輸入確認密碼\n');
  else if(document.createMember.UserPassword.value != document.createMember.mem_pass_chk.value)
    alert('確認密碼輸入錯誤\n');
  else if(document.createMember.UserName.value.length == 0)
    alert('請輸入真實姓名\n');
  else if(document.createMember.HomePhone.value.length == 0)
    alert('請輸入聯絡手機\n');
  else if(document.createMember.UserMail.value.length == 0)
    alert('請輸入電子信箱\n');
  else if (document.createMember.UserMail.value.indexOf('@') < 1 ||
           document.createMember.UserMail.value.indexOf('@')==(document.createMember.UserMail.value.length-1) )
    alert('電子信箱輸入錯誤\n');
  else if(document.createMember.ZipCode.value.length == 0)
    alert('請輸入郵遞區號\n');
  else if(document.createMember.Address.value.length == 0)
    alert('請輸入聯絡地址\n');
  else  {
	document.forms["create"].submit();
  }
}
function checkId(str){
 var reg=/[^A-Za-z0-9_]/g
     if (reg.test(str)){
         return (false);
     }
	 else{
         return(true);
     }
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
</script>
<h2>第一步 填寫基本資料</h2>
<table width="96%" height="100%" border="0" cellpadding="0" cellspacing="0" class="formTable1" >
  <form action="" method="post" name="createMember" id="createMember">
  <tr>
    <td width="20%"  align="right">登入帳號<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="UserId" type="text" id="UserId" value="<?php if(isset($_POST['UserId'])) echo $_POST['UserId'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      2至15位純數字和字母
      <input name="check" type="submit" onclick="MM_callJS('checkid()'); return false" value="檢測帳號"/>
      <?php if(isset($use)) { ?>
        <?php  if($use == true) { ?><font color="#3366FF">此帳號可以使用</font>
	    <?php  }else {?><font color="#CC0000">此帳號已有人使用</font>
	  <?php	}} ?>
    </td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">登入密碼<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="UserPassword" type="text" id="UserPassword" value="<?php if(isset($_POST['UserPassword'])) echo $_POST['UserPassword'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      長度：5至10個字符
    </td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">確認密碼<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="mem_pass_chk" type="password" id="mem_pass_chk" value="<?php if(isset($_POST['mem_pass_chk'])) echo $_POST['mem_pass_chk'];?>" style="width:40%; height:70%; margin: 3px"/>
      確認您剛才輸入的密碼
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">真實姓名<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="UserName" type="text" id="UserName" value="<?php if(isset($_POST['UserName'])) echo $_POST['UserName'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      請輸入您的真實姓名
    </td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">聯絡手機/電話<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="HomePhone" type="text" id="HomePhone" value="<?php if(isset($_POST['HomePhone'])) echo $_POST['HomePhone'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      非常重要，必須填寫
    </td>
  </tr>
  <tr>
    <td width="20%" align="right">電子信箱<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="UserMail" type="text" id="UserMail" value="<?php if(isset($_POST['UserMail'])) echo $_POST['UserMail'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      非常重要，必須填寫
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">郵遞區號<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="ZipCode" type="text" id="ZipCode" value="<?php if(isset($_POST['ZipCode'])) echo $_POST['ZipCode'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      非常重要，必須填寫
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">聯絡地址<font color="#CC0000">*</font></td>
    <td width="80%" align="left">
      <input name="Address" type="text" id="Address" value="<?php if(isset($_POST['Address'])) echo $_POST['Address'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      非常重要，必須填寫
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">LineID</td>
    <td width="80%" align="left">
      <input name="UserQQ" type="text" id=" UserQQ" value="<?php if(isset($_POST['UserQQ'])) echo $_POST['UserQQ'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      建議填寫，便於聯絡
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="15%" align="right">性 別</td>
    <td align="left">
      <label>
        <input type="radio" name="Sex" value="0" id="Sex_0"
		<?php if(isset($_POST['Sex']) && $_POST['Sex']== 0) echo "checked=checked";?>/>男</label>
      <label>
        <input type="radio" name="Sex" value="1" id="Sex_1"
        <?php if(isset($_POST['Sex']) && $_POST['Sex']== 1) echo "checked=checked";?>/>女</label>

    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="15%" align="right">婚 否</td>
    <td align="left">
      <label>
        <input type="radio" name="MaritalStatus" value="0" id="MaritalStatus_0"
        <?php if(isset($_POST['MaritalStatus']) && $_POST['MaritalStatus']== 0) echo "checked=checked";?>/>未婚</label>
      <label>
        <input type="radio" name="MaritalStatus" value="1" id="MaritalStatus_1"
        <?php if(isset($_POST['MaritalStatus']) && $_POST['MaritalStatus']== 1) echo "checked=checked";?>/>已婚</label>

    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">生 日</td>
    <td width="80%" align="left">
      <input name="Birthday" type="text" id="Birthday" value="<?php if(isset($_POST['Birthday'])) echo $_POST['Birthday'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      例如1980-01-01
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">收 入</td>
    <td width="80%" align="left">
      <input name="IncomeRange" type="text" id="IncomeRange" value="<?php if(isset($_POST['IncomeRange'])) echo $_POST['IncomeRange'];?>"
       style="width:40%; height:70%; margin: 3px"/>
      例如1000-2000
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">職 業</td>
    <td width="80%" align="left">
      <input name="Occupation" type="text" id="Occupation" value="<?php if(isset($_POST['Occupation'])) echo $_POST['Occupation'];?>"
       style="width:40%; height:70%; margin: 3px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">公 司</td>
    <td width="80%" align="left">
      <input name="CompanyName" type="text" id="CompanyName" value="<?php if(isset($_POST['CompanyName'])) echo $_POST['CompanyName'];?>"
       style="width:40%; height:70%; margin: 3px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="30%" align="right" valign="center">備 忘</td>
    <td height="30%" align="left" valign="top">
      <textarea id="Memo" name="Memo" cols="40" rows="5"
       value="<?php if(isset($_POST['Memo'])) echo $_POST['Memo'];?>"
       style="margin:3px"></textarea>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td align="right" valign="middle"></td>
    <td align="left" valign="middle">
      <input name="create" type="submit" onclick="MM_callJS('checkform(this.form)'); return false;" value="提交" style="font-size:16px;width:80px;height:25px"/>
      <input name="cancel" type="reset" value="清除" style="font-size:16px;width:80px;height:25px"/>
    </td>
  </tr>

  </form>
</table>
