<?php
chdir('../');
require_once('config.php');

if (isset($_GET)) {

//	var_dump($_GET);

$api = 
$count = 
$since_id = 
$max_id = 
$trim_user =
$exclude_retweet = null;

	if(array_get_value($_GET, 'u', "")) {

		$api = htmlspecialchars($_GET['u'], ENT_QUOTES);

		switch ($api) {

			case 'home_timeline':

				if(array_get_value($_GET, 'count', "")) {

					$count = htmlspecialchars
						($_GET['count'], ENT_QUOTES);
				}
				if(array_get_value($_GET, 'since_id', "")) {

					$since_id = htmlspecialchars 
						($_GET['since_id'], ENT_QUOTES);
				}
				if(array_get_value($_GET, 'max_id', "")) {

					$max_id = htmlspecialchars 
						($_GET['max_id'], ENT_QUOTES);
				}
				if(array_get_value($_GET, 'trim_user', "")) {

					$trim_user = htmlspecialchars 
						($_GET['trim_user'], ENT_QUOTES);
				}
				if(array_get_value($_GET, 'exclude_retweet', "")) {

					$exclude_retweet = htmlspecialchars 
						($_GET['exclude_retweet'], ENT_QUOTES);
				}

				$res = api_home_timeline (
					$count, $since_id, 
					$max_id, $trim_user, 
					$exclude_retweet
					);

				var_dump ($res);

				break;

			default:

		}


	}

}



?>