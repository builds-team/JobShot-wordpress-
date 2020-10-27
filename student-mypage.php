<?php
/*

function redirect_to_company_mypage_func(){
$user_roles=wp_get_current_user( )->roles;
//  var_dump($user_roles);
if(in_array("company", $user_roles, true) && is_page(315)){
//echo "YOU ARE Company";
exit(wp_redirect(site_url('/company_mypage/')));
}
}
//add_action( 'template_redirect', 'redirect_to_company_mypage_func');
add_action( 'get_header', 'redirect_to_company_mypage_func');
*/

function getParamVal($param) {
$val = (isset($_GET[$param]) && $_GET[$param] != '') ? $_GET[$param] : '';
$val = htmlspecialchars($val, ENT_QUOTES);
return $val;
}


function  view_by_get_func($atts, $content = null){
        extract( shortcode_atts( array(
        'param' => '', 
        'value' => '', 
        'invert' => 'false', 
    ), $atts ) );

if($value!='' && getParamVal($param)==$value){
    return do_shortcode($content);
}else if($invert==='true'){
    return do_shortcode($content);
}
return '';
}
add_shortcode('view_by_get','view_by_get_func');

function add_to_table($name, $val){
return '<tr>
    <th>'.$name.'</th>
    <td>
        '.$val.'
    </td>
</tr>
';
}

function view_student_data_func($atts){
        extract( shortcode_atts( array(
        'field' => 'current', 
        'value' => '',
        'info_basic'=>0,
    ), $atts ) );
if($field=='current'){
$current_user = wp_get_current_user();	
}else{
    $current_user = get_user_by( $field, $value );
}
$html='<div class="accbox">';
if($info_basic==1){
$html.= '<div class="acc">
        <label for="acc_kihon">基本情報</label><input type="checkbox" id="acc_kihon" class="cssacc" />
        <div class="accshow">
            <p>'
    .'<table class="demo01">
    <tbody>'
        .add_to_table('ID',$current_user->user_login)
    .add_to_table('氏名',$current_user -> last_name.'　'.$current_user -> first_name)
//	.add_to_table('生年',$current_user -> birth_year)
    .add_to_table('性別',$current_user->sex)
    .add_to_table('居住国',$current_user->country_select.$current_user->country)
        .add_to_table('生年月日',$current_user->birth_date)
        .add_to_table('郵便番号',$current_user->zip)
        .add_to_table('都道府県',$current_user->thestate.$current_user->region)
    .add_to_table('市区町村',$current_user->city.$current_user->locality)
        .add_to_table('住所1',$current_user->addr1.$current_user->street)
        .add_to_table('電話番号',$current_user->phone1.$current_user->mobile_number)
        .add_to_table('メールアドレス',$current_user->user_email)
            .add_to_table('ウェブサイト',$current_user->user_url)
    .'</tbody></table>'
//	.var_dump(get_user_meta($current_user -> ID))
.'</p>
        </div>
    </div>';
}

    $html.= '<div class="acc">
        <label for="acc_academic">学歴</label><input type="checkbox" id="acc_academic" class="cssacc" />
        <div class="accshow">
            <p>'
    .'<table class="demo01"><tbody>'
        .add_to_table('出身高校名',$current_user->highschool)
            .add_to_table('大学',get_univ_name($current_user))
        .add_to_table('学部/研究科',get_faculty_name($current_user))
//			.add_to_table('学科/専攻',$current_user->department)
            .add_to_table('ゼミ',$current_user->seminar)
                .add_to_table('学年',$current_user->school_year)
            .add_to_table('卒業年月',$current_user->graduate_planned_year.'年'.$current_user->graduate_month.'月')

    .'</tbody></table></p>
        </div>
    </div>';

$html.= '<div class="acc">
        <label for="acc_activity">活動実績</label><input type="checkbox" id="acc_activity" class="cssacc" />
        <div class="accshow">
            <p>'
    .'<table class="demo01">
    <tbody>'
        .add_to_table('プログラミング経験',$current_user->programming_experience)
        .add_to_table('経歴',$current_user->bio)
        .add_to_table('TOEIC',$current_user->toeic)
        .add_to_table('活動実績',$current_user->activity)
        .'</tbody></table>
            </p>
        </div>
    </div>
    <div class="acc">
        <label for="acc_aspire">志望業種・職種</label><input type="checkbox" id="acc_aspire" class="cssacc" />
        <div class="accshow">
            <p>'
    .'<table class="demo01">
    <tbody>'
        .'</tbody></table>
            </p>
        </div>
    </div>
</div>

';

return $html;
}
add_shortcode('view_student_data','view_student_data_func');


