	<div id="baseContainer">

<?php

	$tweet_body = null;

	$api_url = SITE_URL . 'api/home_timeline_html?count=5';

	$api_param = '&exclude_retweet=yes';

	if(isset($_COOKIE)) {

		if(array_get_value($_COOKIE, 'exclude_retweet', "")) {

			if($_COOKIE['exclude_retweet'] == 'no') {

				$api_param = '';
			}
		}
	}

	if(isset($screen_name)) {

		$api_param .= '&screen_name='. $screen_name;
	}

// for debug
//var_dump($api_url);
//var_dump($api_param);
//var_dump($api_url.$api_param);

	$tweet_body = file_get_contents($api_url . $api_param);

// for debug
//var_dump($res);
//var_dump(json_decode($res));
//var_dump($tweet_body);

	if (isset($tweet_body)) {

		echo $tweet_body;
	}

?>

	</div>
