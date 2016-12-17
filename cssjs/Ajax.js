$(function(){
	var error  = "javascript/util/ErrorMsg.js";
	var post   = "javascript/util/PostUrl.js";
	var config = "javascript/util/Config.js";
	var blockUIJs = 'javascript/util/blockUI/jquery.blockUI.js';
	importJS(error, "ErrorMsg", function(){});
	importJS(post, "PostUrl", function(){});
	importJS(config, "Config", function(){});
	importJS(blockUIJs, "jQuery.blockUI", function(){}); 
	
	ajaxSetup();
});
var ajaxSetup = function(){
	$.ajaxSetup({
		contentType  : 'application/x-www-form-urlencoded; charset=UTF-8',
		type         : "POST",
		beforeSend   : function(){
			$.blockUI({
//              message: '<img src="http://218.32.217.79:8081/mi/images/ajax-loader1.gif" />'
          });
		},
		complete     : function(){
			$.unblockUI();
		}
	});
};

var importJS = function(src, look_for, onload) {
    var $script = $("<script>").attr("type", "text/javascript").attr("src", src);
    if (onload) wait_for_script_load(look_for, onload);
    if (eval("typeof " + look_for) == 'undefined') {
        var $head = $("head").eq(0);
        if ($head) $head.append($script);
        else document.body.append($script);
    }
};

var wait_for_script_load = function(look_for, callback) {
    var interval = setInterval(function () {
        if (eval("typeof " + look_for) != 'undefined') {
            clearInterval(interval);
            callback();
        }
    }, 50);
};

var doAjaxFunc = function(url, data, callback, obj){
	$.ajax({
		async    :  true,
		dataType : "json",
		url : url, //query.html  ///mi/BillQuery?reqBillDate="+billDate+'&reqMerchNo='+ merchNo
		data: data,
		error : function(jqXHR, textStatus, errorThrown) {
			console.log(url);
			console.log(jqXHR);
			console.log(textStatus);
			console.log(errorThrown);
		},
		success : function(result){
			callback(result, obj);
		}
	});
};

function angularAjaxErr(data, status, headers, config){
	console.log(data);
	console.log(status);
	console.log(headers);
	console.log(config);
}

