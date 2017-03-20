<?php

function api_home_timeline($count = null, $since_id = null, $max_id = null, $screen_name = null, $exclude_retweet = null) {

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
			"screen_name = '" . $screen_name . "' ";
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

	while ($row = $db_res -> 
		fetchArray(SQLITE3_ASSOC)) {

		$res_array[] = $row;

	}

	unset($row);

// date('Y-m-d H:i:s',strtotime($created_at))
// で綺麗に取れる

	unset($db_res);
	$db -> close();

// for debug
//return $res_array;

	return json_encode($res_array, JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}

?>