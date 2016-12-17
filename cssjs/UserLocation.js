var crumbTxt = (function() {
	var instance;
	function init() {
		return {
			Indexx         : function(){return "首頁";}
		    ,AboutUsURL   : function(){return "aboutUs.php";}
		    ,AboutUsTitle : function(){return "關於我們";}
		    ,AboutUs      : function(){return "企業認證";}
		    ,AboutUsAwards: function(){return "獎項認證";}
		    ,AboutUsBefore: function(){return "訂購前注意事項";}
		    ,Login        : function(){return "登入";}
		    ,UserURL      : function(){return "user.php";}
		    ,UserTitle    : function(){return "會員專區";}
		    ,User         : function(){return "會員資料";}
		    ,Order        : function(){return "訂單查詢";}
		    ,Register     : function(){return "註冊";}
		    ,OccasionURL  : function(){return "productOccasion.php";}
		    ,Occasion     : function(){return "產品分類";}
		    ,Cart         : function(){return "購物車";}
		    ,GuaranteeCard: function(){return "產品保證卡";}
		    ,News         : function(){return "最新消息";}
		    ,CustomTitle  : function(){return "顧客服務";}
		    ,QandA        : function(){return "Q&A";}
		    ,SVDealer     : function(){return "服務據點";}
		};

	};
	return {
		getInstance : function() {
			if (!instance) {
				instance = init();
			}
			return instance;
		}
	};
})();

var $breadCrumb = (function(){
	return {
		oneRow : function(php, txt){
			$Crumb(php, txt).appendTo("#p_breadcrumb");
		},
		twoRow : function(php1, txt1, php2, txt2){
			$Crumb(php1, txt1).appendTo("#p_breadcrumb");
			$Crumb(php2, txt2).appendTo("#p_breadcrumb");
		}
	};
})();

$(function() {
	breadcrumbInit();
});

var breadcrumbInit = function() {
	var web = location.pathname;
	var php = web.split("/")[web.split("/").length - 1];
	php = php || "index.php";
	setCrumb(php);
};

var setCrumb = function(php) {
	switch (php) {
	case "index.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Index());
		break;
	}
	case "aboutUs.php" :{
		var txt1 = crumbTxt.getInstance().AboutUsTitle();
		var txt2 = crumbTxt.getInstance().AboutUs();
		$breadCrumb.twoRow(php, txt1, php, txt2);
		break;
	}
	case "aboutUsAwards.php" :{
		var php1 = crumbTxt.getInstance().AboutUsURL();
		var txt1 = crumbTxt.getInstance().AboutUsTitle();
		var txt2 = crumbTxt.getInstance().AboutUsAwards();
		$breadCrumb.twoRow(php1, txt1, php, txt2);
		break;
	}
	case "aboutUsBeforeOrder.php" :{
		var php1 = crumbTxt.getInstance().AboutUsURL();
		var txt1 = crumbTxt.getInstance().AboutUsTitle();
		var txt2 = crumbTxt.getInstance().AboutUsBefore();
		$breadCrumb.twoRow(php1, txt1, php, txt2);
		break;
	}
	case "login.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Login());
		break;
	}
	case "user.php" :{
		var txt1 = crumbTxt.getInstance().UserTitle();
		var txt2 = crumbTxt.getInstance().User();
		$breadCrumb.twoRow(php, txt1, php, txt2);
		break;
	}
	case "order.php" :{
		var php1 = crumbTxt.getInstance().UserURL();
		var txt1 = crumbTxt.getInstance().UserTitle();
		var txt2 = crumbTxt.getInstance().Order();
		$breadCrumb.twoRow(php1, txt1, php, txt2);
		break;
	}
	case "register.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Register());
		break;
	}
	case "productOccasion.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Occasion());
		break;
	}
	case "productList.php": {
		$breadCrumb.oneRow(crumbTxt.getInstance().OccasionURL(), crumbTxt.getInstance().Occasion());
		break;
	}
	case "product.php": {
		$breadCrumb.oneRow(crumbTxt.getInstance().OccasionURL(), crumbTxt.getInstance().Occasion());
		break;
	}
	case "shoppingCar.php": {
		$breadCrumb.oneRow("productList.php", crumbTxt.getInstance().Cart());
		break;
	}
	case "shoppingCarStep1.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Cart());
		break;
	}
	case "shoppingCarStep3.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().Cart());
		break;
	}
	case "guaranteeCard.php": {
		$breadCrumb.oneRow(php, crumbTxt.getInstance().GuaranteeCard());
		break;
	}
	case "news.php":{
		$breadCrumb.oneRow(php, crumbTxt.getInstance().News());
		break;
	}
	case "customerService.php" :{
		var txt1 = crumbTxt.getInstance().CustomTitle();
		var txt2 = crumbTxt.getInstance().CustomTitle();
		$breadCrumb.twoRow(php, txt1, php, txt2);
		break;
	}
	case "customerServiceQA.php" :{
		var txt1 = crumbTxt.getInstance().CustomTitle();
		var txt2 = crumbTxt.getInstance().QandA();
		$breadCrumb.twoRow(php, txt1, php, txt2);
		break;
	}
	case "customerServiceDealer.php" :{
		var txt1 = crumbTxt.getInstance().CustomTitle();
		var txt2 = crumbTxt.getInstance().SVDealer();
		$breadCrumb.twoRow(php, txt1, php, txt2);
		break;
	}
	}
};

var $Crumb = function(php, txt) {
	var $li = $("<li>").addClass("font-small");
	var $a = $("<a>").attr("href", php).text(txt);
	return $li.append($a);
};
