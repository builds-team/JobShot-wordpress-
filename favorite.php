<?php
function add_wpfp_func(){
      return get_favorites_button(get_the_ID());
}
add_shortcode("add_favorite","add_wpfp_func");



function show_favorites_func($atts){
    extract(
        shortcode_atts(
            array(
                'item_type' => '',
            ), $atts
        )
    );
    $user_name = $_GET['um_user'];
    $user = get_user_by('login',$user_name);
    $user_id = $user->ID;
    $fav_html='';
    $favorites = get_user_favorites();
    var_dump($favorites);
    if($item_type == 'internship' || 'column'){
        $favorites = array();
        $meta_query_args = array(
            'relation' => 'AND', // オプション、デフォルト値は "AND"
        );
        $fav_meta_query = array('relation' => 'OR');
        array_push($fav_meta_query, array(
            'key'       => 'favorite',
            'value'     => $user_id,
            'compare'   => 'LIKE'
        ));
        array_push($meta_query_args, $fav_meta_query);
        $args = array(
            'post_type' => array($item_type),
            'post_status' => array( 'publish'),
            'posts_per_page' => -1,
            'meta_query'   => $meta_query_args,
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
              $the_query->the_post();
              $post_id = get_the_ID();
              $fav_array = get_post_meta($post_id,'favorite',true);
              if(in_array($user_id,$fav_array)){
                $favorites[] = $post_id;
              }

            endwhile;
        endif;
    }
    if (isset($favorites) && !empty($favorites)){
        $fav_html.='<div class="cards-container">';
        $fav_count = 0;
        foreach ($favorites as $favorite){
            if(get_post_type($favorite)==$item_type){
                $fav_html.=view_card_func($favorite);
                $fav_count += 1;
            }
        }
        if($fav_count == 0){
            $fav_html .= '<p class="text-center">お気に入りがありません。</p>'; 
        }
        $fav_html.='</div>';
    }else{
        // No Favorites
        $fav_html= '<div class="cards-container"><p class="text-center">お気に入りがありません。</p></div>';
    }
    $fav_html = str_replace('<p>','<p style="font-size: 13px;">',$fav_html);
    $fav_html = str_replace('<h3 id="column__card__title__text">','<h3 id="column__card__title__text" style="font-size: 17px;">',$fav_html);
    return $fav_html;
}
add_shortcode("show_favorites","show_favorites_func");


function view_intern_fav_count(){
    $args = array(
        'post_type' => array('internship'),
        'post_status' => array( 'publish'),
        'posts_per_page' => -1,
    );
    $the_query = new WP_Query($args);
    $count = 0;
    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
          $the_query->the_post();
          $post_id = get_the_ID();
          $fav_array = get_post_meta($post_id,'favorite',true);
          //favを増やす時
          $count += count($fav_array);
        endwhile;
      endif;
    echo 'internのfav数は'.$count.'<br>';
    wp_reset_postdata();
}
add_shortcode("view_intern_fav_count","view_intern_fav_count");

function view_column_fav_count(){
    $args = array(
        'post_type' => array('column'),
        'post_status' => array( 'publish'),
        'posts_per_page' => -1,
    );
    $the_query = new WP_Query($args);
    $count = 0;
    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
          $the_query->the_post();
          $post_id = get_the_ID();
          $fav_array = get_post_meta($post_id,'favorite',true);
          //favを増やす時
          $count += count($fav_array);
        endwhile;
      endif;
    echo 'columnのfav数は'.$count.'<br>';
    wp_reset_postdata();
}
add_shortcode("view_column_fav_count","view_column_fav_count");

function view_mypage_fav(){
    $user_name = $_GET['um_user'];
    $user = get_user_by('login',$user_name);
    $user_id = $user->ID;
    if(get_current_user_id() == $user_id || current_user_can('administrator')){
        $fav_html='';
        $item_types = ['company','event','internship','column'];
        $html_fav_card = array();
        foreach($item_types as $item_type){
            $favorites = get_user_favorites();
            if($item_type == 'internship' || 'column'){
                $favorites = array();
                $meta_query_args = array(
                    'relation' => 'AND', // オプション、デフォルト値は "AND"
                );
                $fav_meta_query = array('relation' => 'OR');
                array_push($fav_meta_query, array(
                    'key'       => 'favorite',
                    'value'     => $user_id,
                    'compare'   => 'LIKE'
                ));
                array_push($meta_query_args, $fav_meta_query);
                $args = array(
                    'post_type' => array($item_type),
                    'post_status' => array( 'publish'),
                    'posts_per_page' => -1,
                    'meta_query'   => $meta_query_args,
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) :
                      $the_query->the_post();
                      $post_id = get_the_ID();
                      $fav_array = get_post_meta($post_id,'favorite',true);
                      if(in_array($user_id,$fav_array)){
                        $favorites[] = $post_id;
                      }
                    endwhile;
                endif;
            }
            if (isset($favorites) && !empty($favorites)){
                $fav_html='<div class="cards-container">';
                $fav_count = 0;
                foreach ($favorites as $favorite){
                    if(get_post_type($favorite)==$item_type){
                        $fav_html.=view_card_func($favorite);
                        $fav_count += 1;
                    }
                }
                if($fav_count == 0){
                    $fav_html .= '<p class="text-center">お気に入りがありません。</p>'; 
                }
                $fav_html.='</div>';
            }else{
                // No Favorites
                $fav_html= '<div class="cards-container"><p class="text-center">お気に入りがありません。</p></div>';
            }
            $html_fav_card[] = $fav_html;
        }
        $html = '
        <h2 class="mypage__title">お気に入り</h2>
        <div class="favorite__containers">
            <input id="mypage__tab__company" type="radio" name="mypage__tab__item" checked>
            <label class="mypage__tab__item" for="mypage__tab__company">企業情報</label>
            <input id="mypage__tab__event" type="radio" name="mypage__tab__item">
            <label class="mypage__tab__item" for="mypage__tab__event">イベント</label>
            <input id="mypage__tab__intern" type="radio" name="mypage__tab__item">
            <label class="mypage__tab__item" for="mypage__tab__intern">インターンシップ</label>
            <input id="mypage__tab__column" type="radio" name="mypage__tab__item">
            <label class="mypage__tab__item" for="mypage__tab__column">就活記事</label>
            <span class="mypage__tab__border"></span>
            <div class="favorite__container mypage__item__container mypage__item__company">
                '.$html_fav_card[0].'
            </div>
            <div class="favorite__container mypage__item__container mypage__item__event">
            '.$html_fav_card[1].'
            </div>
            <div class="favorite__container mypage__item__container mypage__item__intern">
                '.$html_fav_card[2].'
            </div>
            <div class="favorite__container mypage__item__container mypage__item__column">
                '.$html_fav_card[3].'
            </div>
        </div>
        ';
    }
    return $html;
}
add_shortcode("view_mypage_fav","view_mypage_fav");

function view_mypage_attend(){
    $user_name = $_GET['um_user'];
    $user = get_user_by('login',$user_name);
    $user_id = $user->ID;
    if(get_current_user_id() == $user_id || current_user_can('administrator')){
        $internship_num = do_shortcode(' [cfdb-count form="/インターン応募.*/" filter="your-id='.$user_name.'"]');
        $internship_html = '';
        if($internship_num == 0){
            $internship_html .= '<p class="text-center">応募がありません。</p>';
        }else{
            $internship_html .= do_shortcode(' [cfdb-html form="/インターン応募.*/" show="Submitted,job-id,job-name,your-message" filter="your-id='.$user_name.'" orderby="Submitted desc"]
            {{BEFORE}}
            <table class="tbl02">
                <thead>
                    <tr>
                        <th>タイトル</th>
                        <th>応募日時</th>
                        <th>志望動機</th>
                    </tr>
                </thead>
                <tbody>{{/BEFORE}}
                    <tr>
                        <td>[pid2link ${job-id}]${job-name}[/pid2link]</td>
                        <td label="応募日時"><p>[submitted2str sbm="${Submitted}"]</p></td>
                        <td><p>${your-message}</p></td>
                    </tr>
                {{AFTER}}
                </tbody>
            </table>{{/AFTER}}
            [/cfdb-html]');
        }
        $job_num = do_shortcode(' [cfdb-count form="/新卒応募.*/" filter="your-id='.$user_name.'"]');
        $job_html = '';
        if($job_num == 0){
            $job_html .= '<p class="text-center">応募がありません。</p>';
        }else{
            $job_html .= do_shortcode(' [cfdb-html form="/新卒応募.*/" show="Submitted,job-id,job-name" filter="your-id='.$user_name.'" orderby="Submitted desc"]
            {{BEFORE}}
            <table class="tbl02">
                <thead>
                    <tr>
                        <th>企業名</th>
                        <th>応募日時</th>
                    </tr>
                </thead>
                <tbody>{{/BEFORE}}
                    <tr>
                        <td>[pid2link ${job-id}]${job-name}[/pid2link]</td>
                        <td label="応募日時"><p>[submitted2str sbm="${Submitted}"]</p></td>
                    </tr>
                {{AFTER}}
                </tbody>
            </table>{{/AFTER}}
           [/cfdb-html]');
        }
        $event_num = do_shortcode(' [cfdb-count form="/イベント応募.*/" filter="your-id='.$user_name.'"]');
        $event_html = '';
        if($event_num == 0){
            $event_html .= '<p class="text-center">応募がありません。</p>';
        }else{
            $event_html .= do_shortcode(' [cfdb-html form="/イベント応募.*/" show="Submitted,job-id,job-name" filter="your-id='.$user_name.'" orderby="Submitted desc"]
            {{BEFORE}}
            <table class="tbl02">
                <thead>
                    <tr>
                        <th>イベント名</th>
                        <th>応募日時</th>
                    </tr>
                </thead>
                <tbody>{{/BEFORE}}
                    <tr>
                        <td>[pid2link ${job-id}]${job-name}[/pid2link]</td>
                        <td label="応募日時"><p>[submitted2str sbm="${Submitted}"]</p></td>
                    </tr>
                {{AFTER}}
                </tbody>
            </table>{{/AFTER}}
            [/cfdb-html]');
        }
        $html = '
        <h2 class="mypage__title">応募済み一覧</h2>
        <div class="favorite__containers">
            <input id="mypage__tab__recruit-apply" type="radio" name="mypage__tab__item" checked>
            <label class="mypage__tab__item" for="mypage__tab__recruit-apply">新卒応募</label>
            <input id="mypage__tab__event-apply" type="radio" name="mypage__tab__item">
            <label class="mypage__tab__item" for="mypage__tab__event-apply">イベント応募</label>
            <input id="mypage__tab__intern-apply" type="radio" name="mypage__tab__item">
            <label class="mypage__tab__item" for="mypage__tab__intern-apply">インターン応募</label>
            <span class="mypage__tab__border"></span>
            <div class="favorite__container mypage__item__container mypage__item__recruit-apply">
                '.$job_html.'
            </div>
            <div class="favorite__container mypage__item__container mypage__item__event-apply">
                '.$event_html.'
            </div>
            <div class="favorite__container mypage__item__container mypage__item__intern-apply">
            '.$internship_html.'
            </div>
        </div>
        ';
    }
    return $html;
}
add_shortcode("view_mypage_attend","view_mypage_attend");
?>