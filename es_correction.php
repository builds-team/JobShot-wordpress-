<?php

//ES用のサイドバーの追加
function add_sidebar_es(){
  $home_url =esc_url( home_url());
  $html = '
  <div class="es-navi">
    <ul class="es-container">
      <li class="es-navi-each es-navi-selected">
          <a href="https://jobshot.jp/entry-sheet">📝 ホーム</a>
      </li>
      <li class="es-navi-each">
        <a href="https://jobshot.jp/entry-sheet">🔰 基礎から学ぶ</a>
      </li>
      <li class="es-navi-each">
        <a href="https://jobshot.jp/entry-sheet/view">👥 ESを確認する</a>
      </li>
      <li class="es-navi-each">
          <a href="https://jobshot.jp/entry-sheet/view">🔥 実践チャレンジ</a>
      </li>
    </ul>
  </div>';
  return $html;
}
add_shortcode("add_sidebar_es","add_sidebar_es");

//ESを書くの一覧ページ
function view_es_type_func(){
  $home_url =esc_url( home_url());
  $es_practice_categories = get_es_categories('practice');
  $es_challenge_categories = get_es_categories('challenge');
  $practice_card_html = '
  <div class="es-title-container">
    <p class="es-title-sub">\ 基礎からはじめよう /</p>
    <h2 class="es-title">項目別練習</h1>
  </div>
  <div class="es-cards">';
  foreach ($es_practice_categories as $es_get_param => $es_contents) {
    $practice_card_html .= '
      <div class="es-card">
        <div class="es-card__image-holder">
          <img class="card__image" src="https://source.unsplash.com/400x300" alt="wave" />
        </div>
        <div class="card-title">
          <h2>'.$es_contents[0].'<small>🔰 基礎から学ぶ</small></h2>
        </div>
        <div class="card-flap flap1">
          <div class="card-description">'.$es_contents[1].'</div>
          <div class="card-flap flap2">
            <div class="card-actions">
              <a href="'.$home_url.'/entry-sheet/practice?category='.$es_get_param.'" class="btn">Read more</a>
            </div>
          </div>
        </div>
      </div>
    ';
  }
  $practice_card_html .= '</div>';
  $challenge_card_html = '
  <div class="es-title-container">
    <p class="es-title-sub">\ 実際にチャレンジしてみよう /</p>
    <h2 class="es-title">実践チャレンジ</h1>
  </div>
  <div class="es-cards">';
  foreach ($es_challenge_categories as $es_get_param => $es_contents) {
    $challenge_card_html .= '
      <div class="es-card">
        <div class="es-card__image-holder">
          <img class="card__image" src="https://source.unsplash.com/400x300" alt="wave" />
        </div>
        <div class="card-title">
          <h2>'.$es_contents[0].'<small>🔥 実践チャレンジ</small></h2>
        </div>
        <div class="card-flap flap1">
          <div class="card-description">'.$es_contents[1].'</div>
          <div class="card-flap flap2">
            <div class="card-actions">
              <a href="'.$home_url.'/entry-sheet/challenge?category='.$es_get_param.'" class="btn">Read more</a>
            </div>
          </div>
        </div>
      </div>
    ';
  }
  $challenge_card_html .= '</div>';
  $html = $practice_card_html.$challenge_card_html;
  return $html;
}
add_shortcode('view_es_type','view_es_type_func');

//練習用のESフォーム
function new_es_form_practice(){
  if(isset($_GET['category'])){
    $category=$_GET['category'];
  }
  $user = wp_get_current_user();
  $user_id = get_current_user_id();
  $user_name = $user->data->display_name;
  $es_categories = get_es_categories('practice');
  $es_points = get_es_points('practice');
  $post_button_html = '
  <div class="">
    <div class="">
	    <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
      <input type="hidden" name="new_es_practice" value="new_es_practice">
      <input type="hidden" name="user_id" value="'.$user_id.'">
      <input type="submit" name="save" id="publish" class="button button-primary button-large" value="保存">
    </div>
  </div>';
  $es_content = '';
  //ESを見るで編集ボタンが押されたときの処理
  if(!empty($_GET['post_id']) && !empty($_GET['action'])){
    $es = get_post($post_id);
    if($es->post_author == $user_id){
      $post_id = $_GET["post_id"];
      $es_content = get_field("投稿内容",$post_id);
      $post_button_html = '
        <div class="">
          <div class="">
            <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
            <input type="hidden" name="edit_es_practice" value="edit_es_practice">
            <input type="hidden" name="user_id" value="'.$user_id.'">
            <input type="hidden" name="post_id" value="'.$post_id.'">
            <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="保存">
          </div>
        </div>';
    }
  }
  $points_html = '';
  foreach($es_points[$category] as $es_point){
    $points_html .= '<li>'.$es_point.'</li>';
  }
  $new_html =  '
    <h2 class="maintitle">項目別練習('.$es_categories[$category][0].')</h2>
    <div class="">
      <h2 class="">'.$es_categories[$category][0].'のポイント</h2>
      <ul class="">
        '.$points_html.'
      </ul>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="">
        <table class="">
          <tbody>
            <tr>
              <th align="left" nowrap="nowrap">本文*</th>
              <td>
                <div class="es-text"><textarea name="es_content" id="" cols="30" rows="12" placeholder="" required>'.$es_content.'</textarea></div>
              </td>
            </tr>
          </tbody>
        </table>
        '.$post_button_html.'
      </div>
    </form>';
  return $new_html;
}
add_shortcode('new_es_form_practice','new_es_form_practice');

