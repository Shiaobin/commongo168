<?php  //------------------------------新增留言----------------------------------//
if (isset($_POST["update"]) && isset($_POST["update"]) == "更新") {

	if(!isset($_POST['Sex'])) $_POST['Sex'] = 2;
	if(!isset($_POST['MaritalStatus'])) $_POST['MaritalStatus'] = 2;

	$table_usermain = SYS_DBNAME . ".usermain";
	$whereClause = "usernum={$_POST['usernum']}";
	$record = array
	(
		'UserName' => $_POST['UserName'],
		'UserPassword' => $_POST['modify_pass_chk'],
		'HomePhone' => $_POST['HomePhone'],
		'UserMail' => $_POST['UserMail'],
		'ZipCode' => $_POST['ZipCode'],
		'Address' => $_POST['Address'],
		'UserQQ' => $_POST['UserQQ'],
		'Sex' => $_POST['Sex'],
		'MaritalStatus' => $_POST['MaritalStatus'],
		'Birthday' => $_POST['Birthday'],
		'IncomeRange' => $_POST['IncomeRange'],
		'Occupation' => $_POST['Occupation'],
		'CompanyName' => $_POST['CompanyName'],
		'Memo' => $_POST['Memo']
	);

	$is_update = dbUpdate( $table_usermain, $record, $whereClause );

/*
    $updateSQL = sprintf("UPDATE usermain SET UserName=%s, UserPassword=%s, HomePhone=%s, UserMail=%s, ZipCode=%s, Address=%s, UserQQ=%s, Sex=%s, MaritalStatus=%s, Birthday=%s, IncomeRange=%s, Occupation=%s, CompanyName=%s, Memo=%s WHERE usernum=%s",
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
                          GetSQLValueString($_POST['Memo'], "text"),
						  GetSQLValueString($_POST['usernum'], "int"));

    mysql_select_db($database_webshop, $webshop);
    $Result = mysql_query($updateSQL) or die(mysql_error());
  */
    $insertGoTo = "index.php";

    //Show message window
    echo "<script language=\"javascript\">";
    echo "window.alert(\"會員資料修改完成\");";
    echo "window.location.href='$insertGoTo'";
    echo "</script>";
}
?>
<?php  //-----------------------------取得會員資料------------------------------------//
$cloume_showmemberRec = "-1";
if (isset($_GET['usernum'])) {
  $cloume_showmemberRec = $_GET['usernum'];
}
$column = "*";
$table_usermain		= SYS_DBNAME . ".usermain";
$whereClause = "usernum='{$cloume_showmemberRec}'";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}",
		'mssql'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}",
		'oci8'	=> "SELECT {$column} FROM {$table_usermain} WHERE {$whereClause}"
);

$row_showmemberRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
$totalRows_showmemberRec = sizeof($row_showmemberRec);
	  /*
mysql_select_db($database_webshop, $webshop);
$query_showmemberRec = sprintf("SELECT * FROM usermain WHERE usernum=%s",
                               GetSQLValueString($cloume_showmemberRec, "int"));
$showmemberRec = mysql_query($query_showmemberRec, $webshop) or die(mysql_error());
$row_showmemberRec = mysql_fetch_assoc($showmemberRec);
$totalRows_showmemberRec = mysql_num_rows($showmemberRec);
*/
?>

