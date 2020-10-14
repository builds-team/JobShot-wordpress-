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
    $user_id = get_current_user_id();
    $fav_html='';
    $favorites = get_user_favorites();
    if($item_type == 'internship'){
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
            'post_type' => array('internship'),
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
    return $fav_html;
}
add_shortcode("show_favorites","show_favorites_func");

?>