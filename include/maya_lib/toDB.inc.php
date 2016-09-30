<?php 

function toDB ($tweet_array) {

	$return_flg = 0;

	$db = new SQLite3 (DB_FILE);

// for debug
//$db = new SQLite3 (SCRIPT_DIR . 'test.db');

	$query = 'SELECT status_id FROM eostagram_tweet ' . 
		'WHERE status_id=:id';

	$stmt = $db -> prepare ($query);

// for debug
//$status_id='99999';

	$exists_flg_array = array();

	foreach ($tweet_array as $tweet_1_array) {


// for debug
//return $tweet_1_array;

		$status_id = $tweet_1_array ['status_id'];

		$stmt -> bindValue (':id', $status_id, SQLITE3_TEXT);

		$db_res = $stmt -> execute();

		$row_array = array();

		$row_array = $db_res -> fetchArray (SQLITE3_ASSOC);

		// 存在しない場合
		if(is_bool ($row_array)) {

			$exists_flg_array[] = 0;

		}
		else {	// 存在する場合

			$exists_flg_array[] = 1;
		}

	}

	unset($tweet_1_array);
	unset($stmt);
	unset($db_res);



// for debug
//$db -> close();
//return $row_array;
//return $exists_flg_array;

	try {

		$db -> exec("BEGIN DEFERRED;");

		$query = "INSERT INTO eostagram_tweet (". 
			"status_id, text, ". 
			"media_url_1, media_url_2, ". 
			"media_url_3, media_url_4, ". 
			"created_at, screen_name, ". 
			"user_id, user_name, ". 
			"profile_image_url, ". 
			"rt_status_id, rt_created_at, ". 
			"rt_screen_name, rt_user_id, ". 
			"rt_user_name, rt_profile_image_url". 
			") VALUES (". 
			":status_id, :text, ". 
			":media_url_1, :media_url_2, ". 
			":media_url_3, :media_url_4, ". 
			":created_at, :screen_name, ". 
			":user_id, :user_name, ". 
			":profile_image_url, ". 
			":rt_status_id, :rt_created_at, ". 
			":rt_screen_name, :rt_user_id, ". 
			":rt_user_name, :rt_profile_image_url". 
			")";

		$stmt = $db -> prepare ($query);

		for ($i = 0; $i < count($exists_flg_array); $i++) {

			$tweet_1_array = $tweet_array [$i];

			if (0 == $exists_flg_array[$i]) {

				$stmt -> bindValue (':status_id', 
					$tweet_1_array ['status_id'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':text', 
					sqlite_escape_string($tweet_1_array ['text']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':media_url_1', 
					$tweet_1_array ['media_url_1'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':media_url_2',  
					$tweet_1_array ['media_url_2'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':media_url_3', 
					$tweet_1_array ['media_url_3'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':media_url_4', 
					$tweet_1_array ['media_url_4'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':created_at', 
					sqlite_escape_string(
					$tweet_1_array ['created_at']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':screen_name', 
					sqlite_escape_string(
					$tweet_1_array ['screen_name']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':user_id', 
					$tweet_1_array ['user_id'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':user_name', 
					sqlite_escape_string
					($tweet_1_array ['user_name']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':profile_image_url', 
					$tweet_1_array ['profile_image_url'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_status_id', 
					$tweet_1_array ['rt_status_id'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_created_at', 
					sqlite_escape_string(
					$tweet_1_array ['rt_created_at']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_screen_name', 
					sqlite_escape_string(
					$tweet_1_array ['rt_screen_name']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_user_id', 
					$tweet_1_array ['rt_user_id'], 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_user_name', 
					sqlite_escape_string(
					$tweet_1_array ['rt_user_name']), 
					SQLITE3_TEXT);

				$stmt -> bindValue (':rt_profile_image_url', 
					$tweet_1_array ['rt_profile_image_url'], 
					SQLITE3_TEXT);


				$db_res = $stmt -> execute();

				$return_flg++;

			}
		}

		unset($tweet_1_array);

	}
	catch (Exception $e) {

		// ロールバック
		$db -> exec("ROLLBACK;");
		$message = 'SQLの実行でエラーが発生しました。<br>';
		$message .= $e -> getTraceAsString ();
		return;
	}

	// コミット
	$db_res = $db -> exec("COMMIT;");

	$db -> close();

// for debug
//return $db_res;

	if (isset($message)) {

		return array($return_flg, $message);
	}
	else {
		return $return_flg;
	}

}
?>