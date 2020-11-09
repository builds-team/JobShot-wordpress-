<?php

function login_redirect_func(){
    $url=do_shortcode('[geturlnow]');
    return do_shortcode('[wpmem_form login redirect_to="'.$url.'"]');
}
add_shortcode('loginform_redirect','login_redirect_func');

function register_redirect_func(){
    $url=do_shortcode('[geturlnow]');
    return do_shortcode('[wpmem_form register redirect_to="'.$url.'"]');
}
add_shortcode('registerform_redirect','register_redirect_func');

function un_logged_in_user_redirect() {
    /*
    if( ! is_user_logged_in() && is_single() || is_archive() || is_singular( 'カスタム投稿' ) ) {
        wp_redirect( '/login' );// ログインページのURL
        exit();
    }
    if( ! is_user_logged_in() && is_page(1599)) {
        wp_redirect( '/login' );// ログインページのURL
        exit();
    }
    */
}
add_action( 'template_redirect',  'un_logged_in_user_redirect' );

function under_construction_redirect() {
    $cu=wp_get_current_user();
    /*
    if( ! is_user_logged_in() || !($cu->has_cap('administrator'))) {
        wp_redirect( '/' );
        exit();
    }
    */
}
//add_action( 'template_redirect',  'under_construction_redirect' );
add_filter('wpmem_login_redirect', 'my_login_redirect', 10, 2 );
function my_login_redirect( $redirect_to, $user_id ) {
    return '/';
}
/*
add_action( 'auth_redirect', 'subscriber_go_to_home' );
function subscriber_go_to_home( $user_id ) {
    $user = get_userdata( $user_id );
    if ( !$user->has_cap( 'edit_posts' ) ) {
        wp_redirect( get_home_url() );
        exit();
    }
}
*/

function apply_redirect(){
    $home_url =esc_url( home_url( ));
    $post_id = $_GET['post_id'];
    if(get_post_type($post_id)=='internship'){
        $post_title = get_field("募集タイトル",$post_id);
        $redirect_url = do_shortcode('[get_form_address formtype=apply form_id=324 post_id='.$post_id.' title='.$post_title.']'); 
        $redirect_count = get_user_meta(137,'redirect_count',true);
        if(empty($redirect_count)){
            $redirect_count = 1;
        }else{
            $redirect_count += 1;
        }
        update_user_meta(137,'redirect_count',$redirect_count);
    }
    $now_url = $_SERVER['REQUEST_URI'];
    if(strpos($now_url,'interview/login') !== false){
        $redirect_url = 'https://jobshot.jp/interview/apply';
    }
    $html = '<style type="text/css">
        .um-1596.um {
            max-width: 450px;
            margin:auto;
            
            }
        
        .um-alt {
            line-height: 40px;
            color: #666666 !important;
            background:#eeeeee !important;
        }
        .um-right {
        width: 48%;
            display: inline-block;
            height: 30px;
            text-align: center;
            background: #eeeeee;
            height:40px;
            border-radius: 3px;
            cursor: pointer;
        }
        .um-left {
            width: 48%;
            display: inline-block;
            float: left;
            margin-right: 4%;
            height:40px;
        }
        input[type="text"] {
        width:100% !important;
        height:40px;
        }
        input[type="submit"]{
        width:100% !important;
        height:40px;
        }
        input[type="password"] {
        width:100% !important;
        height:40px;
        }
        .um-link-alt {
            line-height: 22px;
            color: #888 !important;
            display: block !important;
            text-decoration: none !important;
            font-weight: normal;
            text-align: center;
            border-bottom: none !important;
        }
        
                .tax-categories{
                    display:none;
                }
                .um-field {
                padding:15px 0 0 0 !important;
                }
                .um-field-label label {
            font-size: 15px !important;
            line-height: 22px !important;
            font-weight: 600 !important;
        }
        span.um-req {
            margin: 0 0 0 8px;
            font-size: 14px;
            display: inline-block;
        }
        .um-field-label {
            display: block;
            margin: 0 0 8px 0;
        }
        .um-field-checkbox:not(.um-field), .um-field-radio:not(.um-field) {
            display: block;
            margin: 8px 0;
            position: relative;
        }
        .um-col-alt-b {
            padding-top: 20px;
        }
        .um-field-checkbox-option{
        font-size:15px;
        }
        .um-field-error {
            width: auto;
            max-width: 100%;
            background: #C74A4A;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            color: #fff;
            box-sizing: border-box;
            position: relative;
            padding: 12px;
            font-size: 14px;
            line-height: 20px !important;
            margin: 12px 0 0 0;
        }
        .um-field-arrow {
            top: -17px;
            left: 10px;
            position: absolute;
            z-index: 1;
            color: #C74A4A;
            font-size: 28px;
            line-height: 1em !important;
        }
        
        
        </style>';
        $html .= '
            <div class="um um-login um-1596 uimob500" style="opacity: 1;">
                <p>ログイン後に応募ページに移動します。</p>
            </div>
        ';
        $html .= do_shortcode('[ultimatemember form_id="1596"]');
        $html = str_replace('action=""','action="'.$redirect_url.'"',$html);
    return $html;
}
add_shortcode('view_apply_redirect','apply_redirect');

function redirect_to_mypage(){
    $home_url =esc_url( home_url( ));
    $user = wp_get_current_user();
    $user_roles = $user->roles;
    if(in_array("company", $user_roles)){
        $company_user_id = $user->ID;
        $company_id = get_company_post_id_func($company_user_id);
        $company_url = get_permalink($company_id);
        $location = $company_url;
        wp_redirect( $location );
        exit;
    }
    wp_redirect( $home_url.'/user');
    exit;
}
add_shortcode('redirect_to_mypage','redirect_to_mypage');

function redirect_to_login(){
    wp_redirect( $home_url.'/login');
    exit;
}
add_shortcode('redirect_to_login','redirect_to_login');

?>