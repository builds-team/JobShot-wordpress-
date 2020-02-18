<?php

function get_company_content_ids_func($company_user_login, $post_type){
  //これが新しい 2018/10/20
  $user= get_user_by( 'login', $company_user_login );
  global $coauthors_plus;
  $author_term = $coauthors_plus->get_author_term( $user );

  $args = array(
    'posts_per_page'   => -1,
    'offset'           => 0,
    'category'         => '',
    'category_name'    => '',
    // 'orderby'          => 'date',
    // 'order'            => 'DESC',
    'include'          => '',
    'exclude'          => '',
    // 'meta_key'         => '',
    // 'meta_value'       => '',
    'post_type'        => $post_type,
    'post_mime_type'   => '',
    'post_parent'      => '',
    'author'	   => '',
    'post_status'      => 'publish',
    'suppress_filters' => true,
    'tax_query'=>array(
        array(
            'taxonomy' => $coauthors_plus->coauthor_taxonomy,
            'field'    => 'name',
            'terms'    => $author_term->name,
        ),
      )
  );
  if($post_type=="event"){
    $args += array(
      'orderby' => 'meta_value',
      'meta_key' => '開催日',
      'order'   => 'DESC',
    );
  }
  $posts_array = get_posts( $args );
  $pids=array();
  foreach($posts_array as $post){
    array_push($pids,$post->ID);
  }
  return $pids;
}

