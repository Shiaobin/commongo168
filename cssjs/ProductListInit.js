$(function(){
	var queryString = location.search.substring(1);
	if (queryString.length <= 0)
		document.location.href = "productList.jsp?type=part&option=Everpoll愛惠浦系列&pid=p01";
	productListInit();
});

var productListInit = function(){
	var type  = _request.getParameter("type");
	var page  = getPage();
	(type === "part") ? $("#p_usagetip").hide() : $("#p_usagetip").show();
	(type === "part") ? productByPart(page) : productByUsage(page);
};

var productByPart = function(page){
	var pid   = _request.getParameter("pid");
	var begin = 10 * (parseInt(page) - 1) + 1;
	var end   = begin + 9;
	var url   = PostUrl.getInstance().productbypart();
	var data  = {pid:pid, begin:begin, end:end};
	doAjaxFunc(url, data, setProductListBack);
};

var productByUsage = function(page){
	var uid   = _request.getParameter("uid");
	var begin = 10 * (parseInt(page) - 1) + 1;
	var end   = begin + 9;
	var url   = PostUrl.getInstance().productbyusage();
	var data  = {uid:uid, begin:begin, end:end};
	doAjaxFunc(url, data, setProductListBack);
};

var setProductListBack = function(json){
	$("#p_productlist").empty();
	var uri_search = geturiSearch();
	var option     = _request.getParameter("option");
	var url        = "productList.jsp"+ uri_search;
	var $li = $("<li>").addClass("font-small").appendTo("#p_breadcrumb");
	$("<a>").attr("href", url).text(option).appendTo($li);
	$("#p_usage").text(" \"" + option + "\" ");
	if(json.ERROR !== 0)
			alert(json.ERROR_MSG);
	else{
		$.each(json.RESULT, function(){
			productItem(this).appendTo("#p_productlist");
		});
	}
	creatPageNumber(json.AMOUNT, "productList.jsp" + uri_search);
};

function geturiSearch(){
	var uri_search = location.search;
	var end = uri_search.indexOf("&page=");
	uri_search = (end !== -1) ? uri_search = uri_search.substring(0, end) : uri_search;
	return uri_search;
}

var partItem = function(obj){
	var type   = _request.getParameter("type");
	var pid    = _request.getParameter("pid");
	var li_cls = (type === "part" && pid === obj.pid) ? "text-center active" : "text-center";
	var url    = "productList.jsp?type=part&option="+ obj.name +"&pid=" + obj.pid;
	var $li    = $("<li>").addClass(li_cls);
	var $a     = $("<a>").attr("href", url).text(obj.name);
	return $li.append($a);
};



var productItem = function(obj){
	var uri_search = location.search;
	var url        = "product.jsp"+ uri_search +"&gid=" + obj.gid;
	var div_cls    = "col-lg-2 col-md-3 col-sm-3 col-xs-4 content-productList-item";
	var img_cls    = "media-object img-thumbnail img-center";
	var a_cls      = "text-productlist-title";
	var $div       = $("<div>").addClass(div_cls);
	var $img       = $("<a>").attr("href",url).append($("<img>").addClass(img_cls).attr("src",obj.img));
	var $a         = $("<a>").addClass(a_cls).attr("href",url).text(obj.name);
	return $div.append($img).append($a);
};