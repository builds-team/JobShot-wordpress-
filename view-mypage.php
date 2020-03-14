<?php

function view_company_mypage_func(){
  $user=wp_get_current_user();
  $user_roles=$user->roles;

  if(in_array("company", $user_roles)){
    $html ='
    [avatar user="'.$user->user_login.'" size="100" /]
    <h2>貴社の情報ページ</h2>
    '.view_company_pagelink_func($user).'
    <h2>応募管理</h2>
    <h3>イベント</h3>
    [view_my_contents posttype=event]
    <h3>インターン</h3>
    [view_my_contents posttype=internship]
    <h3>学生検索</h3>
    [student_search_form]
    <h3>スカウトメール</h3>'
    .'残り件数<br>'.view_remain_mail_num_func($user).'';
  }else{
    $html ='権限がありません';
  }
  return do_shortcode($html);
}
add_shortcode('view_company_mypage','view_company_mypage_func');

  function get_avatar_sc_func($atts){
          extract( shortcode_atts( array(
          'user_login' => '', 
      ), $atts ) );
    $id=get_user_by('login',$user_login)->ID;
  return get_avatar($id);  
  }
  add_shortcode('get_avatar_sc','get_avatar_sc_func');

  function get_avatar_sc_func_re($atts){
    extract( shortcode_atts( array(
    'user_login' => '', 
), $atts ) );
$user_id=get_user_by('login',$user_login)->ID;
$image_date = date("YmdHis");
$upload_dir = wp_upload_dir();
$upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
if(!file_exists($upload_file_name)){
$photo = get_avatar($user_id);
}
else{
$photo = '<img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar avatar-search" />'; 
}
return $photo;
}
add_shortcode('get_avatar_sc_re','get_avatar_sc_func_re');

function my_get_userdata_by_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'data'=> 'univ',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by( $field, $value );
  if($data=='univ'){
    return get_univ_name($user);
  }else if($data=='faculty'){
    return get_faculty_name($user);
  }else{
    return $user->$data;
  }
}
add_shortcode('my_get_userdata_by','my_get_userdata_by_func');

function get_user_meta_info_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id);
  $gender = get_user_meta($user_id,'gender',false)[0][0];
  $school_year = get_user_meta($user_id,'school_year',false)[0];
  $graduate_year_input = get_user_meta($user_id,'graduate_year',false)[0];
  preg_match('/[0-9]{4}/', $graduate_year_input, $graduate_year);
  $graduate_year = $graduate_year[0];
  if($graduate_year == 2020){
      $graduate_year = "20卒";
  }
  if($graduate_year == 2021){
      $graduate_year = "21卒";
  }
  if($graduate_year == 2022){
      $graduate_year = "22卒";
  }
  if($graduate_year == 2023){
      $graduate_year = "23卒";
  }
  if($graduate_year == 2024){
    $graduate_year = "24卒";
  }

  $info_html = '
  <td label="性別">
    <p>'.$gender.'</p>
  </td>
  <td label="学年">
    <p>'.$school_year.'</p>
  </td>
  <td label="卒業年度">
    <p>'.$graduate_year.'</p>
  </td>
  ';
  return $info_html;
}
add_shortcode('get_user_meta_info','get_user_meta_info_func');

function get_user_meta_data_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'post_id'=>'',
  ), $atts ) );
  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $post_name = $post->post_name;
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $home_url =esc_url( home_url( ));
  $html = '<a href='.$home_url.'/?internship='.$post_name.'">'.$post_title.'</a><br><p>'.$company_name.'</p>';

  return $html;
}
add_shortcode('get_user_meta_data','get_user_meta_data_func');

function get_user_email($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_email = $user->data->user_email;
  return $user_email;
}
add_shortcode('get_user_email','get_user_email');

function get_user_mobile_number($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_mobile_number = get_user_meta($user_id,'mobile_number',false)[0];
  return $user_mobile_number;
}
add_shortcode('get_user_mobile_number','get_user_mobile_number');

