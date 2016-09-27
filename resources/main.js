$(function(){

	$('#configOpen').animatedModal({
		modalTarget:'configContainer',
		animatedIn:'fadeIn', //表示する時のアニメーション
		animatedOut:'fadeOut', //閉じる時のアニメーション
		animationDuration:'1s', //アニメーションにかける秒数
		color:'rgb(230, 230, 230)', //背景色
	});

	$("input#config_exclude_retweet").switchButton({
		on_label: 'yes',
		off_label: 'no',
		width: 50,
		height: 20,
		button_width: 25
	});

	$("input#config_exclude_retweet").change(function() {

		var expire = new Date();
		expire.setTime( expire.getTime() + 1000 * 3600 * 24 * 30 );

		if($(this).is(":checked")) {

			document.cookie = 'exclude_retweet=yes; expires=' + expire.toUTCString();

		}
		else {

			document.cookie = 'exclude_retweet=no; expires=' + expire.toUTCString();

		}

	});

});