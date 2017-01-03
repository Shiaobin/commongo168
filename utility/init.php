<?php
	function getLongestMatchingSubstring($str1, $str2)
	{
	    $len_1 = strlen($str1);
	    $longest = '';
	    for($i = 0; $i < $len_1; $i++){
	        for($j = $len_1 - $i; $j > 0; $j--){
	            $sub = substr($str1, $i, $j);
	            if (strpos($str2, $sub) !== false && strlen($sub) > strlen($longest)){
	                $longest = $sub;
	                break;
	            }
	        }
	    }
	    return $longest;
	}

	if(strpos($_SERVER['SCRIPT_FILENAME'],$_SERVER['DOCUMENT_ROOT'])===false){
	    // how it works on reseller accounts...
	    $docroot = getLongestMatchingSubstring(getcwd(), __FILE__).'/';
	}else{
	    // how it normally works...
	    $docroot=$_SERVER['DOCUMENT_ROOT'].'/';
	}

	require_once($docroot."config/config.php");
	require_once($docroot."utility/db.php");
	require_once($docroot."utility/generator.php");
	date_default_timezone_set('Asia/Taipei');
	function now()
	{

		return date('Y-m-d H:i:s');
	}

	function get_year_months()
	{
		date_default_timezone_set('Asia/Taipei');

		$search_year = date("Y") - 1911;
		$search_month = strlen( date("m") ) == 2? date("m") : "0" . date("m");
		$search_year_month = $search_year . "/" . $search_month;

		return $search_year_month;
	}
?>
