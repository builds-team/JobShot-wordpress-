<?php

function view_favorite_list_func ( $atts ) {
    extract(shortcode_atts(array(
      'type' => '',
    ),$atts));

    if($_GET){
      $post_id = $_GET['pid'];
      $mode = $_GET['mode'];
    }

    if(get_post_type($post_id)=='internship'){
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'インターン応募';
        $attendformname = 'インターン出席登録';
        $favorite_users = get_post_meta($post_id,'favorite',true);
    }else{
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'イベント応募';
        $attendformname = 'イベント出席登録';
        $favorite_users = get_users_who_favorited_post($post_id);
    }

    $f=false;
    $f=is_this_my_content($post_id);

    $html .= '
    <font size="2">
        <table class="tbl02">
            <thead>
                <tr>
                    <th></th>
                    <th>大学</th>
                    <th>性別</th>
                    <th>学年</th>
                    <th>卒業年度</th>
                    <th>スカウト</th>
                </tr>
            </thead>
            <tbody>';
    foreach($favorite_users as $favorite_user){
        if(get_post_type($post_id)=='internship'){
            $user_id = $favorite_user;
            $f = get_user_by('ID',$favorite_user);
            $user_name = $f->data->display_name;
            $user_email = $f->data->user_email;
            $user_login_name = $f->data->user_login;
            $user_info = '
            <a href="/user?um_user='.$user_login_name.'" style="color:white">
                <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
                <div>'.get_avatar($user_id).'</div>
            </a>';
            $university = get_univ_name($f).'<br>'.get_faculty_name($f);
            $gender = get_user_meta($user_id,'gender',false)[0][0];
            $school_year = get_user_meta($user_id,'school_year',false)[0];
            $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
            $sta=get_remain_mail_num_for_stu_func($f);
            $scout = '<a href="'.scoutlink($f).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';
        }else{
            $user_id = $favorite_user->data->ID;
            $user_name = $favorite_user->data->display_name;
            $user_email = $favorite_user->data->user_email;
            $user_login_name = $favorite_user->data->user_login;
            $user_info = '
            <a href="/user?um_user='.$user_login_name.'" style="color:white">
                <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
                <div>'.get_avatar($user_id).'</div>
            </a>';
            $university = get_univ_name($favorite_user).'<br>'.get_faculty_name($favorite_user);
            $gender = get_user_meta($user_id,'gender',false)[0][0];
            $school_year = get_user_meta($user_id,'school_year',false)[0];
            $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
            $sta=get_remain_mail_num_for_stu_func($favorite_user);
            $scout = '<a href="'.scoutlink($favorite_user).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';
        }
        if (current_user_can('administrator')){
            $scout .= '<br><p>'.$user_email.'</p>';
        }

        $html .= '<tr>
                    <th>'.$user_info.'</th>
                    <td label="大学">'.$university.'</td>
                    <td label="性別">'.$gender.'</td>
                    <td label="学年">'.$school_year.'</td>
                    <td label="卒業年度">'.$graduate_year.'</td>
                    <td label="スカウト">'.$scout.'</td>
                </tr>';
    }
    $html .= '
            </tbody>
        </table>
    </font>
    ';
    $roles=wp_get_current_user()->roles;
    $result_html = '<div class="cards-container">';
    if(in_array("company", $roles) ){
        $result_html .= '<form action="./scout_form" method="POST">';
    }
    foreach($favorite_users as $favorite_user){
        if(get_post_type($post_id)=='internship'){
            $user_id = $favorite_user;
        }else{
            $user_id = $favorite_user->data->ID;
        }
        $user = get_user_by("id",$user_id);
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
        $bussiness_types = get_user_meta($user_id,'bussiness_type',false)[0];
        $types_html = '';
        if(isset($bussiness_types)) {
            foreach($bussiness_types as $type) {
                if ($type === end($bussiness_types)) {
                    $types_html .= $type;
                }else{
                    $types_html .= $type.'/';
                }
            }
        }
        $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
        if(mb_strlen($self_internship_PR) > 100){
            $self_internship_PR = mb_substr(nl2br($self_internship_PR),0,100).'...';
            }
        $last_login = get_user_meta($user_id,'_um_last_login',false);
        $last_login_date = date('Y年m月d日',$last_login[0]).'<br>'.date('H時i分',$last_login[0]);
        $job_html = '';
        foreach($future_occupations as $future_occupation){
            if ($future_occupation === end($future_occupations)) {
                $job_html .= $future_occupation;
            }else{
                $job_html .= $future_occupation.'/';
            }
        }
        $email = get_user_by("id",$user_id)->data->user_email;
        $image_date = date("YmdHis");
        $upload_dir = wp_upload_dir();
        $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
        $profile_score = get_user_meta( $user_id, 'user_profile_total_score',false)[0];
        if(!file_exists($upload_file_name)){
            $photo = get_avatar($user_id);
        }
        else{
            $photo = '<img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar avatar-search lazyloaded scout__image__img">'; 
        }

        $user_graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        if(!empty($user_graduate_year)){
            $user_graduate_year = substr(strval($user_graduate_year),2,2).'卒';
        }
        if(in_array("company", $roles)){
            $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
            $user_name = $user->data->user_login;
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            if($scout_status["remain"]>0){
                $scout_html = '
                <div class="scout__check">
                    <div class="scout__check__wrap"><input type="checkbox" name="user_ids[]" value="'.$user_id.'" class="checkbox"><span></span></div>
                </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span></span>','<span>スカウト済み</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }else{
                $scout_html = '
                    <div class="scout__check">
                        <div class="scout__check__wrap"><span>上限に達しています</span></div>
                    </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span>上限に達しています</span>','<span>スカウト済み</br></br>上限に達しています</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }
        }else {
            $status_html = '<div class="card scout__card">';
            $scout_html = '
        ';
        }

        if( in_array("administrator", $roles) ){
            $mail_html = '<div class="scout__content scout__content_s scout__mail-field"><p>'.$email.'</p></div>';
            $touch_html = '<div class="scout__content scout__content_s"><a href="'.student_contact_form_link($user).'">接触記録を入力</a></div>';
        }
        $result_html .= '
            '.$status_html.'
                <div class="full-card-main scout__card__main">
                    <div class="scout__image">
                        <div class="scout__image__wrap">
                            <a href="/user?um_user='.$user->user_login.'" class="">
                                <div class="scout__image__container">
                                    <div class="scout__image__img__container"><noscript>'.$photo.'</noscript>'.$photo.'</div>
                                    <div class="scout__prof-score only-pc">'.$profile_score.'</div>
                                    <div class="scout__prof__base only-sp">
                                        <div class="scout__prof-score">
                                            <span class="scout__prof-score-num">'.$profile_score.'</span>
                                            <span class="scout__prof-score-text">Profile Score</span>
                                        </div>
                                        <p class="scout__name">'.esc_html( $user->user_login ) .'</p>
                                    </div>
                                </div>
                            </a>
                            <a href="/user?um_user='.$user->user_login.'" class="only-pc"><p class="scout__name">'.esc_html( $user->user_login ) .'</p></a>
                        </div>
                    </div>
                    <div class="scout__text">
                        <div class="scout__text__wrap">
                            <div class="scout__content scout__univ"><p>'.esc_html( get_univ_name($user)). esc_html( get_faculty_name($user)).'</p></div>
                            <div class="scout__content scout__content_s scout__base"><p>'.$gender.'/'.$user_graduate_year.'</p></div>
                            <div class="scout__content scout__content_s scout__occupations"><p>'.$job_html.'</p></div>
                            <div class="scout__content scout__content_s scout__business-field"><p>'.$types_html.'</p></div>
                            '.$mail_html.$touch_html.'
                            <div class="scout__content scout__pr"><p>'.$self_internship_PR.'</p></div>
                        </div>
                    </div>
                </div>
                '.$scout_html.'
            </div>
        ';
    }
    if(in_array("company", $roles)){
        $result_html .= '
        <div class="fixed-buttom hidden">
            <button class="button button-apply">まとめてスカウトメールを送る</button>
        </div></form>';
    }
    return $result_html;
}
add_shortcode('view_favorite_list','view_favorite_list_func');

