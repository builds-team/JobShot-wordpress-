<?php
function my_esc_sql($str){
    return mb_ereg_replace('(_%#)', '#¥1', $str);
}
//////////////////カスタム検索////////////////////////////////////////

function get_view_get_values($getq, $getname, $view){
    $getv = '';
    if (isset($_GET[$getq])) {
            $getv = $_GET[$getq];
        if ($getv[0] == '0' ){
            array_splice($getv, 0, 1);
        }
    }
    return $getv;
}

function view_recommend_func(){
    $result_html='';
    if (isset($_GET['itype'])) {
        $item_type = my_esc_sql($_GET['itype']);
    } else {
        $item_type = get_post_type();
    }
    $ocs = get_the_terms(get_the_ID(), 'occupation');
    $occupation=array();
    foreach($ocs as $oc){
        array_push($occupation, $oc->term_id);
    }

    $bts = get_the_terms(get_the_ID(), 'business_type');
    $business_type=array();
    foreach($bts as $bt){
        array_push($business_type, $bt->term_id);
    }
  $args=array(
        'orderby' => 'rand',
        'posts_per_page' => 3,
        'paged' => 1,
        'post_type' => array($item_type),
        'post__not_in' => array( get_the_ID()) ,
        'post_status' => array( 'publish' ),
        'tax_query' =>array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'occupation',
                'field' => 'id',
                'terms' => $occupation,
                'include_children' => true,
                'operator' => 'IN',
            ),
            array(
                'taxonomy' => 'business_type',
                'field' => 'id',
                'terms' => $business_type,
                'include_children' => true,
                'operator' => 'IN',
            )
        )
    );
    $query = new WP_Query($args);
    $matching_category_ids = array();


    if ($item_type == 'company' || $item_type == 'internship' || $item_type == 'event') {
        $result_html.= '<div class="cards-container companies-container">';
    while ($query->have_posts()): $query->the_post();
        array_push($matching_category_ids, $post->ID);
        $result_html.= view_card_func($post->ID);
    endwhile;
        $result_html.= '</div>';
    } else {
    //  $result_html.= 'no';
    }
    return $result_html;
}
add_shortcode('view_recommend', 'view_recommend_func');

