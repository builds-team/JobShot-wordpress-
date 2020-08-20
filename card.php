<?php

/**
 * [card.php]
 *  詳細ページを表示するための概略をまとめたもの
 *  view_card_func(),view_fullwidth_card_func()によって、どの種類のカードを表示するか決めている
 *  新卒、長期有給インターン、イベント、企業情報のカードの4種類
 *  カードの種類は、横長のものと、縦長のものの2種類で、横長のものはfullwidthと名前をつけている
 */

function view_card_func($post_id){
  if(!in_the_loop()){
    global $post;
    $post_id=$post->ID;
  }
  switch(get_post_type($post_id)){
    case 'job':
      // return view_job_card_func($post_id);
      return view_fullwidth_job_card_func($post_id);
    case 'internship':
      // return view_intern_card_func($post_id);
      return view_fullwidth_intern_card_func($post_id);
    case 'event':
      // return view_event_card_func($post_id);
      return view_fullwidth_event_card_func($post_id);
    case 'company':
      // return view_company_card_func($post_id);
      return view_fullwidth_company_card_func($post_id);
    case 'summer_internship':
      return view_fullwidth_summer_intern_card_func($post_id);
    case 'autumn_internship':
      return view_fullwidth_autumn_intern_card_func($post_id);
    case 'column':
      return view_fullwidth_column_card_func($post_id);
    break;
  }
  return;
}
add_shortcode('view-card','view_card_func');

function view_fullwidth_card_func($post_id){
  if(!in_the_loop()){
    global $post;
    $post_id=$post->ID;
  }
  switch(get_post_type($post_id)){
    case 'job':
      return view_fullwidth_job_card_func($post_id);
    case 'internship':
      return view_fullwidth_intern_card_func($post_id);
    case 'event':
      return view_fullwidth_event_card_func($post_id);
    case 'company':
      return view_fullwidth_company_card_func($post_id);
    case 'autumn_internship':
      return view_fullwidth_autumn_intern_card_func($post_id);
    case 'summer_internship':
      return view_fullwidth_summer_intern_card_func($post_id);
    break;
  }
  return;
}
add_shortcode('view-fullwidth-card','view_fullwidth_card_func');

//////////////////縦長のカードの関数///////////////////////////

function view_job_card_func($post_id){

  $post_title = get_the_title($post_id);
  $job_description = get_field("仕事内容",$post_id);
  $salary = get_field("月給",$post_id);
  $allowance =get_field("諸手当",$post_id);
  $target =get_field("応募資格",$post_id);
  $mail = get_field("お問い合わせ",$post_id);
  $address = get_field("勤務地",$post_id);
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_field("職種",$post_id);
  $skill = get_the_terms($post_id,"acquire")[0]->name;

  $card_html= '
  <div class="cards-container">
    <a href = "'.esc_url(get_permalink($post_id)).'">
      <div class="card">
        <div class="card-bigimg-wrap">
          <img class="card-bigimg-inner" src="'.$image_url.'" alt="" />
        </div>
        <div class="card-text-content">
          <h4 class="card-title event-title">'.$post_title.'</h4>
          <table class="card-table">
            <tbody>
              <tr>
                <th>募集種別</th>
                <td>新卒採用</td>
              </tr>
              <tr>
                <th>募集職種</th>
                <td>'.$occupation.'</td>
              </tr>
              <tr>
                <th>仕事内容</th>
                <td>'.$job_description.'</td>
              </tr>
              <tr>
                <th>給与</th>
                <td>月給'.$salary.'万円</td>
              </tr>
              <tr>
                <th>諸手当</th>
                <td>'.$allowance.'</td>
              </tr>
              <tr>
                <th>勤務地</th>
                <td>'.$address.'</td>
              </tr>
              <tr>
                <th>応募資格</th>
                <td>'.$target.'</td>
              </tr>
              <tr>
                <th>お問い合わせ</th>
                <td>'.$mail.'</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </a>
  </div>';
  return $card_html;
}
add_shortcode('view-job-card','view_job_card_func');

