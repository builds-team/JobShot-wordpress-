<?php

function view_applied_list_func(){
    $user = wp_get_current_user();
    $user_id= $user->user_login;
    if (current_user_can('administrator')){
        $user_id= $_GET["um_user"];
    }
    $job_num = do_shortcode(' [cfdb-count form="/新卒応募.*/" filter="your-id='.$user_id.'"]');
    $job_html = '<h3>新卒応募</h3>';
    if($job_num == 0){
        $job_html .= '<div class="cards-container"><p class="text-center">応募がありません。</p></div>';
    }else{
        $job_html .= do_shortcode(' [cfdb-html form="/新卒応募.*/" show="Submitted,job-id,job-name" filter="your-id='.$user_id.'" orderby="Submitted desc"]
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

   $internship_num = do_shortcode(' [cfdb-count form="/インターン応募.*/" filter="your-id='.$user_id.'"]');
   $internship_html = '<h3>インターン応募</h3>';
   if($internship_num == 0){
       $internship_html .= '<div class="cards-container"><p class="text-center">応募がありません。</p></div>';
   }else{
        $internship_html .= do_shortcode(' [cfdb-html form="/インターン応募.*/" show="Submitted,job-id,job-name,your-message" filter="your-id='.$user_id.'" orderby="Submitted desc"]
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

    $event_num = do_shortcode(' [cfdb-count form="/イベント応募.*/" filter="your-id='.$user_id.'"]');
    $event_html = '<h3>イベント応募</h3>';
    if($event_num == 0){
        $event_html .= '<div class="cards-container"><p class="text-center">応募がありません。</p></div>';
    }else{
        $event_html .= do_shortcode(' [cfdb-html form="/イベント応募.*/" show="Submitted,job-id,job-name" filter="your-id='.$user_id.'" orderby="Submitted desc"]
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
    $html = $job_html;
    $html .= $event_html;
    $html .= $internship_html;
   return $html;
}
add_shortcode('view_applied_list','view_applied_list_func');


function view_attended_list_func(){
    $user = wp_get_current_user();
    $use_id= $user->user_login;
    $html=do_shortcode(' [cfdb-html form="/イベント出席.*/" show="Submitted,job-id,job-name,your-message" filter="your-id='.$use_id.'" orderby="Submitted desc"]
    {{BEFORE}}
    <table class="tbl02">
        <thead>
            <tr>
                <th>参加日</th>
                <th>ID</th>
                <th>タイトル</th>
                <th>感想</th>
            </tr>
        </thead>
        <tbody>{{/BEFORE}}
            <tr>
                <td>[submitted2str sbm="${Submitted}" format="Y/n/j"]</td>
                <td  label="ID">[pid2link ${job-id}]ID: ${job-id}[/pid2link]</td>
                <td  label="タイトル">[pid2link ${job-id}]${job-name}[/pid2link]</td>
                <td label="感想" class="txtarea"><p>${your-message}</p></td>
            </tr>
            {{AFTER}}
        </tbody>
    </table>{{/AFTER}}
    [/cfdb-html]');
    return $html;
}
add_shortcode('view_attended_list','view_attended_list_func');

function submitted2str_func($atts){
    extract( shortcode_atts( array(
        'sbm' => '',
        'format' =>'Y/n/j G時i分'
    ), $atts ) );
    return date($format, strtotime($sbm));
}
add_shortcode('submitted2str','submitted2str_func');

function pid2link_func($pid, $content = null){
    return '<p><a href="'.get_post_permalink($pid[0]).'">'.$content.'</a></p>';
}
add_shortcode('pid2link','pid2link_func');


?>