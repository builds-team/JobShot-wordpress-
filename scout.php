<?php
//１ヶ月に送信できるメール数を取得する
function get_all_mail_num_per_month_func($user){
    $user_roles=$user->roles;
    $all_nums = array(
        "general" => 75,
        "engineer" => 75,
    );
    if(in_array("company", $user_roles)){
        $user_id = $user->ID;
        $args = array(
            'posts_per_page'   => 1,
            'post_type' => array('company'),
            'author'	   => $user_id,
            'post_status'      => 'publish',
        );
        $posts_array = get_posts( $args );
        $company_id = $posts_array[0]->ID;
        $plan = CFS()->get('plan',$company_id);
        foreach($plan as $plan_key => $plan_value){
          if($plan_key == 'ミニマム'){
            $all_nums = array(
                "general" => 75,
                "engineer" => 75,
            );
          }elseif($plan_key == 'スタンダード'){
            $all_nums = array(
                "general" => 120,
                "engineer" => 120,
            );
          }else{
            $all_nums = array(
                "general" => 75,
                "engineer" => 75,
            );
          }
        }
    }
    return $all_nums;
}

//１ヶ月に取得できるユーザーの情報を取得する(現在不使用)
function get_all_userinfo_num_per_month_func($user, $info_level){
    $user_roles=$user->roles;
    $all_nums = array(
        "general" => 0,
        "engineer" => 0,
    );
    //多い順に
    if(in_array("company", $user_roles)){
        switch ($info_level) {
            case 1:
                $all_nums = array(
                    "general" => 5,
                    "engineer" => 3,
                );
                break;
        }
    }else if(in_array("company", $user_roles)){
        switch ($info_level) {
        case 1:
            $all_nums = array(
                "general" => 3,
                "engineer" => 2,
            );
            break;
        }
    }
    return $all_nums;
}

//１ヶ月に取得することが出来る件数($meta_nameで場合分け)
function get_all_num_per_month_func($company, $meta_name){
    switch($meta_name){
        case 'remain-mail-num':
            return get_all_mail_num_per_month_func($company);
            break;
        case 'remain-view-num-lv1':
            return get_all_userinfo_num_per_month_func($company, 1);
            break;
    }
}


//現在不使用
function has_skill($user, $skill_type){
    switch ($skill_type) {
        case "engineer":
            if(count(get_user_meta($user->ID, 'programming_languages',true))>1){
                return true;
            }else{
                return false;
            }
            break;
        default:
            return false;
    }
}

//１ヶ月で使用できる件数の取得($meta_name(remain-mail-num(メールの件数),remain-view-num-lv(現在不使用)))
function get_remain_num_func($company,$meta_name){
    $company_id=$company->ID;
    //残り件数を$remain_numで取得($meta_nameで場合分け(remain-mail-num(メールの件数),remain-view-num-lv(現在不使用)))
    $remain_num=get_user_meta( $company_id, $meta_name, true);
    if($remain_num){
        return $remain_num;
    }else{
        add_user_meta($company_id, $meta_name, get_all_num_per_month_func($company,$meta_name));
        return get_user_meta( $company_id, $meta_name, true);
    }
}

//送信可能スカウトメールの件数の取得
function get_remain_mail_num_func($company){
    return get_remain_num_func($company,'remain-mail-num');
}

//獲得できるユーザー情報の数の取得(現在不使用)
function get_remain_userinfo_num_func($company, $info_level){
    return get_remain_num_func($company,'remain-view-num-lv'.$info_level);
}

//企業が使用できる件数の表示($meta_name(remain-mail-num(メールの件数),remain-view-num-lv(現在不使用)))
function view_remain_num_func($company,$meta_name){
    $vals=get_remain_num_func($company,$meta_name);
    $html='';
    $labels = array(
        "general" => '一般学生',
        "engineer" => 'エンジニア学生',
    );
    foreach ($vals as $key => $value){
        $html.='<div>'.$labels[$key].': '.$value.'件</div>';
    }
    return $html;
}

//送信可能スカウトメールの件数の表示
function view_remain_mail_num_func($company){
    return view_remain_num_func($company,'remain-mail-num');
}
//獲得できるユーザー情報の数の取得(現在不使用)
function view_remain_userinfo_num_func($company, $info_level){
    return view_remain_num_func($company,'remain-view-num-lv'.$info_level);
}

//残り件数を減少させる
function decrease_remain_num_func($company, $student, $meta_name, $num){
    $company_id = $company->ID;
    $remain_num = get_remain_num_func($company, $meta_name);
    if($remain_num){
        $scout_status = get_remain_num_for_stu_func($student,$meta_name);
        $remain_num[$scout_status['key']]-=$num;
        update_user_meta($company_id, $meta_name,$remain_num);
    }else{
    	return;
    }
}

