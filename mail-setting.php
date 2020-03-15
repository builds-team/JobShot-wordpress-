<?php
function mail_setting_func(){
    $user=wp_get_current_user();
    $user_id = $user->data->ID;
    if(!empty($_POST["mail_settings"])){
        update_user_meta($user_id,"mail_settings",$_POST["mail_settings"]);
    }
    $mail_settings = get_user_meta($user_id,'mail_settings',true);
    $selected_1='';
    $selected_2='';
    if(!empty($mail_settings)){
        if(in_array("Buildsからのメール配信を希望しない",$mail_settings, true)){
            $selected_1='checked';
        }
        if(in_array("企業からのスカウトメールを希望しない",$mail_settings, true)){
            $selected_2='checked';
        }
    }
    $html='
    <p>メール配信設定<p>
    <form action="" method="post">
    <p>
        <label><input type="checkbox" name="mail_settings[]" value="Buildsからのメール配信を希望しない" '.$selected_1.'>Buildsからのメール配信を希望しない</label>
        <label><input type="checkbox" name="mail_settings[]" value="企業からのスカウトメールを希望しない" '.$selected_2.'>企業からのスカウトメールを希望しない</label>
    </p>
    <p>
        <input type="submit" value="更新">
    </p>
    </form>';
    return $html;
}
add_shortcode('mail_setting','mail_setting_func');

function update_mail_setting_func(){
    $user=wp_get_current_user();
    $value=0;

    if (isset($_POST['mail_setting1'])) {
        $value+=1;
    }
    if(isset($_POST['mail_setting2'])){
        $value+=2;
    }
    update_user_meta($user->ID,'mail_setting',strval($value));
}
add_action('template_redirect', 'update_mail_setting_func');

?>