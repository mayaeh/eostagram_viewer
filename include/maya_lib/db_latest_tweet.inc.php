<?php

function db_latest_tweet ($db) {

	$db = new SQLite3 ($db);

	$query = 'SELECT status_id FROM eostagram_tweet ' . 
		'ORDER BY status_id DESC LIMIT 1;';

	$db_res = $db -> query ($query);

	$row_array = array();

	$row_array [] = $db_res -> fetchArray (SQLITE3_ASSOC);

	$db -> close();

	return $row_array[0]['status_id'];

}
?>