function view_intern_card_func($post_id){

  $post_title = get_the_title($post_id);
  $catchphrase = get_field("キャッチコピー",$post_id);
  $salary = get_field("給与",$post_id);
  $requirements =get_field("勤務条件",$post_id);
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_field("職種",$post_id);
  $card_category_html = '';
  if(!empty($area)){
    $card_category_html .= '<div class="card-category">'.$area.'</div>';
  }
  if(!empty($occupation)){
    $card_category_html .= '<div class="card-category">'.$occupation.'</div>';
  }
  $skill = get_the_terms($post_id,"acquire")[0]->name;
  $card_html .=   '
  <div class="card">
    <a href = "'.esc_url(get_permalink($post_id)).'">
      <div class="card-bigimg-wrap">
          <img class="card-bigimg-inner" src="'.$image_url.'" alt>
      </div>
      <div class="card-text-content">
          <div class="card-title">'.$post_title.'</div>
          <div class="card-category-container">'.$card_category_html.'</div>
          <table class="card-table">
          <tbody>
              <tr>
              <th>勤務条件</th>
              <td>'.$requirements.'</td>
              </tr>
              <tr>
              <th>給与</th>
              <td>'.$salary.'</td>
              </tr>
          </tbody>
          </table>
      </div>
    </a>
  </div>';
return do_shortcode($card_html);
}
add_shortcode('view-intern-card','view_intern_card_func');


function view_event_card_func($post_id){
  //global $post;
  //$post_id = $post->ID;
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $event_date = get_field('開催日時1')['日付'].' '.get_field('開催日時1')['開始時刻'].'〜'.get_field('開催日時1')['終了時刻'];
  $area = get_the_terms($post_id,"area")[0]->name;
  $event_target = get_field('募集対象_短文',$post_id);
  $event_capacity = get_field('定員',$post_id);

  $sankas=get_field('参加企業',$post_id);

  $sanka_html='<div>';
  foreach((array)$sankas as $sanka){
    $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'">'.$sanka->post_title.'</a></div>';
  }
  $sanka_html.='</div>';


  $card_html= '
  <div class="card">
    <div class="card-bigimg-wrap">
      <img class="card-bigimg-inner" src="'.$image_url.'" alt="">
    </div>
    <div class="card-text-content">
      <h4 class="card-title event-title">'.get_post_meta($post_id , 'キャッチコピー' ,true).'</h4>
      <table class="card-table">
        <tbody>
          <tr>
            <th>参加企業</th>
            <td>'.$sanka_html.'</td>
          </tr>
          <tr>
            <th>開催エリア</th>
            <td>'.$area.'</td>
          </tr>
          <tr>
            <th>開催日時</th>
            <td>'.$event_date.'</td>
          </tr>
          <tr>
            <th>募集対象</th>
            <td>'.$event_target.'</td>
          </tr>
          <tr>
            <th>定員</th>
            <td>'.$event_capacity.'</td>
          </tr>
        </tbody>
      </table>
      <div class="full-card-buttons">
        <button class="button favorite innactive">☆お気に入り</button>
        <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
      </div>
    </div>
  </div>';

  return $card_html;
}
add_shortcode('view-event-card','view_event_card_func');

function view_company_card_func($post_id){
  $image_id = get_post_thumbnail_id($post_id);
  $image_url = wp_get_attachment_image_src($image_id, thumbnail);

  $test = view_terms_func($post_id, array('area','occupation','business_type','feature','acquire'),'<object>','','</object>');
  //$card_html='<div class="card card-company"><div class="card-bigimg-wrap"><img src="https://www.pakutaso.com/shared/img/thumb/MIYA2012DSCF8671_TP_V.jpg" class="card-bigimg-inner"></div><div class="card-text-content">';
  $card_html='<a class="card card-company" href="'. esc_url(get_permalink($post_id)).'"><div class="card-bigimg-wrap"><img src="https://www.pakutaso.com/shared/img/thumb/MIYA2012DSCF8671_TP_V.jpg" class="card-bigimg-inner"></div><div class="card-text-content card-text-content-company><h4 class="card-title">'.get_post_meta($post_id , '社名' ,true).'</h4><div class="card-category-container">'
  .get_favorites_button($post_id)
  .view_terms_func($post_id, array('area','occupation','business_type','feature','acquire'),'<object>','','</object>')

  .'</div></div></a>';
  //    $card_html.='</div></div></div>';
  return $card_html;
}
add_shortcode('view-company-card','view_company_card_func');