function view_custom_search_func($atts){
    extract(shortcode_atts(array(
        'item_type' => '',
        'style' => '',
        'num_items' => '100',
        'occupation'=>'',
        'sort' => '',
    ), $atts));

    global $post;

    if ($item_type=='' && isset($_GET['itype'])) {
        $item_type = my_esc_sql($_GET['itype']);
    }

    $posts_per_page = 10;
    $page_no = get_query_var('paged')? get_query_var('paged') : 1;
    $reccomend=false;

    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $page_no,
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
    );

    if (!empty($_GET['sw'])) {
        $keyword = my_esc_sql($_GET['sw']);
        $args += array('s' => $keyword);
    }
    if(isset($_GET["feature"])){
        $features = $_GET["feature"];
        foreach($features as $feature){
            $metaquerysp[] = array('key'=>'特徴','value'=> $feature,'compare'=>'LIKE');
        }
        if (!empty($_GET['sw'])) {
            $keyword = my_esc_sql($_GET['sw']);
            //$metaquerysp[] = array('key'=>'author_displayname','value'=> $keyword,'compare'=>'LIKE');
        }
        $args += array('meta_query' => $metaquerysp);
    }
    if($item_type=="event"){
        //$args += array('orderby' => 'meta_value','meta_key' => '開催日','order'   => 'DESC','meta_query' => array('value' => date('Y/m/d'),'compare' => '>=','type' => 'DATE'));
        $args += array('meta_key' => '開催日','orderby' => 'meta_value','order'=> 'DESC',);
    }
    //新卒投稿をしている企業のみを取得
    if($item_type=="company"){
        $args1=array('post_type' => array('job'),'posts_per_page' => -1);
        $job_posts=get_posts($args1);
        $author_id = array();
        foreach($job_posts as $job_post){
            if (!in_array($job_post->post_author, $author_id)) {
                $author_id[]= $job_post->post_author;
            }
        }
        $args += array('author__in'=>$author_id,);
    }
    //コラムのカテゴリー取得
    if($item_type=="column"){
        if(isset($_GET["first_category"])){
            $first_category = $_GET["first_category"];
            $first_category_metaquery = array('key'=>'first_category','value'=> $first_category,'compare'=>'LIKE');
            $args += array('meta_query' => array($first_category_metaquery));
        }
        if(isset($_GET["second_category"])){
            $second_category = $_GET["second_category"];
            $second_category_metaquery = array('key'=>'second_category','value'=> $second_category,'compare'=>'LIKE');
            $args += array('meta_query' => array($second_category_metaquery));
        }
    }

    if($item_type=="related_column"){
        $post_id = $post->ID;
        $column_post_id = $post->ID;
        $args['post_type'] = array('column');
        $args['posts_per_page'] = 5;
        $first_category_values = CFS()->get('first_category',$post_id);
        foreach ($first_category_values as $first_category_value => $first_category_label) {
            $first_category = $first_category_value;
        }
        $first_category_metaquery = array('key'=>'first_category','value'=> $first_category,'compare'=>'LIKE');
        $args += array('meta_query' => array($first_category_metaquery));
        $args += array('meta_key' => 'post_views_count','orderby' => 'meta_value_num',);
    }

    // 業種のタクソノミーは企業情報に基づいているので該当する企業投稿を検索→authorに追加
    if (!empty($_GET['business_type'])) {
        if($item_type!="company"){
            $args2=array('post_type' => array('company'),'posts_per_page' => -1);
            $tax_obj2=get_taxonomy('business_type');
            $terms2= get_view_get_values('business_type',$tax_obj2->labels->name,true);
            $taxq2 = array('relation' => 'AND',);
            array_push($taxq2, array(
                'taxonomy' => 'business_type',
                'field' => 'slug',
                'terms' => $terms2,
                'include_children' => true,
                'operator' => 'IN',
            ));
            $args2 += array('tax_query' => $taxq2);
            $company_posts=get_posts($args2);
            $author_id2 = array();
            foreach($company_posts as $company_post){
                if (!in_array($company_post->post_author, $author_id2)) {
                    $author_id2[]= $company_post->post_author;
                }
            }
            $args+=array('author__in'=>$author_id2,);
        }
    }

    $tax_query = array('relation' => 'AND',);
    $tax_slugs = array('occupation','area','business_type');
    foreach ($tax_slugs as $tax_slug){
        if(!($tax_slug =='business_type' and ($item_type=="internship" or $item_type=="summer_internship" or $item_type=="autumn_internship"))){
            $tax_obj = get_taxonomy($tax_slug);
            $terms = get_view_get_values($tax_slug,$tax_obj->labels->name,true);
            if(!empty($terms)){
                array_push($tax_query, array(
                    'taxonomy' => $tax_slug,
                    'field' => 'slug',
                    'terms' => $terms,
                    'include_children' => true,
                    'operator' => 'IN',
                ));
            }
        }
    }
    $args += array('tax_query' => $tax_query);

    if (isset($_GET['sort'])) {
        $sort = my_esc_sql($_GET['sort']);
        switch($sort){
            case 'popular':
                $args += array('meta_key' => 'week_views_count','orderby' => 'meta_value_num',);
                break;
            case 'new':
                $args += array('order'   => 'DESC','orderby' => 'modified',);
                break;
            case 'recommend':
            	unset($args['posts_per_page']);
            	$args += array(
                	'posts_per_page' => -1,
            	);
                break;
        }
    }else{
        if($item_type == 'internship'){
            $args += array('meta_key' => 'week_views_count','orderby' => 'meta_value_num',);
        }
    }

    if($sort == 'recommend'){
    	$cat_query = recommend_score($args);
    }else{
        $cat_query = new WP_Query($args);
    }
    if($item_type == "column"){
        $html = '';
        if(isset($_GET["first_category"])){
            $first_category_column_array = array(
                'internship' => '長期インターン',
                'beginner' => '就活初心者向けコンテンツ',
                'industry' => '業界研究',
                'selection' => '選考ステップ別対策',
                'your_contents' => '自分にあったコンテンツを探す',
                'career_plan' => 'キャリアプランを考える',
                'after_contents' => '内定者向けコンテンツ',
                'other_contents' => 'その他のコンテンツ',
            );
            $first_category = $_GET["first_category"];
            $column_search_first_category = $first_category_column_array[$first_category];
            if(!empty($column_search_first_category)){
                $home_url =esc_url( home_url());
                $html .= '
                <div class="column_navigation_bar">
                    <span>
                        <a href="'.$home_url.'/column">
                            <span>コラム記事トップ</span>
                        </a>
                    </span>
                    <i class="fa fa-angle-right"></i>
                    <span>
                        <a href="'.$home_url.'/column?first_category='.$first_category.'">
                            <span>'.$column_search_first_category.'</span>
                        </a>
                    </span>
                </div>';
                $html .= '<h2 class="column_search_category">『'.$column_search_first_category.'』の記事一覧</h2>';
            }
        }elseif(isset($_GET["second_category"])){
            $second_category_column_array = array(
                'columm' => 'コラム',
                'experience' => '体験記',
                'basic_knowledge' => '就活の基礎知識',
                'schedule' => '就活スケジュール',
                'entry_sheet' => 'エントリーシート',
                'test' => '筆記試験・WEBテスト',
                'discussion' => 'グループディスカッション',
                'interview' => '面接',
                'case_interview' => 'ケース面接・フェルミ推定',
                'internship' => 'インターンシップ・ジョブ',
                'recruiter' => 'OB訪問・リクルーター',
                'english' => '英語・TOEIC対策',
                'consulting'=>'コンサル',
                'trading_company'=>'商社',
                'mfr'=>'メーカー',
                'fin'=>'金融（銀行・証券・保険）',
                'real_estate'=>'不動産',
                'adv'=>'広告・出版・マスコミ',
                'infrastructure'=>'インフラ',
                'internet'=>'インターネット・通信',
                'government'=>'官公庁',
                'venture'=>'ベンチャー企業',
                'others_industry'=>'その他',
                'science' => '理系学生',
                'female_student' => '女子学生',
                'athlete' => '体育会系',
                'graduate' => '大学院生',
                'aboroad' => '留学経験者',
                'foreign_capital' => '外資系のキャリア',
                'japanese_company' => '日系大手のキャリア',
                'venture' => 'ベンチャー企業のキャリア',
                'others' => 'その他のキャリア',
                'after' => '内定後にやるべきこと',
            );
            $second_category = $_GET["second_category"];
            $column_search_second_category = $second_category_column_array[$second_category];
            $second_to_first_category_column_array = array(
                'columm' => 'internship',
                'experience' => 'internship',
                'basic_knowledge' => 'beginner',
                'schedule' => 'beginner',
                'entry_sheet' => 'selection',
                'test' => 'selection',
                'discussion' => 'selection',
                'interview' => 'selection',
                'case_interview' => 'selection',
                'internship' => 'selection',
                'recruiter' => 'selection',
                'english' => 'selection',
                'consulting'=>'industry',
                'trading_company'=>'industry',
                'mfr'=>'industry',
                'fin'=>'industry',
                'real_estate'=>'industry',
                'adv'=>'industry',
                'infrastructure'=>'industry',
                'internet'=>'industry',
                'government'=>'industry',
                'venture'=>'industry',
                'others_industry'=>'industry',
                'science' => 'your_contents',
                'female_student' => 'your_contents',
                'athlete' => 'your_contents',
                'graduate' => 'your_contents',
                'aboroad' => 'your_contents',
                'foreign_capital' => 'career_plan',
                'japanese_company' => 'career_plan',
                'venture' => 'career_plan',
                'others' => 'career_plan',
                'after' => 'after_contents',
            );
            $first_category = $second_to_first_category_column_array[$second_category];
            $first_category_column_array = array(
                'internship' => '長期インターン',
                'beginner' => '就活初心者向けコンテンツ',
                'industry' => '業界研究',
                'selection' => '選考ステップ別対策',
                'your_contents' => '自分にあったコンテンツを探す',
                'career_plan' => 'キャリアプランを考える',
                'after_contents' => '内定者向けコンテンツ',
                'other_contents' => 'その他のコンテンツ',
            );
            $column_search_first_category = $first_category_column_array[$first_category];
            if(!empty($column_search_second_category)){
                $html .= '
                <div class="column_navigation_bar">
                    <span>
                        <a href="'.$home_url.'/column">
                            <span>コラム記事トップ</span>
                        </a>
                    </span>
                    <i class="fa fa-angle-right"></i>
                    <span>
                        <a href="'.$home_url.'/column?first_category='.$first_category.'">
                            <span>'.$column_search_first_category.'</span>
                        </a>
                    </span>
                    <i class="fa fa-angle-right"></i>
                    <span>
                        <a href="'.$home_url.'/column?second_category='.$second_category.'">
                            <span>'.$column_search_second_category.'</span>
                        </a>
                    </span>
                </div>';
                $html .= '<h2 class="column_search_category">『'.$column_search_second_category.'』の記事一覧</h2>';
            }

        }else{
            $html .= '<h2 class="column_search_category">新着記事一覧</h2>';
        }
    }else{
        $html = '<div class="cards__container__container">';
        $html .= paginate($cat_query->max_num_pages, get_query_var( 'paged' ), $cat_query->found_posts, $posts_per_page);
        if($item_type == "event" || $item_type = "related_column"){
            $html = '';
        }
    }
    $html .= '<div class="cards-container">';
    //損保ジャパンのイベントを先頭に持っていく
    if($item_type == "event"){
        $post_id = '11779';
        $status = get_post_status($post_id);
        //公開中のときに、１ページ目の一番上に表示
        if($status == 'publish'  && get_query_var( 'paged' ) == ''){
            try {
                $html .= view_card_func($post_id);
            } catch (Exception $e) {
                $html .= '';
            } 
        }
    }
    $post_count = 0;
    while ($cat_query->have_posts()): $cat_query->the_post();
        $post_id = $post->ID;
        if($post_id != $column_post_id){
            $html .= view_card_func($post_id);
            $post_count += 1;
            if($item_type == 'internship' && $post_count == 4){
                $chiyoda = wp_get_attachment_image_src(14204, array(250,150))[0];
                $marketing = wp_get_attachment_image_src(14196, array(250,150))[0];
                $retail = wp_get_attachment_image_src(14199, array(250,150))[0];
                $zimu = wp_get_attachment_image_src(14206, array(250,150))[0];
                $sonota = wp_get_attachment_image_src(14202, array(250,150))[0];
                $it = wp_get_attachment_image_src(14194, array(250,150))[0];
                $house = wp_get_attachment_image_src(14193, array(250,150))[0];
                $media = wp_get_attachment_image_src(14197, array(250,150))[0];
                $banner_url = wp_get_attachment_image_src(15473, array(1000, 150))[0];
                $html .= '
                <div class="" style="margin-top:30px;  display: flex; align-items: flex-start;">
                    <img class="" src="' . $banner_url . '" style="margin-top:40px align-items: flex-start;">
                </div>
                <div class="top__search__container top__feature__search__container">
                <div class="top__search__wrap">
                    <h4 class="top__search__wrap__title">自分にあった募集を「特徴」から探そう</h4>
                    <ul class="top__search__contents">
                        <li class="top__search__ele">
                          <span>リモートワーク可能</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E3%83%AA%E3%83%A2%E3%83%BC%E3%83%88%E3%83%AF%E3%83%BC%E3%82%AF%E5%8F%AF%E8%83%BD&itype=internship"><noscript><img src="'.$zimu.'" alt class="only-pc"></noscript><img src="'.$zimu.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$zimu.'"></a>
                        </li>
                        <li class="top__search__ele">
                          <span>プログラミング未経験</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0%E3%81%8C%E6%9C%AA%E7%B5%8C%E9%A8%93%E3%81%8B%E3%82%89%E5%AD%A6%E3%81%B9%E3%82%8B&itype=internship"><noscript><img src="'.$it.'" alt class="only-pc"></noscript><img src="'.$it.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$it.'"></a>
                        </li>
                        <li class="top__search__ele">
                          <span>時給1200円以上</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E6%99%82%E7%B5%A61200%E5%86%86%E4%BB%A5%E4%B8%8A&itype=internship"><noscript><img src="'.$marketing.'" alt class="only-pc"></noscript><img src="'.$marketing.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$marketing.'"></a>
                        </li>
                        <li class="top__search__ele">
                          <span>土日のみでも可</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E5%9C%9F%E6%97%A5%E3%81%AE%E3%81%BF%E3%81%A7%E3%82%82%E5%8F%AF%E8%83%BD&itype=internship"><noscript><img src="'.$house.'" alt class="only-pc"></noscript><img src="'.$house.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$house.'"></a>
                        </li>
                        <li class="top__search__ele">
                          <span>週２日OK</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E9%80%B12%E6%97%A5ok&itype=internship"></noscript><img src="'.$chiyoda.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$chiyoda.'"></a>
                        </li>
                        <li class="top__search__ele">
                          <span>社長直下</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E7%A4%BE%E9%95%B7%E7%9B%B4%E4%B8%8B&itype=internship"><noscript><img src="'.$retail.'" alt class="only-pc"></noscript><img src="'.$retail.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$retail.'"></a>
                        </li>
                        <li class="top__search__ele only-pc">
                          <span>1.2年生歓迎</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=1%2C2%E5%B9%B4%E6%AD%93%E8%BF%8E&itype=internship"><noscript><img src="'.$sonota.'" alt class="only-pc"></noscript><img src="'.$sonota.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$sonota.'"></a>
                        </li>
                        <li class="top__search__ele only-pc">
                          <span>英語力が身に付く</span>
                          <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E8%8B%B1%E8%AA%9E%E5%8A%9B%E3%81%8C%E8%BA%AB%E3%81%AB%E3%81%A4%E3%81%8F&itype=internship"><noscript><img src="'.$media.'" alt class="only-pc"></noscript><img src="'.$media.'" alt="" class="only-pc lazyloaded" data-src="'.$media.'"></a>
                        </li>
                    </ul>
                </div>
              </div>';
            }
        }
    endwhile;
    $html .= '</div>';
    $html .= '</div>';
    if($item_type != 'related_column'){
        $html .= paginate($cat_query->max_num_pages, get_query_var( 'paged' ), $cat_query->found_posts, $posts_per_page);
    }  
   	wp_reset_postdata();
    return $html;
}
add_shortcode('view_custom_search', 'view_custom_search_func');

