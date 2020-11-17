<?php
// テンプレート
/**
 * 内容：
 * 詳細：
 */

/**
 * 内容：レンダリングをブロックする JavaScript(jQuery) を除去
 * 詳細：https://webkikaku.co.jp/blog/wordpress/pagespeed-insights-javascript-css-rendering-block/
 */
if (!(is_admin() )) {
    function add_async_to_enqueue_script( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) return $url;       //.js以外は対象外
        if ( strpos( $url, 'jquery.min.js' ) ) return $url;       //'jquery.min.js'は、asyc対象外
        if (strpos($url,'.js')) return $url;
        return "$url' async charset='UTF-8";                      // async属性を付与
    }
    add_filter( 'clean_url', 'add_async_to_enqueue_script', 11, 1 );
}
/**
 * 内容：Jetpackのcssを無効化
 * 詳細：https://www.imamura.biz/blog/24020
 */
add_filter('jetpack_implode_frontend_css','__return_false', 9999);
function jeherve_remove_all_jp_css() {
    wp_deregister_style('jetpack-carousel');
}
add_action('wp_print_styles', 'jeherve_remove_all_jp_css',99 );
/**
 * 内容：ヘッダーに入るCSSを一旦削除
 * 詳細：https://hacknote.jp/archives/36536/
 * 詳細：https://hacknote.jp/archives/48382/
 * 詳細：https://blog.tachibanacraftworks.com/338/
 *
 * 内容：UM関連のCSSをプロフィールページ以外で削除
 * 詳細：https://www.1-firststep.com/archives/1979#link-scroll-4
 */
