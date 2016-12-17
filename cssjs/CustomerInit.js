$(function(){
	topicInit();
});

function topicInit(){
	var url   = PostUrl.getInstance().customertopic();
	var data  = {};
	doAjaxFunc(url, data, setTopicBack);
};

function setTopicBack(json){
	$("#p_topic").empty();
	if(json.ERROR !== 0)
		alert(json.ERROR_MSG);
	else{
		$.each(json.RESULT, function(i){
			$("<option>").val(this.qid).text(this.type).appendTo("#p_topic");
		});
	}
}