function recommend_score($args){
    $cat_query=new WP_Query($args);
    $posts=get_posts( $args );
    $posts_c=count($posts);
  	$cat_query->found_posts=$posts_c;
    $cat_query->max_num_pages=ceil($posts_c/10);
    $sort=array();
    $score=0;
  	if(is_user_logged_in()){
    	$future_occupations = get_user_meta(wp_get_current_user()->ID,'future_occupations',false)[0];
	}
    foreach($posts as $post){
        $post_id = $post->ID;
        $occupation=get_the_terms( $post_id, 'occupation' )[0]->name;
    	$score = get_post_meta($post_id, 'recommend_score', true);
        if(in_array($occupation,$future_occupations)){
            $score+=50;
        }else{
        }
        $sort[]=$score;
	}
    array_multisort($sort, SORT_DESC, SORT_NUMERIC, $posts);
    $paged = 0 == get_query_var( 'paged', 0 ) ? 1 : get_query_var( 'paged', 1 );
    $cat_query->posts=array_slice($posts, ($paged-1)*10,$paged*10);
    return $cat_query;
}

function koukoku_intern(){
    $post_ids = [1111111,22222222];
    foreach($post_ids as $post_id){
        $view_count = get_post_meta($post_id, 'week_views_count', true);
        $view_count += 10000;
        update_post_meta($post_id, $custom_key, $view_count);
    }
}

