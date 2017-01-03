<?php session_start();
require_once("include/phpfunction.php");
require_once("connections/webshop.php");
$result_head = selectAll_no_where($webshop,"*","shopsetup","ID ASC");
$rs_head = mysql_fetch_array($result_head);
$thiskou= $rs_head['kou1'];
$remai=$rs_head['remai']; //熱賣價
$shichang=$rs_head['shichang']; //市場價
?>
<title><?php echo $rs_head['sitename'];?>-<?php echo $rs_head['siteurl'];?></title>
<link href="./cssjs/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="./cssjs/style.css?t=1" rel="stylesheet" media="screen">
<link href="./cssjs/jquery-ui-1.10.4.custom.css" rel="stylesheet" media="screen">
<link href="./cssjs/jquery.navgoco.css" rel="stylesheet" media="screen">
<link href="./cssjs/topmenu.css" rel="stylesheet" media="screen">
<link href="./cssjs/rating.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
<script src="./cssjs/jquery.js"></script>
<script src="./cssjs/bootstrap.min.js"></script>
<script src="./cssjs/jquery.navgoco.js"></script>
<script src="./cssjs/topmenu.js"></script>
<script type="text/javascript" src="./cssjs/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="./cssjs/Ajax.js"></script>
<script type="text/javascript" src="./cssjs/GetParameter.js"></script>
<script type="text/javascript" src="./cssjs/IndexEvent.js"></script>
<script type="text/javascript" src="./cssjs/ErrorMsg.js"></script>
<script type="text/javascript" src="./cssjs/PostUrl.js"></script>
<script type="text/javascript" src="./cssjs/Config.js"></script>
<script type="text/javascript" src="./cssjs/jquery.blockUI.js"></script>
<script type="text/javascript" src="cssjs/gotoTop.js"></script>
<script type="text/javascript">
//這段會產生問題。雖然還不知道是做什麼用的，先註解掉看看（暈）
// $(function(){
// 	var url   = PostUrl.getInstance().sendinfo();
// 	var data  = {};
// 	doAjaxFunc(url, data, userStatusBack);
// });

var userStatusBack = function(json){
	if(json.ERROR !== 0){
		$("#navbar-collapse-1").children("ul").children("li").eq(2).show();
		$("#navbar-collapse-1").children("ul").children("li").eq(3).hide();
	} else{
		$("#navbar-collapse-1").children("ul").children("li").eq(2).hide();
		$("#navbar-collapse-1").children("ul").children("li").eq(3).show();
	}
};
</script>
<link href="./cssjs/video-js.css" rel="stylesheet">
<script src="./cssjs/video.js"></script>
<script type="text/javascript" src="./cssjs/UserLocation.js"></script>
<script src="./cssjs/rating.js"></script>