//スカウトメールを送信したら残り件数を１件減らす
/*
function minus1_remain_mail_num_func( $contact_form ) {
    $url = $_SERVER['REQUEST_URI'];
    if(strpos($url,'scout_form') !== false){
        $submission = WPCF7_Submission::get_instance();
        if ( $submission ) {
            $posted_data = $submission->get_posted_data();
            $company=get_user_by('login',$posted_data['your-id']);
            $student=get_user_by('login',$posted_data['partner-id']);
            decrease_remain_num_func($company, $student,'remain-mail-num', 1);
        }
    }
}
add_action( 'wpcf7_mail_sent', 'minus1_remain_mail_num_func', 10, 1 );
*/

//企業の１ヶ月の可能件数をリセットする
function reset_remain_num_func($company, $meta_name){
    $company_id=$company->ID;
    delete_user_meta( $company_id, $meta_name);
    add_user_meta($company_id, $meta_name, get_all_num_per_month_func($company, $meta_name));
}

//企業の１ヶ月のスカウトメール送信可能件数をリセットする
function reset_remain_mail_num_func($user){
    return reset_remain_num_func($user, 'remain-mail-num');
}

//企業の１ヶ月のユーザー情報可能件数をリセットする(現在不使用)
function reset_remain_userinfo_num_func($user, $info_level){
    return reset_remain_num_func($user,'remain-view-num-lv'.$info_level);
}

//現在不使用
function reset_weall_remain_num_func($meta_name){
    date_default_timezone_set('Asia/Tokyo');
    if(!current_user_can('administrator') )  {
        return '実行する許可がありません。';
    }
    if(date("d")!=26)return '今日は実行できません。';
    if(date("H")!=19)return '今は実行できません。';

    echo $meta_name.'をリセットします。';
    $user_query = new WP_User_Query( array( 'role' => 'company' ) );
    if ( ! empty( $user_query->results ) ) {
        foreach ( $user_query->results as $user ) {
            echo '<p>' . $user->display_name . ': ';
            reset_remain_num_func($user, $meta_name);
            echo view_remain_num_func($user, $meta_name).'</p>';
        }
        echo 'リセット完了しました。';
    } else {
        echo '企業ユーザーが見つかりませんでした。';
    }
}

//現在不使用
function reset_weall_remain_mail_num_func(){
    return reset_weall_remain_num_func('remain-mail-num');
}
add_shortcode('reset_weall_remain_mail_num','reset_weall_remain_mail_num_func');

//現在不使用
function reset_weall_remain_userinfo_num_func($atts ) {
    extract( shortcode_atts( array(
        'info_level' => '',
    ), $atts ) );
    return reset_weall_remain_num_func('remain-view-num-lv'.$info_level);
}
add_shortcode('reset_weall_remain_userinfo_num','reset_weall_remain_userinfo_num_func');

function get_remain_num_for_stu_func($student, $meta_name){
    $remains = get_remain_num_func(wp_get_current_user(), $meta_name);
    $scout_status = array();
    $user_id = $student->ID;
    $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
    if(in_array('エンジニア',$future_occupations)){
        $scout_status['status']='エンジニア学生';
        $scout_status['remain']=$remains['engineer'];
        $scout_status['key']='engineer';
    }else{
        $scout_status['status']='一般学生';
        $scout_status['remain']=$remains['general'];
        $scout_status['key']='general';
    }
    return $scout_status;
}

//スカウトメールについてget_remain_num_for_stu_funcを実行
function get_remain_mail_num_for_stu_func($student){
    return get_remain_num_for_stu_func($student, 'remain-mail-num');
}

//学生の情報についてget_remain_num_for_stu_funcを実行(現在不使用)
function get_remain_userinfo_num_for_stu_func($student, $info_level){
    return get_remain_num_for_stu_func($student, 'remain-view-num-lv'.$info_level);
}

//現在不使用
function send_upgrade_userinfo_button_func($num) {
    $html='<form action = "https://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'" method = "post">
    <input type = "hidden" name ="action" value="upgrade">
    <input type = "hidden" name ="level" value="1">
    <input type = "submit" value ="この学生の情報表示をアップグレード（残り'.$num.'件）">
    </form>';
    return $html;
}
//add_shortcode('send_upgrade_userinfo_button','send_upgrade_userinfo_button_func');


//現在不使用
function get_info_level_for_stu_func($cuser,$student_login,$meta_name_users){
    $accessible_students=get_user_meta($cuser->ID, $meta_name_users,true);
    if(array_key_exists($student_login,$accessible_students)){
        return $accessible_students[$student_login];
    }
    return 0;
}

