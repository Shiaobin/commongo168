(function($){
	jQuery.fn.FormCheck = function(){
		var bool = true;

		var checkNull = function(obj){
			$(obj).find("input.p_checkNull").each(function(){
				var boo = (!$(this).val());
				tiplabel(boo, ErrorMsg.getInstance().valueNull(), $(this));
				if(!$(this).val()){
					bool = false;
				}
			});
			$(obj).find("textarea.p_checkNull").each(function(){
				var boo = (!$(this).val());
				tiplabel(boo, ErrorMsg.getInstance().valueNull(), $(this));
				if(!$(this).val()){
					bool = false;
				}
			});
		};

		var checkMobile = function(obj){
			$(obj).find("input.p_checkMobile").each(function(){
				var regExp = Config.getInstance().mobilereg();
				var boo = (!regExp.test($(this).val()));
				tiplabel(boo, ErrorMsg.getInstance().mobileErr(), $(this));
				if(!regExp.test($(this).val())){
					bool = false;
				}
			});
		};

		var checknumber = function(obj){
			$(obj).find("input.p_checkNumber").each(function(){
				var regExp = Config.getInstance().numberreg();
				var boo = (!regExp.test($(this).val()));
				tiplabel(boo, ErrorMsg.getInstance().numberErr(), $(this));
				if(!regExp.test($(this).val())){
					bool = false;
				}
			});
		};

		var checkPwd = function(obj){
			$(obj).find("input.p_checkPwd").each(function(){
				var regExp = Config.getInstance().pwdreg();
				var boo = (!regExp.test($(this).val()));
				tiplabel(boo, ErrorMsg.getInstance().pwdcheck(), $(this));
				if(!regExp.test($(this).val())){
					bool = false;
				}
			});
		};

		var checkMail = function(obj){
			$(obj).find("input.p_checkMail").each(function(){
				var regExp = Config.getInstance().mailreg();
				var boo = (!regExp.test($(this).val()));
				tiplabel(boo, ErrorMsg.getInstance().mailcheck(), $(this));
				if(!regExp.test($(this).val())){
					bool = false;
				}
			});
		};

		var checkRadio = function(obj){
			$(obj).find("input:radio").each(function(){
				var rdname = $(this).attr("name");
				var $div = $("[name="+ rdname +"]").parent("label").parent("div");
//				$div.removeAttr("style");
				if(!$(":checked[name="+ rdname +"]").val()){
//					$div.css("border-color", txtColor);
					bool = false;
				}
			});
		};

		this.each(function() {
			checkNull(this);
			checkMobile(this);
			checkPwd(this);
			checkMail(this);
			checkRadio(this);
			checknumber(this);
	    });

		return bool;
	};
})(jQuery);

var tiplabel = function(bool, msg, $obj){
	var txtColor   = "#FF0000";
	var errorCls   = "has-error";
	var successCls = "has-success";
	$obj.parent("div").children("label").remove();
	if(bool){
		$obj.parent("div").removeClass(successCls);
		$obj.parent("div").addClass(errorCls);
		var $label = $("<label>").css("color",txtColor);
		$label.text(msg).insertAfter($obj);
	} else{
		$obj.parent("div").addClass(successCls);
		$obj.parent("div").removeClass(errorCls);
	}
};

