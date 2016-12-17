var getPage = function(){
	var page = _request.getParameter("page");
	page = (page !== "null") ? page : "1";
	return page;
};

var creatPageNumber = function(count, url){
	var $page = $("#page").children("ul").empty();
	var pageNumb = Math.ceil(count / 10);
//	var length = (pageNumb > 10) ? 10 : pageNumb;
	var page = getPage();
	var preten = parseInt(page)-10;
	var nextten = parseInt(page)+10;
	nextten = (nextten > pageNumb) ? pageNumb : nextten;
	if(parseInt(page) > 10){
		$("<li>").append($("<a>").attr("href", url +"&page="+preten).text("上十頁")).appendTo($page);
	}
	var begin = Math.floor((page -1) /10) *10 +1;
	for(var i=begin; i<=begin+9; i++){
		if(i <= pageNumb){
			var $a = $("<a>").attr("href", url +"&page="+i).text(i);
			$("<li>").append($a).appendTo($page);
			if(i == page){
				$a.parent("li").addClass("active");
			}
		}
	}
	if(pageNumb - begin >= 10){
		$("<li>").append($("<a>").attr("href", url +"&page="+nextten).text("下十頁")).appendTo($page);
	}
};