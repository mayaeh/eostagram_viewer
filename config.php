<?php

// eostagram
//  用 config ファイル
// made this file : 2013.07.09
// last mod. : 2016.09.23


// デフォルトのタイムゾーンを設定します。PHP 5.1 以降で使用可能です
date_default_timezone_set ( 'Asia/Tokyo' ) ;

mb_internal_encoding ( "UTF-8" ) ;


// 環境設定ファイルからスクリプト設置ディレクトリの設定を読み込む
if ( is_readable ( 'environment.inc.php' ) ) {

	include ( 'environment.inc.php' ) ;
}
else {

	$message = "environment.inc.php.sample を environment.inc.php ". 
		"と改名し各種設定をしてください。\n" ;
}

if ( ! defined ( 'SCRIPT_DIR' ) ) {

	$message .= "environment.inc.php 内設定を読み込めませんでした。\n" ;
	exit ($message) ;
}

// file_get_contents でのアクセス時用にユーザーエージェントを設定
//ini_set ( 'user_agent' , 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C)' ) ;
ini_set ( 'user_agent' , 'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; rv:11.0) like Gecko' ) ;


// エラーログのパス及びファイル名
define ( 'SCRIPT_ERR_LOGFILE' , SCRIPT_DIR . "error.log" ) ;

//define ( 'HTML_INC_DIR' , SCRIPT_DIR . "include/html/" ) ;

// HTML 出力用インクルードファイル
//define ( 'HTML_HEADER_FILE' , HTML_INC_DIR . "html_header.inc.php" ) ;
//define ( 'HTML_FOOTER_FILE' , HTML_INC_DIR . "html_footer.inc.php" ) ;
//define ( 'HTML_TOP_MENU_FILE' , HTML_INC_DIR . "html_top_menu.inc.php" ) ;

define ( 'MAYALIB_DIR' , SCRIPT_DIR . "include/maya_lib/" ) ;

require_once ( SCRIPT_DIR . 'include/include_config.php' ) ;


?>
