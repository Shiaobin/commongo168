var Config = (function () {

  var instance;

  function init() {

    return {
    	pwdreg : function(){
    		return /[a-zA-Z0-9]{5,13}/;
    	},
    	mailreg : function(){
    		return /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
    	},
    	mobilereg : function(){
    		return /^[09]{2}[0-9]{8}$/;
    	},
    	numberreg : function(){
    		return /^[0-9]/;
    	},
    	birthreg : function(){
    		return /^\d{4}-\d{2}-\d{2}$/;
    	},
    	shipping : function(){
    		return 150;
    	},
    	shiprang : function(){
    		return 1000;
    	}

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