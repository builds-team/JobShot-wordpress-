<?php

add_action( 'wp_footer', function () {
?>
<script>
document.addEventListener('wpcf7mailsent', function( event ) {
    if ( '324' == event.detail.contactFormId ) {
        gtag('event', 'submit', {
            'event_category': 'contactform7',
            'event_label': 'internship'
        });
        setTimeout(function(){
            
        },1000);
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
        var self_internship_pr = $("[name=your-message]").html();
        var flag = false;
        if ($('.pr_save_check_box').prop('checked')) {
            flag = true;
            self_internship_pr = $("[name=your-message]").val();
        }
        $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action' : 'update_self_internship_PR', // フックの名前を渡す
                    'your_message' : self_internship_pr,
                    'flag' : flag,
                },
                success: function( response ){
                    // alert('success');
                },
                error: function( response ){
                    console.log(response);
                    // alert('error');
                }
            });
        var post_id = $("[name=job-id]").val();
        location = 'https://jobshot.jp/thank-you?job_id='+post_id;
    }else if('897' == event.detail.contactFormId){
        gtag('event', 'submit', {
            'event_category': 'contactform7',
            'event_label': 'event'
        });
        setTimeout(function(){
        
        },1000);
    }else if('1583' == event.detail.contactFormId) {
        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
        var motourl = document.referrer;
        var scouted_user_name = $("[name=partner-id]").val();
        var inputs = event.detail.inputs;
        for ( var i = 0; i < inputs.length; i++ ) {
            if ( 'partner-id' == inputs[i].name ) {
                scouted_user_name = ( inputs[i].value );
            break;
            }
        }
        var url = location.href;
        var size = $('.wpcf7-form').length;
        var size_m = 0;
        if ( url.match(/scout_form/)) {
            var text = '<div class="message__scout" role="alert" aria-hidden="true" style="">ありがとうございます。'+scouted_user_name+'さんへのメッセージは送信されました。</div>';
            $('.back').before(text);
            size_m = $('.message__scout').length;
        }else{
            $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                "action":"update_scouted_user",
                "scouted_user_name":scouted_user_name,
            },
            success: function( response ){
                console.log("成功!");
            },
            error: function( response ){
               console.log("失敗!");
            }
        });
        }
        if(size == size_m){
            if ( motourl.match(/=/)) {
                motourl = motourl+'&redirected=true';
            }
            else{
                motourl = motourl+'?redirected=true';
            }
            location = motourl;
        }
    }
}, false );
</script>
<?php } );

function update_scouted_user(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    if(isset($_POST["scouted_user_name"])){
        $flag = $_POST["scouted_user_name"];
    }
    $scouted_users = get_user_meta($user_id,'scouted_users',false)[0];
    if($flag){
        $scouted_users[] = $flag;
        $scouted_users = array_unique($scouted_users);
        $scouted_users = array_values($scouted_users);
        update_user_meta( $user_id, "scouted_users", $scouted_users);
        $student=get_user_by('login',$flag);
        decrease_remain_num_func($user, $student,'remain-mail-num', 1);
    }
    if(isset($_POST["name_array"])){
        $name_array = $_POST["name_array"];
        $re_count_n = $_POST["re_count_n"];
        $re_count_e = $_POST["re_count_e"];
    }
    if($name_array){
        foreach($name_array as $name){
            $scouted_users[] = $name;
            $scouted_users = array_unique($scouted_users);
            $scouted_users = array_values($scouted_users);
            update_user_meta( $user_id, "scouted_users", $scouted_users);
        }
    }
    if($re_count_n){
        $remain_num = get_remain_num_func($user,'remain-mail-num');
        $remain_num['general'] = $re_count_n;
        $remain_num['engineer'] = $re_count_e;
        update_user_meta($user_id,'remain-mail-num',$remain_num);
    }
    echo $remain_num['general'];
    die();
}
add_action( 'wp_ajax_update_scouted_user', 'update_scouted_user' );
add_action( 'wp_ajax_nopriv_update_scouted_user', 'update_scouted_user' );


