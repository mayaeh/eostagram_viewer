<?php

function api_home_timeline_html($count = null, $since_id = null, $max_id = null, $screen_name = null, $exclude_retweet = null) {

// for debug
//return array(
//	'count' => $count, 
//	'since_id' => $since_id, 
//	'max_id' => $max_id, 
//	'screen_name' => $screen_name, 
//	'exclude_retweet' => $exclude_retweet
//);

	if (!isset($count)) {

		$count = 5;
	}

	$query = "SELECT * FROM eostagram_tweet ";

	$query_where_array = array();

	if (isset($since_id)) {

		$query_where_array[] = 
			"status_id > " . $since_id . " ";
	}

	if (isset($max_id)) {

		$query_where_array[] = 
			"status_id < " . $max_id . " ";
	}

	if (isset($screen_name)) {

		$query_where_array[] = 
			"screen_name = " . $screen_name . " ";
	}

	if (isset($exclude_retweet)) {

		$query_where_array[] = 
			"rt_status_id IS NULL ";
	}

	if(array_get_value($query_where_array, "0", "")) {

		$query .= "WHERE " . 
			implode("AND ", $query_where_array);
	}

	$query .= "ORDER BY status_id DESC LIMIT " . 
		$count . ";";

// for debug
//return $query;

	$db = new SQLite3 (DB_FILE);

	$db_res = $db -> query($query);

	$res_array = array();

	$tweet_body = <<<EOM
		<div id="contentContainer">

			<div class="tweetContainer">

EOM;

	while ($row = $db_res -> 
		fetchArray(SQLITE3_ASSOC)) {

// for debug
//return $row;

		$media_url_1 = 
		$profile_image_url = 
		$user_name = 
		$tw_text = 
		$rt_profile_image_url = 
		$rt_user_name = 
		$last_status_id = null;

		$last_status_id = $row ['status_id'];

//		$tweet_body .= '<span class="tw_status_id">' . 
//			$row ['status_id'] . "</span>\n" ;

		$media_url_1 = $row ['media_url_1'];

		$tweet_body .= <<<EOM
				<div class="twContents">
					<div class="tw_media">
						<img src="$media_url_1" />
EOM;

		if (array_get_value($row,'media_url_2', "")) {

			$tweet_body .= "\t\t\t\t\t\t<img src=\"" . 
				$row ['media_url_2'] . "\" />\n";
		}

		if (array_get_value($row, 'media_url_3', "")) {

			$tweet_body .= "\t\t\t\t\t\t<img src=\"" . 
				$row ['media_url_3'] . "\" />\n";
		}

		if (array_get_value($row, 'media_url_4', "")) {

			$tweet_body .= "\t\t\t\t\t\t<img src=\"" . 
				$row ['media_url_4'] . "\" />\n";
		}

		if (array_get_value($row, 'rt_status_id', "")) {

			$profile_image_url = 
				$row ['rt_profile_image_url'];

			$user_name = 
				$row ['rt_user_name'];
		}
		else {

			$profile_image_url = 
				$row ['profile_image_url'];

			$user_name = htmlspecialchars
				($row ['user_name'], ENT_QUOTES);
		}

		$tw_text = preg_replace("/\n/u", "<br />", 
			htmlspecialchars($row ['text'], ENT_QUOTES));

		$tw_pattern1 = "/(https?:\/\/[0-9a-zA-Z\/\-_\.]+)/u";

		$tw_replace1 = "<a href=\"$1\">$1</a>";

		$tw_text = preg_replace($tw_pattern1, 
			$tw_replace1, $tw_text);

		$tw_date = date('Y-m-d H:i:s',strtotime
				($row ['created_at']));

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

		if (isset($row ['rt_status_id'])) {

			$rt_profile_image_url = 
				$row ['profile_image_url'];

			$rt_user_name = htmlspecialchars
				($row ['user_name'], ENT_QUOTES);

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

	$next_url = SITE_URL . 
		'api/home_timeline_html?';

	$url_arg_array = array();

	if (isset($count)) {

		$url_arg_array[] = 'count=' . $count;
		}

	if (isset($last_status_id)) {

		$url_arg_array[] = 'max_id=' . $last_status_id;
	}

	if (isset($exclude_retweet)) {

		$url_arg_array[] = 'exclude_retweet=yes';
	}

	$next_url .= implode('&', $url_arg_array);

	$tweet_body .= <<<EOM

			</div>

			<div class="navigation">
				<a href="$next_url">next</a>
			</div>

		</div>

EOM;

	unset($row);

// date('Y-m-d H:i:s',strtotime($created_at))
// で綺麗に取れる

	unset($db_res);
	$db -> close();

// for debug
//return $res_array;

	return $tweet_body;


}

?>