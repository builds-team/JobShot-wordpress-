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

    $fav_html='';
    $favorites = get_user_favorites();
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
        $fav_html= '<p class="text-center">お気に入りがありません。</p>';
    }
    return $fav_html;
}
add_shortcode("show_favorites","show_favorites_func");

?>