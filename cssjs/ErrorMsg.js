var ErrorMsg = (function () {

  var instance;

  function init() {

    return {
    	pwdcheck  : function(){return "密碼錯誤請確認";},
    	mailcheck : function(){return "信箱格式錯誤";},
    	valueNull : function(){return "資料尚未填寫";},
    	mobileErr : function(){return "帳號格式錯誤或是此帳號已有人使用";},
    	birthErr  : function(){return "日期格式錯誤";},
    	agreeErr  : function(){return "未同意會員註冊權益條款";},
    	numberErr : function(){return "此欄位僅供輸入數字";}
    };

  };

  return {
    getInstance: function () {
      if ( !instance ) {
        instance = init();
      }
      return instance;
    }
  };

})();