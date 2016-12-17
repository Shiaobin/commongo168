<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php require('../utility/init.php'); ?>
<?php require('../include/system.php'); ?>
<?php require('../include/site/showwebinfo.php'); ?>
<?php 
session_start();
//$sysConnDebug = true;
if(!isset($_SESSION['MM_Username'])){
  if(!isset($_SESSION['tempord_id']) || $_SESSION['tempord_id'] == ""){
	
	
	$column = "MAX(user_id)";
	$table_shop_user		= SYS_DBNAME . ".shop_user";
	dbInsert( $table_shop_user, array('created_date' => now()) );
	
  	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_shop_user} ", 
			'mssql'	=> "SELECT {$column} FROM {$table_shop_user} ",
			'oci8'	=> "SELECT {$column} FROM {$table_shop_user} "
	);
	$Id = dbGetOne($sql['list']['select'][SYS_DBTYPE]);
	
    $_SESSION['tempord_id']=date('Ymdhis').$Id;
  }
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Imagetoolbar" content="no" />
<meta nsme="keywords" content="<?php echo $row_showconfigRec["adm_kf"];?>">
<meta nsme="description" content="<?php echo $row_showconfigRec["adm_kfc"];?>">
<title><?php echo $title;?></title>
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
<!---------------------網頁程式碼開始--------------------------------->
<div id="visual">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td align=center height=150 >
</td>
                                </tr>
                              </table>

<?php
// *** Validate request to login to this site
$loginFormAction = $_SERVER['PHP_SELF'];
//session_start();
if(!isset($_SESSION['Username'])){
  if(!isset($_SESSION['tempord_id']) || $_SESSION['tempord_id'] == ""){
	  $table_shop_user		= SYS_DBNAME . ".shop_user";
	  dbInsert( $table_shop_user, array( 'created_date' => now() ));
    //$insertSQL = "INSERT INTO shop_user VALUES ('')";
   // mysql_query($insertSQL, $webshop) or die(mysql_error());
  
    $column = "MAX(user_id)";
	$table_shop_user		= SYS_DBNAME . ".shop_user";
	dbInsert( $table_shop_user, array('created_date' => now()) );
	
  	$sql['list']['select'] = array(
			'mysql'	=> "SELECT {$column} FROM {$table_shop_user} ", 
			'mssql'	=> "SELECT {$column} FROM {$table_shop_user} ",
			'oci8'	=> "SELECT {$column} FROM {$table_shop_user} "
	);
	$Id = dbGetOne($sql['list']['select'][SYS_DBTYPE]);
	
    $_SESSION['tempord_id']=date('Ymdhis').$Id;
  }
}
if((!empty($_POST['checknum'])) && ($_SESSION["ans_ckword"] == $_POST['checknum'])){
	if (isset($_GET['accesscheck'])) {
	  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
	}
	
	if (isset($_POST['name'])) {
	  
	  $loginUsername=mysql_real_escape_string($_POST['name']);
	  $password=mysql_real_escape_string($_POST['password']);
	  $MM_fldUserAuthorization = "";
	  
	  
	  $MM_redirectLoginSuccess = "admineditconfig.php";
	  $MM_redirectLoginFailed = "adminlogin.php";
	  $MM_redirecttoReferrer = false;
	  
	  $column = "name,password";
	  $table_admin		= SYS_DBNAME . ".admin";
	  $whereClause = "name='{$loginUsername}' AND password='{$password}'";
	  
	  $sql['list']['select'] = array(
			  'mysql'	=> "SELECT {$column} FROM {$table_admin} WHERE {$whereClause}", 
			  'mssql'	=> "SELECT {$column} FROM {$table_admin} WHERE {$whereClause}",
			  'oci8'	=> "SELECT {$column} FROM {$table_admin} WHERE {$whereClause}"
	  );
	  $loginFoundUser = dbGetAll($sql['list']['select'][SYS_DBTYPE]);
	/*
	  mysql_select_db($database_webshop, $webshop);
	  
	  $LoginRS__query=sprintf("SELECT name, password FROM admin WHERE name=%s AND password=%s",
		GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
	   
	  $LoginRS = mysql_query($LoginRS__query, $webshop) or die(mysql_error());
	  $loginFoundUser = mysql_num_rows($LoginRS);
	  */
	  if (sizeof( $loginFoundUser ) > 0) {
		$loginStrGroup = "";
		
		if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
		//declare two session variables and assign them
		$_SESSION['MM_AdminName'] = $loginUsername;
		$_SESSION['MM_AdminGroup'] = $loginStrGroup;	      
	
		if (isset($_SESSION['PrevUrl']) && false) {
		  $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
		}
		header("Location: " . $MM_redirectLoginSuccess );
	  }
	  else {
		header("Location: ". $MM_redirectLoginFailed );
	  }
	}
}else{
	//header("Location: ". $MM_redirectLoginFailed );
}
?>

  <!---------------------content--------------------------------->
<table width="230" border=1 bordercolor="#CBE8E9" align="center">
		<tr>
          <td height="45" bgcolor="#CBE8E9" align="center"><font size=4>&nbsp;&nbsp;後台管理登入</font></td>
        </tr>
        <?php $member->getMemberInfo(isset($_SESSION['Username'])? $_SESSION['Username'] : null); ?>
		<tr>
        <td align="center">
<table width="100%" class="formTable1" >
          <form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
            <!-------------------------------------------------------------->
            <tr>
              <td align="center"  height=40 ><font size=3 >帳號：<input type="text" name="name" id="name" class="sizeSs"/></font>
              </td>
            </tr>
            <!-------------------------------------------------------------->
            <tr>
              <td align="center"  height=40 ><font size=3 >密碼：<input type="password" name="password" id="password" class="sizeSs" /></font>
              </td> 
            </tr>
           <!-------------------------------------------------------------->
            <tr>
              <td align="center" height=30 ><font size=3 >驗證：
               <input name="checknum" type="text" id="checknum" class="sizeSss" ><img src="./showpic.php" border="0"></h3>
              </td> 
            </tr>
            <!-------------------------------------------------------------->
            <tr>
              <td colspan="2" align="center" height=40 ><font size=3 >
                <input name="login" type="submit" class="btn_login" id="login" value="登入管理系統"  style="width:60%; height:30px; margin-right:3px"/>
              </td>
            </tr>
          </form>
        </table>
        </td>
        </tr>  
</table>
</div>
</body>
</html>
<!---------------------網頁程式碼結束--------------------------------->
