<?php 

function toDB ($tweet_array) {

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

//$db -> close();

// for debug
//return $row_array;

//return $exists_flg_array;




	$db -> close();

	return 1;

}
?>