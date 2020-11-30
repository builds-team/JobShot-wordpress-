<?php

function import_template2_func($content)
{
  if (is_single() && !empty($GLOBALS['post'])) {
    if ($GLOBALS['post']->ID == get_the_ID()) {
      if (get_post_type() == 'event') {
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_event2_func($content);
        return $content;
      }
      if (get_post_type() == 'internship') {
        // if(is_user_logged_in()){
        if (!is_bot()) {
          setDayViews(get_the_ID());
          setWeekViews(get_the_ID());
          setPostViews(get_the_ID());
        }
        $content = do_shortcode('[header_mypage]').template_internship2_func($content);
        return $content;
        // }else{
        //   return apply_redirect();
        // }
      }
      if (get_post_type() == 'job') {
        if (is_user_logged_in()) {
          $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_job2_func($content);
          return $content;
        } else {
          return apply_redirect();
        }
      }
      if (get_post_type() == 'company') {
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_company_info2_func($content);
        return $content;
      }
      if (get_post_type() == 'summer_internship') {
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_summer_internship2_func($content);
        return $content;
      }
      if (get_post_type() == 'autumn_internship') {
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_autumn_internship2_func($content);
        return $content;
      }
      if (get_post_type() == 'column') {
        if (!is_bot()) {
          setDayViews(get_the_ID());
          setWeekViews(get_the_ID());
          setPostViews(get_the_ID());
        }
        $column_image_url = wp_get_attachment_image_src(14348, array(300, 2000))[0];
        $content = '<a href="' . $home_url . '/interview"><img class="special_contents_img wp-image-5404 aligncenter" src="' .$column_image_url. '"></a>';
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_column2_func($content);
        return $content;
      }
      if(get_post_type() == 'room'){
        $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').template_room_func($content);
        return $content;
      }
    }
  }
  $content = do_shortcode('[header_mypage]').do_shortcode('[header_tab]').$content;
}
add_filter('the_content', 'import_template2_func');

function view_terms_func($pid, $tax_slugs, $before = '', $sep = '', $after = '')
{
  $html = '';
  foreach ($tax_slugs as $tax_slug) {
    if ($tax_slug === reset($tax_slugs)) {
      $html .= $before;
    }
    $term_list = get_the_term_list($pid, $tax_slug, '<span class="card-category">', '</span><span class="card-category">', '</span>');
    $term_list = str_replace('/?', '/customsearch?sw=&itype=' . get_post_type($pid) . '&', $term_list);
    $html .= $term_list;
    if ($tax_slug === end($tax_slugs)) {
      $html .= $after;
    } else {
      $html .= $sep;
    }
  }
  return $html;
}

function add_top_bar($atts)
{
  extract(shortcode_atts(array(
    'item_type' => '',
  ), $atts));
  $home_url = esc_url(home_url());
  $title_array = array(
    'internship'  =>  '長期インターン',
    'job' =>  '新卒情報',
    'event' =>  'イベント',
    'column'  =>  '就活記事',
    'scout' =>  'スカウト',
    'entry-sheet' => 'エントリーシート'
  );
  $text_array = array(
    'internship'  =>  '業界トップクラスの高時給を誇る長期インターン案件を多数掲載中。<br>週２日～で実務のスキルを身につけ、周りの学生と差をつけよう。',
    'job' =>  '大手からベンチャーまで、幅広い業界での新卒求人案件を掲載中。<br>自分の理想的なキャリアを目指すあなたに最適な企業を紹介。',
    'event' =>  '企業説明会から就活対策セミナーまで、就活イベント情報が満載。<br>JobShotでトップレベルの就活を体感しよう！',
    'column'  =>  '就活で勝ち抜くために必要な情報や体験談が多数投稿されています。<br>就活初心者から選考中の人まで様々な人を対象にコンテンツを網羅。コラム記事を読んで万全の対策をしよう！',
    'scout' =>  '最大35項目から学生に直接アプローチするスカウト機能により、<br>「熱意×適性」を両立した、企業に最適な人材を獲得できます。',
    'entry-sheet' => '企業の選考フローで最初の関門となるエントリーシート。<br>項目別練習と実践チャレンジを活用して、確実に突破しよう！'
  );
  $img_array = array(
    'internship'  =>  '2020/02/photo-1552664730-d307ca884978.jpeg',
    'job' =>  '2020/02/photo-1462899006636-339e08d1844e.jpeg',
    'event' =>  '/2020/08/a6e05e90f056b494ab6a2267e5665da1.png',
    'column'  =>  '2020/02/photo-1555443712-22cd30585e5c.jpeg',
    'scout' =>  '2020/02/list-1925752_1920.jpg',
    'entry-sheet' => '2020/03/anders-jilden-TZCehSn-T-o-unsplash.jpg'
  );
  $html = '
  <div class="background-img-container">
      <img src="' . $home_url . '/wp-content/uploads/' . $img_array[$item_type] . '" alt="">
      <div class="background-img-text">
          <h1 class="font-serif">' . $title_array[$item_type] . '</h1>
          <p>' . $text_array[$item_type] . '</p>
      </div>
  </div>';
  return $html;
}
add_shortcode("add_top_bar", "add_top_bar");
