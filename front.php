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

function frontpage_search_func(){
    $tokyo = wp_get_attachment_image_src(14205, array(200,200))[0];
    $sibuya = wp_get_attachment_image_src(14200, array(200,150))[0];
    $shinjuku = wp_get_attachment_image_src(14201, array(200,150))[0];
    $chiyoda = wp_get_attachment_image_src(14204, array(200,150))[0];

    $marketing = wp_get_attachment_image_src(14196, array(200,150))[0];
    $consult = wp_get_attachment_image_src(14189, array(200,150))[0];
    $retail = wp_get_attachment_image_src(14199, array(200,150))[0];
    $kikaku = wp_get_attachment_image_src(14195, array(200,150))[0];
    $engineer = wp_get_attachment_image_src(14192, array(200,150))[0];
    $zimu = wp_get_attachment_image_src(14206, array(200,150))[0];
    $design = wp_get_attachment_image_src(14191, array(200,150))[0];
    $sonota = wp_get_attachment_image_src(14202, array(200,150))[0];

    $consulting = wp_get_attachment_image_src(14190, array(200,150))[0];
    $zinzai = wp_get_attachment_image_src(14207, array(200,150))[0];
    $money = wp_get_attachment_image_src(14198, array(200,150))[0];
    $syosya = wp_get_attachment_image_src(14203, array(200,150))[0];
    $advertise = wp_get_attachment_image_src(14188, array(200,150))[0];
    $it = wp_get_attachment_image_src(14194, array(200,150))[0];
    $house = wp_get_attachment_image_src(14193, array(200,150))[0];
    $media = wp_get_attachment_image_src(14197, array(200,150))[0];

    $html = 
        '    <div class="top__search">
        <h3 class="widget-title top__search_title">人気の求人検索</h3>
        <div class="top__search__container">
            <div class="top__search__wrap">
                <h4 class="top__search__wrap__title">エリアから探す</h4>
                <ul class="top__search__contents">
                    <li class="top__search__ele">
                      <span>東京</span>
                      <a href="https://jobshot.jp/internship?selective=on&area%5B%5D=%25e6%259d%25b1%25e4%25ba%25ac&sw=&itype=internship"><img src="'.$tokyo.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>渋谷区</span>
                      <a href="https://jobshot.jp/internship?selective=on&area%5B%5D=%25e6%25b8%258b%25e8%25b0%25b7%25e5%258c%25ba&sw=&itype=internship"><img src="'.$sibuya.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>新宿区</span>
                      <a href="https://jobshot.jp/internship?selective=on&area%5B%5D=%25e6%2596%25b0%25e5%25ae%25bf%25e5%258c%25ba&sw=&itype=internship"><img src="'.$shinjuku.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>千代田区</span>
                      <a href="https://jobshot.jp/internship?selective=on&area%5B%5D=%25e5%258d%2583%25e4%25bb%25a3%25e7%2594%25b0%25e5%258c%25ba&sw=&itype=internship"><img src="'.$chiyoda.'" alt="" class="only-pc"></a>
                    </li>
                </ul>
            </div>
            <div class="top__search__wrap">
                <h4 class="top__search__wrap__title">職種から探す</h4>
                <ul class="top__search__contents">
                    <li class="top__search__ele">
                      <span>マーケティング</span>
                      <a href="https://jobshot.jp/internship?selective=on&selective=on&occupation%5B%5D=marketer&sw=&itype=internship"><img src="'.$marketing.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>コンサル</span>
                      <a href="https://jobshot.jp/internship?selective=on&occupation%5B%5D=consulting&sw=&itype=internship"><img src="'.$consult.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>営業</span>
                      <a href="https://jobshot.jp/internship?selective=on&occupation%5B%5D=sales&sw=&itype=internship"><img src="'.$retail.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>企画</span>
                      <a href="https://jobshot.jp/internship?selective=on&occupation%5B%5D=planning&sw=&itype=internship"><img src="'.$kikaku.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>エンジニア</span>
                      <a href="https://jobshot.jp/internship?selective=on&occupation%5B%5D=engineer&sw=&itype=internship"><img src="'.$engineer.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>事務</span>
                      <a href="https://jobshot.jp/internship?selective=on&occupation%5B%5D=corporate_staff&sw=&itype=internship"><img src="'.$zimu.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>デザイナー</span>
                      <a href="https://jobshot.jp/internship?occupation%5B%5D=designer&sw=&itype=internship"><img src="'.$design.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>その他</span>
                      <a href="https://jobshot.jp/internship?occupation%5B%5D=others&sw=&itype=internship"><img src="'.$sonota.'" alt="" class="only-pc"></a>
                    </li>
                </ul>
            </div>
            <div class="top__search__wrap">
                <h4 class="top__search__wrap__title">業種から探す</h4>
                <ul class="top__search__contents">
                    <li class="top__search__ele">
                      <span>コンサルティング</span>
                      <a href="https://jobshot.jp/internship?selective=on&business_type%5B%5D=consult&sw=&itype=internship"><img src="'.$consulting.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>人材</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=hr&sw=&itype=internship"><img src="'.$zinzai.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>金融</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=fin&sw=&itype=internship"><img src="'.$money.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>商社</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=trad&sw=&itype=internship"><img src="'.$syosya.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>広告</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=adv&sw=&itype=internship"><img src="'.$advertise.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>IT</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=it&sw=&itype=internship"><img src="'.$it.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>不動産</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=real_estate&sw=&itype=internship"><img src="'.$house.'" alt="" class="only-pc"></a>
                    </li>
                    <li class="top__search__ele">
                      <span>メディア</span>
                      <a href="https://jobshot.jp/internship?business_type%5B%5D=media&sw=&itype=internship"><img src="'.$media.'" alt="" class="only-pc"></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>';

    return $html;
}
add_shortcode('frontpage_search','frontpage_search_func');
?>