	<div id="baseContainer">

		<div id="tweetContainer">

<?php

	$tweet_body = null;

	$api_url = SITE_URL . 'api/home_timeline?count=5';

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

			$media_url_1 = 
			$profile_image_url = 
			$user_name = 
			$tw_text = 
			$rt_profile_image_url = 
			$rt_user_name = null;


//			$tweet_body .= '<span class="tw_status_id">' . 
//				$json_row -> status_id . "</span>\n" ;

			$media_url_1 = 
				$json_row -> media_url_1;

			$tweet_body .= <<<EOM
			<div class="twContents">
				<div class="tw_media">
					<img src="$media_url_1" />
EOM;

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

			if (isset($json_row -> rt_status_id)) {

				$profile_image_url = 
					$json_row -> rt_profile_image_url;

				$user_name = 
					$json_row -> rt_user_name;
			}
			else {

				$profile_image_url = 
					$json_row -> profile_image_url;

				$user_name = 
					$json_row -> user_name;
			}

			$tw_text = preg_replace("/\n/u", "<br />", 
				$json_row -> text);

			$tw_pattern1 = "/(https?:\/\/[0-9a-zA-Z\/\-_\.]+)/u";

			$tw_replace1 = "<a href=\"$1\">$1</a>";

			$tw_text = preg_replace($tw_pattern1, 
				$tw_replace1, $tw_text);

			$tw_date = date('Y-m-d H:i:s',strtotime
					($json_row -> created_at));

			$tweet_body .= <<<EOM
				</div>
				<div class="tw_body">
					<div class="profile_image_url">
						<img src="$profile_image_url" />
					</div>
					<p class="user_name">$user_name</p>
					<p class="tw_text">$tw_text</p>
					<span class="created_at">$tw_date</span>

EOM;

			if (isset($json_row -> rt_status_id)) {

				$rt_profile_image_url = 
					$json_row -> profile_image_url;

				$rt_user_name = 
					$json_row -> user_name;

				$tweet_body .= <<<EOM
					<div class="rt_user">
						<div class="rt_profile_image_url">
							<img src="$rt_profile_image_url" />
						</div>
						<p class="rt_user_name">
							<span>$rt_user_name</span>
							<span>ReTweeted</span>
						</p>
					</div>

EOM;

			}

			$tweet_body .= <<<EOM
				</div>
			</div>


EOM;
		}

		unset($json_row);

	}

	echo $tweet_body;


?>

		</div>

	</div>
