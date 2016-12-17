$(function(){
	$("#content").children("div").each(function(){
		$(this).children("div").hover(divIn, divOut);
	});
});

var divIn = function(){
	$(this).children("a:eq(0)").children("div").addClass("img-hover");
	$(this).children("a:eq(1)").children("div").css("background-color", "rgb(224, 224, 224)");
	$(this).children("a:eq(1)").children("div").css("color", "#000");
};

var divOut = function(){
	$(this).children("a:eq(0)").children("div").removeClass("img-hover");
	$(this).children("a:eq(1)").children("div").css("background-color", "rgb(255, 255, 255, 0.4)");
	$(this).children("a:eq(1)").children("div").css("color", "#666");
};