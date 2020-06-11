<?php
function frontpage_view_pickups_func(){
    $html='';
    $pickups=get_field('ピックアップ１');
    foreach($pickups as $pickup){
        $html.=view_card_func($pickup->ID);
    }
    return $html;
  }
  add_shortcode('view_pickups','frontpage_view_pickups_func');

  function builds_loginform_func(){

   return do_shortcode(' [wpmem_form login redirect_to="http://mysite.com/my-page/"]');
  }
  add_shortcode('builds_loginform','builds_loginform_func');

  function view_top_intern_card_func(){
    $item_type = "internship";
    $args = array(
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
        'meta_key' => 'day_views_count',
        'orderby' => 'meta_value_num',
        'order'=>'DESC',
        'showposts'=>10
    );
    $posts = get_posts($args);

    $card_html = '<div class="cards-container">';
    // $card_html .= view_fullwidth_intern_card_func(7382);
    // $card_html .= view_fullwidth_intern_card_func(6635);

    foreach($posts as $post){
        $post_id = $post->ID;
        // if($post_id != 7382 and $post_id != 6635){
          $card_html .= view_fullwidth_intern_card_func($post_id);
        // }
    }
    $card_html .= '</div>';
    $home_url =esc_url( home_url( ));
    $card_html .= '<p style="text-align: right; text-decoration: underline;"><a href="'.$home_url.'/internship">長期インターン案件をもっと見る</a></p>';
    $card_html .= '
    <div class="intern__intro">
      <h3 class="widget-title intern__intro__head">長期インターンとは</h3>
      <div class="card intern__intro__container">
          <div class="intern__intro__title">
              <span class="intern__intro__title__icon google-icon"></span>
              <h4 class="">長期インターンとは？</h4>
          </div>
          <p class="intern__intro__text">
              長期インターンとは、「有給で長期間（約6ヵ月以上）実際のビジネスの現場で就業すること」です。 <br>社員とほとんど変わらない基準で働くことが求められており、実務経験やスキルを早い段階で身に付けることが期待できます。
              <a href="https://jobshot.jp/column/11621" class="intern__intro__link">選考・勤務のコツ</a>
          </p>
          <div class="intern__intro__title">
              <span class="intern__intro__title__icon google-icon"></span>
              <h4 class="">長期インターンシップって何をするの？</h4>
          </div>
          <p class="intern__intro__text">
              長期インターンで携われる仕事の種類は様々です。営業、マーケティング、ライター/編集のようなビジネス職の募集もあれば、特定の分野に関するスキルを持っている場合、エンジニアやWebデザイナーといった専門職に参加する学生もいます。
              <a href="https://jobshot.jp/column/11614" class="intern__intro__link">職種・勤務環境</a>
          </p>
          <div class="intern__intro__title">
              <span class="intern__intro__title__icon google-icon"></span>
              <h4 class="">長期インターンについて詳しく教えて！</h4>
          </div>
          <p class="intern__intro__text">
              長期インターンについてさらに詳しく知りたい方は、こちらの記事をご覧ください。数々の学生の長期インターン選びをサポートしたJobShot社員が、長期インターンに関してよくある質問に答えています。
              <a href="https://jobshot.jp/column/11595" class="intern__intro__link">概要・メリット</a>
          </p>
      </div>
    </div>';
    return do_shortcode($card_html);
  }
add_shortcode('view-top-intern-card','view_top_intern_card_func');
?>