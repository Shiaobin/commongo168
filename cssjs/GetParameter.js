var _request = (function() {
//	var uri_enc     = encodeURIComponent(location.href);
//	var uri_dec     = decodeURIComponent(uri_enc);
	var queryString = location.search.substring(1);//uri_dec.substring(uri_dec.search(/\?/)+1);
	
	function getParameter(name) {
		var parameterName = name + "=";
		if (queryString.length > 0) {
			var begin = queryString.indexOf(parameterName);
			if (begin != -1) {
				begin += parameterName.length;
				end = queryString.indexOf("&", begin);
				if (end == -1) {
					end = queryString.length;
				}
				return decodeURIComponent(queryString.substring(begin, end));
			}
			return "null";
		}
		return "null";
	}

	return {
		getParameter : getParameter
	};

})();