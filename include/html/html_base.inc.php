	<div id="baseContainer">

		<div id="tweetContainer">

<?php

	$tweet_body = null;

	$api_url = SITE_URL . 'api/home_timeline?';

	$api_url .= 'count=5';

	if(isset($_COOKIE)) {

		if(array_get_value($_COOKIE, 'exclude_retweet', "")) {

			if($_COOKIE['exclude_retweet'] == 'yes') {

				$api_url .= '&exclude_retweet=yes';
			}
		}
	}

// for debug
//var_dump($api_url);

	$res = file_get_contents($api_url);

// for debug
//var_dump($res);
//var_dump(json_decode($res));

	if (isset($res)) {

		$json_array = json_decode($res);
	}

	if (isset($json_array)) {

		foreach ($json_array as $json_row) {

//			$tweet_body .= '<span class="tw_status_id">' . 
//				$json_row -> status_id . "</span>\n" ;

			$tweet_body .= 
				"\t\t\t<div class=\"twContents\">\n" . 
				"\t\t\t\t<div class=\"tw_media\">\n" . 
				"\t\t\t\t\t<img src=\"" . 
				$json_row -> media_url_1 . "\" />\n";


			if (isset($json_row -> media_url_2)) {

				$tweet_body .= "\t\t\t\t\t<img src=\"" . 
					$json_row -> media_url_2 . "\" />\n";
			}

			if (isset($json_row -> media_url_3)) {

				$tweet_body .= "\t\t\t\t\t<img src=\"" . 
					$json_row -> media_url_3 . "\" />\n";
			}

			if (isset($json_row -> media_url_4)) {

				$tweet_body .= "\t\t\t\t\t<img src=\"" . 
					$json_row -> media_url_4 . "\" />\n";
			}

			$tweet_body .= "\t\t\t\t</div>\n" . 
				"\t\t\t\t<div class=\"tw_body\">\n" . 
				"\t\t\t\t\t<div class=\"profile_image_url\">\n" . 
				"\t\t\t\t\t\t<img src=\"";

			if (isset($json_row -> rt_status_id)) {

				$tweet_body .= $json_row -> rt_profile_image_url;
			}
			else {

				$tweet_body .= $json_row -> profile_image_url;
			}

			$tweet_body .= "\" />\n" . 
				"\t\t\t\t\t</div>\n" . 
				"\t\t\t\t\t<p class=\"user_name\">";

			if (isset($json_row -> rt_status_id)) {

				$tweet_body .= $json_row -> rt_user_name;
			}
			else {

				$tweet_body .= $json_row -> user_name;
			}

			$tweet_body .= "</p>\n" . 
				"\t\t\t\t\t<p class=\"tw_text\">" . 
				preg_replace("/(https?:\/\/[0-9a-zA-Z\/\-_\.]+)/u", 
					"<a href=\"$1\">$1</a>", 
					preg_replace("/\n/u", "<br />", 
						$json_row -> text)) . 
				"</p>\n" . 
				"\t\t\t\t\t<span class=\"created_at\">" . 
				date('Y-m-d H:i:s',strtotime
					($json_row -> created_at)) .
				"</span>\n";

			if (isset($json_row -> rt_status_id)) {

				$tweet_body .= 
				"\t\t\t\t\t<div class=\"rt_user\">" . 
				"\t\t\t\t\t\t<div class=\"rt_profile_image_url\">\n" .  
				"\t\t\t\t\t\t\t\t<img src=\"" . 
				$json_row -> profile_image_url . 
				"\" />\n" . 
				"\t\t\t\t\t\t</div>\n" . 
				"\t\t\t\t\t\t<p class=\"rt_user_name\">" . 
				$json_row -> user_name . 
				"</p>\n" . 
				"\t\t\t\t\t</div>\n";


			}

			$tweet_body .= "\t\t\t\t</div>\n" . 
				"\t\t\t</div>\n\n" ;


		}

		unset($json_row);

	}

	echo $tweet_body;


?>

		</div>

	</div>