//現在不使用
function upgrade_userinfo_level_func( $atts ) {
    extract( shortcode_atts( array(
        'info_level' => '',
    ), $atts ) );

    if(empty($_GET['um_user'])){
        return '';
    }

    $student_login=$_GET['um_user'];
    $student=get_user_by('login',$student_login);
    $scout_status=get_remain_userinfo_num_for_stu_func($student, $info_level);
    $meta_name_users='accessible-students';
    $cuser=wp_get_current_user();
    $accessible_students=get_user_meta($cuser->ID, $meta_name_users,true);

    if($_GET['um_user']==$cuser->user_login){
        return '';
    }


    $lv_now=get_info_level_for_stu_func($cuser,$student_login,$meta_name_users);
    $html='現在の情報レベル： '.$lv_now.'<br>';

    if($_POST['action']!='upgrade' || empty($_POST['level'])){
        if($scout_status['remain']>0){
            return $html.send_upgrade_userinfo_button_func($scout_status['remain']);
        }else{
            return $html.'アップグレードの制限数を超えました。';
        }
    }
    $info_level= esc_sql($_POST['level']);

    if($lv_now>0){
        return $html.'アップグレード済みです。';
    }

    if($scout_status['remain']<1){
        return $html.'アップグレードの制限数を超えました。';
    }
    if($accessible_students){
        $accessible_students_updated=array_merge($accessible_students,array($student_login=>$info_level));
        update_user_meta($cuser->ID, $meta_name_users,$accessible_students_updated);
    }else{
        add_user_meta($cuser->ID, $meta_name_users,array($student_login=>$info_level));
    }

    $html.='アップグレードしました。';

    decrease_remain_num_func($cuser, $student,'remain-view-num-lv'.$info_level, 1);
    $html.='情報レベル：'.$info_level.'<br>';
    $html.=view_remain_userinfo_num_func($cuser, $info_level);
    return $html;
}
add_shortcode('upgrade_userinfo_level_by_post','upgrade_userinfo_level_func');


function scoutlink($umuser){
    $user=wp_get_current_user();
    $user_id=$user->ID;
    $umuser_id=$umuser->ID;
    if($user_id!=$umuser_id){
        return home_url('scoutform?user_name='. $umuser->user_login);
    }
}

function scoutform_func(){
    $user=wp_get_current_user();
    if(isset($_GET['pid'])){
        $pid= esc_sql($_GET['pid']);
    }else{
        return 'エラー';
    }
    $scout_status=get_remain_mail_num_for_stu_func(get_user_by('login',$pid));
    if($scout_status['remain']>0){
        $html='対象学生ステータス：'.$scout_status['status'].'<br>';
        $html.='[contact-form-7 id="1583" title="企業スカウトメール送信フォーム"]';
        $html.='現在の残り送信可能数'.view_remain_mail_num_func($user).'';
        return do_shortcode($html);
    }else{
        return '制限を超えたか、権限がありません。';
    }
}
add_shortcode('scoutform','scoutform_func');

