<?php  //-----------------------------取得線上留言資訊----------------------------------//
//$sysConnDebug = true;
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_msgRec = 4;
$pageNum_msgRec = 0;
if (isset($_GET['pageNum_msgRec'])) {
  $pageNum_msgRec = $_GET['pageNum_msgRec'];
}
$startRow_msgRec = $pageNum_msgRec * $maxRows_msgRec;

$table_index_msg		= SYS_DBNAME . ".index_msg";
$column = "*";
$whereClause = "1=1";

$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} ", 
		'mssql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} ",
		'oci8'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC LIMIT {$startRow_msgRec}, {$maxRows_msgRec} "
);
$row_msgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_msgRec = "SELECT * FROM index_msg ORDER BY msg_send_date DESC";
$query_limit_msgRec = sprintf("%s LIMIT %d, %d", $query_msgRec, $startRow_msgRec, $maxRows_msgRec);
$msgRec = mysql_query($query_limit_msgRec, $webshop) or die(mysql_error());
$row_msgRec = mysql_fetch_assoc($msgRec);
*/
$total_msgRec = sizeof($row_msgRec); 

if(isset($_GET['totalRows_msgRec'])){
    $totalRows_msgRec = $_GET['totalRows_msgRec'];
}else{
    $sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC ", 
		'mssql'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC ",
		'oci8'	=> "SELECT * FROM {$table_index_msg} WHERE {$whereClause} ORDER BY msg_send_date DESC "
);
$all_msgRec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
    $totalRows_msgRec = sizeof($all_msgRec);
}

$totalPages_msgRec = ceil($totalRows_msgRec/$maxRows_msgRec)-1;

$queryString_msgRec = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_msgRec") == false && 
        stristr($param, "totalRows_msgRec") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_msgRec = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_msgRec = sprintf("&totalRows_msgRec=%d%s", $totalRows_msgRec, $queryString_msgRec);
?>
<?php  //-----------------------------取得使用者IP---------------------------------//
if (!empty($_SERVER['HTTP_CLIENT_IP']))
{
  $ip=$_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
  $ip=$_SERVER['REMOTE_ADDR'];
}
?>
<?php  //-----------------------------取得驗證碼----------------------------------//
$password_len = 5;
$password = '';

$word = '0123456789';
$len = strlen($word);