<!-------------------------填寫會員資訊----------------------------->
<script type="text/javascript">
function checkid(){
  if(document.createMember.mem_id.value.length > 0) {
	  if(!checkId(document.createMember.mem_id.value))
		alert('帳號只能包含英文或數字');

	  else if(document.createMember.mem_id.value.length<2)
		alert('帳號長度過短，請重新輸入');

	  else if(document.createMember.mem_id.value.length>15)
		alert('帳號長度過長，請重新輸入');
	  else
	     document.forms["check"].submit();
  }
  else
    alert('請輸入登入帳號');
}
function checkform(form){
  if(document.createMember.modify_pass.value.length == 0)
    alert('請輸入登入密碼\n');
  else if(!checkId(document.createMember.modify_pass.value))
		alert('密碼只能包含英文或數字');
  else if(document.createMember.modify_pass.value.length < 5)
		alert('密碼長度過短，請重新輸入');
  else if(document.createMember.modify_pass.value.length > 10)
		alert('密碼長度過長，請重新輸入');
  else if(document.createMember.modify_pass_chk.value.length == 0)
    alert('請輸入確認密碼\n');
  else if(document.createMember.modify_pass.value != document.createMember.modify_pass_chk.value)
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
	document.forms["update"].submit();
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
<h2>會員基本資料修改</h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="" method="post" name="createMember" id="createMember">

  <tr>
    <td width="20%" align="right">登入帳號:</td>
    <td width="80%" align="left"><?php echo $row_showmemberRec['UserId'];?></td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">修改密碼:</td>
    <td width="80%" align="left">
      <input name="UserPassword" type="hidden" value="<?php echo $row_showmemberRec['UserPassword'];?>" />
      <input name="modify_pass" type="text" id="modify_pass" value="<?php echo $row_showmemberRec['UserPassword'];?>"
       class="sizeS"/>
      長度：5至10個字符
    </td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">確認密碼:</td>
    <td width="80%" align="left">
      <input name="modify_pass_chk" type="password" id="modify_pass_chk" value="<?php echo $row_showmemberRec['UserPassword'];?>" class="sizeS"/>
      確認您剛才輸入的密碼
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">真實姓名:</td>
    <td width="80%" align="left">
      <input name="UserName" type="text" id="UserName" value="<?php echo $row_showmemberRec['UserName'];?>"
       class="sizeS"/>
    </td>
  </tr>
   <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">聯絡手機/電話:</td>
    <td width="80%" align="left">
      <input name="HomePhone" type="text" id="HomePhone" value="<?php echo $row_showmemberRec['HomePhone'];?>"
       class="sizeS"/>
    </td>
  </tr>
  <tr>
    <td width="20%" align="right">電子信箱:</td>
    <td width="80%" align="left">
      <input name="UserMail" type="text" id="UserMail" value="<?php echo $row_showmemberRec['UserMail'];?>"
       class="sizeM"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">郵遞區號:</td>
    <td width="80%" align="left">
      <input name="ZipCode" type="text" id="ZipCode" value="<?php echo $row_showmemberRec['ZipCode'];?>"
       class="sizeSs"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">聯絡地址:</td>
    <td width="80%" align="left">
      <input name="Address" type="text" id="Address" value="<?php echo $row_showmemberRec['Address'];?>"
       class="sizeL"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">LineID:</td>
    <td width="80%" align="left">
      <input name="UserQQ" type="text" id=" UserQQ" value="<?php echo $row_showmemberRec['UserQQ'];?>"
       class="sizeS"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="15%" align="right">性 別:</td>
    <td align="left">
      <label>
        <input type="radio" name="Sex" value="0" id="Sex_0"
		<?php if($row_showmemberRec['Sex']== 0) echo "checked=checked";?>/>男</label>
      <label>
        <input type="radio" name="Sex" value="1" id="Sex_1"
        <?php if($row_showmemberRec['Sex']== 1) echo "checked=checked";?>/>女</label>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="15%" align="right">婚 否:</td>
    <td align="left">
      <label>
        <input type="radio" name="MaritalStatus" value="0" id="MaritalStatus_0"
        <?php if($row_showmemberRec['MaritalStatus']== 0) echo "checked=checked";?>/>未婚</label>
      <label>
        <input type="radio" name="MaritalStatus" value="1" id="MaritalStatus_1"
        <?php if($row_showmemberRec['MaritalStatus']== 1) echo "checked=checked";?>/>已婚</label>

    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">生 日:</td>
    <td width="80%" align="left">
      <input name="Birthday" type="text" id="Birthday" value="<?php echo $row_showmemberRec['Birthday'];?>"
       class="sizeS"/>
      例如1980-01-01
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">收 入:</td>
    <td width="80%" align="left">
      <input name="IncomeRange" type="text" id="IncomeRange" value="<?php echo $row_showmemberRec['IncomeRange'];?>"
       class="sizeS"/>
      例如1000-2000
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">職 業:</td>
    <td width="80%" align="left">
      <input name="Occupation" type="text" id="Occupation" value="<?php echo $row_showmemberRec['Occupation'];?>"
       class="sizeS"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td width="20%" align="right">公 司:</td>
    <td width="80%" align="left">
      <input name="CompanyName" type="text" id="CompanyName" value="<?php echo $row_showmemberRec['CompanyName'];?>"
       class="sizeM"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="30%" align="right" valign="center">備 忘:</td>
    <td height="30%" align="left" valign="top">
      <textarea id="Memo" name="Memo" cols="40" rows="5" style="margin:3px"><?php echo $row_showmemberRec['Memo'];?></textarea>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td align="right" valign="top"></td>
    <td align="left" valign="top">
      <input name="usernum" type="hidden" value="<?php echo $row_showmemberRec['usernum'];?>" />
      <input name="update" type="submit" onclick="MM_callJS('checkform(this.form)'); return false;" value="更新" style="font-size:16px;width:50px;height:35px"/>&nbsp;&nbsp;&nbsp;&nbsp;
      <input name="cancel" type="reset" value="清除" style="font-size:16px;width:50px;height:35px"/>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td height="8%" colspan="2"></td>
  </tr>
  <!-------------------------------------------------------------->
  </form>
</table>
<?php
 // mysql_free_result($showmemberRec);
?>