function scout_mailbox_func(){
    $user=wp_get_current_user();
    $user_roles = $user->roles;
    $user_name=$user->full_name;
    $user_email=$user->user_email;
    $html="";
    if(in_array("company", $user_roles)){
        $html.=$user_name.'様が送信したスカウトメール';
        $html.=do_shortcode('[cfdb-html form="企業スカウトメール送信フォーム" show="Submitted,partner-id,partner-email,your-subject,your-message" filter="your-email='.$user_email.'" orderby="Submitted DESC"]
        {{BEFORE}} <table class="tbl02">
        <colgroup>
        <col width="8%" />
        <col width="12%" />
        <col width="20%" />
        <col width="20%" />
        <col width="40%" />
        </colgroup>
        <thead>
<tr><th>応募日時</th><th>送信先</th><th>送信先メールアドレス</th><th>題名</th><th>メッセージ</th></tr></thead><tbody>{{/BEFORE}}
        <tr>
            <td label="応募日時"><p>[submitted2str sbm="${Submitted}" format="Y/n/j G時i分"]</p></td>
            <td label="送信先"><p>${partner-id}</p></td>
            <td label="送信先メールアドレス"><p>${partner-email}</p></td>
            <td label="題名">
            <div style="height:100px; overflow:scroll;">
            <p>${your-subject}</p>
            </div>
            </td>
            <td label="メッセージ">
            <div style="height:100px; overflow:scroll;">
            <p>${your-message}</p>
            </div>
            </td>
			</tr>
  {{AFTER}}</tbody></table>{{/AFTER}}
  [/cfdb-html]');
        return $html;
    }elseif(in_array("student", $user_roles)){
        $html.=$user_name.'さんに届いているスカウトメール';
        $html.=do_shortcode('[cfdb-html form="企業スカウトメール送信フォーム" show="Submitted,your-name,your-id,your-email,your-subject,your-message" filter="partner-email='.$user_email.'" orderby="Submitted DESC"]
        {{BEFORE}}
        <table class="tbl02">
            <colgroup>
                <col width="8%" />
                <col width="12%" />
                <col width="20%" />
                <col width="20%" />
                <col width="40%" />
            </colgroup>
            <thead>
                <tr>
                    <th>企業名</th>
                    <th>応募日時</th>
                    <th>連絡先</th>
                    <th>題名</th>
                    <th>メッセージ</th>
                </tr>
            </thead>
            <tbody>{{/BEFORE}}
                <tr>
                    <td>
                        [get_company_logo_data field=login value="${your-id}"]
                    </td>
                    <td label="応募日時">
                        <p>[submitted2str sbm="${Submitted}" format="Y/n/j G時i分"]</p>
                    </td>
                    <td label="企業メールアドレス">
                        <p>${your-email}</p>
                    </td>
                    <td label="題名">
                        <div style="height:100px; overflow:scroll;">
                        <p>${your-subject}</p>
                        </div>
                    </td>
                    <td label="メッセージ">
                        <div style="height:100px; overflow:scroll;">
                        <p>${your-message}</p>
                        </div>
                    </td>
                </tr>{{AFTER}}
            </tbody>
        </table>{{/AFTER}}[/cfdb-html]');
        return $html;
    }
}
add_shortcode('scout_mailbox','scout_mailbox_func');

function get_company_logo_data($atts){
    extract( shortcode_atts( array(
      'field' => 'id',
      'value'=> '',
    ), $atts ) );

    $user = get_user_by($field,$value);
    $user_id = $user->data->ID;
    $user_meta = get_user_meta($user_id);
    $company_name = get_user_meta($user_id,"first_name",false)[0];
    $company = get_userdata($user_id);
    $company_id = get_company_id($company);
    $company_url = get_permalink($company_id);
    $company_image = get_field("企業ロゴ",$company_id);
    if(is_array($company_image)){
        $company_image_url = $company_image["url"];
    }else{
        $company_image_url = wp_get_attachment_url($company_image);
    }
    $company_logo_data = '
        <a href="'.$company_url.'" style="color:white">
            <p class="company-name">'.$company_name.'</p>
            <div><img src="'.$company_image_url.'" ></div>
        </a>
        ';
    return $company_logo_data;
}
add_shortcode('get_company_logo_data','get_company_logo_data');

//企業の送信可能スカウトメールをリセットする
function reset_company_remain_num_func(){
    $user_query = new WP_User_Query( array( 'role' => 'company' ) );
    if ( ! empty( $user_query->results ) ) {
        foreach ( $user_query->results as $user ) {
            reset_remain_mail_num_func($user);
        }
    }
}
add_action('reset_company_remain_num', 'reset_company_remain_num_func');

//wp-cronに月初めに更新するスケジュールを追加
function my_interval($schedules) {
    date_default_timezone_set( 'Asia/Tokyo' );
    //今の時刻を取得
    $dt_now = new DateTime('now');
    //翌月の１日の０時の時刻を取得
    $dt_next = new DateTime('midnight first day of next month');
    //$dtとdt_2の差を計算して、翌月の１日に発生するスケジュールを登録
    $d = $dt_next->diff($dt_now, true);
    $dt_array = get_object_vars($d);
    $day = $dt_array["d"] * 24 * 60 * 60;
    $hour = $dt_array["h"] * 60 * 60;
    $minutes = $dt_array["i"] * 60;
    $second = $dt_array["s"];
    $difftime = $day + $hour + $minutes + $second + 60;
    $schedules['Nextmonth'] = array(
        'interval' => $difftime,
        'display' => 'Nextmonth'
    );
    return $schedules;
}
add_filter('cron_schedules', 'my_interval' );

//イベントが登録されていなければ登録する
function my_activation_remain() {
    if(!wp_next_scheduled('reset_company_remain_num')){
        wp_schedule_event(time(), 'Nextmonth', 'reset_company_remain_num');
    }
}
add_action('wp', 'my_activation_remain');

/*
    イベント排除
    月によって日にちが異なるので、ページを開くたびにスケジュールの削除と登録をすることによって
    調整している。ちょっと重いかも
*/
function my_deactivation() {
    wp_clear_scheduled_hook('reset_company_remain_num');
}
register_deactivation_hook(__FILE__, 'my_deactivation');

?>