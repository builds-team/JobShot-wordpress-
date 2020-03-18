<?php
function set_content_func ( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'id' => '', 
        'class' => '', 
	  		'text' => '',
    ), $atts ) );
 /*
    $content = str_replace( '<br />' , '' , $content );
    $content = str_replace( '<br>' , '' , $content );
  $content = str_replace( '\r' , '' , $content );
    $content = str_replace( '\n' , '' , $content );
    $content = str_replace( '\t' , '' , $content );
    $content = str_replace( '\r\n' , '' , $content );
    $content = str_replace( '</p>' , '' , $content );
*/
//  $content = str_replace( array("<p>","</p>") , '<br>' , $content );
  $content = do_shortcode($content);
  $content = str_replace(array("\r\n","\r","\n"), '<br />', $content);

  
//  if($class==='job-name' || $class==='job-tag' || $class==='job-slogan'){echo "<p style='visibility:hidden;'>".$content."</p>";}

  if($class){
	  return "<div><script type='text/javascript'>var replacement = document.getElementsByClassName( '".$class."' ); for (i = 0; i < replacement.length; i++) {replacement[i].innerHTML = '".$content."';} </script></div>"; 
//		  return "<div><script type='text/javascript'>  var txt = (function(param) {return param[0].replace(/\n|\r/g, '');})`".$content."`; var replacement = document.getElementsByClassName( '".$class."' ); for (i = 0; i < replacement.length; i++) {replacement[i].innerHTML = txt;} </script></div>"; 
	}
  if($id){
	  return "<div><script type='text/javascript'>var e1 = document.getElementById('".$id."');e1.innerHTML = '".$content."';</script></div>"; 
	}
}
add_shortcode('setcontent', 'set_content_func');

function set_douga_func($atts){
      extract( shortcode_atts( array(
        'name' => '', 
    ), $atts ) );
 $url = get_field($name);
	return '<div class="youtube">'.createvideotag($url).'</iframe></div>';
}
add_shortcode('setdouga', 'set_douga_func');




function set_youtube_func ( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'url' => '', 
    ), $atts ) );
   $content = str_replace(array("\r\n","\r","\n"), '', $content);

//return '<div class="youtube"><iframe width="560" height="315" src="'.$url.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>';
  if(createvideotag($content)===false){
	return 'No movie';
  }else{
	return '<div class="youtube">'.createvideotag($content).'</div>';
  }
}
add_shortcode('setyoutube', 'set_youtube_func');

/**
 * youtubeのURLから埋め込みタグを生成する
 */
function createvideotag($param)
{
    //とりあえずURLがyoutubeのURLであるかをチェック
    if(preg_match('#https?://www.youtube.com/.*#i',$param,$matches)){
        //parse_urlでhttps://www.youtube.com/watch以下のパラメータを取得
        $parse_url = parse_url($param);
        // 動画IDを取得
        if (preg_match('#v=([-\w]{11})#i', $parse_url['query'], $v_matches)) {
            $video_id = $v_matches[1];
        } else {
            // 万が一動画のIDの存在しないURLだった場合は埋め込みコードを生成しない。
            return false;
        }
        $v_param = '';
        // パラメータにt=XXmXXsがあった時の埋め込みコード用パラメータ設定
        // t=〜〜の部分を抽出する正規表現は記述を誤るとlist=〜〜の部分を抽出してしまうので注意
        if (preg_match('#t=([0-9ms]+)#i', $parse_url['query'], $t_maches)) {
            $time = 0;
            if (preg_match('#(\d+)m#i', $t_maches[1], $minute)) {
                // iframeでは正の整数のみ有効なのでt=XXmXXsとなっている場合は整形する必要がある。
                $time = $minute[1]*60;
            }
            if (preg_match('#(\d+)s#i', $t_maches[1], $second)) {
                $time = $time+$second[1];
            }
            if (!preg_match('#(\d+)m#i', $t_maches[1]) && !preg_match('#(\d+)s#i', $t_maches[1])) {
                // t=(整数)の場合はそのままの値をセット ※秒数になる
                $time = $t_maches[1];
            }
            $v_param .= '?start=' . $time;
        }
        // パラメータにlist=XXXXがあった時の埋め込みコード用パラメータ設定
        if (preg_match('#list=([-\w]+)#i', $parse_url['query'], $l_maches)) {
            if (!empty($v_param)) {
                // $v_paramが既にセットされていたらそれに続ける
                $v_param .= '&list=' . $l_maches[1];
            } else {
                // $v_paramが既にセットされていなかったら先頭のパラメータとしてセット
                $v_param .= '?list=' . $l_maches[1];
            }
        }
        // 埋め込みコードを返す
        return '<iframe width="600" height="338" src="https://www.youtube.com/embed/' . $video_id . $v_param . '" frameborder="0" allowfullscreen></iframe>';
    }
    // パラメータが不正(youtubeのURLではない)ときは埋め込みコードを生成しない。
    return false;
}

