<?php

function add_thankspage(){
    global $post;
    if(isset($_GET["job_id"])){
        $job_id = $_GET["job_id"];
        $formname='インターン応募';
        try{
        $applycnt=do_shortcode(' [cfdb-value form="/'.$formname.'.*/" filter="job-id='.$job_id.'" function="count"]');
        update_post_meta($job_id, "applycnt", $applycnt);
        }catch(Exception $e){
            
        }
    }
    $args = array(
        'posts_per_page' => 6,
        'paged' => 1,
        'post_type' => array('internship'),
        'post_status' => array( 'publish' ),
    );
    $args += array('meta_key' => 'week_views_count','orderby' => 'meta_value_num',);
    $cat_query = new WP_Query($args);
    $count = 0;
    $card_html = '';
    while ($cat_query->have_posts()): $cat_query->the_post();
        $post_id = $post->ID;
        if($post_id != $job_id){
            $card_html .= view_card_func($post_id);
            $count += 1;
        }
        if($count == 5){
            break;
        }
        endwhile;
    $home_url =esc_url( home_url( ));
    $intern_card = do_shortcode('[view_custom_search item_type=internship posts_per_page="3"]');
    $html = '
    <h1 style="text-align: center;"><strong>Thank you!</strong></h1>
    <p style="text-align: center;">ご応募ありがとうございました。</p>
    <p style="text-align: center;">ご登録済みのメールアドレスに応募完了のメールが送信されているかご確認ください。</p>
    <div class="thankyou-main">
        <div class="reccomend-internship">
            <p>外資内定者による過去問に基づく面接対策により、</p>
            <p>合格率<span class="emphasis-number">50</span>％以上UP！<br>面接対策に応募してみよう！</p>
            <a href="'.$home_url.'/interview" class="btn-flat-border">面接対策に応募する</a>
        </div>
        <hr>
        <div class="after-flow-internship">
            <h2>長期インターンの合格率は20％以下！？</h2>
            <figure><img src="'.$home_url.'/wp-content/uploads/2019/09/f40e747caf1794220abe699050de4df7_s_upscaled_image_x4.jpg" alt=""></figure>
            <div>
                <p>長期インターンを申し込んだあとは、</p>
                <ol>
                    <li>学生のプロフィールを元に1次選考が行われる</li>
                    <li>選考に通った学生のみ、企業から面接日程を提示される</li>
                    <li>面接を行い、採用の可否を決定する</li>
                </ol>
                <p>といった流れで選考が進んでいきます。</p>
            </div>
            <p>過去、長期インターンに合格した学生の割合は20％を下回っているため、<span class="emphasis-text">短期間で採用決定されるためにプロフィールの充実と複数インターンへ応募</span>するようにしましょう！</p>
            <p>また、<span class="emphasis-text">合格率が約30％UP</span>する面接対策も行なっています！過去の面接での質問事項を元に設計されているので、ぜひ参加して事前に面接で気をつけるポイントなどを押さえておきましょう！</p>
            <div class="thankyou-next">
                <p><a href="'.$home_url.'/user" class="btn-flat-border-white">プロフィールを充実させる</a></p>
                <p><a href="'.$home_url.'/internship" class="btn-flat-border-white">他のインターンを探す</a></p>
                <p><a href="'.$home_url.'/interview" class="btn-flat-border-white">面接対策を行う</a></p>
            </div>
        </div>
        <div class="after-flow-internship">
            <h2>人気の長期インターン</h2>
        </div>
    </div>
        <div class="cards-container">
        '.$card_html.'
        </div>

    ';
    return $html;
}
add_shortcode("add_thankspage","add_thankspage");

?>