add_action( 'wp_footer', 'mycustom_wp_footer' );
function mycustom_wp_footer() {
?>
<script>
document.addEventListener( 'wpcf7mailsent', function( event ) {
  if ( "324" == event.detail.contactFormId ) {
    gtag('event', 'click', {
      'event_category': 'link',
      'event_label': 'intern'
    });
  }
  else if ( '[form id 2]' == event.detail.contactFormId ) {
    gtag('event', '[action]', {
      'event_category': '[category]',
      'event_label': '[label]'
    });
  }
}, false );
</script>
<?php
}

jQuery(function($){
    $("#um-submit-btn").attr(
        "onclick", "ga('send', 'event', 'link', 'click','register');"
    );
});

jQuery(function($){
	$("#wpcf7-f324-p918-o1 .wpcf7-submit").attr(
		"onclick", "ga('send', 'event', 'link', 'click','intern');"
	);
});

jQuery(function($){
	$("#wpcf7-f897-p918-o1 .wpcf7-submit").attr(
		"onclick", "ga('send', 'event', 'link', 'click','intern');"
	);
});

jQuery(function($){
	$(".bookingButton").attr(
		"onclick", "ga('send', 'event', 'link', 'click','interview');"
	);
});

function update_self_internship_PR_func(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    $flag = $_POST["flag"];
    $self_internship_PR = $_POST["your_message"];
    if($flag){
        if(isset($_POST["your_message"])) {
            update_user_meta( $user_id, "self_internship_PR", $self_internship_PR);
        }
    }
    die();
}
add_action( 'wp_ajax_update_self_internship_PR', 'update_self_internship_PR_func' );
add_action( 'wp_ajax_nopriv_update_self_internship_PR', 'update_self_internship_PR_func' );

function past_self_internship_PR_func(){
    $user = wp_get_current_user();
    $user_id = $user->data->ID;
    $login_name = $user->user_login;
    $self_internship_pr_value = do_shortcode('[cfdb-value form="インターン応募フォーム" show="your-message" filter="your-id='.$login_name.'&&your_message=on" limit="5" orderby="Submitted DESC"]');
    $self_internship_pr_count = do_shortcode('[cfdb-count form="インターン応募フォーム" show="your-message" filter="your-id='.$login_name.'&&your_message=on" limit="5" orderby="Submitted DESC"]');
    $internship_title = do_shortcode('[cfdb-value form="インターン応募フォーム" show="job-name" filter="your-id='.$login_name.'&&your_message=on" limit="5" orderby="Submitted DESC"]');
    $self_internship_pr_value = preg_split("/[,]/",$self_internship_pr_value);
    $internship_title = preg_split("/[,]/",$internship_title);
    $izimodal_content = '<button class="open-options button">過去の自己PRを使う</button>';
    if($self_internship_pr_count == 0){
	  $izimodal_content = '<button class="open-options button button-nonactive">過去の自己PRを使う</button>';
	}
    for($i = 0; $i<$self_internship_pr_count; $i++){
        $title_count = $i+1;
        $izimodal_content .= '
        <div class="modal_options" data-izimodal-group="group1" data-izimodal-loop="" data-izimodal-title="過去の自己PR'.$title_count.'" data-izimodal-subtitle="'.$internship_title[$i].'">
            <p id="past-self-pr-'.$title_count.'" class="past-self-pr-text">'.$self_internship_pr_value[$i].'</p>
            <input type="button" class="past-self-pr-button" id="button'.$title_count.'" value="これを使う"/>
        </div>';
    }
    return $izimodal_content;
}
add_shortcode("past_self_internship_PR","past_self_internship_PR_func");

function es_menjo(){
    $post_id = $_GET['post_id'];
    $es = get_field('ES',$post_id);
    $results = "";
    if(in_array('応募の際にESを不要とする', $es, true)){
          $results = '<p id="esmenjo">本インターンでは応募の際に自己PRは不要です</p>';
      }
    return $results;
  }
  add_shortcode("es_menjo","es_menjo");
?>