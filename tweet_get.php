<?php
require_once ('config.php');

// for debug
//var_dump(tweet_get(null,null,null));
//exit;

$latest_id = 
$oldest_id = null;

for ($i = 0; $i < 10; $i++) {

	$latest_id = db_latest_tweet(DB_FILE);

	$oldest_id = db_oldest_tweet(DB_FILE);

	$tweet_array = tweet_get (100, $oldest_id, $latest_id);

	if (is_array($tweet_array)) {

		$res = toDB($tweet_array);
	}
	else {

		var_dump($tweet_array);

		break;

	}

	if (isset($res)) {

		if (1 != $res) {

			var_dump($res);

			break;
		}

		break;
	}

// for debug
//echo "tweet_get " . $i . " loop end...\n";

	sleep (2);
}

// for debug
//var_dump(array("latest_id" => $latest_id, 
//	"oldest_id" => $oldest_id));
//var_dump($res);


?>
