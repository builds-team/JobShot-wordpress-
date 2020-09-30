<?php

function template_event2_func($content){
    global $post;
    date_default_timezone_set('Asia/Tokyo');

    $home_url =esc_url( home_url( ));
    $post_id = $post->ID;
    $event_type= get_field('イベントタイプ',$post_id);
    $capacity = get_field('定員',$post_id);
    preg_match('/[0-9]+/',$capacity,$result);
    $capacity = (int)$result[0];
    $capacity += 10;
    $participant_num = do_shortcode(' [cfdb-count form="/イベント応募*/" filter="job-id='.$post_id.'"]');

    $accesses=textarea2array(get_field('交通案内',$post_id));
    $access_html='<div>';
    foreach($accesses as $access){
        $access_html.=  '<div><i class="fas fa-train"></i>'.$access.'</div>';
    }
    $access_html.='</div>';

    $sankas=textarea2array(get_field('参加企業',$post_id));
    $sanka_company_link_array=textarea2array(get_field('参加企業注釈',$post_id));
    $sanka_company_logo_link_array=textarea2array(get_field('参加企業ロゴリンク',$post_id));
    if($sanka_company_logo_link_array){
        $sanka_html='<div class="company-logo-box">';
        foreach($sankas as $key => $sanka){
            $sanka_company_link = $sanka_company_link_array[$key];
            $sanka_html.=  '
                <div class="company-logo event-logo-width">
                    <a href="'.$sanka_company_link.'">
                        <img src="'.$sanka_company_logo_link_array[$key].'">
                    </a>
                    <p class="small-font-size"><i class="fas fa-building"></i> '.$sanka.'</p>
                </div>';
        }
        $sanka_html.='</div>';
    }else{
        $sanka_html='<div>';
        foreach($sankas as $key => $sanka){
            $sanka_company_link = $sanka_company_link_array[$key];
            $sanka_html.=  '<div><a href="'.$sanka_company_link.'"><i class="fas fa-building" style="color:#03c4b0;"></i> '.$sanka.'</a></div>';
        }
        $sanka_html.='</div>';
    }

    $contents=textarea2array(get_field('コンテンツ',$post_id));
    if($contents[0]=='' && count($contents)==1){
        $contents_html=NULL;
    }else{
        $contents_html='<ul>';
        foreach($contents as $acontent){
            $contents_html.=  '<li>'.$acontent.'</li>';
        }
        $contents_html.='</ul>';
    }

    $schedule=textarea2array(get_field('スケジュール',$post_id));
    $schedule_html='<ul>';
    foreach($schedule as $sch){
        $schedule_html.=  '<li>'.$sch.'</li>';
    }
    $schedule_html.='</ul>';

    $event_image = get_field("イメージ画像",$post_id);
    $event_image_url = $event_image["url"];
    $event_name = get_field('イベント名',$post_id);

    $event_date = get_field('開催日時',$post_id);
    $event_due_date = get_field('申込締切日時',$post_id);
    $points=textarea2array(get_field('イベントのポイント',$post_id));
    $event_due_date = str_replace('年', '-', $event_due_date);
    $event_due_date = str_replace('月', '-', $event_due_date);
    $event_due_date = str_replace('日', '', $event_due_date);
    $event_due_date .= ':00';
    $points_html = '';

    $points=textarea2array(get_field('イベントのポイント',$post_id));
    $points_html = '';
    foreach($points as $point){
	    $points_html.= '<div class="card-category">'.$point.'</div><br>';
    }

    $student_voice = get_field('過去参加者の声',$post_id);
    if(!empty($student_voice)){
        $student_voice_html = '
        <section>
            <h2 class="maintitle">過去参加者の声</h2>
            <div class="sectionVoice">
                <div class="sectionVoice__img">
                    <img src="'.$home_url.'/wp-content/uploads/2020/02/1544077817-1.png" alt="">
                </div>
                <div class="sectionVoice__comment">
                    <p class="sectionVoice__ttl">早稲田大学・文系</p>
                    <p class="sectionVoice__txt">これからのキャリアを考える上で、参考になる話ばかりを聞けました。また就活だけでなく、入社後に心がけるべき考え方を学べて良かったです。</p>
                </div>
            </div>
            <div class="sectionVoice">
                <div class="sectionVoice__img">
                    <img src="'.$home_url.'/wp-content/uploads/2020/02/1544077823-1.png" alt="">
                </div>
                <div class="sectionVoice__comment">
                    <p class="sectionVoice__ttl">東京理科大学・理系</p>
                    <p class="sectionVoice__txt">フィードバックをしっかりもらえて良かったです。とても楽しく就活に役立ち勉強になるイベントでした。</p>
                </div>
            </div>
        </section>
        ';
    }
    if(strtotime($event_due_date)>strtotime('now')){
        if($event_type == "job"){
            $entry_html = '
            <div class="fixed-buttom">
                <a href="[get_form_address formtype=apply form_id=2489 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>
            </div>';
        }elseif($event_type == "internship"){
            $entry_html = '
            <div class="fixed-buttom">
                <a href="[get_form_address formtype=apply form_id=897 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>
            </div>';
        }else{
            $entry_html = '
            <div class="fixed-buttom">
                <a href="[get_form_address formtype=apply form_id=897 post_id='.$post->ID.' title='.$post->post_title.']">
                    <button class="button button-apply">イベントに応募する</button>
                </a>
            </div>';
        }
    }else{
        $entry_html = '<a>申し込み受付終了</a>';
    }
    if($capacity < $participant_num){
        $entry_html = '<a>定員に達したため締め切りました</a>';
    }
    // ベイカレント用
    if($post_id == 7554){
        $entry_html = '
        <div class="fixed-buttom">
            <a href="[get_form_address formtype=apply form_id=7552 post_id='.$post->ID.' title='.$post->post_title.']">
                <button class="button button-apply">イベントに応募する</button>
            </a>
        </div>';
    }
    // 就活無双塾用
    if($post_id == 7842){
        $entry_html = '
        <div class="fixed-buttom">
            <a href="[get_form_address formtype=apply form_id=7848 post_id='.$post->ID.' title='.$post->post_title.']">
                <button class="button button-apply">イベントに応募する</button>
            </a>
        </div>';
    }
    // スカイライト用
    if($post_id == 8505){
        $entry_html = '
        <div class="fixed-buttom">
            <a href="https://job.axol.jp/gs/c/skylight/entry_5715120011/agreement">
                <button class="button button-apply">イベントに応募する</button>
            </a>
        </div>';
    }
    // メルカリ用
    if($post_id == 9484){
        $entry_html = '
        <div class="fixed-buttom">
            <a href="https://jobshot.jp/?page_id=9777">
                <button class="button button-apply">イベントに応募する</button>
            </a>
        </div>';
    }


    // ミダス
    if($post_id == 15171){
        $entry_html = '
        <div class="fixed-buttom">
            <a href="https://jobshot.jp/?page_id=15359">
                <button class="button button-apply">イベントに応募する</button>
            </a>
        </div>';
    }
    $area_html = '';
    if(!empty(get_field('開催場所名',$post_id))){
        $area_html .= '<div>'.get_field('開催場所名',$post_id).'</div>';
    }
    if(!empty(get_field('開催場所住所',$post_id))){
        $area_html .= '<div>'.get_field('開催場所住所',$post_id).'</div>';
    }
    if(!empty($access_html)){
        $area_html .= $access_html;
    }
    $map_html = do_shortcode('[acf type=area name=開催場所の地図]');
    if(!empty($map_html)){
        $area_html .= '<div class="respiframe">'.$map_html.'</div>';
    }

    $user = wp_get_current_user();
    $user_login = $user->data->user_login;
    $event_apply_value = do_shortcode('[cfdb-count form="/イベント応募.*/" filter="job-id='.$post_id.'&&your-id='.$user_login.'"]');
    if($event_apply_value > 0){
        $entry_html = '<a>申し込み済み</a>';
    }

    if(!empty(get_field('概要',$post_id))){
        $table_body_html .= add_to_table('概要', '<div>'.get_field('概要',$post_id).'</div>');
    }
    if(!empty(get_field('開催日時',$post_id))){
        $table_body_html .= add_to_table('開催日時', '<div>'.$event_date.'</div>');
    }
    if(!empty(get_field('開催場所名',$post_id))){
        $table_body_html.=add_to_table('場所', $area_html);
    }
    if(!empty(get_field('募集対象',$post_id))){
        $table_body_html.=add_to_table('募集対象', get_field('募集対象',$post_id));
    }
    if(!empty(get_field('定員',$post_id))){
        $table_body_html.=add_to_table('定員', get_field('定員',$post_id));
    }
    if(!empty(get_field('参加費',$post_id))){
        $table_body_html.=add_to_table('参加費', get_field('参加費',$post_id));
    }
    if(!empty($sankas)){
        $table_body_html.=add_to_table('参加企業', $sanka_html);
    }
    if(!empty(get_field('コンテンツ',$post_id))){
        $table_body_html.=add_to_table('コンテンツ', get_field('コンテンツ',$post_id));
    }
    if(!empty(get_field('スケジュール',$post_id))){
        $table_body_html.=add_to_table('スケジュール', get_field('スケジュール',$post_id));
    }
    if(!empty(get_field('持ち物',$post_id))){
        $table_body_html.=add_to_table('持ち物', get_field('持ち物',$post_id));
    }
    if(!empty(get_field('報酬',$post_id))){
        $table_body_html.=add_to_table('報酬',get_field('報酬',$post_id));
    }
    if(!empty(get_field('開催期間',$post_id))){
        $table_body_html.=add_to_table('開催期間',get_field('開催期間',$post_id));
    }
    if(!empty(get_field('申込締切日時',$post_id))){
        $table_body_html.=add_to_table('申込締切',get_field('申込締切日時',$post_id));
    }
    if(!empty(get_field('備考',$post_id))){
        $table_body_html.=add_to_table('備考', get_field('備考',$post_id));
    }

    $html='
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .datalist dt:before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            padding-right: 15px;
            color: #03c4b0;
            }
            .table th {
            width: 25%;
            text-align: left
        }
        .table td, .table th {
            border-bottom: 2px solid #f0f0f0
        }
        .table td {
            padding: 12px 0 13px
        }
        @media screen and (min-width:768px) {
            .table {
                width: 100%
            }
        }
    </style>
    <section>
        <h2 class="event-title">'.$event_name.'</h2>
        <img class="event__image" src="'.$event_image_url.'">
        <div class="card-category-container event">'.$points_html.'</div>
        <div>'.$content.'</div>
    </section>
    <section>
        <table class="demo01">
            <tbody>'.$table_body_html.'</tbody>
        </table>
    </section>
    '.$student_voice_html.$entry_html;

  return do_shortcode($html);
}
?>