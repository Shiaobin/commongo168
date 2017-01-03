<?php  //-----------------------------更新商品資訊------------------------------------//
//$sysConnDebug = true;
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_config"])) && ($_POST["update_config"] == "更新")) {
/*
  $updateSQL = sprintf("UPDATE shopsetup SET sitename=%s, siteurl=%s, reg=%s, adm_address=%s, adm_post=%s,
  adm_name=%s, adm_mail=%s, adm_tel=%s, adm_qq=%s, adm_kf=%s, adm_kfc=%s, shichang=%s, remai=%s, jsq=%s,
  usertype1=%s, usertype2=%s, usertype3=%s, usertype4=%s, usertype5=%s, usertype6=%s, pei1=%s, pei2=%s, pei3=%s, pei4=%s,
  kou1=%s, kou2=%s, kou3=%s, kou4=%s, kou5=%s, kou6=%s, fei1=%s, fei2=%s, fei3=%s, fei4=%s",
                       GetSQLValueString($_POST['sitename'], "text"),
                       GetSQLValueString($_POST['siteurl'], "text"),
					   GetSQLValueString($_POST['reg'], "tinyint"),
                       GetSQLValueString($_POST['adm_address'], "text"),
					   GetSQLValueString($_POST['adm_post'], "text"),
					   GetSQLValueString($_POST['adm_name'], "text"),
					   GetSQLValueString($_POST['adm_mail'], "text"),
                       GetSQLValueString($_POST['adm_tel'], "text"),
                       GetSQLValueString($_POST['adm_qq'], "text"),
					   GetSQLValueString($_POST['adm_kf'], "text"),
					   GetSQLValueString($_POST['adm_kfc'], "text"),
					   GetSQLValueString($_POST['shichang'], "text"),
					   GetSQLValueString($_POST['remai'], "text"),
					   GetSQLValueString($_POST['jsq'], "int"),
					   GetSQLValueString($_POST['usertype1'], "text"),
					   GetSQLValueString($_POST['usertype2'], "text"),
					   GetSQLValueString($_POST['usertype3'], "text"),
					   GetSQLValueString($_POST['usertype4'], "text"),
                       GetSQLValueString($_POST['usertype5'], "text"),
                       GetSQLValueString($_POST['usertype6'], "text"),
					   GetSQLValueString($_POST['pei1'], "text"),
					   GetSQLValueString($_POST['pei2'], "text"),
					   GetSQLValueString($_POST['pei3'], "text"),
					   GetSQLValueString($_POST['pei4'], "text"),
					   GetSQLValueString($_POST['kou1'], "int"),
					   GetSQLValueString($_POST['kou2'], "int"),
					   GetSQLValueString($_POST['kou3'], "int"),
					   GetSQLValueString($_POST['kou4'], "int"),
					   GetSQLValueString($_POST['kou5'], "int"),
					   GetSQLValueString($_POST['kou6'], "int"),
					   GetSQLValueString($_POST['fei1'], "int"),
					   GetSQLValueString($_POST['fei2'], "int"),
					   GetSQLValueString($_POST['fei3'], "int"),
					   GetSQLValueString($_POST['fei4'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
  */
  $table_shopsetup = SYS_DBNAME . ".shopsetup";
  $whereClause = "ID=1";
  $record = array
  (
	  'sitename' => $_POST['sitename'],
	  'siteurl' => $_POST['siteurl'],
	  'reg' => $_POST['reg'],
	  'adm_address' => $_POST['adm_address'],
	  'adm_post' => $_POST['adm_post'],
	  'adm_name' => $_POST['adm_name'],
	  'adm_mail' => $_POST['adm_mail'],
	  'adm_tel' => $_POST['adm_tel'],
	  'adm_qq' => $_POST['adm_qq'],
	  'adm_kf' => $_POST['adm_kf'],
	  'adm_kfc' => $_POST['adm_kfc'],
	  'shichang' => $_POST['shichang'],
	  'remai' => $_POST['remai'],
	  'jsq' => $_POST['jsq'],
	  'usertype1' => $_POST['usertype1'],
	  'usertype2' => $_POST['usertype2'],
	  'usertype3' => $_POST['usertype3'],
	  'usertype4' => $_POST['usertype4'],
	  'usertype5' => $_POST['usertype5'],
	  'usertype6' => $_POST['usertype6'],
	  'pei1' => $_POST['pei1'],
	  'pei2' => $_POST['pei2'],
	  'pei3' => $_POST['pei3'],
	  'pei4' => $_POST['pei4'],
	  'kou1' => $_POST['kou1'],
	  'kou2' => $_POST['kou2'],
	  'kou3' => $_POST['kou3'],
	  'kou4' => $_POST['kou4'],
	  'kou5' => $_POST['kou5'],
	  'kou6' => $_POST['kou6'],
	  'fei1' => $_POST['fei1'],
	  'fei2' => $_POST['fei2'],
	  'fei3' => $_POST['fei3'],
	  'fei4' => $_POST['fei4']
  );

  $is_update = dbUpdate( $table_shopsetup, $record, $whereClause );

  $updateGoTo = "admineditconfig.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  /*
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
  */
}
?>
<?php  //-----------------------------取得網站設置資訊------------------------------------//
	$column = "*";
	$table_shopsetup		= SYS_DBNAME . ".shopsetup";

  	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
			'mssql'	=> "SELECT {$column} FROM {$table_shopsetup} ",
			'oci8'	=> "SELECT {$column} FROM {$table_shopsetup} "
	);
	$row_showconfigRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
	/*
mysql_select_db($database_webshop, $webshop);
$query_showconfigRec = "SELECT * FROM shopsetup";
$showconfigRec = mysql_query($query_showconfigRec, $webshop) or die(mysql_error());
$row_showconfigRec = mysql_fetch_assoc($showconfigRec);
*/
?>
<h3 class=ttl01><font color=#800080>網站設置</h3>
<table width="650" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!---------------------編輯網站資訊--------------------------------->
<form name="editconfig" action="<?php echo $editFormAction; ?>" method="POST"
 enctype="multipart/form-data" id="editconfig">
  <tr>
    <td width="20%" align="right">網站名稱:</td>
    <td width="80%" colspan="3" align="left">
      <input id="sitename" name="sitename" value="<?php echo $row_showconfigRec['sitename']; ?>"  type="text" class="sizeML" />
    </td>
  </tr>
  <!----------------------------網站域名---------------------------->
  <tr>
    <td width="20%" align="right">網站域名:</td>
    <td width="80%" colspan="3" align="left">
      <input id="siteurl" name="siteurl"  type="text" class="sizeML" value="<?php echo $row_showconfigRec['siteurl']; ?>"/></td>
  </tr>
  <!------------------------是否允許未註冊購物------------------------>
  <tr>
    <td width="20%" align="right">是否允許未註冊購物:</td>
    <td width="80%" colspan="3" align="left">
      <input id="reg" name="reg" type="text" class="sizeSss" value="<?php echo $row_showconfigRec['reg']; ?>"/>
      [1:允許，0:不允許]
    </td>
  </tr>
  <!----------------------------聯絡地址---------------------------->
  <tr>
    <td width="20%" align="right">聯絡地址:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_address" name="adm_address"  type="text" class="sizeML" value="<?php echo $row_showconfigRec['adm_address']; ?>"/>
    </td>
  </tr>
  <!----------------------------郵遞區號---------------------------->
  <tr>
    <td width="20%" align="right">郵遞區號:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_post" name="adm_post"  type="text" class="sizeSss" value="<?php echo $row_showconfigRec['adm_post']; ?>"/>
    </td>
  </tr>
  <!----------------------------聯 系 人---------------------------->
  <tr>
    <td width="20%" align="right">聯 系 人:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_name" name="adm_name" type="text" class="sizeM" value="<?php echo $row_showconfigRec['adm_name']; ?>"/>
    </td>
  </tr>
  <!----------------------------電子郵箱  ---------------------------->
  <tr>
    <td width="20%" align="right">電子郵箱:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_mail" name="adm_mail" type="text" class="sizeML" value="<?php echo $row_showconfigRec['adm_mail']; ?>"/></td>
  </tr>
  <!----------------------------聯絡電話  ---------------------------->
  <tr>
    <td width="20%" align="right">聯絡電話:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_tel" name="adm_tel" type="text" class="sizeM" value="<?php echo $row_showconfigRec['adm_tel']; ?>"/>
     </td>
  </tr>
  <!------------------------------傳真------------------------------->
  <tr>
    <td width="20%" align="right">傳真:</td>
    <td width="80%" colspan="3" align="left">
      <input id="adm_qq" name="adm_qq"  type="text" class="sizeM" value="<?php echo $row_showconfigRec['adm_qq']; ?>"/>
    </td>
  </tr>
  <!----------------------------網站關鍵字---------------------------->
  <tr>
    <td width="20%" align="right">網站關鍵字:</td>
    <td width="80%" colspan="3" align="left">
      <textarea id="adm_kf" name="adm_kf" cols="20" rows="5"><?php echo $row_showconfigRec['adm_kf']; ?></textarea>
    </td>
  </tr>
  <!----------------------------網站內容描述--------------------------->
  <tr>
    <td width="20%" align="right">網站內容描述:</td>
    <td width="80%" colspan="3" align="left">
      <textarea id="adm_kfc" name="adm_kfc" cols="20" rows="5" ><?php echo $row_showconfigRec['adm_kfc']; ?></textarea>
    </td>
  </tr>
  <!--------------------------自定義市場價名稱-------------------------->
  <tr>
    <td width="20%" align="right">自定義市場價名稱:</td>
    <td width="80%" colspan="3" align="left">
      <input id="shichang" name="shichang"  type="text" class="sizeSs" value="<?php echo $row_showconfigRec['shichang']; ?>"/>[如『原價』等]
    </td>
  </tr>
  <!--------------------------自定義熱賣價名稱-------------------------->
  <tr>
    <td width="20%" align="right">自定義熱賣價名稱:</td>
    <td width="80%" colspan="3" align="left">
      <input id="remai" name="remai"   type="text" class="sizeSs" value="<?php echo $row_showconfigRec['remai']; ?>"/>[如『逍遙價』、『心動價』等]
    </td>
  </tr>
  <!--------------------------網站計數器初始值-------------------------->
  <tr>
    <td width="20%" align="right">網站計數器初始值:</td>
    <td width="80%" colspan="3" align="left">
      <input id="jsq" name="jsq"   type="text" class="sizeSs" value="<?php if($row_showconfigRec['jsq']!="") echo $row_showconfigRec['jsq'];
	        else echo "0";?>"/> [設大後，不能恢復以前的小值]
    </td>
  </tr>

  <!----------------------------------------------------------->
  <tr><td colspan="2">
        <p align="left"><h3 class=ttl01><font color=#800080>會員等級及折扣設置:</h3></td></tr>


	<tr><td align="right">會員等級一:</td><td width="80%"> <input type="text" class="sizeS" value="<?php echo $row_showconfigRec['usertype1']; ?>" name="usertype1" >
        [至少有一個會員等級]
      </td></tr>


	<tr><td align="right">折扣:</td><td width="80%"> <input type="text" class="sizeSss" value="<?php echo $row_showconfigRec['kou1']; ?>" name="kou1" >
        [取值0-10，數字越小優惠越大]
      </td></tr>


	<tr><td align="right">會員等級二:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['usertype2']; ?>" name="usertype2"  class="sizeS">
        [如沒有，可空出]
      </td></tr>


	<tr><td align="right">折扣:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['kou2']; ?>" name="kou2" class="sizeSss">
      </td></tr>


	<tr><td align="right">會員等級三:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['usertype3']; ?>" name="usertype3" class="sizeS">
        [如沒有，可空出]
      </td></tr>


	<tr><td align="right">折扣:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['kou3']; ?>" name="kou3" class="sizeSss">
      </td></tr>


	<tr><td align="right">會員等級四:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['usertype4']; ?>" name="usertype4" class="sizeS">
        [如沒有，可空出]
      </td></tr>


	<tr><td align="right">折扣:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['kou4']; ?>" name="kou4" class="sizeSss">
      </td></tr>

    <tr><td align="right">會員等級五:</td><td width="80%">
      <input type=text value="<?php echo $row_showconfigRec['usertype5']; ?>" name="usertype5" class="sizeS">
        [如沒有，可空出]
      </td></tr>


	<tr><td align="right">折扣</td><td width="80%">
      <input type=text value="<?php echo $row_showconfigRec['kou5']; ?>" name="kou5" class="sizeSss">
      </td></tr>

    <tr><td align="right">會員等級六:</td><td width="80%">
      <input type=text value="<?php echo $row_showconfigRec['usertype6']; ?>" name="usertype6" class="sizeS">
        [如沒有，可空出]
      </td></tr>


	<tr><td align="right">折扣:</td><td width="80%">
      <input type=text value="<?php echo $row_showconfigRec['kou6']; ?>" name="kou6" class="sizeSss">
      </td></tr>


	<tr><td colspan="2">
        <h3 class=ttl01><font color=#800080>配送方式及費用設置:</h3></td></tr>

	<tr><td align="right">配送方式一:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['pei1']; ?>" name="pei1" class="sizeS">
        [至少有一種配送方式] </td></tr>

	<tr><td align="right">費用:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['fei1']; ?>" name="fei1" class="sizeSss">
        元 </td></tr>

	<tr><td align="right">配送方式二</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['pei2']; ?>" name="pei2" class="sizeS">
        [如沒有，可空出] </td></tr>

	<tr><td align="right">費用:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['fei2']; ?>" name="fei2" class="sizeSss">
        元 </td></tr>

	<tr><td align="right">配送方式三:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['pei3']; ?>" name="pei3" class="sizeS">
        [如沒有，可空出] </td></tr>

	<tr><td align="right">費用:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['fei3']; ?>" name="fei3" class="sizeSss">
        元 </td></tr>


    <tr>
      <td align="right">配送方式四</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['pei4']; ?>" name="pei4" class="sizeS">
        [如沒有，可空出] </td>
    </tr>
    <tr>
      <td align="right">費用:</td><td width="80%"> <input type=text value="<?php echo $row_showconfigRec['fei4']; ?>" name="fei4" class="sizeSss">
        元 </td>
    </tr>
      <!-----------------------------更新按鈕----------------------------->
  <tr>
    <td colspan="2" align="center">
      <input type="submit" name="update_config"  value="更新" style="font-size:16px;width:120px; height:30px; margin: 3px"/>
    </td>
  </tr>
</form>
</table>
<?php
//mysql_free_result($showconfigRec);
?>