//添削用のESフォーム
function new_es_form_challenge(){
  if(isset($_GET['category'])){
        $category=$_GET['category'];
    }
  $user = wp_get_current_user();
  $user_id = get_current_user_id();
  $user_name = $user->data->display_name;
  $es_categories = get_es_categories('challenge');
  $es_points = get_es_points('challenge');
  $post_button_html = '
  <div class="">
    <div class="">
      <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="投稿">
    </div>
  </div>';
  $points_html = '';
  foreach($es_points[$category] as $es_point){
    $points_html .= '<li>'.$es_point.'</li>';
  }
  $new_html =  '
    <h2 class="maintitle">ES添削チャレンジ('.$es_categories[$category][0].')</h2>
    <div class="">
      <h2 class="">'.$es_categories[$category][0].'の要項</h2>
      <ul class="">'
        .$points_html.'
      </ul>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
      <p>ESのテーマ*</p>
      <div class="select_box select_box_01">
        <select name="selection_status" required>
            <option value="gakutika">学生時代力を入れたこと</option>
            <option value="self-pr">自己PR</option>
            <option value="strong-weak">長所・短所</option>
            <option value="motivation">志望動機</option>
            <option value="news">最近のニュース</option>
        </select>
      </div>
      <div class="">
        <table class="">
          <tbody>
            <tr>
              <th align="left" nowrap="nowrap">本文*</th>
              <td>
                <div class="es-text"><textarea name="es_content" id="" cols="30" rows="12" placeholder="" required></textarea></div>
              </td>
            </tr>
          </tbody>
        </table>
        <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
        <input type="hidden" name="new_es_challenge" value="new_es_challenge">
        <input type="hidden" name="user_id" value="'.$user_id.'">
        '.$post_button_html.'
      </div>
    </form>';
  return $new_html;
}
add_shortcode('new_es_form_challenge','new_es_form_challenge');


//新規投稿された時の処理
function new_es_post(){
  if(!empty($_POST["new_es_practice"]) || !empty($_POST["new_es_challenge"])){
    $user = wp_get_current_user();
    $es_content = $_POST["es_content"];
    $es_category = $_POST["es_category"];
    $user_name = $user->data->display_name;
		$es_type = 'entry_sheet';
    $post_value = array(
      'post_author' => get_current_user_id(),
      'post_title' => $es_category.'/'.$user_name,
      'post_type' => $es_type,
      'post_status' => 'draft'
    );
    $insert_id = wp_insert_post($post_value); //下書き投稿。
    if($insert_id) {
      //配列$post_valueに上書き用の値を追加、変更
      $post_value['ID'] = $insert_id; // 下書きした記事のIDを渡す。
      if(!empty($_POST["save"])){
        $post_status = "draft";
      }
      if(!empty($_POST["preview"])){
        $post_status = "draft";
      }
      if(!empty($_POST["publish"])){
        $post_status = "publish";
      }
      $post_value['post_status'] = $post_status; // 公開ステータスを$post_statusで
      update_post_meta($insert_id, 'author', $user_name);
      update_post_meta($insert_id, '投稿テーマ', $es_category);
      update_post_meta($insert_id, '投稿内容', $es_content);
		  $home_url =esc_url( home_url( ));
      $insert_id2 = wp_insert_post($post_value);
      if($insert_id2) {
        /* 投稿に成功した時の処理等を記述 */
        if(!empty($_POST["save"])){
          header('Location: '.$home_url.'/entry-sheet/view');
        }
        if(!empty($_POST["preview"])){
          header('Location: '.$home_url.'/entry-sheet/view');
        }
        if(!empty($_POST["publish"])){
          header('Location: '.$home_url.'/entry-sheet/view');
        }
        die();
        $html = '<p>success</p>';
      }else{
        /* 投稿に失敗した時の処理等を記述 */
        $html = '<p>error1</p>';
      }
    }else{
      /* 投稿に失敗した時の処理等を記述 */
      $html = '<p>error2</p>';
      $html .= '<p>'.$insert_id.'</p>';
    }
  }
}
add_action('template_redirect', 'new_es_post');

