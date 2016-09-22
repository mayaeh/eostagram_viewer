<?php

function tweet_get() {

	$connection = new Abraham\TwitterOAuth\TwitterOAuth 
		(TWITTER_CONSUMER_KEY, 
		TWITTER_CONSUMER_SECRET, 
		TWITTER_OAUTH_ACCESS_TOKEN, 
		TWITTER_OAUTH_ACCESS_TOKEN_SECRET);


//	$content = $connection -> get 
//		("statuses/user_timeline", ["count" => 1, "page" => 1]);

	$content = $connection->get
		("search/tweets", ["q" => "#エオスタグラム", 
		"count" => "2"]);

		if ($connection -> getLastHttpCode() == 200) {
		// Tweet posted succesfully

//			$screen_name = 
//				$statuses -> user -> screen_name;

//			$id = $statuses -> id_str;

//			if (isset($screen_name) and isset($id)) {

//				$tweet_url = 'https://twitter.com/'. 
//					$screen_name . '/status/'. 
//					$id;

//				unset($statuses);
//				unset($connection);

			$content_array = $content -> statuses;

// for debug
return $content_array [0] -> text;


		}
		else {

			$message = 'ツイート取得に失敗しました。';

			if (property_exists($statuses, 'errors')) {
				// Handle error case

				$message .= "\n". $statuses -> errors [0] -> message;
			}

			unset($statuses);
			unset($connection);

			return $message;
		}

}
?>