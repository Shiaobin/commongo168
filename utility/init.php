<?php
	require_once("config/config.php");
	require_once("utility/db.php");
	require_once("utility/generator.php");
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
