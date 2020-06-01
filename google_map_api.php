<?php

function get_time_to_station($address){
    $pattern = '/東京都|北海道|(?:大阪|京都)府|(?:三重|兵庫|千葉|埼玉|大分|奈良|岐阜|岩手|島根|新潟|栃木|沖縄|熊本|福井|秋田|群馬|長野|青森|高知|鳥取|(?:宮|長)崎|(?:宮|茨)城|(?:佐|滋)賀|(?:静|福)岡|山(?:口|形|梨)|愛(?:媛|知)|(?:石|香|神奈)川|(?:富|岡|和歌)山|(?:福|広|徳|鹿児)島)県/';
    $pref = preg_match($pattern, $address[0], $m) ? $m[0] : null;
  
    mb_language("Japanese");//文字コードの設定
    mb_internal_encoding("UTF-8");
    $api_key='AIzaSyAo-HEaelxKq4jLvmvCg8HI7_UKoGAz_ms';
    $address = urlencode($address[0]);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "+&key=" . $api_key ;
    $contents= file_get_contents($url);
    $jsonData = json_decode($contents,true);
  
    $lat = $jsonData["results"][0]["geometry"]["location"]["lat"];
    $lng = $jsonData["results"][0]["geometry"]["location"]["lng"];

    $stations=array();

    $url1="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".strval($lat).",".strval($lng)."&radius=800&type=train_station&language=ja&key=" . $api_key ;
    $contents1= file_get_contents($url1);
    $jsonData1 = json_decode($contents1,true);
  	 $i=0;
    foreach($jsonData1["results"] as $data){
        $nameArray = array_column($stations, 'name');
        $sta=$data["name"];
    		$lat1 = $jsonData1["results"][$i]["geometry"]["location"]["lat"];
    		$lng1 = $jsonData1["results"][$i]["geometry"]["location"]["lng"];
        if(!in_array($sta,$nameArray)){
            $endpoint = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&origin='.strval($lat1).",".strval($lng1).'&mode=walking&destination='.$address.'&key='.$api_key;
            $contents3= file_get_contents($endpoint);
            $jsonData3 = json_decode($contents3,true);
            $sta1 = rtrim($sta, '駅');
            $get_lines='http://express.heartrails.com/api/json?method=getStations&name='.$sta1;
            $lines_contents=file_get_contents($get_lines);
            $lines_json = json_decode($lines_contents,true);
            $lines=array();
            foreach($lines_json['response']['station'] as $ln){
                if ( strcmp($ln['prefecture'], $pref) == 0 ) {
                    array_push($lines,$ln['line']);
                }
            }
            array_push($stations,array('name'=>$sta,'distance'=>$jsonData3["routes"][0]["legs"][0]["distance"]["text"],'time'=>$jsonData3["routes"][0]["legs"][0]["duration"]["text"],'line'=>$lines));
        }
	  	  $i++;
    }

    $url2="https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".strval($lat).",".strval($lng)."&radius=800&type=subway_station&language=ja&key=" . $api_key ;
    $contents2= file_get_contents($url2);
    $jsonData2 = json_decode($contents2,true);
  	 $i=0;
    foreach($jsonData2["results"] as $data){
        $nameArray = array_column($stations, 'name');
        $sta=$data["name"];
		  $lat2 = $jsonData2["results"][$i]["geometry"]["location"]["lat"];
		  $lng2 = $jsonData2["results"][$i]["geometry"]["location"]["lng"];
        if(!in_array($sta,$nameArray)){
            $endpoint = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&origin='.strval($lat2).",".strval($lng2).'&mode=walking&destination='.$address.'&key='.$api_key;
            $contents4= file_get_contents($endpoint);
            $jsonData4 = json_decode($contents4,true);
            $sta1 = rtrim($sta, '駅');
            $get_lines='http://express.heartrails.com/api/json?method=getStations&name='.$sta1;
            $lines_contents=file_get_contents($get_lines);
            $lines_json = json_decode($lines_contents,true);
            $lines=array();
            foreach($lines_json['response']['station'] as $ln){
                if ( strcmp($ln['prefecture'], $pref) == 0 ) {
                    array_push($lines,$ln['line']);
                }
            }
            array_push($stations,array('name'=>$sta,'distance'=>$jsonData4["routes"][0]["legs"][0]["distance"]["text"],'time'=>$jsonData4["routes"][0]["legs"][0]["duration"]["text"],'line'=>$lines));
        }
	  	  $i++;
    }
    return $stations;
}
add_shortcode('get_time_to_station','get_time_to_station');

function delete_station_meta(){
	$args = array(
        'post_status' => array('publish'),
        'post_type' => array('internship'),
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $posts = get_posts( $args );
    $custom_key = 'station';
    foreach($posts as $post){
        $post_id=$post->ID;
        delete_post_meta($post_id, $custom_key);
    }
}
add_shortcode('delete_station_meta','delete_station_meta');

?>