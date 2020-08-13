<?php
function update_univ_community(){
    $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    $univ_community_meta_query = array('relation' => 'OR');
    $univ_communities = array('文化系サークル','スポーツ系サークル','体育会系部活','文化系部活','学生団体');
    foreach($univ_communities as $univ_community){
        array_push($univ_community_meta_query, array(
            'key'       => 'univ_community',
            'value'     => $univ_community,
            'compare'   => 'LIKE'
        ));
    }
    array_push($meta_query_args, $univ_community_meta_query);
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'student',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => $meta_query_args,
        'date_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'search_columns' => array( 'user_login','faculty_lineage','languages','programming_languages','region','skill_dev','skill',),
        'count_total'  => true,
        'fields'       => 'all',
        'who'          => ''
    );
    $students=new WP_User_Query( $args );
    if ( $students->get_results() ) foreach( $students->get_results() as $user )  {
        $user_id = $user->data->ID;
        $univ_community = get_user_meta($user_id,'univ_community',false)[0];
        $univ_community_checkbox = get_user_meta($user_id,'univ_community_checkbox',false);
        update_user_meta( $user_id, 'univ_community_checkbox' , $univ_community);
    }
}
add_shortcode('update_univ_community','update_univ_community');

function update_user_score(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    $user_base_profile_score = get_user_meta( $user_id, 'user_base_profile_score',false)[0];
    update_user_base_profile_score($user_id);
    update_user_univ_profile_score($user_id);
    update_user_abroad_profile_score($user_id);
    update_user_programming_profile_score($user_id);
    update_user_skill_profile_score($user_id);
    update_user_community_profile_score($user_id);
    update_user_internship_profile_score($user_id);
    update_user_interest_profile_score($user_id);
    update_user_experience_profile_score($user_id);
    update_user_picture_profile_score($user_id);
    update_user_total_profile_score($user_id);
}
add_shortcode('update_user_score','update_user_score');

function update_all_user_score(){
    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'student',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => '',
        'date_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        'search_columns' => array(),
        'count_total'  => true,
        'fields'       => 'all',
        'who'          => ''
    );
    $students=new WP_User_Query( $args );
    $count = 0;
    $user_ids = array();
    if ( $students->get_results())foreach( $students->get_results() as $user )  {
        $user_id = $user->data->ID;
        $user_base_profile_score = get_user_meta( $user_id, 'user_base_profile_score',false)[0];
        update_user_base_profile_score($user_id);
        update_user_univ_profile_score($user_id);
        update_user_abroad_profile_score($user_id);
        update_user_programming_profile_score($user_id);
        update_user_skill_profile_score($user_id);
        update_user_community_profile_score($user_id);
        update_user_internship_profile_score($user_id);
        update_user_interest_profile_score($user_id);
        update_user_experience_profile_score($user_id);
        update_user_picture_profile_score($user_id);
        update_user_total_profile_score($user_id);
    }
}
add_shortcode('update_all_user_score','update_all_user_score');
?>