function dequeue_plugins_style() {
    //プラグインIDを指定し解除する
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style( 'monsterinsights-vue-frontend-style' );
    // wp_dequeue_style( 'wp-members' );
    wp_dequeue_style( 'dashicons' );
    wp_dequeue_style( 'admin-bar-style' );
    wp_dequeue_style( 'addtoany' );
    wp_dequeue_style( 'jetpack_likes' );
    wp_dequeue_style( 'chronicle-style-lato-web' );
    wp_deregister_style( 'broadsheet-style' );
    if( !is_page( array('apply','contact','published_contact','scout','mail_setteing','アカウント削除', 'jobshotxtech-build','スカウトフォーム','ログイン（インターン応募）','面接対策（ログイン）') )){
        wp_dequeue_style( 'contact-form-7' );
    }
    if( !is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply','エントリーシート','エントリーシートを見る','エントリーシートを見る（お気に入り）','ログイン（インターン応募）','面接対策（ログイン）') )){
        wp_deregister_style( 'um_crop' );
        wp_deregister_style( 'um_modal' );
        wp_deregister_style( 'um_datetime_date' );
        wp_deregister_style( 'um_datetime_time' );
        wp_deregister_style( 'um_tipsy' );
        wp_deregister_style( 'um_members' );
        wp_deregister_style( 'um_profile' );
        wp_deregister_style( 'um_account' );
        wp_deregister_style( 'um_fileupload' );
        wp_deregister_style( 'um_raty' );
        wp_deregister_style( 'um_scrollbar' );
        wp_deregister_style( 'um_datetime' );
        wp_dequeue_style( 'select2' );
	    wp_deregister_style('um_fonticons_ii');
        wp_deregister_style('um_styles');
        wp_deregister_style('um_misc');
	    wp_deregister_style('um_default_css');
	    wp_deregister_style('um_account');
	    wp_deregister_style('um_responsive');
    }
   if(!is_page(array('カレンダー'))){
        wp_deregister_script('mec-frontend-script');
        wp_deregister_script('mec-select2-script');
        wp_deregister_script('mec-owl-carousel-script');
        wp_deregister_script('mec-tooltip-script');
        wp_deregister_script('mec-featherlight-script');
        wp_deregister_script('mec-events-script');
        wp_deregister_script('mec-lity-script');
	    wp_deregister_script('mec-typekit-script');
	    wp_deregister_script('mec-colorbrightness-script');
	    wp_deregister_style('mec-font-icons');
        wp_deregister_style('mec-select2-style');
        wp_deregister_style('mec-events');
        wp_deregister_style('mec-tooltip-style');
        wp_deregister_style('mec-tooltip-shadow-style');
        wp_deregister_style('mec-featherlight-style');
        wp_deregister_style('mec-lity-style');
	    wp_deregister_style('mec-google-fonts');
	    wp_deregister_style('mec-frontend-style');

    }

    if( !is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply','エントリーシート','エントリーシートを見る','エントリーシートを見る（お気に入り）','ログイン（インターン応募）','面接対策（ログイン）') )){
        wp_deregister_script('um_pickadate');
        wp_deregister_script('um_pickadate_picker');
        wp_deregister_script('um_pickadate_picker.date');
        wp_deregister_script('um_pickadate_picker_time');
        wp_deregister_script('um_featherlight');
        wp_deregister_script('um_picker_time');
        wp_deregister_script('um_select2');
        wp_deregister_script('um_functions');
        wp_deregister_script('um-gdpr');
        wp_deregister_script('um_modal');
        wp_deregister_script('um_responsive');
        wp_deregister_script('um_profile');
        wp_deregister_script('um_account');
        wp_deregister_script('um_misc');
        wp_deregister_script('um_fileupload');
        wp_deregister_script('um_datetime');
        wp_deregister_script('um_datetime_date');
        wp_deregister_script('um_datetime_time');
        wp_deregister_script('um_datetime_legacy');
        wp_deregister_script('um_raty');
        wp_deregister_script('um_crop');
        wp_deregister_script('um_tipsy');
        wp_deregister_script('um_conditional');
        wp_deregister_script('um_profile');
        wp_deregister_script('um_tipsy');
        wp_deregister_script('um_account');
    }
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugins_style', 9999);
/**
 * 内容：CSSをフッターに移動
 * 詳細：https://hacknote.jp/archives/36536/
 */
function enqueue_css_footer(){
    wp_enqueue_style('monsterinsights-vue-frontend-style');
    wp_enqueue_style('wp-members');
    wp_enqueue_style('dashicons');
    wp_enqueue_style('admin-bar-style');
    wp_enqueue_style('addtoany');
    wp_enqueue_style('jetpack_likes');
    // wp_enqueue_style('wpcom-text-widget-styles');
    // wp_enqueue_style('um_crop');
    // wp_enqueue_style('um_modal');
    // wp_enqueue_style('um_misc');
    // wp_enqueue_style('um_datetime_date');
    // wp_enqueue_style('um_datetime_time');
    // wp_enqueue_style('um_tipsy');
    // wp_enqueue_style('');
    // wp_enqueue_style('');
    // wp_enqueue_style('');
    // wp_enqueue_style('genericons');
    // wp_enqueue_style('admin-bar');
    // wp_enqueue_style('broadsheet-style');
}
add_action('wp_footer', 'enqueue_css_footer',9999);

/**
 * 内容：ヘッダーに入るJSを一旦削除
 * 詳細：https://hacknote.jp/archives/36536/
 */
/**
 * 内容：JSをフッターに移動
 * 詳細：https://hacknote.jp/archives/36536/
 */
function my_enqueue_scripts() {
    // if(is_page( array('intern_test') )){
    //     wp_deregister_script('jquery');
    // }
    // wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), '3.3.1');
    wp_deregister_script('jquery');

    if(is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply','contact','published_contact','scout','intern_test','プロフィール更新のお願い','アカウント削除','スカウトフォーム','ログイン（インターン応募）','面接対策（ログイン）') )){
        wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',array(),'3.1.1');
    }else{
        wp_enqueue_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', array(), '1.8.3'); 
    }
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function enqueue_js_footer() {
    // jQuery3系
    /*
    if(is_page( array('user','register','login','user_account','mypage_test','interview_apply','contact','published_contact','scout','intern_test') )){
        wp_enqueue_script('jquery3','https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',array(),'3.1.1');
    }
    */
    // jQuery2系
    // if(is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply','contact','published_contact','scout','intern_test') )){
    //     wp_enqueue_script('jquery3','https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js',array(),'3.1.1');
    // }
}
add_action('wp_footer', 'enqueue_js_footer');
function izimodal_function() {
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/izimodal/1.5.1/js/iziModal.min.js" type="text/javascript"></script>';
    echo "
    <script>
    jQuery(document).on('click', '.open-options', function(event) {
        event.preventDefault();
        jQuery('.modal_options').iziModal('open');
    });
    jQuery('.modal_options').iziModal({
        group: 'group01',
        loop: true,
        headerColor: '#26A69A', //ヘッダー部分の色
        width: '80%', //横幅
        overlayColor: 'rgba(0, 0, 0, 0.5)', //モーダルの背景色
        transitionIn: 'fadeInUp', //表示される時のアニメーション
        transitionOut: 'fadeOutDown' //非表示になる時のアニメーション
    });
    </script>";
}
add_action( 'wp_footer', 'izimodal_function', 100 );
/**
 * 内容：管理バーを非表示にする
 * 詳細：https://www.understandard.net/wordpress/wp021.html
 */
add_filter( 'show_admin_bar', '__return_false' );

//表示崩れの修正（現在不使用）
/*
function primary_content(){
    $http = is_ssl() ? 'https' : 'http' . '://';
    $url = $http . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	if(strpos($url, 'jobshot.jp/column/')){
        echo "
            <script>
                jQuery(function($){
                    $('.main-content').addClass('main-container');
                    $('.main-container').removeClass('main-content');
                });
            </script>";
	}else{
        echo "
            <script>
                jQuery(function($){
                    $('.main-content').addClass('main-container');
                    $('.main-container').removeClass('main-content');
                    $('.main-container').addClass('primary-content');
                });
            </script>";
	}
}
add_action( 'wp_footer', 'primary_content', 100 );
*/
?>