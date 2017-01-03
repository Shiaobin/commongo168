var PostUrl = (function () {

  var instance;

  function init() {

    return {
    	register       : function(){return "RegisterSv.sv";}
        ,login         : function(){return "LoginSv.sv";}
        ,usermobile    : function(){return "UserMobileSv.sv";}
        ,part          : function(){return "ProductPartSv.sv";}
        ,usage         : function(){return "ProductUsageSv.sv";}
        ,productbypart : function(){return "ProductByPartSv.sv";}
        ,productbyusage: function(){return "ProductByUsageSv.sv";}
        ,productcontetn: function(){return "ProductContentSv.sv";}
        ,productcolor  : function(){return "ProductColorAndCountSv.sv";}
        ,addcart       : function(){return "AddCartSv.sv";}
        ,cartlist      : function(){return "CartListSv.sv";}
        ,removecart    : function(){return "RemoveCartItemSv.sv";}
        ,payment       : function(){return "PayMentSv.sv";}
        ,sendinfo      : function(){return "SendInfoSv.sv";}
        ,shopstatuslist: function(){return "ShopStatusListSv.sv";}
        ,shopcontent   : function(){return "ShopContentSv.sv";}
        ,payInfo       : function(){return "CodePaymentDetailSv.sv";}
        ,producttype   : function(){return "ProductGidListSv.sv";}
        ,guaranteecard : function(){return "AddGuaranteeCardSv.sv";}
        ,news          : function(){return "NewsListSv.sv";}
        ,newspart      : function(){return "NewsTypeListSv.sv";}
        ,newscontent   : function(){return "NewsContentSv.sv";}
        ,customertopic : function(){return "QuestionTypeListSv.sv";}
        ,customerqu    : function(){return "AddCustomerServiceSv.sv";}
        ,proposaltype  : function(){return "ProposalTypeListSv.sv";}
        ,newproposal   : function(){return "NewPorposalSv.sv";}
        ,QandA   : function(){return "SelectQandASv.sv";}
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