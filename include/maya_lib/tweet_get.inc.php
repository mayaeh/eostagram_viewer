<?php

function tweet_get($count, $max_id, $since_id) {

	$connection = new Abraham\TwitterOAuth\TwitterOAuth 
		(TWITTER_CONSUMER_KEY, 
		TWITTER_CONSUMER_SECRET, 
		TWITTER_OAUTH_ACCESS_TOKEN, 
		TWITTER_OAUTH_ACCESS_TOKEN_SECRET);

	if (!isset($count)) {

		$count = 3;
	}

// for debug
//	$content = $connection -> get 
//		("statuses/user_timeline", ["count" => 1, "page" => 1]);
//$content = $connection -> get 
//	("statuses/show", ["id" => '']);
//return $content;


	if (isset($since_id)) {

		$content = $connection -> get
			("search/tweets", ["q" => "#エオスタグラム", 
			"count" => $count, "since_id" => $since_id, 
			"locale" => "ja"]);
	}
	elseif (isset($max_id)) {

		$content = $connection -> get
			("search/tweets", ["q" => "#エオスタグラム", 
			"count" => $count, "max_id" => $max_id, 
			"locale" => "ja"]);
	}
	else {

		$content = $connection -> get
			("search/tweets", ["q" => "#エオスタグラム", 
			"count" => $count, "locale" => "ja"]);
	}

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

		$media_array = null;

		foreach ($content -> statuses as $status) {

			$text =
			$rt_status_id =
			$rt_created_at = 
			$rt_screen_name =
			$rt_user_id = 
			$rt_user_name =
			$rt_profile_image_url = null;

			// 非公開アカウントの tweet はスキップする
			if($status -> user -> protected == 'true') {

				continue;
			}

			// 画像を含まない tweet を除外する
			if (property_exists($status -> entities,
				"media")) {

				if (property_exists($status,"retweeted_status")) {

					$text = 
						$status -> retweeted_status -> text;

					$rt_status_id = 
						$status -> retweeted_status -> id;

					$rt_created_at = 
						$status -> retweeted_status -> created_at;

					$rt_screen_name = 
						$status -> retweeted_status -> user -> screen_name;

					$rt_user_id = 
						$status -> retweeted_status -> user -> id;

					$rt_user_name = 
						$status -> retweeted_status -> user -> name;

					$rt_profile_image_url = 
						$status -> retweeted_status -> user -> profile_image_url_https;


				}
				else {

					$text = $status -> text;
				}

				$media = 
				$media_url_1 = 
				$media_url_2 = 
				$media_url_3 = 
				$media_url_4 = null;

				$media = $status -> extended_entities -> media;

				if (array_get_value($media, '0', "")) {

					$media_url_1 = 
						$media [0] -> media_url_https;
				}

				if (array_get_value($media, '1', "")) {

					$media_url_2 = 
						$media [1] -> media_url_https;
				}

				if (array_get_value($media, 	'2', "")) {

					$media_url_3 = 
						$media [2] -> media_url_https;
				}

				if (array_get_value($media, 	'3', "")) {

					$media_url_4 = 
						$media [3] -> media_url_https;
				}

				$tweet_array[] = array(
					"status_id" => $status -> id, 
					"text" => $text, 
					"media_url_1" => $media_url_1, 
					"media_url_2" => $media_url_2, 
					"media_url_3" => $media_url_3, 
					"media_url_4" => $media_url_4, 
					"created_at" => $status -> created_at, 
					"screen_name" => 
					$status -> user -> screen_name, 
					"user_id" => $status -> user -> id, 
					"user_name" => $status -> user -> name, 
					"profile_image_url" => 
					$status -> user -> profile_image_url_https, 
					"rt_status_id" => $rt_status_id, 
					"rt_created_at" => $rt_created_at, 
					"rt_screen_name" => $rt_screen_name, 
					"rt_user_id" => $rt_user_id, 
					"rt_user_name" => $rt_user_name, 
					"rt_profile_image_url" => 
					$rt_profile_image_url
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