//////////////////fullwidthカードの関数///////////////////////////

/**
 * 項目を「業種・従業員数・場所・平均初任給・写真・お気に入りボタン・詳細を見るボタン」に変更する
 */

function view_fullwidth_job_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  if($occupation == '総合職'){
    $occupation = '総合';
 }
  $salary = nl2br(get_field("給与",$post_id));
  $requirements = nl2br(get_field("応募資格",$post_id));
  $work_contents = nl2br(get_field("業務内容",$post_id));

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="'.$home_url.'/edit_job?post_id='.$post_id.'"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url=$home_url.'/?company='.$company_name;

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-text">
        <div class="full-card-text-title">'.$occupation.'職</div>
        <div class="full-card-text-caption">
        <div class="full-card-text-company"><a href="'.esc_url($company_url).'">'.$company_name.'</a></div>
        </div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th width="25%" style="text-align:center;" >給与</th>
              <td>'.$salary.'</td>
            </tr>
            <tr>
              <th width="25%" style="text-align:center;" >応募条件</th>
              <td>'.$requirements.'</td>
            </tr>
            <tr>
              <th width="25%" style="text-align:center; vertical-align:top;">業務内容</th>
              <td>'.$work_contents.'</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-job-card','view_fullwidth_job_card_func');


function view_fullwidth_intern_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $post_content = $post->post_content;
  $post_content = mb_substr($post_content,0,50).'...';
  $catchphrase = get_field("キャッチコピー",$post_id);
  $salary = nl2br(get_field("給与",$post_id));
  $requirements = nl2br(get_field("勤務条件",$post_id));
  $image = get_field("イメージ画像",$post_id);
  if(is_array($image)){
    $image_url = $image["url"];
  }else{
    $image_url = wp_get_attachment_url($image);
  }
  $skill = get_the_terms($post_id,"acquire")[0]->name;
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;

  $post_title = get_field("募集タイトル",$post_id);
  $company_bussiness = get_field("事業内容",$post_id);
  $company_id = get_company_id($company);
  $company_image = get_field("企業ロゴ",$company_id);
  if(is_array($company_image)){
    $company_image_url = $company_image["url"];
  }else{
    $company_image_url = wp_get_attachment_url($company_image);
  }
  if(empty($image_url)){
    $image_url = $company_image_url;
  }
  if(empty($company_bussiness)){
    $company_bussiness = get_field("事業内容",$company_id);
  }
  if(mb_strlen($company_bussiness) > 100){
    $company_bussiness = mb_substr(nl2br($company_bussiness),0,100).'...';
  }
  $intern_contents = get_field("業務内容",$post_id);
  $skills = get_field("身につくスキル",$post_id);
  $address = get_field("勤務地",$post_id);
  $skill_requirements = get_field('応募資格',$post_id);
  $prospective_employer = get_field('インターン卒業生の内定先',$post_id);
  $intern_student_voice = get_field('働いているインターン生の声',$post_id);
  $builds_voice = get_field('Builds担当者の声',$post_id);
  $features = get_field('特徴',$post_id);
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $business_type = get_the_terms($company_id,"business_type")[0]->name;
  $card_category_html = '';
  if(!empty($area)){
    $card_category_html .= '<div class="card-category">'.$area.'</div>';
  }
  if(!empty($occupation)){
    $card_category_html .= '<div class="card-category">'.$occupation.'</div>';
  }
  if(!empty($business_type)){
    $card_category_html .= '<div class="card-category">'.$business_type.'</div>';
  }

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="'.$home_url.'/edit_internship?post_id='.$post_id.'"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url = get_permalink($company_id);
  $intern_url=get_permalink($post_id);

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url($intern_url).'">'.$post_title.'</a></div>
        <div class="full-card-text-caption">
          <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
          <div class="card-category-container">'.$card_category_html.'</div>
        </div>
        <div><p>'.$company_bussiness.'</p></div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>勤務条件</th>
              <td>'.$requirements.'</td>
            </tr>
            <tr>
              <th>給与</th>
              <td>'.$salary.'</td>
            </tr>
          </tbody>
        </table>'.
        $features_html
      .'</div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-intern-card','view_fullwidth_intern_card_func');

