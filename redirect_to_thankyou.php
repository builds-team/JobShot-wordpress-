<?php

add_action( 'wp_footer', function () {
?>
<script>
document.addEventListener('wpcf7mailsent', function( event ) {
    if ( '324' == event.detail.contactFormId ) {
        gtag('event', 'apply', {
            'event_category': 'contactform7',
            'event_label': 'internship'
        });
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
        location = 'https://jobshot.jp/thank-you';
    }
}, false );
</script>
<?php } );

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
    $internship_title = do_shortcode('[cfdb-value form="インターン応募フォーム" show="job-name" filter="your-id='.$login_name.'&&your_message=on" limit="5" orderby="Submitted DESC"]');
    $self_internship_pr_value = preg_split("/[,]/",$self_internship_pr_value);
    $internship_title = preg_split("/[,]/",$internship_title);
    $izimodal_content = '<button class="open-options button" style="float: right;">過去の自己PRを使う</button>';
    for($i = 0; $i<count($self_internship_pr_value); $i++){
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