//ESを見るページ
function view_past_es(){
  $home_url =esc_url( home_url( ));
  $user = wp_get_current_user();
  $user_id = get_current_user_id();

  //詳細を見るボタンが押された時の表示
  if(!empty($_GET["post_id"]) && !empty($_GET["action"])){
    $post_id = $_GET["post_id"];
    $es = get_post($post_id);
    $post_status = get_post_status($post_id);
    if($post_status == 'publish'){
      $es_categories = get_es_categories('challenge');
      $es_points = get_es_points('challenge');
    }else{
      $es_categories = get_es_categories('practice');
      $es_points = get_es_points('practice');
    }
    if($es->post_author == $user_id){
      $es_category = get_field("投稿テーマ",$post_id);
      $es_urls = get_es_url();
	  $es_url = $es_urls[$es_category];
      $es_content = get_field("投稿内容",$post_id);
      $es_corrector = get_field("添削者",$post_id);
      $es_correction = get_field("添削内容",$post_id);
      $points_html = '';
      foreach($es_points[$es_url] as $es_point){
        $points_html .= '<li>'.$es_point.'</li>';
      }
      if($post_status == 'publish'){
       $html = '<h2 class="maintitle">ES添削チャレンジ('.$es_categories[$es_url][0].')</h2>
       <div class="">
         <h2 class="">'.$es_categories[$es_url][0].'の要項</h2>
         <ul class="">
           '.$points_html.'
         </ul>
       </div>';
      }else{
        $html = '<h2 class="maintitle">ES添削チャレンジ('.$es_categories[$es_url][0].')</h2>
       <div class="">
         <h2 class="">'.$es_categories[$es_url][0].'の要項</h2>
         <ul class="">
           '.$points_html.'
         </ul>
       </div>';
      }
      $html .= '
        <div class="card full-card">
          <div class="full-card-main">
		        <div class="full-card-text">
              <div class="full-card-text-title">
                <h3>'.$es_category.'</h3>
              </div>
              <table class="full-card-table">
                <tbody>
                  <tr>
                    <th>投稿内容</th>
                    <td>'.$es_content.'</td>
                  </tr>';
      if(!empty($es_corrector)){
        $html .= '
          <tr>
            <th>添削者</th>
            <td>'.$es_corrector.'</td>
          </tr>
          <tr>
            <th>添削内容</th>
            <td>'.$es_correction.'</td>
          </tr>';
      }
      $html .= '</tbody></table></div></div></div>';
    }
  }else{
    //ESを見るの一覧ページ
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'post_author' => $user_id,
	  'posts_per_page' => 100
    );
    $es_challenge = get_posts($args);
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('draft'),
      'post_author' => $user_id,
	  'posts_per_page' => 100
    );
    $es_practice = get_posts($args);
    $post_ids=array();
    $challenge_card_html = '';
    foreach($es_challenge as $es){
      $post_id = $es->ID;
      $es_category = get_field("投稿テーマ",$post_id);
      $es_content = get_field("投稿内容",$post_id);
      $es_corrector = get_field("添削者",$post_id);
      $es_correction = get_field("添削内容",$post_id);
      if(mb_strlen($es_content) > 100){
        $es_content = mb_substr($es_content, 0,100);
        $es_content .= '...';
      }
      if(mb_strlen($es_correction) > 100){
        $es_correction = mb_substr($es_correction, 0,100);
        $es_correction .= '...';
      }
      $challenge_card_html .=
        '<div class="card full-card">
          <div class="full-card-main">
            <div class="full-card-text">
              <div class="full-card-text-title">
                <h3>'.$es_category.'</h3>
              </div>
              <table class="full-card-table">
                <tbody>
                  <tr>
                    <th>投稿内容</th>
                    <td>'.$es_content.'</td>
                  </tr>';
                  if(!empty($es_corrector)){
                    $challenge_card_html .= '
                      <tr>
                        <th>添削者</th>
                        <td>'.$es_corrector.'</td>
                      </tr>
                      <tr>
                        <th>添削内容</th>
                        <td>'.$es_correction.'</td>
                      </tr>';
                  }
      $challenge_card_html .='
                </tbody>
              </table>
            </div>
          </div>
          <div class="full-card-buttons">
            <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show"><button class="button">詳細を見る</button></a>
          </div>
        </div>
      ';
    }
    $html = '
      <h2 class="column_search_category">ESを見る</h2>
      <div class="">
        <h3 class="">ES添削チャレンジ</h3>
        '.$challenge_card_html.'
      </div>';

    $es_categories = get_es_categories('practice');
    $es_points = get_es_points('practice');
    foreach($es_practice as $es){
      $post_id = $es->ID;
      $es_category = get_field("投稿テーマ",$post_id);
      $es_content = get_field("投稿内容",$post_id);
      if(mb_strlen($es_content) > 100){
        $es_content = mb_substr($es_content, 0,100);
        $es_content .= '...';
      }
      $es_urls = get_es_url();
      //ESのカテゴリのgetパラメータを取得
      $es_url = $es_urls[$es_category];
      $practice_card_html .= '
        <div class="card full-card">
          <div class="full-card-main">
            <div class="full-card-text">
              <div class="full-card-text-title">
                <h3>'.$es_category.'</h3>
              </div>
              <table class="full-card-table">
                <tbody>
                  <tr>
                    <th>投稿内容</th>
                    <td>'.$es_content.'</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="full-card-buttons">
            <a href = "'.$home_url.'/entry-sheet/practice?category='.$es_url.'&post_id='.$post_id.'&action=edit"><button class="button">編集する</button></a>
            <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show"><button class="button">詳細を見る</button></a>
            <form action="" method="POST">
              <input type="hidden" name="post_id" value="'.$post_id.'">
              <input type="submit" name="es-delete" id="es-delete" class="button button-primary button-large" value="削除する">
            </form>
          </div>
        </div>
      ';
    }
    $html .= '
      <div class="">
        <h3 class="">項目別練習</h3>
        '.$practice_card_html.'
      </div>';
  }
  return $html;
}
add_shortcode('view_past_es','view_past_es');