function template_company_info2_func($content){
  global $post;
  $post_id=$post->ID;

  global $coauthors_plus;

  $author_terms = get_the_terms( $post_id, $coauthors_plus->coauthor_taxonomy);
  $company_user_login=$author_terms[0]->name;

  $company = get_userdata($post->post_author);
  $company_id = $company->data->ID;
  $company_name = $company->data->display_name;
  $company_bussiness = get_field("事業内容",$post_id);
  $build_year = get_field("設立年",$post_id);
  $build_money = get_field("資本金",$post_id);
  $company_worker = get_field("従業員数",$post_id);
  $representative = get_field("代表者",$post_id);
  $address_num = get_field("郵便番号",$post_id);
  $address = get_field("住所",$post_id);
  $image = get_field('企業ロゴ',$post_id);
  $image_url = $image["url"];

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;

  $style_html = '
  <style type="text/css">
    .company_edit{
      text-align:center;
    }
  </style>';
  $home_url =esc_url( home_url( ));
  if($company_name == $current_user_name){
      $edit_company_html = '<div><a href="'.$home_url.'/edit_company?post_id='.$post_id.'"><button class="button favorite innactive" style="width:100%;">編集する</button></a></div>';
      $edit_job_html = '<div class="company_edit"><a href="'.$home_url.'/new_post_job"><button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;">新規募集</button></a></div>';
      $edit_internship_html = '<div class="company_edit"><a href="'.$home_url.'/new_post_internship"><button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;">新規募集</button></a></div>';
      $edit_event_html = '<div class="company_edit"><a href=""><button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;">新規投稿</button></a></div>';
  }else{
      $edit_company_html = '';
      $edit_job_html = '';
      $edit_internship_html = '';
      $edit_event_html = '';
  }
    if(!empty($image)){
      $top_content_html = '<div class="company-page-logo-image"><img src="'.$image_url.'" alt></div>';
  }else{
      $top_content_html = '';
  }

  if($company_user_login == "Build"){
      $tab_title_html = '<input id="tab-company" type="radio" name="tab_item" checked><label class="tab_item" for="tab-company">会社情報</label><input id="tab-job" type="radio" name="tab_item"><label class="tab_item" for="tab-job">新卒</label><input id="tab-internship" type="radio" name="tab_item"><label class="tab_item" for="tab-internship">インターン</label><input id="tab-event" type="radio" name="tab_item"><label class="tab_item" for="tab-event">イベント</label>';
      $tab_contents_html= '
      <div class="tab_content" id="tab-job_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'job').'</p>
          </div>'.$edit_job_html.'
      </div>
      <div class="tab_content" id="tab-internship_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'internship').'</p>
          </div>'.$edit_internship_html.'
      </div>
      <div class="tab_content" id="tab-event_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'event').'</p>
          </div>'.$edit_event_html.'
      </div>';
  }else{
    $tab_title_html = '<input id="tab-company" type="radio" name="tab_item" checked><label class="tab_item" for="tab-company">会社情報</label><input id="tab-job" type="radio" name="tab_item"><label class="tab_item" for="tab-job">新卒</label><input id="tab-internship" type="radio" name="tab_item"><label class="tab_item" for="tab-internship">インターン</label><input id="tab-event" type="radio" name="tab_item"><label class="tab_item" for="tab-event">秋インターン</label>';
    $tab_contents_html= '
      <div class="tab_content" id="tab-job_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'job').'</p>
          </div>'.$edit_job_html.'
      </div>
      <div class="tab_content" id="tab-internship_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'internship').'</p>
          </div>'.$edit_internship_html.'
      </div>
      <div class="tab_content" id="tab-event_content">
          <div class="tab_content_description">
              <p class="c-txtsp">'.get_company_contents_func($company_user_login, 'summer_internship').'</p>
          </div>
      </div>';
  }

  $html= $style_html.'
  <div style="display:flex;">
      <div class="job-name job-title">'.$company_name.'</div>
  </div>
  '.$top_content_html.'
  <div class="tabs">
      '.$tab_title_html.'
      <div class="tab_content" id="tab-company_content">
          <div class="tab_content_description">
              <p class="c-txtsp">
                  <table class="demo01">
                      <tbody>
                          <tr>
                              <th>社名</th>
                              <td>
                                  <div>'.$company_name.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">事業内容</th>
                              <td>
                                  <div class="company-business-contents">'.$company_bussiness.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">設立</th>
                              <td>
                                  <div class="company-established">'.$build_year.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">本社</th>
                              <td>
                                  <div class="company-address">'.$address.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">代表者</th>
                              <td>
                                  <div class="company-representative">'.$representative.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">従業員数</th>
                              <td>
                                  <div class="company-representative">'.$company_worker.'</div>
                              </td>
                          </tr>
                          <tr>
                              <th align="left" nowrap="nowrap">資本金</th>
                              <td>
                                  <div class="company-capital">'.$build_money.'</div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </p>
          </div>'.$edit_company_html.'
      </div>
      '.$tab_contents_html.'
  </div>';
  if (current_user_can('administrator')){
	$last_login = get_user_meta($company_id,'_um_last_login',false);
	$last_login[0] -= 32400;
    $last_login_date = date('Y年m月d日',$last_login[0]).date('H時i分',$last_login[0]);
	$html .= '<p>'.'最終ログイン日時：'.$last_login_date.'</p>';
  }
  return do_shortcode($html);
}

function get_company_contents_func($company_user_login, $post_type){
  $post_ids=get_company_content_ids_func($company_user_login, $post_type);
  $relate_html = '<section><div class="cards-container"><div class="siteorigin-widget-tinymce textwidget"><div style="text-align: center;"><p><span style="font-size: x-large;">coming soon…</span></p></div></div></div></section>';
  if($company_user_login == 'dena'){
      return $relate_html;
  }
  $relate_html = '<section><div class="cards-container">';

  foreach($post_ids as $post_id){
    $relate_html.= view_fullwidth_card_func($post_id);
  }
  $relate_html.='</div></section>';
  return $relate_html;
}