//おすすめの点数の詳細表示用。使い終わったら非常に処理が重くなるのですぐに元に戻す。
/* function recommend_score($args){
    $cat_query=new WP_Query($args);
    $posts=get_posts( $args );
    $posts_c=count($posts);
  	$cat_query->found_posts=$posts_c;
    $cat_query->max_num_pages=ceil($posts_c/10);
    $sort=array();
    $score=0;
    $score1=array();
    $score2=array();
    $score3=array();
  	if(is_user_logged_in()){
    	$future_occupations = get_user_meta(wp_get_current_user()->ID,'future_occupations',false)[0];
	}
    foreach($posts as $post){
        $post_id = $post->ID;*/
        //$score1[]+=(20-(int)do_shortcode(' [cfdb-count form="/インターン応募.*/" filter="job-id='.$post_id.'"]'))*6;
        /*$score2[]+=(int)get_post_meta($post_id, 'week_views_count', true)*4;
        $occupation=get_the_terms( $post_id, 'occupation' )[0]->name;
    	$score = get_post_meta($post_id, 'recommend_score', true);
        if(in_array($occupation,$future_occupations)){
            $score+=50;
            $score3[]+=50;
        }else{
		  	$score3[]+=0;
        }
        $sort[]=$score;
	}
    array_multisort($sort, SORT_DESC, SORT_NUMERIC, $posts,$score1,$score2,$score3);
    print_r($score1);
    print_r($score2);
    print_r($score3);
    print_r($sort);
    $paged = 0 == get_query_var( 'paged', 0 ) ? 1 : get_query_var( 'paged', 1 );
    $cat_query->posts=array_slice($posts, ($paged-1)*10,$paged*10);
    return $cat_query;
} */


?>