function set_href_func ( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'id' => '', 
        'class' => '', 
	  		'text' => '',
    ), $atts ) );
    $content = do_shortcode($content);
  $content = str_replace(array("\r\n","\r","\n"), '<br />', $content);
  if($class){
	  return "<div><script type='text/javascript'>var replacement = document.getElementsByClassName( '".$class."' ); for (i = 0; i < replacement.length; i++) {replacement[i].href = '".$content."';} </script></div>"; 
	}
  if($id){
	  return "<div><script type='text/javascript'>var e1 = document.getElementById('".$id."');e1.href= '".$content."';</script></div>"; 
	}
}
add_shortcode('sethref', 'set_href_func');


function set_address_func ( $atts, $content = null ) {
    $home_url =esc_url( home_url( ));
    $url = $home_url."/application_internship?jobid=".get_the_ID()."&jobname=".get_the_title().";";
    return "<div><script type='text/javascript'>var e1 = document.getElementById('button_apply_internship');e1.href=".$url."</script></div>";
}
add_shortcode('setaddress', 'set_address_func');

function intern_apply_address_func(){
    return $home_url."/application_internship?jobid=".get_the_ID()."&jobname=".get_the_title();
}
add_shortcode('internapplyaddress', 'intern_apply_address_func');

function get_form_address_func($atts){
    $home_url =esc_url( home_url( ));
    extract( shortcode_atts( array(
        'formtype' => '',
        'form_id' => '',
        'post_id' => '',
        'title' => '',
        'redirect' => ''
    ), $atts ) );
    if(!empty($redirect)){
        return $home_url.'/'.$formtype.'?form_id='.$form_id.'&post_id='.$post_id.'&jobname='.$title.'&redirect='.$redirect;
    }
    return $home_url.'/'.$formtype.'?form_id='.$form_id.'&post_id='.$post_id.'&jobname='.$title;
}
add_shortcode('get_form_address', 'get_form_address_func');

// 固定ページにて[get_contactform_by_get formtype=apply returntype=form]
function get_contactform_by_get_func($atts){
    extract( shortcode_atts( array(
        'pid' => '',
        'formtype' => 'apply',
		'returntype' =>'form',
    ), $atts ) );
    if(isset($_GET['post_id'])){
  	    $post_id=$_GET['post_id'];
    }
    if(isset($_GET['form_id'])){
        $form_id=$_GET['form_id'];
    }
    return do_shortcode('[get_contactform post_id='.$post_id.' form_id='.$form_id.' formtype='.$formtype.' returntype='.$returntype.']');
}
add_shortcode('get_contactform_by_get','get_contactform_by_get_func');

function get_contactform_func($atts){
    extract( shortcode_atts( array(
          'post_id' => '',
          'form_id' => '',
          'formtype' => 'apply',
          'returntype' =>'form',
      ), $atts ) );

    $field_names_array = array(
        'apply' => '応募フォーム',
        'attend' => '出席登録フォーム',
    );

    if(array_key_exists($formtype,$field_names_array)){
        $field_name = $field_names_array[$formtype];
    }else{
      return "";
    }

    $form_name = get_the_title($form_id);

    return do_shortcode('[contact-form-7 id="'.$form_id.'" title="'.$form_name.'"]');
}
add_shortcode('get_contactform','get_contactform_func');