function view_fullwidth_event_card_func($post_id){
  $post_title = get_the_title($post_id);
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $event_date = get_field('開催日時',$post_id);
  $event_day=get_field('開催日',$post_id);
  $event_day_2 = str_replace('/', '-', $event_day);
  $today=date("Y/m/d");
  $area = get_the_terms($post_id,"area")[0]->name;
  $event_target = get_field('募集対象_短文',$post_id);
  $event_summary = get_field('概要',$post_id);
  if(mb_strlen($event_summary) > 150){
    $event_summary = mb_substr(nl2br($event_summary),0,150).'...';
  }
  $event_deadline = get_field('申込締切日時',$post_id);
  $event_capacity = get_field('定員',$post_id);
  $sankas=get_field('参加企業',$post_id);
  $sanka_html='<div>';
  foreach((array)$sankas as $sanka){
    $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'">'.$sanka->post_title.'</a></div>';
  }
  $sanka_html.='</div>';
  $home_url =esc_url( home_url( ));
  $detai_url = $home_url.'/manage_application?pid='.$post_id;

  $post = get_post($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $event_url=get_permalink($post_id);

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt>
      </div>
      <div class="full-card-text">';
  if(strtotime($event_day_2)<strtotime('now')){
  $card_html.='
        <div class="full-card-text-title">
          <font color = "gray">'.$post_title.'【終了】</font>
        </div>';
  }else{
  $card_html.='
        <div class="full-card-text-title"><a href="'.esc_url($event_url).'">'.$post_title.'</a></div>';
  }
  $card_html .='
        <div class="full-card-text-content"><p>'.$event_summary.'</p></div>
        <table class="full-card-table">
          <tbody>';
  if(!empty($sankas)){
  $card_html.='
            <tr>
              <th>参加企業</th>
              <td>'.$sankas.'</td>
            </tr>';
  }
  if(!empty($area)){
    $card_html .= '
            <tr>
              <th>開催エリア</th>
              <td>'.$area.'</td>
            </tr>';
  }
  if(!empty($event_date)){
    $card_html .= '
            <tr>
              <th>開催日時</th>
              <td>'.$event_date.'</td>
            </tr>';
  }
  if(!empty($event_target)){
    $card_html .= '
            <tr>
              <th>募集対象</th>
              <td>'.$event_target.'</td>
            </tr>';
  }
  if(!empty($event_capacity)){
    $card_html .= '
            <tr>
              <th>定員</th>
              <td>'.$event_capacity.'</td>
            </tr>';
  }
  if(!empty($event_deadline)){
    $card_html .= '
            <tr>
              <th>申込締切日時</th>
              <td>'.$event_deadline.'</td>
            </tr>';
  }
  $card_html .='
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-event-card','view_fullwidth_event_card_func');

function view_fullwidth_company_card_func($post_id){

  $post = get_post($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $company_id = get_company_id($company);
  $company_bussiness = get_field("事業内容",$post_id);
  if(mb_strlen($company_bussiness) > 100){
    $company_bussiness = mb_substr($company_bussiness,0,100).'...';
  }
  $build_year = get_field("設立年",$post_id);
  $stock = get_field("資本金",$post_id);
  $address = get_field("住所",$post_id);
  $image = get_field("企業ロゴ",$post_id);
  $image_url = $image["url"];

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url = get_permalink($company_id);

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url($company_url).'">'.$company_name.'</a></div>
        <div class="full-card-text-content"><p>'.$company_bussiness.'</p></div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>設立年</th>
              <td>'.$build_year.'</td>
            </tr>
            <tr>
              <th>資本金</th>
              <td>'.$stock.'</td>
            </tr>
            <tr>
              <th>本社所在地</th>
              <td>'.$address.'</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-company-card','view_fullwidth_company_card_func');

function view_fullwidth_summer_intern_card_func($post_id){

  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $company_id = get_company_id($company);
  $intern_contents = get_field("インターン内容",$post_id);
  if(mb_strlen($intern_contents) > 100){
    $intern_contents = mb_substr(nl2br($intern_contents),0,100).'...';
  }
  $event_date = nl2br(get_field("開催日",$post_id));
  $deadline = nl2br(get_field("締め切り日",$post_id));
  $image = get_field("トップイメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $business_type = get_the_terms($company_id,"business_type")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $card_category_html = '';
  if(!empty($area)){
    $card_category_html .= '<div class="card-category">'.$area.'</div>';
  }
  if(!empty($occupation)){
    $card_category_html .= '<div class="card-category">'.$occupation.'</div>';
  }
  if(!empty($business_type)){
    $card_category_html .= '<div class="card-category">'.$business_type.'</div>';
  }

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url = get_permalink($company_id);
  $features = get_field('特徴',$post_id);

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></div>
        <div class="full-card-text-caption">
          <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
          <div class="card-category-container">'.$card_category_html.'</div>
        </div>
        <div>'.$intern_contents.'</div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>開催日</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>締め切り日</th>
              <td>'.$deadline.'</td>
            </tr>
          </tbody>
        </table>'.$features_html
      .'</div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);

}
add_shortcode('view-fullwidth-summer-intern-card','view_fullwidth_summer_intern_card_func');

function view_fullwidth_autumn_intern_card_func($post_id){

  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $company_id = get_company_id($company);
  $intern_contents = get_field("インターン内容",$post_id);
  if(mb_strlen($intern_contents) > 100){
    $intern_contents = mb_substr(nl2br($intern_contents),0,100).'...';
  }
  $event_date = nl2br(get_field("開催日",$post_id));
  $deadline = nl2br(get_field("締め切り日",$post_id));
  $image = get_field("トップイメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $business_type = get_the_terms($company_id,"business_type")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $card_category_html = '';
  if(!empty($area)){
    $card_category_html .= '<div class="card-category">'.$area.'</div>';
  }
  if(!empty($occupation)){
    $card_category_html .= '<div class="card-category">'.$occupation.'</div>';
  }
  if(!empty($business_type)){
    $card_category_html .= '<div class="card-category">'.$business_type.'</div>';
  }

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url = get_permalink($company_id);
  $features = get_field('特徴',$post_id);

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></div>
        <div class="full-card-text-caption">
        <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
        <div class="card-category-container">'.$card_category_html.'</div>
        </div>
        <div>'.$intern_contents.'</div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>開催日</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>締め切り日</th>
              <td>'.$deadline.'</td>
            </tr>
          </tbody>
        </table>'.$features_html
      .'</div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url(get_permalink($post_id)).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);

}
add_shortcode('view-fullwidth-autumn-intern-card','view_fullwidth_autumn_intern_card_func');

function view_fullwidth_column_card_func($post_id){

  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $description = get_post_meta($post_id, '_aioseop_description', true);
  $post_date = get_the_date( 'Y-m-d', $post_id );
  $image_url = get_the_post_thumbnail_url( $post_id , 'medium' );
  $premium_column = get_post_meta($post_id, 'プレミアム記事', true);
  if (!is_user_logged_in() and !empty($premium_column[0])){
    $lock_html = '<i class="fas fa-lock"></i>';
  }

  $card_html = '
  <div class="card full-card">
    <div class="full-card-maim">
      <div class="column_card_img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="column_card_contents">
        <div class="column_card_title"><h3 id="column_card_title_text"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></h3></div>
        <div class="column_card_description">
          <p>'.$description.'</p>
        </div>
        <div class="column_card_date">
          <p><i class="far fa-clock"></i>'.$post_date.$lock_html.'</p>
        </div>
      </div>
    </div>
  </div>';

  return do_shortcode($card_html);

}
add_shortcode('view-fullwidth-column-card','view_fullwidth_column_card_func');


function view_insert_column_card_func($post_id){

  $post_title = get_the_title($post_id);
  $image_url = get_the_post_thumbnail_url( $post_id , 'medium' );

  $card_html = '
  <div class="card full-card">
    <div class="full-card-maim">
      <div class="column_card_img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="column_card_contents">
        <div class="column_card_title"><span id="column_card_title_text"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></span></div>
      </div>
    </div>
  </div>';

  return do_shortcode($card_html);
}

function get_youtube_embed_address_func($origin_addr){
  return str_replace('watch?v=','embed/',$origin_addr);
}

?>