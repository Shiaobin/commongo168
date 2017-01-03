$(function(){
	$("#p_submit").click(function(){
		var bool = $("#p_register").FormCheck();
		if(bool)
			questionSend();
	});
});

function questionSend(){
	var qid  = $("#p_topic").val();
	var subject = $("#p_topic").children("option:selected").text();
	var qu   = $("#p_qu").val();
	var name = $("#p_name").val();
	var sex  = $(":radio[name=p_sex]:checked").val();
	var phoneAM  = $("#p_codeAM").val() + $("#p_phoneAM").val() + "#" + $("#p_extensionAM").val();
	var phonePM  = $("#p_codePM").val() + $("#p_phonePM").val() + "#" + $("#p_extensionPM").val();
	var postCode = $("#p_codepost").val();
	var city     = $("#p_city").children("option:selected").text();
	var district = $("#p_district").children("option:selected").text();
	var addr     = city + district + $("#p_addr").val();
	var email    = $("#p_mail").val();

	var url = PostUrl.getInstance().customerqu();
	var data = {qid:qid, subject:subject, question:qu, username:name, sex:sex,
			phoneAM:phoneAM, phonePM:phonePM, postCode:postCode, addr:addr, email:email};
	doAjaxFunc(url, data, questionSendBack);
}

function questionSendBack(json){
	alert(json.ERROR_MSG);
}