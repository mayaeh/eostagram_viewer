<?php

function tweet_get($count) {

	$connection = new Abraham\TwitterOAuth\TwitterOAuth 
		(TWITTER_CONSUMER_KEY, 
		TWITTER_CONSUMER_SECRET, 
		TWITTER_OAUTH_ACCESS_TOKEN, 
		TWITTER_OAUTH_ACCESS_TOKEN_SECRET);

	if(!isset($count)) {

		$count = 3;
	}

//	$content = $connection -> get 
//		("statuses/user_timeline", ["count" => 1, "page" => 1]);

	$content = $connection -> get
		("search/tweets", ["q" => "#エオスタグラム", 
		"count" => $count, "locale" => "ja"]);

	if ($connection -> getLastHttpCode() == 200) {
	// Tweet posted successfully

//		$screen_name = 
//			$statuses -> user -> screen_name;

//		$id = $statuses -> id_str;

//		if (isset($screen_name) and isset($id)) {

//			$tweet_url = 'https://twitter.com/'. 
//				$screen_name . '/status/'. 
//				$id;

//			unset($content);
//			unset($connection);
//		}

// for debug
//return $content -> statuses [0] -> text;
//return $content;


		$tweet_array = array();

		$status = null;

		$media_url_array = array();

		$media_array = null;

		foreach ($content -> statuses as $status) {

			$media_url_array = array();

			if (property_exists($status,"retweeted_status")) {

				foreach ($status -> entities -> media as 
					$media_array) {
					
					$media_url_array[] = 
						$media_array -> media_url_https;
				}

				$tweet_array[] = array(
					"status_id" => $status -> id, 
					"text" => 
						$status -> retweeted_status -> text, 
					"media_url_array" => $media_url_array, 
					"created_at" => $status -> created_at, 
					"screen_name" => 
						$status -> user -> screen_name, 
					"user_id" => $status -> user -> id, 
					"user_name" => $status -> user -> name, 
					"profile_image" => 
						$status -> user -> profile_image_url_https, 
					"retweeted_status_id" => 
					$status -> retweeted_status -> id, 
					"retweeted_created_at" => 
					$status -> retweeted_status -> created_at, 
					"retweeted_screen_name" => 
					$status -> retweeted_status -> user -> screen_name, 
					"retweeted_user_id" => 
					$status -> retweeted_status -> user -> id, 
					"retweeted_user_name" => 
					$status -> retweeted_status -> user -> name, 
					"retweeted_profile_image" => 
					$status -> retweeted_status -> user -> profile_image_url_https
				);
			}
			else {

				foreach ($status -> entities -> media as 
					$media_array) {
					
					$media_url_array[] = 
						$media_array -> media_url_https;
				}

				$tweet_array[] = array(
					"status_id" => $status -> id, 
					"text" => $status -> text, 
					"media_url_array" => $media_url_array, 
					"created_at" => $status -> created_at, 
					"screen_name" => 
						$status -> user -> screen_name, 
					"user_id" => $status -> user -> id, 
					"user_name" => $status -> user -> name, 
					"profile_image" => 
						$status -> user -> profile_image_url_https
				);
			}

		}

		unset($content);
		unset($connection);

		return $tweet_array;


	}
	else {

		$message = 'ツイート取得に失敗しました。';

		if (property_exists($content, 'errors')) {
			// Handle error case

			$message .= "\n". $content -> errors [0] -> message;
		}

		unset($content);
		unset($connection);

		return $message;
	}
}
?>