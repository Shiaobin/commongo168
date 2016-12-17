$(function(){
	productInit();
	colorInit();
});

var partItem = function(obj){
	var url    = "productList.jsp?type=part&option="+ obj.name +"&pid=" + obj.pid;
	var $li    = $("<li>").addClass("text-center").attr("id","p_"+ obj.pid);
	var $a     = $("<a>").attr("href", url).text(obj.name);
	return $li.append($a);
};

var productInit = function(){
	var gid = _request.getParameter("gid");
	var url   = PostUrl.getInstance().productcontetn();
	var data  = {gid:gid};
	doAjaxFunc(url, data, setProductContentBack);
};

var colorInit = function(){
	var gid = _request.getParameter("gid");
	var url   = PostUrl.getInstance().productcolor();
	var data  = {gid:gid};
	doAjaxFunc(url, data, setProductColorBack);
};

var setProductContentBack = function(json){
	console.log(json);
	tagPathInit(json.RESULT[0].name);
	if(json.ERROR !== 0)
		alert(json.ERROR_MSG);
	else{
		$.each(json.RESULT, function(){
			if(this.DISCOUNT){
				$("#p_price").addClass("text--product-price-del");
				$("#p_discount").text($("#p_discount").text() + this.DISCOUNT).show();
				$("#p_discountTime").children("span").text(this.STARTDATE+" - "+this.ENDDATE);
				$("#p_discountTime").show();
			}
			$("#p_"+ this.pid).addClass("active");
			$("#p_gid").text($("#p_gid").text() + this.gid);
			$("#p_name").attr("product",this.name);
			$("#p_intro").html(this.intro);
			$("#p_price").text($("#p_price").text() + this.PRICE);
			$("#p_addcart").attr("price", this.PRICE);
			$("#p_content").html(this.content);
		});
		$("#p_color").children("li").eq(0).click();
	}
};

var setProductColorBack = function(json){
	var $color = $("#p_color").empty();
	if(json.ERROR !== 0)
		alert(json.ERROR_MSG);
	else{
		$.each(json.RESULT, function(){
			var $li = $("<li>").addClass("product-color01").css("background", this.color);
			$li.attr("img", this.img).attr("amount_msg", this.AMOUNT_MSG);
			$li.attr("amount", this.amount).attr("colorid", this.colorid);
			$li.attr("gid", this.gid).attr("color", this.colorname);
			$li.attr("listimg", this.listimg);
			$li.click(colorItemCK);
			$li.appendTo($color);
		});
	}
	$color.children("li").eq(0).click();
};

var tagPathInit = function(name){
	var uri_search = location.search;
	var option     = _request.getParameter("option");
	var url        = "productList.jsp"+ uri_search.substring(0, uri_search.indexOf("&gid"));
	var $li = $("<li>").addClass("font-small").appendTo("#p_breadcrumb");
	$("<a>").attr("href", url).text(option).appendTo($li);
	var $product   = $("#p_listproduct").empty();
	$("<a>").attr("href", uri_search).text(name).appendTo($product);
};