function view_mypage_func(){
$user=wp_get_current_user();
$html='[ultimatemember form_id=1597]';
//$html='';
//  $html.='あなたの情報です！[avatar user="'.$user->user_login.'" size="100" /]';
$html.=$user -> last_name.'　'.$user -> first_name.'さん';
//  $html.=$user ->display_name.'さん';
$html.='<br><a href="'.home_url('/avatar').'">アバターの追加・変更</a>';

$html.='<h2>あなたの評価</h2>
<div>[drawgraph]</div>';
$html.='<h2>お気に入りインターン</h2><p>[show_favorites item_type=internship]</p>';
$html.='<h2>お気に入り企業</h2><p>[show_favorites item_type=company]</p>';
$html.='<h2>お気に入りイベント</h2><p>[show_favorites item_type=event]</p>';
$html.='<h2>プロフィール</h2>[view_student_data info_basic=1]';
$html.='<h2>申し込み一覧</h2>[view_applied_list]';
$html.='<h2>参加済み一覧</h2>[view_attended_list]';
$html.='<h2>設定</h2>[wp-members page="members-area"]';

//$html.='<h2>テスト</h2>'.view_my_access_counts_func();//.db_test();
//  $html.='<h2>デバッグ</h2>'.update_student_points_debug();
return do_shortcode($html);
}
add_shortcode('view_mypage','view_mypage_func');


/*
function db_test(){
global $wpdb; 
//  $univs=$wpdb->"univs";
//   $results = $univs->get_results( 'SELECT * FROM wp_options WHERE option_id = 1', OBJECT );
//  $results=$wpdb->get_var( "SELECT COUNT(*) FROM univs" );

$results=$wpdb->get_results( 
    "
    SELECT * 
    FROM univs
    "
);
$html='';
var_dump(json_decode($results));
foreach ( $results as $r ){
    var_dump($r);
    $html.='v: '.($r->univHeadv).', t:'.($r->univHeadt).'<br>';
}
return $html;
}*/

function get_univ_name_sql($type, $val){
    global $wpdb;
    if(empty($val)){
        return '';
    }

    if($type=='univ'){
        $wh='univv';
    }else if($type=='faculty'){
        $wh='facultyv';
    }else{
        return;
    }
    $val= esc_sql($val);
    $results=$wpdb->get_results(
        "
        SELECT *
        FROM univs
        WHERE ".$wh."='".$val."'
        ORDER BY no ASC
        "
    );
    if($type=='univ'){
        return $results[0]->univt;
    }else if($type=='faculty'){
        return $results[0]->facultyt;
    }
}

function get_univ_name($user){
    if(strlen($user->university_text)>1){
        return $user->university_text;
    }else if(strlen($user->university)>3){
        return $user->university;
    }else{
        return get_univ_name_sql('univ', $user->university);
    }
}

function get_univ_name_by_get_um_user_func(){
if ( isset( $_GET['um_user'] ) ){
    $login=wp_unslash($_GET['um_user'] );
$user=get_user_by('login',$login);
return get_univ_name($user);
}
return '';
}
add_shortcode('get_univ_name_by_get_um_user','get_univ_name_by_get_um_user_func');

function get_faculty_name($user){
// $f1=get_univ_name_sql('faculty', $user->faculty);
// if(empty($f1)){
// return get_univ_name_sql('faculty', $user->faculty_select);
// }else{
//     return $f1;
// }
    $f1=get_univ_name_sql('faculty', $user->faculty);
    $f2=get_univ_name_sql('faculty', $user->faculty_select);
    if(!empty($f1)){
        return $f1;
    }else if(!empty($f2)){
        return $f2;
    }else{
        $user_id = $user->data->ID;
        $faculty_department = get_user_meta( $user_id, 'faculty_department', false )[0];
        return $faculty_department;
    }
}

function get_faculty_name_by_get_um_user_func(){
    if ( isset( $_GET['um_user'] ) ){
    $login=wp_unslash($_GET['um_user'] );
$user=get_user_by('login',$login);
return get_faculty_name($user);
    }else{
    return '';
}
}
add_shortcode('get_faculty_name_by_get_um_user','get_faculty_name_by_get_um_user_func');

function get_birthday_by_get_um_user_func(){
if ( isset( $_GET['um_user'] ) ){
    $login=wp_unslash($_GET['um_user'] );
$user=get_user_by('login',$login);
    return $user->birth_year.'年'.$user->birth_month.'月'.$user->birth_day.'日';
}else{
return '';
}}
add_shortcode('get_birthday_by_get_um_user','get_birthday_by_get_um_user_func');

?>