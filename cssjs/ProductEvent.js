$(function(){
	$("#p_addcart").click(function(){addCartCK(this);});
});

var addCartCK = function(obj){
	var gid       = $(obj).attr("gid");
	var colorid   = $(obj).attr("colorid");
	var img       = $(obj).attr("imgurl");
	var name      = $("#p_name").text();
	var buyamount = $("#p_amount").val();
	var reurl       = "product.jsp" + location.search;

	var url   = PostUrl.getInstance().addcart();
	var data  = {gid:gid, colorid:colorid, img:img, name:name, buyamount:buyamount, url:reurl};
	doAjaxFunc(url, data, setAddCartBack);
};

var colorItemCK = function(){
	$("#p_img").attr("src", $(this).attr("img"));
	$("#p_reserve").text("庫存：" + $(this).attr("amount_msg"));
	$("#p_addcart").attr("colorid", $(this).attr("colorid"));
	$("#p_addcart").attr("gid", $(this).attr("gid"));
	$("#p_addcart").attr("imgurl", $(this).attr("listimg"));
	var color = ($(this).attr("color") == "無" || $(this).attr("color") == undefined) ? "" : "("+ $(this).attr("color") +")";
	$("#p_name").text($("#p_name").attr("product") + color);

	var len = ($(this).attr("amount") >= 10) ? 10 : $(this).attr("amount");
	$("#p_amount").empty();
	for(var i=1; i<=len; i++){
		var $option = $("<option>").attr("value", i).text(i);
		$option.appendTo("#p_amount");
	}
};

var setAddCartBack = function(json){
	if(json.ERROR !== 0)
		alert(json.ERROR_MSG);
	else{
		window.location = "shoppingCar.jsp";
	}
};