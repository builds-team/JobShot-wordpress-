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
?>