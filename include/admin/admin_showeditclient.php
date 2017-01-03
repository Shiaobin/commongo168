<?php  //-----------------------------更新客戶資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update"])) && ($_POST["update"] == "確定修改")) {
  if(!isset($_POST['Sex'])) $_POST['Sex'] = 2;
  if(!isset($_POST['MaritalStatus'])) $_POST['MaritalStatus'] = 2;

	$column = "*";
	$table_shopsetup		= SYS_DBNAME . ".shopsetup";

	$sql['list']['select'] = array(
		'mysql'	=> "SELECT {$column} FROM {$table_shopsetup}",
		'mssql'	=> "SELECT {$column} FROM {$table_shopsetup}",
		'oci8'	=> "SELECT {$column} FROM {$table_shopsetup}"
	);
	$row_shopsetup = dbGetRow($sql['list']['select'][SYS_DBTYPE]);

	for($i=1;$i<=6;$i++)
	{
		$str="usertype".$i;
		if($row_shopsetup[$str]==$_POST['UserType'])
		{
			$UserKou=$row_shopsetup["kou".$i];
		}
	}
		$table_usermain		= SYS_DBNAME . ".usermain";
  $record = array(
  				'UserName' => $_POST['UserName'],
				'UserPassword' => $_POST['UserPassword'],
				'CompPhone' => $_POST['CompPhone'],
				'UserMail' => $_POST['UserMail'],
				'ZipCode' => $_POST['ZipCode'],
				'Address' => $_POST['Address'],
				'UserQQ' => $_POST['UserQQ'],
				'UserType' => $_POST['UserType'],
				'UserKou' => $UserKou,
				'Sex' => $_POST['Sex'],
				'MaritalStatus' => $_POST['MaritalStatus'],
				'Birthday' => $_POST['Birthday'],
				'IncomeRange' => $_POST['IncomeRange'],
				'Occupation' => $_POST['Occupation'],
				'CompanyName' => $_POST['CompanyName'],
				'Memo' => $_POST['Memo'],
				'Status' => $_POST['Status'],
				'WantMessage' => @$_POST['WantMessage']
				);
  $whereClause = "usernum={$_POST['usernum']}";

  dbUpdate( $table_usermain, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE usermain SET UserName=%s, UserPassword=%s, CompPhone=%s, UserMail=%s,
                        ZipCode=%s, Address=%s, UserQQ=%s, UserType=%s, Sex=%s, MaritalStatus=%s,
						Birthday=%s, IncomeRange=%s, Occupation=%s, CompanyName=%s, Memo=%s,
						Status=%s, WantMessage=%s WHERE usernum=%s",
						GetSQLValueString($_POST['UserName'], "text"),
                        GetSQLValueString($_POST['UserPassword'], "text"),
                        GetSQLValueString($_POST['CompPhone'], "text"),
					    GetSQLValueString($_POST['UserMail'], "text"),
                        GetSQLValueString($_POST['ZipCode'], "text"),
                        GetSQLValueString($_POST['Address'], "text"),
                        GetSQLValueString($_POST['UserQQ'], "text"),
					    GetSQLValueString($_POST['UserType'], "text"),
					    GetSQLValueString($_POST['Sex'], "tinyint"),
					    GetSQLValueString($_POST['MaritalStatus'], "tinyint"),
                        GetSQLValueString($_POST['Birthday'], "text"),
                        GetSQLValueString($_POST['IncomeRange'], "text"),
					    GetSQLValueString($_POST['Occupation'], "text"),
                        GetSQLValueString($_POST['CompanyName'], "text"),
					    GetSQLValueString($_POST['Memo'], "text"),
					    GetSQLValueString($_POST['Status'], "tinyint"),
					    GetSQLValueString($_POST['WantMessage'], "tinyint"),
                        GetSQLValueString($_POST['usernum'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminclient.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得會員資訊------------------------------------//
$colname_memmainRec = "-1";
if (isset($_GET['UserId'])) {
  $colname_memmainRec = $_GET['UserId'];
}
$table_usermain		= SYS_DBNAME . ".usermain";
$whereClause = "UserId='{$colname_memmainRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}",
		'mssql'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_usermain} WHERE {$whereClause}"
		);
$row_memmainRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_memmainRec = sprintf("SELECT * FROM usermain
WHERE UserId = %s",
GetSQLValueString($colname_memmainRec, "text"));
$memmainRec = mysql_query($query_memmainRec, $webshop) or die(mysql_error());
$row_memmainRec = mysql_fetch_assoc($memmainRec);
$totalRows_memmainRec = mysql_num_rows($memmainRec);
*/
?>
<?php  //-----------------------------取得會員等級------------------------------------//
$table_shopsetup		= SYS_DBNAME . ".shopsetup";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_shopsetup}",
		'mssql'	=> "SELECT * FROM {$table_shopsetup}",
		'oci8'	=> "SELECT * FROM {$table_shopsetup}"
		);
$row_memlevel = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_memmainRec = sprintf("SELECT * FROM usermain
WHERE UserId = %s",
GetSQLValueString($colname_memmainRec, "text"));
$memmainRec = mysql_query($query_memmainRec, $webshop) or die(mysql_error());
$row_memmainRec = mysql_fetch_assoc($memmainRec);
$totalRows_memmainRec = mysql_num_rows($memmainRec);
*/
?>
<?php  //------------------------------取得折扣資訊----------------------------------//
  $class = $row_memmainRec['UserType'];