function get_user_ruby($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id);
  $last_name_ruby = get_user_meta($user_id,'last_name_ruby',false)[0];
  $first_name_ruby = get_user_meta($user_id,'first_name_ruby',false)[0];
  $user_ruby = $last_name_ruby.' '.$first_name_ruby;
  return $user_ruby;
}
add_shortcode('get_user_ruby','get_user_ruby');

function get_user_graduate_year(){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $graduate_year_input = get_user_meta($user_id,'graduate_year',false)[0];
  preg_match('/[0-9]{4}/', $graduate_year_input, $graduate_year);
  $graduate_year = $graduate_year[0];
  if($graduate_year == 2020){
      $graduate_year = "20卒";
  }
  if($graduate_year == 2021){
      $graduate_year = "21卒";
  }
  if($graduate_year == 2022){
      $graduate_year = "22卒";
  }
  if($graduate_year == 2023){
      $graduate_year = "23卒";
  }
  if($graduate_year == 2024){
    $graduate_year = "24卒";
  }
  return $graduate_year;
}
add_shortcode('get_user_graduate_year','get_user_graduate_year');


function get_user_jender_by_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id,'gender',false);
  $gender = $user_meta[0][0];
  return $gender;
}
add_shortcode('get_user_jender','get_user_jender_by_func');

function get_user_year($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id);
  $user_meta = get_user_meta($user_id,'school_year',false);
  $gender = $user_meta[0][0];
  return $gender;
}
add_shortcode('get_user_year','get_user_year');

function get_user_skill($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_skill = get_user_meta($user_id,'skill',false);
  $user_skill = $user_skill[0];
  return $user_skill;
}
add_shortcode('get_user_skill','get_user_skill');

function get_user_experience_programming($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_experience_programming = get_user_meta($user_id,'experience_programming',false);
  $user_experience_programming = $user_experience_programming[0][0];
  return $user_experience_programming;
}
add_shortcode('get_user_experience_programming','get_user_experience_programming');

function get_user_studied_abroad($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_studied_abroad = get_user_meta($user_id,'studied_abroad',false);
  $user_studied_abroad = $user_studied_abroad[0][0];
  return $user_studied_abroad;
}
add_shortcode('get_user_studied_abroad','get_user_studied_abroad');

function get_user_univ_community($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_univ_community = get_user_meta($user_id,'univ_community',false);
  $user_univ_community = $user_univ_community[0][0];
  return $user_univ_community;
}
add_shortcode('get_user_univ_community','get_user_univ_community');

function get_user_community_univ($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_community_univ = get_user_meta($user_id,'community_univ',false);
  $user_community_univ = $user_community_univ[0];
  return $user_community_univ;
}
add_shortcode('get_user_community_univ','get_user_community_univ');

function get_user_bussiness_type($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_bussiness_types = get_user_meta($user_id,'bussiness_type',false);
  $user_bussiness_types = $user_bussiness_types[0];
  $numItems = count($user_bussiness_types);
  $i = 0;
  $html = '';
  foreach($user_bussiness_types as $key => $user_bussiness_type){
    if(++$i !== $numItems){
      $html .= $user_bussiness_type.'・';
    }else{
      $html .= $user_bussiness_type.' ';
    }
  }
  return $html;
}
add_shortcode('get_user_bussiness_type','get_user_bussiness_type');


  function my_substr_func($atts){
     extract( shortcode_atts( array(
          'text' => '',
               'num'=>100,
      ), $atts ) );
    return mb_substr($text,0,$num);
  }
  add_shortcode('my_substr','my_substr_func');
  
