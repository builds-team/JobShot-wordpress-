<?php

function is_bot() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $bot = array("googlebot","msnbot","yahoo");
    foreach( $bot as $bot ) {
      if (stripos( $ua, $bot ) !== false){
        return true;
      }
    }
    return false;
}

function manage_posts_columns($columns) {
    if(current_user_can( 'administrator' )){
        $columns['post_views_count'] = 'Total閲覧数';
        $columns['week_views_count'] = 'Week閲覧数';
        $columns['day_views_count'] = 'Day閲覧数';
        //$columns['apply_count'] = '応募数';
        unset($columns['date']);
        unset($columns['wpmem_block']);
    }
    return $columns;
}
function add_column($column_name, $post_id) {
    if(current_user_can( 'administrator' )){
        if ( $column_name == 'post_views_count' ) {
            $stitle = get_post_meta($post_id, 'post_views_count', true);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
        if ( $column_name == 'week_views_count' ) {
            $stitles =array();
            $stitles[]+=get_post_meta($post_id, 'week_views_count', true);
            $stitles[]+=get_post_meta($post_id, 'week_views_count1', true);
            $stitles[]+=get_post_meta($post_id, 'week_views_count2', true);
            $stitles[]+=get_post_meta($post_id, 'week_views_count3', true);
            foreach($stitles as $stitle){
                if ( isset($stitle) && $stitle ) {
                    echo attribute_escape($stitle)."<br>";
                } else {
                    echo __('None')."<br>";
                }
            }
        }
        if ( $column_name == 'day_views_count' ) {
            $stitle = get_post_meta($post_id, 'day_views_count', true);
            if ( isset($stitle) && $stitle ) {
                echo attribute_escape($stitle);
            } else {
                echo __('None');
            }
        }
        //if ( $column_name == 'apply_count' ) {
            //$formname = 'インターン応募';
            //$stitle = do_shortcode(' [cfdb-count form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
            //if ( isset($stitle) && $stitle ) {
                //echo attribute_escape($stitle);
            //} else {
                //echo __('None');
            //}
        //}
    }
}
add_filter( 'manage_internship_posts_columns', 'manage_posts_columns' );
add_action( 'manage_internship_posts_custom_column', 'add_column', 10, 2 );

function setPostViews() {
    $post_id = get_the_ID();
    $custom_key = 'post_views_count';
    $view_count = get_post_meta($post_id, $custom_key, true);
    if ($view_count === '') {
        delete_post_meta($post_id, $custom_key);
        add_post_meta($post_id, $custom_key, '0');
    } else {
        $view_count++;
        update_post_meta($post_id, $custom_key, $view_count);
    }
}

function setWeekViews() {
    $post_id = get_the_ID();
    $custom_key = 'week_views_count';
    $view_count = get_post_meta($post_id, $custom_key, true);
    if ($view_count === '') {
        delete_post_meta($post_id, $custom_key);
        add_post_meta($post_id, $custom_key, '0');
    } else {
        $view_count++;
        update_post_meta($post_id, $custom_key, $view_count);
    }
}

function setDayViews() {
    $post_id = get_the_ID();
    $custom_key = 'day_views_count';
    $view_count = get_post_meta($post_id, $custom_key, true);
    if ($view_count === '') {
        delete_post_meta($post_id, $custom_key);
        add_post_meta($post_id, $custom_key, '0');
    } else {
        $view_count++;
        update_post_meta($post_id, $custom_key, $view_count);
    }
}

function setRecScore() {
    $post_id = get_the_ID();
    $custom_key = 'recommend_score';
    $recommend_score = get_post_meta($post_id, $custom_key, true);
    $formname = 'インターン応募';
    $score=(20-(int)do_shortcode(' [cfdb-count form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]'))*6;
    $score+=(int)get_post_meta($post_id, 'week_views_count', true)*4;
    if ($recommend_score === '') {
        delete_post_meta($post_id, $custom_key);
        add_post_meta($post_id, $custom_key, $score);
    } else {
        update_post_meta($post_id, $custom_key, $score);
    }
}

function my_add_weekly( $schedules ) {
	$schedules['weekly'] = array(
		'interval' => 604800,
		'display' => __('Once Weekly')
	);
	return $schedules;
}
add_filter( 'cron_schedules', 'my_add_weekly' );

function my_activation() {
	if ( ! wp_next_scheduled( 'reset_week_ranking_cron' ) ) {
		wp_schedule_event( time(), 'weekly', 'reset_week_ranking_cron' );
    }
    if ( ! wp_next_scheduled( 'reset_day_ranking_cron' ) ) {
		wp_schedule_event( time(), 'daily', 'reset_day_ranking_cron' );
	}
}
add_action('wp', 'my_activation');

function reset_day_ranking() {
	$args = array(
        'post_status' => array('publish'),
        'post_type' => array('internship','column'),
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $posts = get_posts( $args );
    $custom_key = 'day_views_count';
    foreach($posts as $post){
        $post_id=$post->ID;
        update_post_meta($post_id, $custom_key, '0');
        if(get_post_type($post_id)=='internship'){
            setRecScore();
        }
    }
}
add_action ( 'reset_day_ranking_cron', 'reset_day_ranking' );

function reset_week_ranking() {
	$args = array(
        'post_status' => array('publish'),
        'post_type' => array('internship','column'),
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $custom_key = 'week_views_count';
    $custom_key1 = 'week_views_count1';
    $custom_key2 = 'week_views_count2';
    $custom_key3 = 'week_views_count3';
    $posts = get_posts( $args );
    $weekly_column_view = 0;
    $weekly_internship_view = 0;
    foreach($posts as $post){
        $post_id=$post->ID;
        if(get_post_type($post_id)=='internship'){
            $view_count = get_post_meta($post_id, 'week_views_count', true);
            if ($view_count != ''){
                $weekly_internship_view += (int)$view_count;
            }
        }else {
            $view_count = get_post_meta($post_id, 'week_views_count', true);
            if ($view_count != ''){
                $weekly_column_view += (int)$view_count;
            }
        }
        update_post_meta($post_id, $custom_key3, get_post_meta($post_id, 'week_views_count2', true));
        update_post_meta($post_id, $custom_key2, get_post_meta($post_id, 'week_views_count1', true));
        update_post_meta($post_id, $custom_key1, get_post_meta($post_id, 'week_views_count', true));
        update_post_meta($post_id, $custom_key, '0');

    }
    $lastweek = date('Y/m/d', strtotime('-7 day'));
    $today = date('Y/m/d',strtotime('today')); 
    // 新規ユーザーの取得
    $string =  '今週のレポートを報告します';
    $string .= "\n\n";
    $string .= sprintf("\n\n " . $lastweek . 'から' . $today . 'の9:00までのインターン詳細閲覧数：%d', $weekly_internship_view);
    $string .= sprintf("\n\n " . $lastweek . 'から' . $today . 'の9:00までの就活記事閲覧数：%d', $weekly_column_view);
    $attachment = array(
        "text"  =>  $string
    );
    builds_slack('', $attachment, '#2-1-jobshot事業部bot');
}
add_action ( 'reset_week_ranking_cron', 'reset_week_ranking' );

?>