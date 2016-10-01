<?php
// written by maya minatsuki
// made this file : 2016.04.30
// last mod. : 2016.05.17
//


// 連想配列の要素が存在するかチェックする関数
require_once ( SCRIPT_DIR . "include/unoh_lib/array_get_value.inc.php" ) ;

// Include abraham-twitteroauth Library, thanks
require_once ( SCRIPT_DIR . 'include/composer/vendor/autoload.php' ) ;

require_once ( MAYALIB_DIR . 'access_log_writer.inc.php' ) ;

if ( ! function_exists ('sqlite_escape_string') ) {
	require_once ( MAYALIB_DIR . 'sqlite_escape_string.inc.php' ) ;
}

require_once ( MAYALIB_DIR . 'yahoo_ma.inc.php' ) ;

require_once ( MAYALIB_DIR . 'tweet_get.inc.php' ) ;

require_once ( MAYALIB_DIR . 'toDB.inc.php' ) ;

require_once ( MAYALIB_DIR . 'db_latest_tweet.inc.php' ) ;

require_once ( MAYALIB_DIR . 'db_oldest_tweet.inc.php' ) ;

require_once ( MAYALIB_DIR . 'api_home_timeline.inc.php' ) ;

require_once ( MAYALIB_DIR . 'api_home_timeline_html.inc.php' ) ;

?>
