<?php


//headにBootstrapのCDNを追加
// function add_bootstrap_to_head() {
//   echo '
//   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
//   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
//   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
//   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>';
// }
// add_action( 'wp_head', 'add_bootstrap_to_head' );

function import_Google_Material_Icons(){
  // if(is_page(array('student-search','user','mypage_test'))){
    echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
  // }
}
add_action( 'wp_head', 'import_Google_Material_Icons');

function navigation_safearea(){
  echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">';
}
add_action( 'wp_head', 'navigation_safearea');

function import_Google_Search_Console(){
  echo '<meta name="google-site-verification" content="iKzXL1QDakUAnzl2wnV8s4tYyj1q8eHW2_preEu6J7c"/>';
}
add_action( 'wp_head', 'import_Google_Search_Console');

function navigation_tab(){
  $home_url =esc_url( home_url());
  if ( is_user_logged_in() ){
    echo '
    <div class="navi-container">
      <ul class="navi-menu">
        <li class="navi-menu-button">
          <a href="'.$home_url.'/" class="navi-menu-content navi-menu-content-home">
            <span class="navi-menu-icon navi-menu-icon-home"></span>
            <span class="navi-menu-text">ホーム</span>
          </a>
        </li>
        <li class="navi-menu-button">
          <a href="'.$home_url.'/company" class="navi-menu-content navi-menu-content-recruit">
            <span class="navi-menu-icon navi-menu-icon-recruit"></span>
            <span class="navi-menu-text">新卒</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-intern">
          <a href="'.$home_url.'/internship" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-intern"></span>
            <span class="navi-menu-text">インターン</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-event">
          <a href="'.$home_url.'/event" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-event"></span>
            <span class="navi-menu-text">イベント</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-mypage">
          <a href="'.$home_url.'/user" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-mypage"></span>
            <span class="navi-menu-text">マイページ</span>
          </a>
        </li>
      </ul>
    </div>';
  }else{
    echo '
    <div class="navi-container">
      <ul class="navi-menu">
        <li class="navi-menu-button">
          <a href="'.$home_url.'/" class="navi-menu-content navi-menu-content-home">
            <span class="navi-menu-icon navi-menu-icon-home"></span>
            <span class="navi-menu-text">ホーム</span>
          </a>
        </li>
        <li class="navi-menu-button">
          <a href="'.$home_url.'/company" class="navi-menu-content navi-menu-content-recruit">
            <span class="navi-menu-icon navi-menu-icon-recruit"></span>
            <span class="navi-menu-text">新卒</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-intern">
          <a href="'.$home_url.'/internship" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-intern"></span>
            <span class="navi-menu-text">インターン</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-event">
          <a href="'.$home_url.'/event" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-event"></span>
            <span class="navi-menu-text">イベント</span>
          </a>
        </li>
        <li class="navi-menu-button navi-menu-content-mypage">
          <a href="'.$home_url.'/login" class="navi-menu-content">
            <span class="navi-menu-icon navi-menu-icon-mypage"></span>
            <span class="navi-menu-text">ログイン</span>
          </a>
        </li>
      </ul>
    </div>';
  }

}
add_action( 'wp_footer', 'navigation_tab');

// function import_Google_Adwords(){
//   echo '<script async src="https://www.googletagmanager.com/gtag/js?id=AW-749000228"></script>
//   <script>
//     window.dataLayer = window.dataLayer || [];
//     function gtag(){dataLayer.push(arguments);}
//     gtag("js", new Date());

//     gtag("config", "AW-749000228");
//   </script>';
// }
// add_action( 'wp_head', 'import_Google_Adwords');


function import_template_func ( $atts ) {
    extract( shortcode_atts( array(
      'type' => '', 
  ), $atts ) );

if($_GET) {
  $getStr = $_GET['s'];
  $getCat = $_GET['cat'];
  $getTag = $_GET['tag'];
}

if($getStr == '') {//検索結果画面でも読み込まれてしまうのを防ぐ
if($type=='internship'){
  echo do_shortcode(do_shortcode(get_post( 365 )->post_content)); 
}
/*
  if($type==''){
  echo do_shortcode(do_shortcode(get_post( 365 )->post_content)); 
}
*/
  //  return '<p class="job-name" ></p><p class="job-tag"  ></p><p class="job-slogan"></p>';
  }
}
add_shortcode('import_template', 'import_template_func');
add_shortcode('importtemplate', 'import_template_func');

function textarea2array($text){
$array = explode("\n", $text); // とりあえず行に分割
$array = array_map('trim', $array); // 各行にtrim()をかける
$array = array_filter($array, 'strlen'); // 文字数が0の行を取り除く
$array = array_values($array); // これはキーを連番に振りなおしてるだけ
return $array;
}

function held_date_text($event_open,$event_close){ 
$week = array("日", "月", "火", "水", "木", "金", "土");
$date = date_create(''.get_field($event_open).'');   $t= date_format($date,'Y年m月d日') . "(" . $week[(int)date_format($date,'w')] . ")" ;
$time = date_create(''.get_field($event_open).'');   $t.= date_format($time,'H:i').'～';
$time = date_create(''.get_field($event_close).'');  $t.= date_format($time,'H:i');
return $t;
}

function text2date($date_text,$punc){
  $date_text=mb_convert_kana($date_text, 'kvrn');
$date_text=str_replace('：',':',$date_text);
$date_text=str_replace('〜','~',$date_text);

    if(strpos($date_text,$punc)===false){
    try{
  $ds=new DateTime($date_text);	
      return $ds;
    } catch (Exception $e) {
      return NULL;
}
  }else{
    try{
  $ds=new DateTime(mb_substr($date_text, 0, strpos($date_text,$punc) ));	
    } catch (Exception $e) {
      return NULL;
}
          try{
  $de=new DateTime($ds->format('Y-m-d ').str_replace('<br />','',mb_substr($date_text, strpos($date_text,$punc)+1)));
          } catch (Exception $e) {
                  return NULL;
}
  return array('open'=>$ds,'close'=>$de);
  }
}

function date2text($date){
        $week = array("日", "月", "火", "水", "木", "金", "土");

if($date===NULL){
  return '';
}else{
  return $date->format('Y年n月j日'). " (" . $week[(int)date_format($date,'w')] . ") ".$date->format('G時i分');
}
}

function textarea2dates($text){
date_default_timezone_set('Asia/Tokyo');
      $week = array("日", "月", "火", "水", "木", "金", "土");

$date_text_array=textarea2array($text);
$dates=array();
foreach($date_text_array as $date_text){
  if(text2date($date_text,'~')!==NULL){
  array_push($dates,text2date($date_text,'~'));	  
  }	
  }

//  date_default_timezone_set('UTC');
$dates_text='';

foreach($dates as $d){
$date = date_create(''.get_field($event_open).'');   $t= date_format($date,'Y年m月d日') . "(" . $week[(int)date_format($date,'w')] . ")" ;

  $dates_text.='<div class="date-text">';
$dates_text.=$d['open']->format('Y年n月j日'). " (" . $week[(int)date_format($d['open'],'w')] . ") ".$d['open']->format('G時i分');
  $dates_text.='〜';
  $dates_text.=$d['close']->format('G時i分');
  $dates_text.='</div>';
}
return $dates_text;
}	   


?>