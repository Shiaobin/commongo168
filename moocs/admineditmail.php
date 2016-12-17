<?php require('../utility/init.php'); 
include("../connections/webshop.php");
?>

<?php // ** initialize the session ** 
if (!isset($_SESSION)) {
  session_start();
}


// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_AdminName'] = NULL;
  $_SESSION['MM_AdminGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_AdminName']);
  unset($_SESSION['MM_AdminGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>


<?php // ** Login未成功重新到login.php畫面 **
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_AdminName set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "adminlogin.php";
if (!((isset($_SESSION['MM_AdminName'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_AdminName'], $_SESSION['MM_AdminGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Imagetoolbar" content="no" />
<title>後台管理</title>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="../img/favicon.ico" />
<link rel="icon" type="image/vnd.microsoft.icon" href="../img/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/reset.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/fonts.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/global.css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.imgpreload.js"></script>
<script type="text/javascript" src="js/global.js"></script>
</head>
<body >
<div id="wrap">
<div id="contents" class="cf">
<div id="side">
<div class="bg">
<?php include("../include/admin/admin_menubar_vertical.php"); ?>
</div>
</div>

<div id="main">
<div class="bgt">
<div class="bgb">
<h2><a href="../index.php">回前台</a></h2>
<!---------------------網頁程式碼開始--------------------------------->
<?php  //-----------------------------寄信及加入資訊------------------------------------//
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["update_msg"])) && ($_POST["update_msg"] == "寄信")) {	
  
  $table_contact_msg		= SYS_DBNAME . ".contact_msg";
  $record = array(  				
				'Reply' => "1"
				);
  $whereClause = "ID={$_POST['messageid']}";
		
  dbUpdate( $table_contact_msg, $record, $whereClause );
  
  $table_contact_re	= SYS_DBNAME . ".contact_re";
  $record = array(
				'MessageId' => $_POST['messageid'],
				'Subject' => $_POST['subject'],
				'ReplyMessage' => $_POST['body'],			
				'ImgFull' => 'none.png'
				);
  dbInsert( $table_contact_re, $record );
  
  
 
  include_once("adminsendmail.php");

  /*
  $updateSQL = sprintf("UPDATE contact_msg SET msg_back=%s, msg_back_date=%s, set_open=%s where ID=%s", 
					   GetSQLValueString($_POST['msg_back'], "text"),
					   GetSQLValueString($_POST['msg_back_date'], "text"),
					   GetSQLValueString($_POST['set_open'], "tinyint"),
					   GetSQLValueString($_POST['ID'], "int"));

  mysql_select_db($database_webshop, $webshop);
  $Result1 = mysql_query($updateSQL, $webshop) or die(mysql_error());
*/
  $updateGoTo = "adminmailbox.php";
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
if (isset($_GET['ID'])) {
  $cloume_showmsgRec = $_GET['ID'];
}

$table_contact_msg		= SYS_DBNAME . ".contact_msg";
$whereClause = "ID='{$cloume_showmsgRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_contact_msg} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_contact_msg} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_contact_msg} WHERE {$whereClause}"
		);
$row_showmsgRec = dbGetRow($sql['list']['select'][SYS_DBTYPE]);



$table_contact_re  	= SYS_DBNAME . ".contact_re";
$whereClause = "MessageId='{$cloume_showmsgRec}'";
$sql['list']['select'] = array(
		'mysql'	=> "SELECT * FROM {$table_contact_re} WHERE {$whereClause}", 
		'mssql'	=> "SELECT * FROM {$table_contact_re} WHERE {$whereClause}",
		'oci8'	=> "SELECT * FROM {$table_contact_re} WHERE {$whereClause}"
		);
$row_showcontact_Rec = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
/*
mysql_select_db($database_webshop, $webshop);
$query_showmsgRec = sprintf("SELECT * FROM contact_msg WHERE contact_msg.ID=%s",
                               GetSQLValueString($cloume_showmsgRec, "text"));
$showmsgRec = mysql_query($query_showmsgRec, $webshop) or die(mysql_error());
$row_showmsgRec = mysql_fetch_assoc($showmsgRec);
$totalRows_showmsgRec = mysql_num_rows($showmsgRec);
*/
?>
<script type='text/javascript'>
function show(obj, id)
{
  var table=document.getElementById(id);
  if( table.style.display == 'none' )
  {
    table.style.display='';
	obj.style.border='';
    obj.innerHTML='';
  }
  else
  {
    table.style.display='none';
	obj.style.border='';
    
  }
}
</script>

<h3 class=ttl01 >信件內容</h3>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
<form name="editmsg" action="<?php echo $editFormAction; ?>" method="POST" 
 enctype="multipart/form-data" id="editmsg">

      <input type="hidden" name="messageid" id="messageid" value="<?php echo $row_showmsgRec['ID']; ?>"/>

  <!---------------------------寄件者---------------------------->
  <tr>
    <td>寄件者:<?php echo $row_showmsgRec['Name']; ?></td>
  </tr>
  <!----------------------------日期---------------------------->
  <tr>
    <td>日期:<?php echo $row_showmsgRec['MessageDate']; ?></td>
  </tr>  
  <!----------------------------郵件---------------------------->
  <tr>
    <td>Email:<?php echo $row_showmsgRec['Email'];?></td>
  </tr>
  <!----------------------------連絡電話---------------------------->
  <tr>
    <td>連絡電話:<?php echo $row_showmsgRec['Telphone'];?></td>
  </tr>
  <!----------------------------地址---------------------------->
  <tr>
    <td>地址:<?php echo $row_showmsgRec['Address'];?></td>
  </tr>
  <!----------------------------內容---------------------------->
  <tr>
    <td>內容:<br/>
   	 <?php echo str_replace("\r\n","<br />",$row_showmsgRec['Message']);?>
    </td>
  </tr>
    <!------------------------------------------------------------->
  <tr>
    <td>
    <font color="#0000FF"><?php 
			if($row_showmsgRec['Reply']=="0")
	          echo "未回覆</font>";
	        else echo "已完成回覆</font>"; ?>
	 
    </td>
  </tr>
    <!------------------------------------------------------------->
    <tr>
  <?php foreach ($row_showcontact_Rec as $key => $array){ ?>
  <tr>
    <td height="90%" colspan="2" align="center">
      <table width="100%" border="1" BORDERCOLOR="#000000" cellpadding="0" cellspacing="0" class="admin_submsg_table">
        <!----------------------------留言日期---------------------------->
        <tr bgcolor="#CCCCCC">
          <td width="10%" height="20%" align="left" colspan="2">日期:<?php echo $array['ReplyDate'];?></td>
        </tr>  
        <!-----------------------------留言人----------------------------->
        <tr>
          <td colspan="2" height="20%" align="left">主旨:<?php echo $array['Subject'];?></td>
         
        </tr>
        <!----------------------------留言圖片---------------------------->
        <tr>
          <td  colspan="2" height="50%" align="left">回覆內容:</br>
          <?php echo $array['ReplyMessage'];?>
          </td>          
        </tr>
        
        </table>
    </td>
  </tr>
        <?php
	  }
	  ?>
 
  </tr>
</table>
<span id="txt" style='border: 1px solid black;background-clip: padding-box;font-size:20px; background-color: #DFDFDF;' onclick='show(this, "box")'>
我要回信
</span>
<table id="box" style="display:none;" width="600" border="0" cellspacing="0" cellpadding="0" class="formTable">
  <tr>
    <td align="center" colspan="2" bgcolor="#DFDFDF">回信區塊</td>
  </tr>
  <!----------------------------收件者---------------------------->
 
  <tr >
    <td>1.收件者:
    <?php echo $row_showmsgRec['Name']." <"; ?>
    <?php echo $row_showmsgRec['Email']." >"; ?>
    <input type="hidden" name="name" value="<?php echo $row_showmsgRec['Name']; ?>"/>
    <input type="hidden" name="email" value="<?php echo $row_showmsgRec['Email']; ?>"/>
    </td>
  </tr>
  <!----------------------------主旨---------------------------->
  <tr >
    <td>2.主旨:<br>      
      <input name="subject" type="text" class="sizeML"/>
   </td>
  </tr> 
   <!----------------------------信件內容---------------------------->
  <tr>
    <td>3.信件內容:<br>
      <textarea id="body" name="body" cols="30" rows="15" ></textarea>
   </td>
  </tr>

  <!----------------------------是否隱藏---------------------------->
  <!--tr>
    <td>10.是否隱藏:
      <label>
        <input type="radio" name="set_open" value="0" id="set_open_0" 
        <?php if ($row_showmsgRec['set_open'] == '0'): ?>checked='checked'<?php endif; ?>/>隱藏</label>
      <label>
        <input type="radio" name="set_open" value="1" id="set_open_1" 
		<?php if ($row_showmsgRec['set_open'] == '1'): ?>checked='checked'<?php endif; ?>/>公開</label>
    </td>
  </tr-->
  <!------------------------新增按鈕---------------------------->
  <tr>
    <td>
      
      <input type="submit" name="update_msg"  value="寄信" style="width:10%; height:100%; margin: 3px"/>
      <input type="reset" name="reset"  value="重設" style="width:10%; height:100%; margin: 3px"/>
    </td>
  </tr>
  <!----------------------------------------------------------->
</form>
</table>
<?php
//mysql_free_result($showmsgRec);
?>

</div>
</div>
</div>
</div>
</body>
<!---------------------網頁程式碼結束--------------------------------->
