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
    if( !is_page( array('apply','contact','published_contact','scout') )){
        wp_dequeue_style( 'contact-form-7' );
    }
    if( !is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply') )){
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
        // wp_deregister_style( 'um_default_css' );
        wp_deregister_style( 'um_fonticons_fa' );
        // wp_deregister_style( 'um_fonticons_ii' );
        // wp_deregister_style( 'um_styles' );
        wp_dequeue_style( 'select2' );
    }
    // // wp_dequeue_style( 'wpcom-text-widget-styles' );
    // wp_dequeue_style( 'um_misc' );
    // wp_dequeue_style( '' );
    // wp_dequeue_style( 'genericons' );
    // wp_dequeue_style( 'admin-bar' );
    // wp_dequeue_style( 'broadsheet-style' );
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
    if(is_page( array('user','register','login','user_account','mypage_test','apply','interview_apply','contact','published_contact','scout','intern_test') )){
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
?>