function view_application_detail_func(){
    if($_GET) {
    $sn= $_GET['sn'];
    $login=$_GET['login'];
      $pid=$_GET['pid'];
  }

  $cnt= do_shortcode('[cfdb-value form="/.*/" filter="your-id='.$login.'&&job-id='.$pid.'" function="count"]');

  if(!is_this_my_content($pid) || $cnt==0){
//	echo do_shortcode('[ultimatemember form_id=1597]');
    return '権限がありません。';
}

      $applied_profile='[ultimatemember form_id=1968]';

  $user = get_user_by( 'login', $login );
  $html='<h1>'.$user -> last_name.'　'.$user -> first_name.'さんの情報</h1>';
      $html.=do_shortcode($applied_profile);
    $html.=do_shortcode('[view_student_data field=login value='.$login.']');
  return $html;
}
add_shortcode('view_application_detail','view_application_detail_func');


function get_current_link() {
  return (is_ssl() ? 'https' : 'http') . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

function view_user_info_func(){
    if($_GET) {
        $login=$_GET['um_user'];
        $pid=$_GET['pid'];
        $um_action=$_GET['um_action'];
    }
    $meta_name_accessible_stu='accessible-students';

    $applied_profile='[ultimatemember form_id=1968]';
    $public_profile='[ultimatemember form_id=1597]';
    $company_profile='[ultimatemember form_id=1638]';

    $login_form='[ultimatemember form_id=1596]';

    $umuser= get_user_by( 'login', $login );

    if(in_array("company", $umuser->roles)){
        return do_shortcode($company_profile);
    }

    return do_shortcode($public_profile);

    $current_user=wp_get_current_user();
    $accessible_students=get_user_meta($current_user->ID, $meta_name_accessible_stu,true);

    // if(in_array("officer", $current_user->roles)){
    //     return do_shortcode($applied_profile);
    // }



    if(!isset($_GET['pid'])){
        // if($login==$current_user->user_login){
        //     //  自分の情報
        //     $profile_edit_button_html='<div><input type="submit" value="プロフィールを編集" onClick="location.href='."'".esc_url(get_current_link().'&um_action=edit')."'".'"></div>';
        //     if($um_action=='edit'){
        //         return do_shortcode($applied_profile);
        //     }else{
        //         return do_shortcode($applied_profile).$profile_edit_button_html;
        //     }
        // }
        if(array_key_exists($login,$accessible_students)){
            return do_shortcode($applied_profile);
        }
        return do_shortcode($public_profile);
    }
    $cnt= do_shortcode('[cfdb-value form="/.*/" filter="Submitted Login='.$login.'&&job-id='.$pid.'" function="count"]');


    if(is_this_my_content($pid) && $cnt>0){
        $html='<h2>'.$umuser -> last_name.'　'.$umuser -> first_name.'さんの情報</h2>';
        $html.=do_shortcode($applied_profile);
        return $html;
    }else{
        return do_shortcode($public_profile);
    }
}
add_shortcode('view_user_info','view_user_info_func');


function scout_button(){
  if($_GET) {
    $login=$_GET['um_user'];
    $pid=$_GET['pid'];
    $um_action=$_GET['um_action'];
  }
  $umuser= get_user_by( 'login', $login );
  $user = wp_get_current_user();
  $user_roles = $user->roles;

  if(in_array("company", $user_roles) && in_array("student", $umuser->roles)){
    /*
    $scout_status["status"]でその学生の分類(エンジニアor一般)、$scout_status["remain"]で学生の分類に対して送れる
    残りスカウトメールの数を表示
    */
    $scout_status=get_remain_mail_num_for_stu_func($umuser);
    if($scout_status["remain"]>0){
      $scout_html = '
          <a href="'.scoutlink($umuser).'">
              <button class="button button-apply">スカウトメールを送る</button>
          </a>';
        $html = '<div class="fixed-buttom">'.$scout_html.'</div>';
        return $html;
    }
    return;
  }
  return;
}

add_shortcode('scout_button','scout_button');

function get_user_sex_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id);
  $gender = get_user_meta($user_id,'gender',false)[0][0];
  $info_html = '
    <p>'.$gender.'</p>
  ';
  return $info_html;
}
add_shortcode('get_user_sex','get_user_sex_func');

