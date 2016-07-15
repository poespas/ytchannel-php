<?php
function channel($input) {
    if (strpos($input, 'http') !== false) {
		$dom = new DOMDocument();
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
		error_reporting(0);
		$dom->loadHtml(file_get_contents($input));
		libxml_use_internal_errors(false);
		$metas = $dom->getElementsByTagName('meta');

		foreach($metas as $el) {
			//echo $el->getAttribute('content');
			if ($el->getAttribute('itemprop') == "channelId") {
				echo $el->getAttribute('content');
				break;
			}
			
		}
    }
	else {
		$input = $c_id;
	}
	$feed = 'https://www.youtube.com/feeds/videos.xml?channel_id=' . $c_id;
	$feed_to_array = (array) simplexml_load_file($feed);
	$json = json_encode($feed_to_array);
	$array = json_decode($json,TRUE);

	$channel = array();
	$channel["channel_id"] = str_replace("yt:channel:", "", $array["id"]);
	$channel["author"]["name"] = $array["author"]["name"];

	foreach ($array["entry"] as $entry) {
		$v_id = str_replace("yt:video:", "", $entry["id"]);
		$channel["videos"][$v_id]["video_id"] = $v_id;
		$channel["videos"][$v_id]["title"] = $entry["title"];
		$channel["videos"][$v_id]["description"] = $entry["media:group"]["media:description"];
		$channel["videos"][$v_id]["url"] = 'https://www.youtube.com/watch?v=' . $v_id;
		
		$channel["videos"][$v_id]["published"]["timestamp"] = $entry["published"];
		$channel["videos"][$v_id]["published"]["unix"] = strtotime($entry["published"]);
		
		$channel["videos"][$v_id]["updated"]["timestamp"] = $entry["updated"];
		$channel["videos"][$v_id]["updated"]["unix"] = strtotime($entry["updated"]);
	}
	return $channel;
}