//Contact Form 7 URLパラメーター取得　関数
function my_form_tag_filter($tag){
    if ( ! is_array( $tag ) ){
        return $tag;
    }
    $user = wp_get_current_user();
    $user_id = $user->data->ID;

    if(isset($_GET['post_id'])){
        $name = $tag['name'];
        $post_id = $_GET['post_id'];
        if($name == 'job-id'){
            $tag['values'] = (array) $_GET['post_id'];
        }
        if($name == 'company-email'){
            $post = get_post($post_id);
            if ($post){
                $author = get_userdata($post->post_author);
                $company_email = $author->data->user_email;
                $tag['values'] = (array) $company_email;
            }else{
                $tag['values'] = (array)'jobshot+forward-author-companies@builds.ventures';
            }
        }
    }

    // if(isset($_GET['company-email'])){
    //     $name = $tag['name'];
    //     if($name == 'company-email'){
    //         $post_id = $_GET['post_id'];
    //         $post = get_post($post_id);
    //         if ($post){
    //             $author = get_userdata($post->post_author);
    //             $company_email = $author->data->user_email;
    //             _log($company_email);
    //             $tag['values'] = (array) $company_email;
    //         }else{
    //             $tag['values'] = (array)'jobshot+forward-author-companies@builds.ventures';
    //         }
    //     }
    // }
    $partner_name = $_GET['user_name'];
    $partner = get_user_by( 'login', $partner_name );
    $partner_email = $partner->data->user_email;

    if(isset($_GET['jobname'])){
        $name = $tag['name'];
        if($name == 'job-name'){
            $tag['values'] = (array) $_GET['jobname'];
        }
    }
    if( $tag['name'] == 'apply-profile'){
        $user_url = 'https://jobshot.jp/user?um_user='.$user->user_login;
        $tag['values'] = (array) $user_url;
    }
    if( $tag['name'] == 'your-name'){
        $tag['values'] = (array)  ( $user ->last_name  .' '.$user -> first_name);
    }
    if( $tag['name'] == 'your-id'){
        $tag['values'] = (array)   $user->user_login;
    }
    if( $tag['name'] == 'your-email'){
        $tag['values'] = (array)   $user->user_email ;
    }
    if(isset($_GET['pname'])){
        if($tag['name'] == 'partner-name'){
            $tag['values'] = (array) $_GET['pname'];
        }
    }
    if(isset($_GET['user_name'])){
        if($tag['name'] == 'partner-id'){
            $tag['values'] = (array) $_GET['user_name'];
        }
    }
    if($tag['name'] == 'partner-email'){
        $tag['values'] = (array)$partner_email;
    }
    if($tag['name'] == 'redirect'){
        $tag['values'] = (array) $_GET["redirect"];
    }
    if($tag['name'] == 'your-message'){
        $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
        $tag['values'] = (array) $self_internship_PR;
    }
    return $tag;
  }
  add_filter('wpcf7_form_tag', 'my_form_tag_filter');

// function company_names_onchu_func($atts, $content=null){
//     extract(shortcode_atts(array(
//         'elem' => 'p',
//         'pid'=> '',
//     ), $atts));
//     if(isset($content)) {
//         $pid=do_shortcode($content);
//         global $coauthors_plus;
//         $companies=get_the_terms($pid,$coauthors_plus->coauthor_taxonomy);
//         $str='';
//         foreach($companies as $company)  {
//             $cuser=get_user_by('login',$company->name);
//             $str.=$cuser->display_name." 採用担当者様\n";
//         }
//         $str.='';
//         return $str;
//     }else{
//         return '';
//     }
// }
// add_shortcode('company-names-onchu','company_names_onchu_func');
?>