for ($i = 0; $i < $password_len; $i++) {
  $password = $password.$word[rand() % $len];
}
?>
<?php  //------------------------------新增留言----------------------------------//
if (isset($_POST["add_btn"])) {
  if($_POST["msg_input"] == $_POST["msg_chk"]) {
	$table_index_msg = SYS_DBNAME . ".index_msg";
	$record = array
	(	
		'msg_ip' => $ip,
		'msg_name' => $_POST['msg_name'],
		'msg_mail' => $_POST['msg_mail'],
		'msg_send' => $_POST['msg_send'],
		'set_open' => $_POST['set_open'],
		'msg_phone' => $_POST['msg_phone'],
		'msg_title' => $_POST['msg_title']
	);
	
	dbInsert( $table_index_msg, $record );
	/*
    $insertSQL = sprintf("INSERT INTO index_msg (msg_ip, msg_name, msg_mail, msg_send, set_open, msg_phone, msg_title) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                          GetSQLValueString($ip, "text"),
                          GetSQLValueString($_POST['msg_name'], "text"),
                          GetSQLValueString($_POST['msg_mail'], "text"),
                          GetSQLValueString($_POST['msg_send'], "text"),
                          GetSQLValueString($_POST['set_open'], "tinyint"),
						  GetSQLValueString($_POST['msg_phone'], "text"),
                          GetSQLValueString($_POST['msg_title'], "text"));

    mysql_select_db($database_webshop, $webshop);
    $Result = mysql_query($isertSQL, $webshop) or die(mysql_error());
  */
   
     $insertGoTo = "feedback.php";	
    //Send information
    //$headers = "Content-Type:text/html; charset = UTF-8";
    //$body = "親愛的顧客 ".$_POST['ord_name']."您好!!<br>";
    //$body = $body."您的訂單編號: ".$_POST['ord_id']."<br>";
    //$body = $body."訂單總金額: ".$_POST['ord_total']."<br>";
    //$body = $body."訂單商品我們會儘快完成出貨!非常感謝您的惠顧!!";
    //mail($_POST['ord_email'],"感謝您的訂購!!",$body,$headers);
  
    //Show message window
    echo "<script language=\"javascript\">";
    echo "window.alert(\"感謝您的留言\");";
    echo "window.location.href='$insertGoTo'";
    echo "</script>";
  }
}
?>
<!--------------------------------------------------------------------------------->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) {
	  test=args[i+2]; 
	  val=document.getElementById(args[i]);
      if (val) { 
	     nm=val.name; 
		 if ((val=val.value)!="") {
           if (test.indexOf('isEmail')!=-1) { 
		     p=val.indexOf('@');
             if (p<1 || p==(val.length-1)) 
			   errors+='- '+nm+' must contain an e-mail address.\n';
           }
		   else if (test!='R') { 
		     num = parseFloat(val);
             if (isNaN(val)) 
		       errors+='- '+nm+' must contain a number.\n';
             if (test.indexOf('inRange') != -1) { 
		       p=test.indexOf(':');
               min=test.substring(8,p); 
			   max=test.substring(p+1);
               if (num<min || max<num) 
			     errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
             } 
	       } 
	     } 
	     else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; 
	  }  
    } 
	if(document.sendMsg.msg_input.value != document.sendMsg.msg_chk.value)
    errors += '- 驗證碼輸入錯誤，請重新輸入.\n';
	
    if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
  } 
}
</script>
<table width="96%" border="0" cellspacing="0">
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="5" align="center" height="30" ><p><b>線上留言</b></p></td>
  </tr>
  <tr bgcolor="#666666">
    <td align="center" height="30" ><font color="#FFFFFF">留言時間</font></td>
    <td align="center" height="30" ><font color="#FFFFFF">留言標題</font></td>
    <td align="center" height="30" ><font color="#FFFFFF">留言人</font></td>
    <td align="center" height="30" ><font color="#FFFFFF">狀態</font></td>
    <td align="center" height="30" ><font color="#FFFFFF">回覆時間</font></td>
  </tr>
  <!-------------------------------------------------------------->
  <?php if ($total_msgRec > 0) { // Show if recordset not empty ?> 
    <?php 
	    foreach ($row_msgRec as $key => $array){ ?>
          <tr bgcolor="#CCCCCC">
            <td width="22%" align="center" height="30" >
              <?php echo date('Y-m-d',strtotime($array['msg_send_date']));?>
            </td>
            <!-------------------------------------------------------------->
            <td width="28%" align="left" height="30" >
			  <?php echo $array["msg_title"];?>
            </td>
            <!-------------------------------------------------------------->
            <td width="15%" align="center" height="30" >
              <?php echo $array["msg_name"];?>
            </td>
            <!-------------------------------------------------------------->
            <td width="13%" align="center" height="30" >
              <?php if($array["set_open"] == 1) echo "開放";
			        else echo "隱藏";?>
            </td>
            <!-------------------------------------------------------------->
            <td width="22%" align="center" height="30" >
              <font color="#CC0033"><?php if($array["msg_back_date"] != "") echo date('Y-m-d',strtotime($array['msg_back_date']));?></font>
            </td>
          </tr>
          <!-------------------------------------------------------------->
          <?php if($array["set_open"] == 1){ ?>
          <tr>
            <td colspan="5" align="left" height="30" ><font color="#FF3333"><b>  #</font>留言內容：</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			  <?php echo str_replace("\r\n","<br />",$array["msg_send"]);}?>
            </td>
          </tr>
          <!-------------------------------------------------------------->
          <tr>
            <td colspan="5" align="left" height="10" >
            </td>
          </tr>
        <tr>
            <td colspan="5" align="left" height="30" >
              <font color="#CC0033"><font color="#FF3333">  #</font><b>客服回覆：</b></font><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($array["set_open"] == 1) echo str_replace("\r\n","<br />",$array["msg_back"]); else echo "悄悄話";?>
            </td>
          </tr>
    <?php 
	}  ?>		
  <?php } // Show if recordset not empty ?>
  <!-------------------------------------------------------------->
  <tr>
    <td height="8%" colspan="5" align="right" >&nbsp;
      <table border="0">
        <tr>
          <td height="30" >
          <?php if ($pageNum_msgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, 0, $queryString_msgRec); ?>">
              <img src="../../images/symbol/First.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td height="30" >
          <?php if ($pageNum_msgRec > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, max(0, $pageNum_msgRec - 1), $queryString_msgRec); ?>">
              <img src="../../images/symbol/Previous.gif" class="img"/>
            </a>
          <?php } // Show if not first page ?>
          </td>
          <td height="30" >
          <?php if ($pageNum_msgRec < $totalPages_msgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, min($totalPages_msgRec, $pageNum_msgRec + 1), $queryString_msgRec); ?>">
              <img src="../../images/symbol/Next.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
          <td height="30" >
          <?php if ($pageNum_msgRec < $totalPages_msgRec) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_msgRec=%d%s", $currentPage, $totalPages_msgRec, $queryString_msgRec); ?>">
              <img src="../../images/symbol/Last.gif" class="img"/>
            </a>
          <?php } // Show if not last page ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-------------------------填寫留言------------------------------->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <form action="" method="post" name="sendMsg" id="sendMsg" onsubmit="MM_validateForm('msg_name','','R','msg_mail','','RisEmail','msg_chk','','R','msg_send','','R');return document.MM_returnValue"> 
  <!-------------------------------------------------------------->
  <tr>
<th><p>標題<b>※</b></p></th>
<td colspan=3 ><input name="msg_title" id="msg_title"  type="text"  class="sizeML" /></td>
</tr>
<tr>
<th><p>姓名<b>※</b></p></th>
<td><input name="msg_name" id="msg_name"  type="text"  class="sizeS" /></td>
<th><p>電話<b>※</b></p></th>
<td><input name="msg_phone" id="msg_phone"  type="text"  class="sizeS" /></td>
</tr>
  <tr>
<th><p>信箱<b>※</b></p></th>
<td colspan=3 ><input name="msg_mail" id="msg_mail"  type="text"  class="sizeM" /></td>
</tr>
<tr>
<th><p>狀態<b>※</b></p></th>
<td>  <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" checked/>開放</label>
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" />隱藏</label></td>
<th><p>驗證碼<b>※</b></p></th>
<td><input name="msg_input" type="text" id="msg_input" class="sizeS" />
      <font color="#3366FF"><?php echo $password;?></font>
      <input name="msg_chk" type="hidden" value="<?php echo $password;?>" /></td>
</tr>

  <tr>
    <th><p>內容</p></th>
    <td colspan="3">
      <textarea id="msg_send" name="msg_send" cols="30" rows="10"></textarea>
    </td>
  </tr>
  <!-------------------------------------------------------------->
  <tr>
    <td colspan="4">
  <input name="add_btn" type="submit" value="送出" class="submit03" />
    </td>
  </tr>
  <!-------------------------------------------------------------->
  </form> 
</table>
<?php
//mysql_free_result($msgRec);
?>
