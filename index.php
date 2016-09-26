<?php
require_once ('config.php');

if(isset($_COOKIE)) {

	if(!array_get_value($_COOKIE, "exclude_retweet", "")) {

		setcookie("exclude_retweet","yes",time()+60*60*24*30);

	}
}

require_once (HTML_HEADER_FILE);

require_once (HTML_TOP_MENU_FILE);

require_once (HTML_BASE_FILE);

require_once (HTML_CONFIG_PAGE_FILE);

require_once (HTML_FOOTER_FILE);

?>
