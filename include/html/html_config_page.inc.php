<?php

$checked = 'checked';

if(isset($_COOKIE)) {

	if(array_get_value($_COOKIE, 'exclude_retweet', "")) {

		if($_COOKIE['exclude_retweet'] == 'no') {

			$checked = null;
		}
	}
}

?>
	<div id="configContainer">

		<div id="config">

			<p class="close-configContainer"><span>×</span></p>

			<span>リツイートを表示しない</span>
			<div class="switch-wrapper">
				<input type="checkbox" id="config_exclude_retweet" name="config_exclude_retweet" <?php echo $checked; ?> />
			</div>

		</div>

	</div>
