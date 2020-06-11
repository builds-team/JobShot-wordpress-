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
    $html = '
        <div class="um um-login um-1596 uimob500" style="opacity: 1;">
            <div class="um-form">
                <form method="post" action="" autocomplete="off">
                    <div class="um-row _um_row_1 " style="margin: 0 0 30px 0;">
                        <div class="um-col-1">
                            <div class="um-field um-field-username um-field-text um-field-type_text" data-key="username">
                                <div class="um-field-label"><label for="username-1596">ユーザー名またはメールアドレス<span class="um-req" title="必須">*</span></label>
                                    <div class="um-clear"></div>
                                </div>
                                <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="username-1596" id="username-1596" value="" placeholder="" data-validate="unique_username_or_email" data-key="username"></div>
                            </div>
                            <div class="um-field um-field-user_password um-field-password um-field-type_password" data-key="user_password">
                                <div class="um-field-label"><label for="user_password-1596">パスワード<span class="um-req" title="必須">*</span></label>
                                    <div class="um-clear"></div>
                                </div>
                                <div class="um-field-area"><input class="um-form-field valid " type="password" name="user_password-1596" id="user_password-1596" value="" placeholder="" data-validate="" data-key="user_password"></div>
                            </div>
                        </div>
                    </div>
                    <p><input type="hidden" name="form_id" id="form_id_1596" value="1596"></p>
                    <p><input type="hidden" name="timestamp" class="um_timestamp" value="1548337902"></p>
                    <p class="request_name">
                        <label for="request_1596">Only fill in if you are not human</label><br>
                        <input type="text" name="request" id="request_1596" class="input" value="" size="25" autocomplete="off">
                    </p>
                    <div class="um-col-alt">
                        <div class="um-field um-field-c">
                            <div class="um-field-area">
                                <label class="um-field-checkbox "><input type="checkbox" name="rememberme" value="1"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option"> ログイン状態を保存する</span></label>
                            </div>
                        </div>
                        <div class="um-clear"></div>
                        <div class="um-left um-half">
                            <input type="submit" value="ログイン" class="um-button" id="um-submit-btn">
                        </div>
                        <div class="um-right um-half">
                            <a href="'.$home_url.'/regist" class="um-button um-alt"><br>新規登録</a>
                        </div>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-col-alt-b">
                        <a href="'.$home_url.'/?page_id=1605" class="um-link-alt"><br>パスワードをお忘れですか ?</a>
                    </div>
                </form>
            </div>
        </div>
        ';
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
        $html .= do_shortcode('[ultimatemember form_id="1596"]');
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