<?php  //-----------------------------更新留言資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_msg"])) && ($_POST["update_msg"] == "更新")) {	
  $table_index_msg		= SYS_DBNAME . ".index_msg";
  $record = array(
  				'msg_back' => $_POST['msg_back'],
				'msg_back_date' => $_POST['msg_back_date'],
				'set_open' => $_POST['set_open']
				);
  $whereClause = "msg_no={$_POST['msg_no']}";
		
  dbUpdate( $table_index_msg, $record, $whereClause );
  /*
  $updateSQL = sprintf("UPDATE index_msg SET msg_back=%s, msg_back_date=%s, set_open=%s where msg_no=%s", 
					   GetSQLValueString($_POST['msg_back'], "text"),
					   GetSQLValueString($_POST['msg_back_date'], "text"),
					   GetSQLValueString($_POST['set_open'], "tinyint"),
					   GetSQLValueString($_POST['msg_no'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminmsg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script type='text/javascript'>";
  echo "window.location.href='$updateGoTo'";
  echo "</script>";
}
?>
<?php  //-----------------------------取得留言資訊------------------------------------//
$cloume_showmsgRec = "%";
if (isset($_GET['msg_no'])) {
  $cloume_showmsgRec = $_GET['msg_no'];
}

$table_index_msg		= SYS_DBNAME . ".index_msg";
$whereClause = "msg_no='{$cloume_showmsgRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause}"
		);
$row_showmsgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = sprintf("SELECT * FROM index_msg WHERE index_msg.msg_no=%s",
                               GetSQLValueString($cloume_showmsgRec, "text"));
$showmsgRec = mysql_query($query_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
$totalRows_showmsgRec = mysql_num_rows($showmsgRec);
*/
?>
<h3 class=ttl01 >編輯留言訊息</h3>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST" 
 enctype="multipart/form-data" id="editmsg">

      <input type="hidden" name="msg_no" id="msg_no" value="<?php echo $row_showmsgRec['msg_no']; ?>"/>

  <!---------------------------諮詢者IP---------------------------->
  <tr>
    <td>1.諮詢者IP:<?php echo $row_showmsgRec['msg_ip']; ?></td>
  </tr>
  <!----------------------------諮詢日期---------------------------->
  <tr>
    <td>2.諮詢日期:<?php echo $row_showmsgRec['msg_send_date']; ?></td>
  </tr>  
  <!-----------------------------諮詢人----------------------------->
  <tr>
    <td>3.諮詢人:<?php echo $row_showmsgRec['msg_name']; ?></td>
  </tr>
  <!----------------------------郵件---------------------------->
  <tr>
    <td>4.Email:<?php echo $row_showmsgRec['msg_mail'];?></td>
  </tr>
  <!----------------------------連絡電話---------------------------->
  <tr>
    <td>5.連絡電話:<?php echo $row_showmsgRec['msg_phone'];?></td>
  </tr>
  <!----------------------------標題---------------------------->
  <tr>
    <td>6.諮詢標題:<?php echo $row_showmsgRec['msg_title'];?></td>
  </tr>
  <!----------------------------諮詢內容---------------------------->
  <tr>
    <td>7.諮詢內容:<br>
   	  <textarea id="msg_sent" name="msg_sent" cols="50" rows="10" ><?php echo str_replace("\r\n","<br />",$row_showmsgRec['msg_send']);?></textarea>
    </td>
  </tr>
    <!------------------------------------------------------------->
  <tr>
    <td align="center" colspan="2" bgcolor="#DFDFDF">回復區塊</td>
  </tr>
  <!----------------------------回復---------------------------->
  <tr>
    <td>8.回復:
    <font color="#0000FF"><?php 
			if($row_showmsgRec['msg_back']=="")
	          echo "新諮詢，未回復";
	        else echo "已完成回復";
	  ?></font>
    </td>
  </tr>
  <!----------------------------更新回復---------------------------->
  <tr>
    <td>9.更新回復:<br>
      <textarea id="msg_back" name="msg_back" cols="50" rows="10" ><?php echo $row_showmsgRec['msg_back'];?></textarea>
      <input name="msg_back_date" type="hidden" value="<?php $date=date("Y-m-d H:i:s"); echo date('Y-m-d H:i:s',strtotime($date))?>" />
   </td>
  </tr> 
  <!----------------------------是否隱藏---------------------------->
  <tr>
    <td>10.是否隱藏:
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" 
        <?php if ($row_showmsgRec['set_open'] == '0'): ?>checked='checked'<?php endif; ?>/>隱藏</label>
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" 
		<?php if ($row_showmsgRec['set_open'] == '1'): ?>checked='checked'<?php endif; ?>/>公開</label>
    </td>
  </tr>
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      <input name="msg_no" type="hidden" value="<?php echo $row_showmsgRec['msg_no']; ?>" />
      <input type="submit" name="update_msg"  value="更新" style="width:10%; height:100%; margin: 3px"/>
      <input type="reset" name="reset"  value="重設" style="width:10%; height:100%; margin: 3px"/>
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showmsgRec);
?>
