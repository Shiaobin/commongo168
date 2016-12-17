$(function(){
	partInit();
});

var partInit = function(){
	var url   = PostUrl.getInstance().part();
	var data  = {};
	doAjaxFunc(url, data, setPartBack);
};

var setPartBack = function(json){
	var $part = $("#nav").children("ul").empty();
	if(json.ERROR !== 0)
		alert(json.ERROR_MSG);
	else{
		$.each(json.RESULT, function(){
			partItem(this).appendTo($part);
		});
	}
};
