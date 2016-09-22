<?php
// Written by maya minatsuki
// Made this file : 2016.05.02
// Last mod. : 2016.05.04



// 指定した品詞のみ出力には ma_filter を与える

// ma_filter : 以下の番号のうち必要なものを | で区切って指定
//  1 : 形容詞
//  2 : 形容動詞
//  3 : 感動詞
//  4 : 副詞
//  5 : 連体詞
//  6 : 接続詞
//  7 : 接頭辞
//  8 : 接尾辞
//  9 : 名詞
// 10 : 動詞
// 11 : 助詞
// 12 : 助動詞
// 13 : 特殊（句読点、カッコ、記号など）

// Yahoo! Japan Web API の日本語形態素解析を使い解析する
// urlencode する位置について注意
function yahoo_ma ($text_body, $ma_filter)
{

	// text_body の文字コードを UTF-8 に変換する
	$sentence =
		mb_convert_encoding ( $text_body, 'utf-8', 'auto' ) ;


// 解析オプション 形態素の表示
  
	// レスポンスの種類を指定
	// ma_response : 以下のうち必要なものを , で区切って指定
	// surface	: 表記
	// reading	: よみ
	// pos		: 品詞
	// baseform	: 基本形
	// feature	: 全情報

	$arr_response = array () ;

// 以下のうち必要な分だけコメントアウトを外す

//	$arr_response [0] = 'surface' ;		// surface	: 表記
//	$arr_response [1] = 'reading' ;		// reading	: よみ
//	$arr_response [2] = 'pos' ;		// pos		: 品詞
//	$arr_response [3] = 'baseform' ;	// baseform	: 基本形
	$arr_response [4] = 'feature' ;		// feature	: 全情報




//	$arr_filter = array () ;

// 以下のうち必要な分だけコメントアウトを外す

//	$arr_filter [0] = '1' ;		//  1 : 形容詞
//	$arr_filter [1] = '2' ;		//  2 : 形容動詞
//	$arr_filter [2] = '3' ;		//  3 : 感動詞
//	$arr_filter [3] = '4' ;		//  4 : 副詞
//	$arr_filter [4] = '5' ;		//  5 : 連体詞
//	$arr_filter [5] = '6' ;		//  6 : 接続詞
//	$arr_filter [6] = '7' ;		//  7 : 接頭辞
//	$arr_filter [7] = '8' ;		//  8 : 接尾辞
//	$arr_filter [8] = '9' ;		//  9 : 名詞
//	$arr_filter [9] = '10' ;	// 10 : 動詞
//	$arr_filter [10] = '11' ;	// 11 : 助詞
//	$arr_filter [11] = '12' ;	// 12 : 助動詞
//	$arr_filter [12] = '13' ;	// 13 : 特殊（句読点、カッコ、記号など）



	if ( isset ($sentence) ) {
		$url =
			'http://jlp.yahooapis.jp/MAService/V1/parse?' .
			'appid=' . YAHOO_J_APP_ID . '&results=ma' ;


		$ma_response =
			join ( ',' , array_values ($arr_response) ) ;

		if ( isset ($ma_response) ) {
			$url .= '&ma_response=' . $ma_response ;
		}


  //  		$ma_filter = join ( '|' , array_values ($arr_filter) ) ;

		if ( isset ($ma_filter) ) {
			$url .= '&ma_filter=' .
				urlencode ($ma_filter) ;
		}


		$url .= '&sentence=' . urlencode ($sentence) ;


		$xml  = simplexml_load_file ($url) ;


// for debug
//return $xml ;

		$arr_res = array();

		foreach ( $xml -> ma_result -> word_list -> word as $cur ) {

			if ( isset ( $arr_response[0] ) ) {

				$arr_res['surface'][] = 
					sqlite_escape_string ($cur -> surface);
			}
			if ( isset ( $arr_response[1] ) ) {

				$arr_res['reading'][] =
					sqlite_escape_string ($cur -> reading);
			}
			if ( isset ( $arr_response[2] ) ) {

				$arr_res['pos'][] =
					sqlite_escape_string ($cur -> pos);
			}
			if ( isset ( $arr_response[3] ) ) {

				$arr_res['baseform'][] =
					sqlite_escape_string ($cur -> baseform);
			}
			if ( isset ( $arr_response[4] ) ) {

				$arr_res['feature'][] =
					sqlite_escape_string ($cur -> feature);
			}
		}

	}
	else
	{
		exit ( '変数が空のため形態素解析を中断します\n' ) ;
	}

	return $arr_res;

}


?>