function get_user_graduate_year_func($atts){
  extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $graduate_year_input = get_user_meta($user_id,'graduate_year',false)[0];
  preg_match('/[0-9]{4}/', $graduate_year_input, $graduate_year);
  $graduate_year = $graduate_year[0];
  if($graduate_year == 2020){
      $graduate_year = "20卒";
  }
  if($graduate_year == 2021){
      $graduate_year = "21卒";
  }
  if($graduate_year == 2022){
      $graduate_year = "22卒";
  }
  if($graduate_year == 2023){
      $graduate_year = "23卒";
  }
  if($graduate_year == 2024){
    $graduate_year = "24卒";
  }

  $info_html = '
    <p>'.$graduate_year.'</p>
  ';
  return $info_html;
}
add_shortcode('get_user_graduate_year','get_user_graduate_year_func');

function get_user_school_year_func($atts){
extract( shortcode_atts( array(
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user = get_user_by($field,$value);
  $user_id = $user->data->ID;
  $user_meta = get_user_meta($user_id);
  $gender = get_user_meta($user_id,'gender',false)[0][0];
  $school_year = get_user_meta($user_id,'school_year',false)[0];


  $info_html = '
    <p>'.$school_year.'</p>
  ';
  return $info_html;
}
add_shortcode('get_user_school_year','get_user_school_year_func');

function get_user_selection_status($atts){
  extract( shortcode_atts( array(
    'post_id' => '',
    'field' => 'id',
    'value'=> '',
  ), $atts ) );

  $user_login_name = $value;
  $selection_status = get_post_meta($post_id,'selection_status',false)[0][$user_login_name];
  if(empty($selection_status)){
    $selection_status = 'outstanding';
  }
  switch($selection_status){
    case 'outstanding':
        $status_html = '
          <div class="select_box select_box_01">
            <select name="selection_status">
                <option value="outstanding" selected>未対応</option>
                <option value="processing">対応中</option>
                <option value="closed">採用済</option>
                <option value="no_offer">不採用</option>
            </select>
          </div>';
        break;
    case 'processing':
        $status_html = '
          <div class="select_box select_box_01">
            <select name="selection_status">
              <option value="outstanding">未対応</option>
              <option value="processing" selected>対応中</option>
              <option value="closed">採用済</option>
              <option value="no_offer">不採用</option>
            </select>
          </div>';
        break;
    case 'closed':
        $status_html = '
          <div class="select_box select_box_01">
            <select name="selection_status">
              <option value="outstanding">未対応</option>
              <option value="processing">対応中</option>
              <option value="closed" selected>採用済</option>
              <option value="no_offer">不採用</option>
            </select>
          </div>';
        break;
    case 'no_offer':
        $status_html = '
          <div class="select_box select_box_01">
            <select name="selection_status">
              <option value="outstanding">未対応</option>
              <option value="processing">対応中</option>
              <option value="closed">採用済</option>
              <option value="no_offer" selected>不採用</option>
            </select>
          </div>';
        break;
  }
  return $status_html;
}
add_shortcode('get_user_selection_status','get_user_selection_status');

function update_user_selection_status(){
  if(!empty($_POST["update_user_selection_status"])){
    /**
     * $selection_status = array( "user_login_name" =>  "status", "user_login_name" =>  "status", ...);
     */
    $user_login_name = $_POST["user_login_name"];
    $post_id = $_POST["post_id"];
    $new_status = $_POST["selection_status"];
    $selection_status = get_post_meta($post_id,'selection_status',false)[0];
    if(empty($selection_status)){
      $selection_status = array();
    }
    if(array_key_exists($user_login_name, $selection_status)){
      $selection_status[$user_login_name] = $new_status;
    }else{
      $selection_status += array($user_login_name =>  $new_status);
    }
    update_post_meta($post_id,'selection_status',$selection_status);
    return;
  }
}
add_action('template_redirect', 'update_user_selection_status');
?>