?>
<!--------------------------------------------------------------------------------->
<h3 class=ttl01 >客戶資訊</h3>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------編輯客戶資訊--------------------------------->
<form name="editclient" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editclient">
  <tr>
    <td>1.會員ID:<?php echo $row_memmainRec['UserId']; ?></td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>2.會員密碼:
    <input name="UserPassword" type="password" id="UserPassword" class=sizeS value="<?php echo $row_memmainRec['UserPassword']; ?>"/></td>
  </tr>
  <tr>
    <td>3.會員等級:
      <select name="UserType">
      <?php for($i=1;$i<=6;$i++)
	  {
	  $str='usertype'.$i;
	  	if(!empty($row_memlevel[$str]))
		{
	  ?>
      		<option value="<?php echo $row_memlevel[$str]; ?>" <?php if($row_memlevel[$str]==$row_memmainRec['UserType']) echo "selected"; ?>><?php echo $row_memlevel[$str]; ?></option>
      <?php
		}
	  }
	  ?>
      </select>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>4.購物折扣:
      <?php for($i=1;$i<=6;$i++)
	  {
	  $str1='usertype'.$i;
	  $str2='kou'.$i;
	  	if($row_memmainRec['UserType']==$row_memlevel[$str1])
		{
			echo $row_memlevel[$str2];
	  ?>
      		<input type="hidden" name="UserKou" value="<?php echo $row_memlevel[$str2]; ?>" />
      <?php
		}
	  }
	  ?>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>5.姓名:
      <input name="UserName" type="text" id="UserName" class=sizeS
       value="<?php echo $row_memmainRec['UserName']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>6.E-MAIL:
      <input name="UserMail" type="text" id="UserMail" class=sizeML
       value="<?php echo $row_memmainRec['UserMail']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>7.LineID::
      <input name="UserQQ" type="text" id="UserQQ" class=sizeS
       value="<?php echo $row_memmainRec['UserQQ']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>8.性別:
      <label>
        <input type="radio" name="Sex" value="0" id="Sex_0"
        <?php if ($row_memmainRec['Sex'] == '1'): ?>checked='checked'<?php endif; ?>/>
        男</label>
      <label>
        <input type="radio" name="Sex" value="1" id="Sex_1"
        <?php if ($row_memmainRec['Sex'] == '0'): ?>checked='checked'<?php endif; ?>/>
        女</label>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>9.婚姻:
      <label>
        <input type="radio" name="MaritalStatus" value="0" id="MaritalStatus_0"
        <?php if ($row_memmainRec['MaritalStatus'] == '1'): ?>checked='checked'<?php endif; ?>/>
        未婚</label>
      <label>
        <input type="radio" name="MaritalStatus" value="1" id="MaritalStatus_1"
        <?php if ($row_memmainRec['MaritalStatus'] == '0'): ?>checked='checked'<?php endif; ?>/>
        已婚</label>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>10.出生日期:
      <input name="Birthday" type="text" id="Birthday" class=sizeS
       value="<?php echo $row_memmainRec['Birthday']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>11.收入範圍:
      <input name="IncomeRange" type="text" id="IncomeRange" class=sizeS
       value="<?php echo $row_memmainRec['IncomeRange']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>12.職業:
      <input name="Occupation" type="text" id="Occupation" class=sizeM
       value="<?php echo $row_memmainRec['Occupation']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>13.工作單位:
      <input name="CompanyName" type="text" id="CompanyName" class=sizeML
       value="<?php echo $row_memmainRec['CompanyName']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>14.聯絡電話:
      <input name="CompPhone" type="text" id="CompPhone" class=sizeM
       value="<?php echo $row_memmainRec['CompPhone']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>15.地址:
      <input name="Address" type="text" id="Address" class=sizeL
       value="<?php echo $row_memmainRec['Address']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>16.郵遞區號:
      <input name="ZipCode" type="text" id="ZipCode" class=sizeSss
       value="<?php echo $row_memmainRec['ZipCode']; ?>"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>17.備忘:<br>
      <textarea id="Memo" name="Memo" cols="40" rows="10"
       style="width:70%; height:90px; margin:3px"><?php echo $row_memmainRec['Memo']; ?></textarea>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>18.是否接收郵件通知:
      <label>
        <input type="radio" name="WantMessage" value="0" id="WantMessage_0"
        <?php if ($row_memmainRec['WantMessage'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="WantMessage" value="1" id="WantMessage_1"
        <?php if ($row_memmainRec['WantMessage'] == '1'): ?>checked='checked'<?php endif; ?>/>
        是</label>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>19.是否凍結客戶:
      <label>
        <input type="radio" name="Status" value="0" id="Status _0"
		<?php if ($row_memmainRec['Status'] == '0'): ?>checked='checked'<?php endif; ?>/>
        否</label>
      <label>
        <input type="radio" name="Status" value="1" id="Status _1"
        <?php if ($row_memmainRec['Status'] == '1'): ?>checked='checked'<?php endif; ?> />
        是</label>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
  <tr>
    <td>
      <input name="usernum" type="hidden" value="<?php echo $row_memmainRec['usernum']; ?>" />
      <input type="submit" name="update"  value="確定修改" style="width:16%; height:100%; margin: 3px"/>
      <input type="reset" name="reset"  value="重新設定"   style="width:16%; height:100%; margin: 3px"/>
    </td>
  </tr>
  <!---------------------------------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($memmainRec);
//mysql_free_result($classRec);
?>
