	<div id="baseContainer">

		<div id="tweetContainer">

<?php

	$tweet_body = null;

	$api_url = SITE_URL . 'api/home_timeline_html?count=5';

	if(isset($_COOKIE)) {

		if(array_get_value($_COOKIE, 'exclude_retweet', "")) {

			if($_COOKIE['exclude_retweet'] == 'yes') {

				$api_url .= '&exclude_retweet=yes';
			}
		}
	}

// for debug
//var_dump($api_url);

	$tweet_body = file_get_contents($api_url);

// for debug
//var_dump($res);
//var_dump(json_decode($res));
//var_dump($tweet_body);

	if (isset($tweet_body)) {

		echo $tweet_body;
	}



?>

		</div>

	</div>
