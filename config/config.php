<?php
    /**
     * 系統組態檔
     *
	 * 2013 Version
     *
	 *
     */

    // 專案設定	**************************************************************************************************
    // 專案名稱
    define('PROJECT_NAME'			, 'hfShop');
	define('SHM_SYSTEM_ID'			, 3002);

	// 系統(後台Console)設定 	******************************************************************************************
	// 	網頁伺服器通訊協定(http:// or https://)
	define('SYS_WEB_PROTOCOL'		, 'http://');
	// 系統實體路徑
	define('SYS_DOCUMENT_ROOT'		, 'C:/hfShop/store');

	define('SYS_RELATIVE_ROOT'		, '/hfShop/store');
	// 網頁伺服器IP
	define('SYS_WEB_SERVER_IP'		, 'v88t');
	// 網頁伺服器Port
	define('SYS_WEB_SERVER_PORT'	, '80');

	// 資料庫 設定			******************************************************************************************
	// 資料庫種類(SYSTEM)
	define('SYS_DBTYPE'       		, 'mysql' ); // 'mssql'
	// 資料庫擴充原件(SYSTEM)
	define('SYS_DB_EXTENSION'  		, 'mysql' ); // 'mssqlnative'
	// 資料庫主機
	define('SYS_DBHOST'       		, '140.117.240.248' );
	// 資料庫 PORT
	define('SYS_DBPORT'       		, 'test168' ); // '1433'
	// 資料庫名稱(SYSTEM)
	define('SYS_DBNAME'				, 'moocs' );
	// 資料庫預設語系(SYSTEM)
	define('SYS_DBLANG'     		, 'utf8');
	// 資料庫帳號(SYSTEM)
	define('SYS_DBACCOUNT'    		, 'moocs');
	// 資料庫密碼(SYSTEM)
	define('SYS_DBPASSWD'     		, 'moocs1590'); // '1234'



	/*
	 * 程式庫路徑定義 Code Library(API, class)			**********************************************************
	 * php_library: adodb5, php_mailer5.2.6
	 * js_library: ExtJS4.2
	 *
	 * library defination start
	 */

	// PHP Mailer Library相對路徑
	define('PHP_LIBRARY_MAILER_PATH'	, '/service/utility/php_mailer');

	// 郵件字符集 Charset(utf-8: 繁體中文)
	define('MAIL_CHAR_SET'				, 'utf-8');

	// 信箱帳號
	define('MAIL_USERNAME'				, 's98113169@gmail.com');

	// 信箱密碼
	define('MAIL_PASSWORD'				, 'qq310441');

	// 寄件者郵件信箱
	define('MAIL_SENDER_ADDRESS'		, 's98113169@gmail.com');

	// 寄件者姓名
	define('MAIL_SENDER_NAME'			, 'Ching-Wei');

	// 語系設定 			******************************************************************************************

	// 其它設定 			******************************************************************************************


	// 使用者授權碼傳送方式(mail,sms)
	define('USER_AUTH_SENDBY'			, 'mail');

	// app_name_id app特定ID辨識名稱
	define('APP_NAME_ID'	  		, 'com.chinaairlines.efb');
	// corp_id預設公司統一編號
	define('APP_CORP_ID'			, 'CA' );
	// corp_name預設公司名稱
	define('APP_CORP_NAME'			, 'ChinaAirlines');

	// host ip
	define("HOST_IP"		  		, SYS_WEB_SERVER_IP . ':' . SYS_WEB_SERVER_PORT);
	// 預設語系
    define('DEFAULT_LANG'     		, 'big5');
	// 預設佈景
    define('DEFAULT_THEME'    		, 'blue');
    // 最高管理者權限
    $sys_admin                 		= array( 'administrator' , 'admin' );
    // 預設管理者
    $sys_manager              		= array( 'admin' , 'root' , 'sys' , 'system' );
    // 一般管理者限制功能
    $sys_func_limit           		= array( 'user_information' , 'action_message' , 'system_performance' );
    // 每頁預設筆數
    $sys_per_page             		= 20;
    // 預設佈景
    $sys_theme                		= 'default';
    // 預設資源檔目錄(絕對路徑)
    $sys_resource_dir_abs     		= SYS_DOCUMENT_ROOT . '/resource';
	// 預設資源檔目錄(相對路徑)
	$sys_resource_dir_rel	  		= SYS_RELATIVE_ROOT . '/resource';
	// 檔案上船路徑
    $sys_upload_path_abs       		= $sys_resource_dir_abs . '/files/document_manage';
	// 檔案上傳路徑(相對)
	$sys_upload_path_rel			= $sys_resource_dir_rel . '/files/document_manage';
    // 預設 IMAGE 路徑
    $sys_image      		  		= $sys_resource_dir_rel . '/' . $sys_theme . '/image';
    // 預設 CSS 路徑
    $sys_css                  		= $sys_resource_dir_abs . '/' . $sys_theme . '/css';
    // 匯出檔預設路徑
    $export_path              		= $sys_resource_dir_abs . '/files/export';
	// extjs tab預設顯示頁面(歡迎頁)
	$sys_default_page				= SYS_RELATIVE_ROOT . '/adm/welcome.php';

    // $document_download_root 		= SYS_WEB_PROTOCOL . HOST_IP .'/console/resource/files/document_manage';

    // $http_authroization_username 	= 'efb';

    // $http_authroization_password 	= 'efb5678';


    // 資料庫名稱(MIS_LOG)
    // define('SYS_DBNAME_2'     , 'mis_log.dbo');

    // 資料庫名稱(Mis Web Consol)
    // define('SYS_DBNAME_3'     , 'mis_web.dbo');

    // MisCore(API) Construct IP
    // define('SYS_API_HOST'     , '60.249.149.65');

    // MisCore(API) Construct Port
    // define('SYS_API_PORT'     , '6996');

    // MultiCastServer IP
    // define('SYS_MULTICAST_HOST' , '236.69.96.88');

    // MultiCastServer Port
    // define('SYS_MULTICAST_PORT' , '8231');
?>