function view_favorite_list_from_post_func ( $post_id ) {

    if($_GET){
    //   $post_id = $_GET['pid'];
      $mode = $_GET['mode'];
    }

    if(get_post_type($post_id)=='internship'){
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'インターン応募';
        $attendformname = 'インターン出席登録';
        $favorite_users = get_post_meta($post_id,'favorite',true);
    }else{
        $html = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
        $formname = 'イベント応募';
        $attendformname = 'イベント出席登録';
        $favorite_users = get_users_who_favorited_post($post_id);
    }

    $f=false;
    $f=is_this_my_content($post_id);

    $html .= '
    <font size="2">
        <table class="tbl02">
            <thead>
                <tr>
                    <th></th>
                    <th>大学</th>
                    <th>性別</th>
                    <th>学年</th>
                    <th>卒業年度</th>
                    <th>スカウト</th>
                </tr>
            </thead>
            <tbody>';
    foreach($favorite_users as $favorite_user){
        if(get_post_type($post_id)=='internship'){
            $user_id = $favorite_user;
        }else{
            $user_id = $favorite_user->data->ID;
        }
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
        $bussiness_types = get_user_meta($user_id,'bussiness_type',false)[0];
        $types_html = '';
        if(isset($bussiness_types)) {
            foreach($bussiness_types as $type) {
                if ($type === end($bussiness_types)) {
                    $types_html .= $type;
                }else{
                    $types_html .= $type.'/';
                }
            }
        }
        $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
        if(mb_strlen($self_internship_PR) > 100){
            $self_internship_PR = mb_substr(nl2br($self_internship_PR),0,100).'...';
            }
        $last_login = get_user_meta($user_id,'_um_last_login',false);
        $last_login_date = date('Y年m月d日',$last_login[0]).'<br>'.date('H時i分',$last_login[0]);
        $job_html = '';
        foreach($future_occupations as $future_occupation){
            if ($future_occupation === end($future_occupations)) {
                $job_html .= $future_occupation;
            }else{
                $job_html .= $future_occupation.'/';
            }
        }
        $email = get_user_by("id",$user_id)->data->user_email;
        $image_date = date("YmdHis");
        $upload_dir = wp_upload_dir();
        $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
        $profile_score = get_user_meta( $user_id, 'user_profile_total_score',false)[0];
        if(!file_exists($upload_file_name)){
            $photo = get_avatar($user_id);
        }
        else{
            $photo = '<img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar avatar-search lazyloaded scout__image__img">'; 
        }

        $user_graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        if(!empty($user_graduate_year)){
            $user_graduate_year = substr(strval($user_graduate_year),2,2).'卒';
        }
        if(in_array("company", $roles)){
            $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
            $user_name = $user->data->user_login;
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            if($scout_status["remain"]>0){
                $scout_html = '
                <div class="scout__check">
                    <div class="scout__check__wrap"><input type="checkbox" name="user_ids[]" value="'.$user_id.'" class="checkbox"><span></span></div>
                </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span></span>','<span>スカウト済み</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }else{
                $scout_html = '
                    <div class="scout__check">
                        <div class="scout__check__wrap"><span>上限に達しています</span></div>
                    </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span>上限に達しています</span>','<span>スカウト済み</br></br>上限に達しています</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }
        }else {
            $status_html = '<div class="card scout__card">';
            $scout_html = '
        ';
        }

        if( in_array("administrator", $roles) ){
            $mail_html = '<div class="scout__content scout__content_s scout__mail-field"><p>'.$email.'</p></div>';
            $touch_html = '<div class="scout__content scout__content_s"><a href="'.student_contact_form_link($user).'">接触記録を入力</a></div>';
        }
        $result_html .= '
            '.$status_html.'
                <div class="full-card-main scout__card__main">
                    <div class="scout__image">
                        <div class="scout__image__wrap">
                            <a href="/user?um_user='.$user->user_login.'" class="">
                                <div class="scout__image__container">
                                    <div class="scout__image__img__container"><noscript>'.$photo.'</noscript>'.$photo.'</div>
                                    <div class="scout__prof-score only-pc">'.$profile_score.'</div>
                                    <div class="scout__prof__base only-sp">
                                        <div class="scout__prof-score">
                                            <span class="scout__prof-score-num">'.$profile_score.'</span>
                                            <span class="scout__prof-score-text">Profile Score</span>
                                        </div>
                                        <p class="scout__name">'.esc_html( $user->user_login ) .'</p>
                                    </div>
                                </div>
                            </a>
                            <a href="/user?um_user='.$user->user_login.'" class="only-pc"><p class="scout__name">'.esc_html( $user->user_login ) .'</p></a>
                        </div>
                    </div>
                    <div class="scout__text">
                        <div class="scout__text__wrap">
                            <div class="scout__content scout__univ"><p>'.esc_html( get_univ_name($user)). esc_html( get_faculty_name($user)).'</p></div>
                            <div class="scout__content scout__content_s scout__base"><p>'.$gender.'/'.$user_graduate_year.'</p></div>
                            <div class="scout__content scout__content_s scout__occupations"><p>'.$job_html.'</p></div>
                            <div class="scout__content scout__content_s scout__business-field"><p>'.$types_html.'</p></div>
                            '.$mail_html.$touch_html.'
                            <div class="scout__content scout__pr"><p>'.$self_internship_PR.'</p></div>
                        </div>
                    </div>
                </div>
                '.$scout_html.'
            </div>
        ';
    }
    $result_html.= paginate( $num_pages, $current_page, $total_users, $users_per_page);
    if(in_array("company", $roles)){
        $result_html .= '
        <div class="fixed-buttom hidden">
            <button class="button button-apply">まとめてスカウトメールを送る</button>
        </div></form>';
    }
    $result_html .= '</div>';
    foreach($favorite_users as $favorite_user){
        if(get_post_type($post_id)=='internship'){
            $user_id = $favorite_user;
            $f = get_user_by('ID',$favorite_user);
            $user_name = $f->data->display_name;
            $user_email = $f->data->user_email;
            $user_login_name = $f->data->user_login;
            $user_info = '
            <a href="/user?um_user='.$user_login_name.'" style="color:white">
                <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
                <div>'.get_avatar($user_id).'</div>
            </a>';
            $university = get_univ_name($f).'<br>'.get_faculty_name($f);
            $gender = get_user_meta($user_id,'gender',false)[0][0];
            $school_year = get_user_meta($user_id,'school_year',false)[0];
            $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
            $sta=get_remain_mail_num_for_stu_func($f);
            $scout = '<a href="'.scoutlink($f).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';
        }else{
            $user_id = $favorite_user->data->ID;
            $user_name = $favorite_user->data->display_name;
            $user_email = $favorite_user->data->user_email;
            $user_login_name = $favorite_user->data->user_login;
            $user_info = '
            <a href="/user?um_user='.$user_login_name.'" style="color:white">
                <p>'.$user_name.'<br><font size="1">'.$user_login_name.'</font></p>
                <div>'.get_avatar($user_id).'</div>
            </a>';
            $university = get_univ_name($favorite_user).'<br>'.get_faculty_name($favorite_user);
            $gender = get_user_meta($user_id,'gender',false)[0][0];
            $school_year = get_user_meta($user_id,'school_year',false)[0];
            $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
            $sta=get_remain_mail_num_for_stu_func($favorite_user);
            $scout = '<a href="'.scoutlink($favorite_user).'">'.$sta['status'].'<br>スカウトする（残り'.$sta['remain'].'件）</a>';
        }

        $html .= '<tr>
                    <th>'.$user_info.'</th>
                    <td label="大学">'.$university.'</td>
                    <td label="性別">'.$gender.'</td>
                    <td label="学年">'.$school_year.'</td>
                    <td label="卒業年度">'.$graduate_year.'</td>
                    <td label="スカウト">'.$scout.'</td>
                </tr>';
    }
    $html .= '
            </tbody>
        </table>
    </font>
    ';
    return $html;
}
add_shortcode('view_favorite_list_from_post','view_favorite_list_from_post_func');

?>