function view_company_contents_func($company_user_id, $posttype){
    $company_user_login=get_user_by('id',$company_user_id)->user_login;
    $arr=get_company_content_ids_func($company_user_login,$posttype);
    if($posttype=='internship'){
        $formname='インターン応募';
    }else if($posttype=='job'){
        $formname = '新卒応募';
    }else if($posttype=='summer_internship'){
        $formname='サマーインターン';
    }else{
        $formname='イベント応募';
    }

    $relate_html= '
    <table class="tbl02">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>お気に入り数</th>
                <th>応募者数</th>
            </tr>
        </thead>
    <tbody>';
    foreach ($arr as $post_id) {
    $applylist=do_shortcode(' [cfdb-table form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
    $applycnt=do_shortcode(' [cfdb-value form="/'.$formname.'.*/" filter="job-id='.$post_id.'" function="count"]');

    $favorite_count = get_favorites_count($post_id);
    $home_url =esc_url( home_url( ));
    $relate_html.='
            <tr>
                <th>
                    <p><strong>'.get_the_title( $post_id ).'</strong></p>
                </th>
                <td label="お気に入り数">
                    <p><a href="'.$home_url.'/manage-favorite?pid='.$post_id.'"><b>'.$favorite_count.'名</b></a></p>
                </td>
                <td label="応募者数">
                    <p><a href="'.$home_url.'/manage_application?pid='.$post_id.'"><b>'.$applycnt.'名</b></a></p>
                </td>
            </tr>';
    }
    $relate_html.= '
        </tbody>
    </table>';

    return $relate_html;
}

function edit_company_info(){
  if($_GET["post_id"]){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_title = $post->post_title;
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;
    $company_movie = get_field("企業紹介動画",$post_id);
    $company_bussiness = get_field("事業内容",$post_id);
    $build_year = get_field("設立年",$post_id);
    $build_money = get_field("資本金",$post_id);
    $company_worker = get_field("従業員数",$post_id);
    $representative = get_field("代表者",$post_id);
    $address_num = get_field("郵便番号",$post_id);
    $address = get_field("住所",$post_id);
    $style_html = '
    <style type="text/css">
      .company_edit{
        text-align:center;
      }
    </style>';
    $home_url =esc_url( home_url( ));
    $edit_html = $style_html.'
    <h2 class="maintitle">会社情報</h2>
    <form action="'.$home_url.'/edit_company?post_id='.$post_id.'" method="POST" enctype="multipart/form-data">
        <div class="tab_content_description">
            <table class="demo01">
                <tbody>
                    <tr>
                        <th>社名</th>
                        <td>
                            <div class="company-name">'.$company_name.'</div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">事業内容</th>
                        <td>
                            <div class="company-business-contents"><textarea name="company_bussiness" id="" cols="30" rows="5" placeholder="">'.$company_bussiness.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">設立</th>
                        <td>
                            <div class="company-established"><input type="text" min="0" name="build_year" id="" value="'.$build_year.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">本社</th>
                        <td>
                            <div class="company-address"><input type="text" min="0" name="address" id="" class="input-width" value="'.$address.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">代表者</th>
                        <td>
                            <div class="company-representative"><input type="text" min="0" name="representative" id="" value="'.$representative.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">従業員数</th>
                        <td>
                            <div class="company-representative"><input type="text" min="0" name="company_worker" id="" value="'.$company_worker.'"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">資本金</th>
                        <td>
                            <div class="company-capital"><input type="text" min="0" name="build_money" id="" value="'.$build_money.'"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="edit_company" value="edit_company">
            <div class="company_edit">
                <input class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;" type="submit" value="更新する">
                <a class="button favorite innactive" style="width:40%; margin-top:15px; border-radius: 5px;" href="'.$home_url.'/?company='.$post_title.'">戻る</a>
            </div>
        </div>
    </form>';
    return $edit_html;
  }else{
    header('Location: '.$home_url.'/');
    die();
  }
}
add_shortcode("edit_company_info","edit_company_info");

function update_company_info(){
  if(!empty($_POST["company_bussiness"]) && !empty($_POST["edit_company"])){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_title = $post->post_title;
    $company_bussiness = $_POST["company_bussiness"];
    $build_year = $_POST["build_year"];
    $build_money = $_POST["build_money"];
    $company_worker = $_POST["company_worker"];
    $representative = $_POST["representative"];
    $address_num = $_POST["address_num"];
    $address = $_POST["address"];
    $home_url =esc_url( home_url( ));
    if($_POST["company_bussiness"]){
      update_post_meta($post_id, "事業内容", $company_bussiness);
    }
    if($_POST["build_year"]){
      update_post_meta($post_id, "設立年", $build_year);
    }
    if($_POST["build_money"]){
      update_post_meta($post_id, "資本金", $build_money);
    }
    if($_POST["company_worker"]){
      update_post_meta($post_id, "従業員数", $company_worker);
    }
    if($_POST["representative"]){
      update_post_meta($post_id, "代表者", $representative);
    }
    if($_POST["address_num"]){
      update_post_meta($post_id, "郵便番号", $address_num);
    }
    if($_POST["address"]){
      update_post_meta($post_id, "住所", $address);
    }
    header('Location: '.$home_url.'/?company='.$post_title);
    die();
  }
}
add_action('template_redirect', 'update_company_info');

function get_company_post_ids_func($company_user_id){
    if ( class_exists( 'coauthors_plus' ) ) {
        global $coauthors_plus;
        $company = get_user_by('id',$company_user_id);
        $company_name= $company->user_login;
        $author_term = $coauthors_plus->get_author_term( get_user_by('id',$company_user_id));
        $args = array(
            'posts_per_page'    =>  -1,
            'post_type'         =>  array('company'),
            'post_status' => array('publish' ),
            'author'    =>  $company_user_id,
        );
        $cat_query = new WP_Query( $args );
        $post_ids=array();
        while ($cat_query->have_posts()):
            $cat_query->the_post();
            array_push($post_ids,get_the_ID($post));
        endwhile;
        return $post_ids;
    }
}
function get_company_post_id_func($company_user_id){
return get_company_post_ids_func($company_user_id)[0];
}

function is_this_company_content($pid, $company_user_login){
global $coauthors_plus;
$author_terms = get_the_terms( $pid, $coauthors_plus->coauthor_taxonomy);
$f=false;
foreach($author_terms as $author_term){
if($author_term->name==$company_user_login){
$f=true;
}
}
return $f;
}
function is_this_my_content($pid){
$user = wp_get_current_user();
$company_user_login=$user->user_login;
return is_this_company_content($pid, $company_user_login);
}

function view_company_pagelink_by_postid_func($pid){
global $coauthors_plus;
$author_terms = get_the_terms( $pid, $coauthors_plus->coauthor_taxonomy);
$html='';
foreach($author_terms as $author_term){
$html.=view_company_pagelink_func(get_user_by('login',$author_term->name));
}
return $html;
}



function view_my_contents_func($atts){
extract( shortcode_atts( array(
'posttype' => '',
), $atts ) );

$user = wp_get_current_user();
$uid=$user -> ID;
return view_company_contents_func($uid,$posttype);
}
add_shortcode('view_my_contents','view_my_contents_func');

function view_company_contents_by_umuser_func(){
    $user = wp_get_current_user();
    $company_user_id = $user->ID;
    $company_id = get_company_post_ids_func($company_user_id)[0];
    $company_url = get_permalink($company_id);
    $location = $company_url;
    wp_redirect( $location );
    exit;
}
add_shortcode('view_company_contents_by_umuser','view_company_contents_by_umuser_func');



function view_company_pagelink_func($user){
$uid=$user -> ID;
$post_ids=get_company_post_ids_func($uid);
$phtml='<div>';
foreach($post_ids as $pid){
$phtml.='<p><a href="';
$phtml.= get_permalink($pid);
$phtml.='"><strong>'.get_the_title( $pid ).'</strong></a></p>';
}
$phtml.='</div>';
return $phtml;
}

function view_my_pagelink_func(){
$user = wp_get_current_user();
return view_company_pagelink_func($user);
}

add_shortcode('view_my_pagelink','view_my_pagelink_func');


function view_company_pagelink_umuser_func(){
if(isset($_GET['um_user'])){
return view_company_pagelink_func(get_user_by('login',$_GET['um_user']));
}else{
return '';
}
}

add_shortcode('view_company_pagelink_umuser','view_company_pagelink_umuser_func');

#企業が送ったスカウトメールを企業ごとに表示する
function view_company_scout_mail_func(){
    $company = wp_get_current_user();
    $company_user_login=$company->data->display_name;
    $scout_num = do_shortcode('[cfdb-count form="企業スカウトメール送信フォーム" filter="your-name='.$company_user_login.'"]');
    $result = '(全'.$scout_num.'件)<br>';
    $result .= 
    do_shortcode('[cfdb-html form="企業スカウトメール送信フォーム" show="Submitted,partner-id,your-subject,your-message" filter="your-name='.$company_user_login.'" orderby="Submitted desc"]
    {{BEFORE}}
      <table class="tbl02">
          <thead>
            <tr>
              <th>送信日時</th>
              <th>ユーザー名</th>
              <th>題名</th>
              <th>本文</th>
            </tr>
          </thead>
          <tbody>
          {{/BEFORE}}
            <tr>
                <td label="送信日時">
                    <div class="submitted">
                        <p>[submitted2str sbm="${Submitted}"]</p>
                    </div>
                </td>
                <td label="ユーザー名">
                <a href="/user?um_user=${partner-id}"><b>${partner-id}</b></a>
                </td>
                <td label="題名">
                    <p>${your-subject}</p>
                </td>
                <td label="本文">
                    <div style="height:71px; width:300px; overflow-y:auto;">
                        <p>${your-message}</p>
                    </div>
                </td>
            </tr>
          {{AFTER}}
          </tbody>
      </table>
    {{/AFTER}}
    [/cfdb-html]');
    return $result;
}
add_shortcode("view_company_scout_mail","view_company_scout_mail_func");


function view_company_contents_func_test(){
    $post_type = $_GET["posttype"];
    $company = wp_get_current_user();
    $company_user_login=$company->ID;
    $args = array(
        'post_type' => array($post_type),
        'post_status' => array( 'publish','draft','private'),
        'author' => $company_user_login
    );
    $posts = get_posts($args);
    $post_ids=array();
    foreach($posts as $post){
        array_push($post_ids,$post->ID);
    }
    if($post_type=='internship'){
        $formname='インターン応募';
        $title = 'インターン管理';
    }else if($post_type=='job'){
        $formname = '新卒応募';
        $title = '新卒管理';
    }else if($post_type=='summer_internship'){
        $formname='サマーインターン';
        $title = 'サマーインターン管理';
    }else if($post_type=='autumn_internship'){
        $formname='秋インターン';
        $title = '秋インターン管理';
    }else{
        $formname='イベント応募';
        $title = 'イベント管理';
    }
    $style_html = '
    <style>
    .manage_post_tbody{
    }
    .manage_post_tbody td{
        vertical-align: middle !important;
    }
    .manage_post_tbody td p{
        text-align: center;
    }
    .manage_post_title div{
        margin: auto 15px;
    }
    .manage_post_status div{
        margin: auto 5px;
    }
    @media only screen and (min-width: 1024px){
        .manage_post_title img{
            width: 150px;
        }
        .manage_post_title .card-category{
            margin-left: 0 !important;
        }
    }
    @media only screen and (max-width: 1024px){
        .manage_post_title div{
            text-align: center;
            margin-top: 10px !important;
        }
        .manage_post_status div{
            margin-top: 10px !important;
        }
    }
    </style>';

    $relate_html = $style_html.'
    <h3 class="widget-title">'.$title.'</h3>
    <table class="tbl02">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>ステータス</th>
                <th>お気に入り数</th>
                <th>応募者数</th>
            </tr>
        </thead>
        <tbody class="manage_post_tbody">';
    $home_url =esc_url( home_url( ));
    foreach ($post_ids as $post_id) {
        $edit_link = '<a href="'.$home_url.'/edit_'.$post_type.'?post_id='.$post_id.'">編集</a>';
        $applylist=do_shortcode(' [cfdb-table form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
        $applycnt=do_shortcode(' [cfdb-value form="/'.$formname.'.*/" filter="job-id='.$post_id.'" function="count"]');
        $occupation = get_the_terms($post_id,"occupation")[0]->name;
        $company = get_userdata($post->post_author);
        $company_id = get_company_id($company);
        $company_image = get_field("企業ロゴ",$company_id);
        if(is_array($company_image)){
            $company_image_url = $company_image["url"];
        }else{
            $company_image_url = wp_get_attachment_url($company_image);
        }
        $image = get_field("イメージ画像",$post_id);
        if(is_array($image)){
            $image_url = $image["url"];
        }else{
            $image_url = wp_get_attachment_url($image);
        }
        if(empty($image_url)){
            $image_url = $company_image_url;
        }
        $favorite_count = get_favorites_count($post_id);
        switch(get_ja_post_status($post_id)){
            case '下書き':
                $status_html = '
                    <select name="post_status">
                        <option value="draft" selected>下書き</option>
                        <option value="publish">公開済</option>
                        <option value="private">非公開</option>
                    </select>';
                break;
            case '公開済':
                $status_html = '
                    <select name="post_status">
                        <option value="draft">下書き</option>
                        <option value="publish" selected>公開済</option>
                        <option value="private">非公開</option>
                    </select>';
                break;
            case '非公開':
                $status_html = '
                    <select name="post_status">
                        <option value="draft">下書き</option>
                        <option value="publish">公開済</option>
                        <option value="private" selected>非公開</option>
                    </select>';
                break;
        }
        $relate_html.='
            <tr>
                <td label="タイトル" class="manage_post_title">
                    <div>
                        <p><img src="'.$image_url.'"></p>
                        <div><strong><a href="'.get_permalink( $post_id ).'">'.get_the_title( $post_id ).'</a></strong><br><div class="card-category">'.$occupation.'</div>'.$edit_link.'</div>
                    </div>
                </td>
                <td label="ステータス" class="manage_post_status">
                    <form action="" method="POST">
                        <div>
                            <p>'.$status_html.'<br>作成日：'.get_the_time("Y/m/d",$post_id).'<br>最終編集日：'.get_the_modified_time("Y/m/d",$post_id).'<p>
                            <input type="hidden" name="update_intern_status" value="update_intern_status">
                            <input type="hidden" name="post_id" value="'.$post_id.'">
                            <input type="submit" value="更新">
                        </div>
                    </form>
                </td>
                <td label="お気に入り数">
                    <p><a href="'.$home_url.'/manage-favorite?pid='.$post_id.'"><b>'.$favorite_count.'名</b></a></p>
                </td>
                <td label="応募者数">
                    <p><a href="'.$home_url.'/manage_application?pid='.$post_id.'"><b>'.$applycnt.'名</b></a></p>
                </td>
            </tr>';
    }
    $relate_html.= '
        </tbody>
    </table>';
    return $relate_html;
}
add_shortcode("view_company_contents_func_test","view_company_contents_func_test");

function get_ja_post_status($post_id){
    $status = get_post_status($post_id);
    $status_array = array(
        'publish' => '公開済',
        'pending' => '承認待ち',
        'draft' => '下書き',
        'private' => '非公開',
        'trash' => 'ゴミ箱'
    );
    foreach($status_array as $key => $value){
        if($status == $key){
            $ja_status = $value;
        }
    }
    return $ja_status;
}

function update_intern_status(){
    if(!empty($_POST["update_intern_status"])){
        $post_id = $_POST["post_id"];
        $post_status = $_POST["post_status"];
        wp_update_post(array(
            'ID'    =>  $post_id,
            'post_status'   =>  $post_status,
        ));
    }
}
add_action('template_redirect', 'update_intern_status');
?>