//デリート機能
function es_delete(){
  if(!empty($_POST["post_id"]) && !empty($_POST["es-delete"])){
    $post_id = $_POST["post_id"];
    wp_trash_post($post_id);
    $home_url =esc_url( home_url( ));
    header('Location: '.$home_url.'/entry-sheet/view');
    exit;
  }
}
add_action('template_redirect', 'es_delete');

//ESが編集された時の処理
function edit_es_post(){
  if(!empty($_POST["edit_es_practice"])){
    $user = wp_get_current_user();
    $es_content = $_POST["es_content"];
    $es_category = $_POST["es_category"];
    $user_name = $user->data->display_name;
    $es_type = 'entry_sheet';
	  $post_id = $_POST['post_id'];
    update_post_meta($post_id, '投稿内容', $es_content);
		$home_url =esc_url( home_url( ));
	  header('Location: '.$home_url.'/entry-sheet/view');
    die();
  }
}
add_action('template_redirect', 'edit_es_post');

//esのカテゴリの取得（key：getパラメータ、value:題名、説明、イメージ画像）
function get_es_categories($type){
  if($type == "practice"){
    $es_categories = array(
      'gakutika' => array('学生時代力を入れたこと','学生時代力を入れたことの説明','imageurl'),
      'self-pr' => array('自己PR','自己PRの説明','imageurl'),
      'strong-weak' => array('長所・短所','自己PRの説明','imageurl'),
      'motivation' => array('志望動機','志望動機の説明','imageurl'),
      'news' => array('最近のニュース','最近のニュースの説明','imageurl')
    );
  }else{
    $es_categories = array(
      'test' => array('テスト','テストの説明','imageurl'),
      'builds' => array('株式会社Builds','株式会社Buildsの説明','imageurl'),
      'musojyuku' => array('就活無双塾','就活無双塾の説明','imageurl')
    );
  }
  return $es_categories;
}

//esのポイントの取得（key：getパラメータ、value:ポイントの配列の取得）
function get_es_points($type){
  if($type == "practice"){
    $es_points = array(
      'gakutika' => array('がくちかのポイント１','がくちかのポイント２','がくちかのポイント３'),
      'self-pr' => array('自己PRの１','自己PRのポイント２'),
      'strong-weak' => array('長所・短所のポイント１','長所・短所のポイント２','長所・短所のポイント３','長所・短所のポイント４'),
      'motivation' => array('志望動機のポイント１','志望動機のポイント２'),
      'news' => array('最近のニュースのポイント１','最近のニュースのポイント２')
    );
  }
  else{
    $es_points = array(
      'test' => array('testの要項１','testの要項２'),
      'builds' => array('buildsの要項１','buildsの要項２'),
      'musojyuku' => array('就活無双塾の要項１','就活無双塾の要項２')
    );
  }
  return $es_points;
}

function get_es_url(){
    $es_url = array(
      '学生時代力を入れたこと' => 'gakutika',
      '自己PR' => 'self-pr',
      '長所・短所' => 'strong-weak',
      '志望動機' => 'motivation',
      '最近のニュース' => 'news',
      'テスト' => 'test',
      '株式会社Builds' => 'builds',
      '就活無双塾' => 'musojyuku'
    );
  return $es_url;
}