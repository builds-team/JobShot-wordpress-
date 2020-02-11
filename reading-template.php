<?php

function import_template2_func( $content ) {
    if( is_single() && ! empty( $GLOBALS['post'] ) ) {
        if ( $GLOBALS['post']->ID == get_the_ID() ) {
          if( get_post_type() =='event' ) {
            if(is_user_logged_in()){
              $content = template_event2_func($content);
              return $content;
            }else{
              global $post;
              $post_id = $post->ID;
              if($post_id == 9146){
                $content = template_event2_func($content);
                return $content;
              }else{
                return apply_redirect();
              }
            }
          }
          if( get_post_type() == 'internship' ) {
            if(is_user_logged_in()){
              if( !is_bot() ){
                setDayViews(get_the_ID());
                setWeekViews(get_the_ID());
                setPostViews(get_the_ID());
              }
              $content = template_internship2_func($content);
              return $content;
            }else{
              return apply_redirect();
            }
          }
          if( get_post_type() == 'job' ) {
            if(is_user_logged_in()){
              $content = template_job2_func($content);
              return $content;
            }else{
              return apply_redirect();
            }
          }
          if( get_post_type() == 'company' ) {
            $content=template_company_info2_func($content);
            return $content;
          }
          if( get_post_type() == 'summer_internship' ) {
            $content=template_summer_internship2_func($content);
            return $content;
          }
          if( get_post_type() == 'autumn_internship' ) {
            $content=template_autumn_internship2_func($content);
            return $content;
          }
          if( get_post_type() == 'column' ) {
            $content=template_column2_func($content);
            return $content;
          }
        }
    }
    return $content;
}
add_filter('the_content', 'import_template2_func');

function view_terms_func($pid, $tax_slugs,$before='',$sep='',$after=''){
  $html='';
  foreach($tax_slugs as $tax_slug){
	 if ($tax_slug === reset($tax_slugs)) {
	   $html.=$before;
	 }
   $term_list=get_the_term_list($pid, $tax_slug, '<span class="card-category">', '</span><span class="card-category">','</span>');
	   $term_list=str_replace('/?', '/customsearch?sw=&itype='.get_post_type($pid).'&',$term_list);
$html.=$term_list;
		 if ($tax_slug === end($tax_slugs)) {
		   $html.=$after;
		 }else{
		   $html.=$sep;
		 }
  }
return $html;
}

function add_top_bar($atts){
  extract(shortcode_atts(array(
    'item_type' => '',
  ), $atts));
  $home_url =esc_url( home_url());
  $title_array = array(
    'internship'  =>  '長期インターン',
    'job' =>  '新卒情報',
    'event' =>  'イベント',
    'column'  =>  '就活記事',
    'scout' =>  'スカウト'
  );
  $text_array = array(
    'internship'  =>  '業界No.1の高時給を誇る長期インターン案件を多数掲載中。<br>週２日～で働けるから大学生活との両立も簡単です。自分が興味のある案件に応募して、就活に向けての第一歩を踏み出そう。',
    'job' =>  '大手企業からベンチャー企業まで、様々な業界で活躍する企業の新卒求人案件を掲載中。<br>自分の理想的なキャリアを歩んでいきたいあなたにとって最適な企業を紹介します。',
    'event' =>  '企業説明からワークショップ、就活対策セミナーまで、就活で周りと差をつけられるイベント情報が満載です。<br>『JobShot』限定の選考パスもご用意しており、トップレベルの学生と切磋琢磨したい方は必見です。',
    'column'  =>  '就活で勝ち抜くために必要な情報や体験談が多数投稿されています。<br>就活初心者から選考中の人まで様々な人を対象にコンテンツを網羅。コラム記事を読んで万全の対策をしよう！',
    'scout' =>  ''
  );
  $img_array = array(
    'internship'  =>  '2020/02/photo-1552664730-d307ca884978.jpeg',
    'job' =>  '2020/02/photo-1462899006636-339e08d1844e.jpeg',
    'event' =>  '2020/02/photo-1544264747-d8af8eb09999.jpeg',
    'column'  =>  '2020/02/photo-1555443712-22cd30585e5c.jpeg',
    'scout' =>  ''
  );
  $html = '
  <div class="background-img-container">
      <img src="'.$home_url.'/wp-content/uploads/'.$img_array[$item_type].'" alt="">
      <div class="background-img-text">
          <h1 class="font-serif">'.$title_array[$item_type].'</h1>
          <p>'.$text_array[$item_type].'</p>
      </div>
  </div>';
  return $html;
}
add_shortcode("add_top_bar","add_top_bar");

?>