<?php
/*

ログイン時のみesがかけるようにする(完了)
user_idで取得することができるようにする(完了)
ファイルの分割(完了)
公開日の取得（完了）
日付順に変更(完了、更新日時取得完了)
*/


//ES用のサイドバーの追加
function add_sidebar_es(){
  $home_url =esc_url( home_url());
  $category_array = array(
    '/entry-sheet'  =>  '<i class="fas fa-home"></i>ホーム',
    '/entry-sheet?type=practice' =>  '<i class="fas fa-book-open"></i>基礎から学ぶ',
    '/entry-sheet?type=challenge'  =>  '<i class="fas fa-user-tie"></i>実践チャレンジ',
    '/entry-sheet/view'  =>  '<i class="far fa-address-card"></i>あなたのES',
  );
  foreach($category_array as $category_each_key =>  $category_each_value){
    $url = $_SERVER["REQUEST_URI"];
    if($category_each_key == $url){
      $category_html .= '
      <li class="es-navi-each es-navi-selected">
        <a href="https://jobshot.jp'.$category_each_key.'">'.$category_each_value.'<span class="left"></span><span class="right"></span></a>
      </li>';
    }else{
      $category_html .= '
      <li class="es-navi-each">
        <a href="https://jobshot.jp'.$category_each_key.'">'.$category_each_value.'<span class="left"></span><span class="right"></span></a>
      </li>';
    }
  }
  $html = '
  <div class="es-navi">
    <h2 class="only-sp text-align-center">カテゴリーから探す</h2>
    <ul class="es-container">
      '.$category_html.'
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
    <a href="'.$home_url.'/entry-sheet/practice?category='.$es_get_param.'">
      <div class="es-card">
        <div class="es-card__image-holder">
          <img class="card__image" src="'.$home_url.'/wp-content/uploads/'.$es_contents[2].'" alt="wave" />
        </div>
        <div class="card-title">
          <h2>'.$es_contents[0].'<small><i class="fas fa-book-open"></i>基礎から学ぶ</small></h2>
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
    </a>
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
    <a href="'.$home_url.'/entry-sheet/challenge?category='.$es_get_param.'">
      <div class="es-card">
        <div class="es-card__image-holder">
          <img class="card__image" src="'.$home_url.'/wp-content/uploads/'.$es_contents[2].'" alt="wave" />
        </div>
        <div class="card-title">
          <h2>'.$es_contents[0].'<small><i class="fas fa-user-tie"></i>実践チャレンジ</small></h2>
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
    </a>
    ';
  }
  $challenge_card_html .= '</div>';

  //基礎から学ぶ、実践チャレンジの時はそれぞれ項目別練習、実践チャレンジのみを表示する
  if(isset($_GET['type'])){
    if($_GET['type'] == 'practice'){
      return $practice_card_html;
    }else{
      return $challenge_card_html;
    }
  }
  //一覧ページ
  $html = $practice_card_html.$challenge_card_html;
  return $html;
}
add_shortcode('view_es_type','view_es_type_func');

//項目別練習用のESフォーム(新規投稿・編集)
function new_es_form_practice(){
  if(isset($_GET['category'])){
    $category=$_GET['category'];
  }
  $user = wp_get_current_user();
  $user_id = get_current_user_id();
  $user_name = $user->data->display_name;
  $es_categories = get_es_categories('practice');
  $es_points = get_es_points('practice');

  //投稿ボタン
  $post_button_html = '
  <div class="es-submit-box">
    <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
    <input type="hidden" name="new_es_practice" value="new_es_practice">
    <input type="hidden" name="user_id" value="'.$user_id.'">
    <input type="hidden" name="correction" value="false">
    <input type="submit" name="publish" id="publish" class="es-submit-button" value="保存する">
  </div>';

  $es_content = '';
  //項目別練習のESを見るで編集ボタンが押されたときの処理
  if(!empty($_GET['post_id']) && !empty($_GET['action'])){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_user_id = get_userdata($post->post_author)->ID;
    $user_profile_image = get_user_profile_image($post_user_id);
    $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
    if($post->post_author == $user_id){
      $es_content = get_field("投稿内容",$post_id);
      $post_button_html = '
        <div class="es-submit-box">
          <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
          <input type="hidden" name="edit_es_practice" value="edit_es_practice">
          <input type="hidden" name="user_id" value="'.$user_id.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" name="publish" id="publish" class="es-submit-button" value="保存する">
        </div>';
      $new_html =  '
        <div class="es-framework-container">
          <div class="es-content-main">
            <div class="es-timeline_footer_avatar">
              <div class="es-timeline_footer_icon">
                <div class="es-avatar">
                  <img src="'.$user_profile_image.'">
                </div>
              </div>
              <div class="es-timeline_footer_name">
                  <span>'.$user_name.'</span>
              </div>
              <div class="es-timeline_footer_date">
                  <span>'.$uploaded_date.'</span>
              </div>
            </div>
            <div class="es-fav_status margin-10">
              <div class="es-fav_status_item">
                  <div class="es-fav_status_icon">
                      <i class="far fa-heart"></i>
                  </div>
                  <div class="es-fav_status_label">42</div>
              </div>
              <div class="es-category_item">項目別練習</div>
              <div class="es-category_item">'.$es_categories[$category][0].'</div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="es-content-box">
                <h3>'.$es_categories[$category][0].'</h3>
                <textarea class="es-content-textarea" name="es_content" placeholder="" height="100px" rows="4" required>'.$es_content.'</textarea>
              </div>
              '.$post_button_html.'
            </form>
          </div>
        </div>';
      return $new_html;
    }
  }
  $points_html = '';
  $point_count = 0;
  foreach($es_points[$category] as $es_point){
    $point_count += 1;
    $points_html .= '
    <div class="es-framework-box">
      <div class="es-framework-num">
        <h1 font-size="48px">0'.$point_count.'</h1>
        <div></div>
      </div>
      <div class="es-framework-main">
          <div class="es-framework-main-text">
              <h2 class="sc-ifAKCX hOCPBR">デザインのコツ : そろえる</h2>
              <div>
                '.$es_point.'
              </div>
          </div>
      </div>
    </div>
    ';
  }
  $new_html =  '
    <div class="es-framework-container">
      <div class="es-framework-head-container">
          <h3 class="es-framework-head-title">'.$es_categories[$category][0].'のフレームワーク</h3>
          <div class="es-framework-head-step-box">
              <p color="#FFFFFF">'.count($es_points[$category]).'</p>
          </div>
      </div>
      '.$points_html.'
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="es-content-box">
          <h3>実際にESを書いてみよう！</h3>
          <textarea class="es-content-textarea" name="es_content" placeholder="上記のフレームワークを活かしてESを書いてみよう!" height="100px" rows="4" required>'.$es_content.'</textarea>
        </div>
        '.$post_button_html.'
      </form>
    </div>';
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

  //過去のESを検索して、提出していたらボタンを提出済みに変更(ボタン)
  $args = array(
    'post_type' => 'entry_sheet',
    'post_status' => array('publish'),
    'posts_per_page' => 100,
    'meta_query' => array(
      array(
        'key' => '投稿先',
        'value' => $es_categories[$category][0]
      ),
      array(
        'key' => 'author_id',
        'value' => $user_id
      )
    )
  );
  $es_challenge = get_posts($args);
  $count = count($es_challenge);
  if($count == 0){
    $post_button_html = '
      <div class="es-submit-box">
        <input type="hidden" name="challenge_company" value="'.$es_categories[$category][0].'">
        <input type="hidden" name="new_es_challenge" value="new_es_challenge">
        <input type="hidden" name="user_id" value="'.$user_id.'">
        <input type="hidden" name="correction" value="true">
        <input type="submit" name="publish" id="publish" class="es-submit-button" value="投稿する">
      </div>';
  }else{
    $post_button_html = '
      <div class="es-submit-box">
          <button type="submit" class="es-submit-button" disabled>投稿済み</button>
      </div>';
  }


  $points_html = '';
  $point_count = 0;
  foreach($es_points[$category] as $es_point){
    $point_count += 1;
    $points_html .= '
    <div class="es-framework-box">
      <div class="es-framework-num">
        <h1 font-size="48px">0'.$point_count.'</h1>
        <div></div>
      </div>
      <div class="es-framework-main">
          <div class="es-framework-main-text">
              <h2 class="sc-ifAKCX hOCPBR">デザインのコツ : そろえる</h2>
              <div>
                '.$es_point.'
              </div>
          </div>
      </div>
    </div>
    ';
  }
  $new_html =  '
    <div class="es-framework-container">
      <div class="es-framework-head-container">
          <h3 class="es-framework-head-title">'.$es_categories[$category][0].'のフレームワーク</h3>
          <div class="es-framework-head-step-box">
              <p color="#FFFFFF">'.count($es_points[$category]).'</p>
          </div>
      </div>
      '.$points_html.'
      <form action="" method="POST" enctype="multipart/form-data">
        <p>ESのテーマ*</p>
        <div class="select_box select_box_01">
          <select name="es_category" required>
              <option value=""></option>
              <option value="学生時代力を入れたこと">学生時代力を入れたこと</option>
              <option value="自己PR">自己PR</option>
              <option value="長所・短所">長所・短所</option>
              <option value="志望動機">志望動機</option>
              <option value="最近のニュース">最近のニュース</option>
          </select>
        </div>
        <div class="es-content-box">
          <h3>実際にESを書いてみよう！</h3>
          <textarea class="es-content-textarea" name="es_content" placeholder="上記のフレームワークを活かしてESを書いてみよう!" height="100px" rows="4" required>'.$es_content.'</textarea>
        </div>
        '.$post_button_html.'
      </form>
    </div>';
  return $new_html;
}
add_shortcode('new_es_form_challenge','new_es_form_challenge');


//新規投稿された時の処理
function new_es_post(){
  if(!empty($_POST["new_es_practice"]) || !empty($_POST["new_es_challenge"])){
    $user = wp_get_current_user();
	  $user_id = $_POST["user_id"];
    $es_content = $_POST["es_content"];
    $es_category = $_POST["es_category"];
    $post_title = $es_category;

    //実践チャレンジの時は企業名を$challenge_companyで取得
    if(isset($_POST["challenge_company"])){
      $challenge_company = $_POST["challenge_company"];
      $post_title = $challenge_company.'/'.$es_category;
    }
    //添削するかどうかのフラグ
    $correction = $_POST["correction"];
    $user_name = $user->data->display_name;
		$es_type = 'entry_sheet';
    $post_value = array(
      'post_author' => $user_id,
      'post_title' => $post_title,
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
      update_post_meta($insert_id,'投稿先',$challenge_company);
      update_post_meta($insert_id, '投稿テーマ', $es_category);
      update_post_meta($insert_id, '投稿内容', $es_content);
      update_post_meta($insert_id,'correction',$correction);
      update_post_meta($insert_id,'author_id',$user_id);
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

//ESを見るページ(一覧・詳細ページ)
function view_past_es(){
  $home_url =esc_url( home_url( ));
  $user = wp_get_current_user();
  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);
  $user_name = $user_info->user_login;
  //詳細を見るボタンが押された時の表示
  if(!empty($_GET["post_id"]) && !empty($_GET["action"])){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_user_id = get_userdata($post->post_author)->ID;
    $user_profile_image = get_user_profile_image($post_user_id);
    $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
    $post_status = get_post_meta($post_id,'correction',true);
    if($post_status == 'true'){
      $es_categories = get_es_categories('challenge');
      $es_points = get_es_points('challenge');
    }else{
      $es_categories = get_es_categories('practice');
      $es_points = get_es_points('practice');
    }
    if($post->post_author == $user_id){
      $es_category = get_field("投稿テーマ",$post_id);

      //実践チャレンジの時は$es_categoryに企業名を代入、subに５つのカテゴリの中の１つを代入
      if($post_status == 'true'){
        $es_category_sub = get_field("投稿テーマ",$post_id);
        $es_category = get_field("投稿先",$post_id);
      }

      $es_urls = get_es_url();
	    $es_url = $es_urls[$es_category];
      $es_content = get_field("投稿内容",$post_id);
      $es_corrector = get_field("添削者",$post_id);
      $es_corrector_image = get_field("添削者イメージ画像",$post_id);
      if(empty($es_corrector_image)){
        $es_corrector_image = 'https://source.unsplash.com/random/200x200';
      }
      $es_corrector_team = get_field("添削者所属",$post_id);
      $es_correction = get_field("添削内容",$post_id);
      $es_kansei = get_field("完成es",$post_id);
      if($post_status == 'true'){
        $html = '
          <div class="es-framework-container">
            <div class="es-content-main">
                <div class="es-timeline_footer_avatar">
                    <div class="es-timeline_footer_icon">
                      <div class="es-avatar">
                          <img src="'.$user_profile_image.'">
                      </div>
                    </div>
                    <div class="es-timeline_footer_name">
                        <span>'.$user_name.'</span>
                    </div>
                    <div class="es-timeline_footer_date">
                        <span>'.$uploaded_date.'</span>
                    </div>
                </div>
                <div class="es-fav_status margin-10">
                    <div class="es-fav_status_item">
                        <div class="es-fav_status_icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="es-fav_status_label">42</div>
                    </div>
                    <div class="es-category_item">実践チャレンジ</div>
                    <div class="es-category_item">'.$es_category_sub.'</div>
                </div>
                <div class="es-detail-content-box">
                    <div class="es-content-box-text">'.$es_content.'</div>
                </div>
            </div>
            <hr>
            <div>
                <div class="es-timeline_footer_avatar">
                    <div class="es-timeline_footer_icon">
                      <div class="es-avatar">
                          <img src="'.$es_corrector_image.'">
                      </div>
                    </div>
                    <div class="es-timeline_footer_name">
                        <span>'.$es_corrector.'</span>
                    </div>
                    <div class="es-timeline_footer_date">
                        <span>'.$es_corrector_team.'</span>
                    </div>
                </div>
                <div class="es-content-box">
                <div class="es-content-box-text">'.$es_correction.'</div>
                </div>
            </div>
            <hr>
            <div>
                <div class="es-framework-head-container margin-buttom-0">
                    <h3 class="es-framework-head-title">完成ES</h3>
                </div>
                <div class="es-content-box">
                <div class="es-content-box-text">'.$es_kansei.'</div>
                </div>
            </div>
        </div>
        ';
      }else{
        $html = '
          <div class="es-framework-container">
            <div class="es-content-main">
                <div class="es-timeline_footer_avatar">
                    <div class="es-timeline_footer_icon">
                      <div class="es-avatar">
                          <img src="'.$user_profile_image.'">
                      </div>
                    </div>
                    <div class="es-timeline_footer_name">
                        <span>'.$user_name.'</span>
                    </div>
                    <div class="es-timeline_footer_date">
                        <span>'.$uploaded_date.'</span>
                    </div>
                </div>
                <div class="es-content-edit">
                  <i class="fas fa-pen-fancy"></i>
                  <a href="/entry-sheet/practice?post_id='.$post_id.'&category='.$es_url.'&action=edit">編集</a>
                </div>
                <div class="es-content-edit-delete-between">|</div>
                <div class="es-content-delete">
                  <form action="" method="POST" enctype="multipart/form-data">
                    <i class="fas fa-trash"></i>
                    <input type="hidden" name="post_id" value="'.$post_id.'">
                    <input type="submit" name="es-delete" id="es-delete" class="" value="削除">
                  </form>
                </div>
                <div class="es-fav_status margin-10">
                    <div class="es-fav_status_item">
                        <div class="es-fav_status_icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <div class="es-fav_status_label">42</div>
                    </div>
                    <div class="es-category_item">項目別練習</div>
                    <div class="es-category_item">'.$es_category.'</div>
                </div>
                <div class="es-detail-content-box">
                <div class="es-content-box-text">'.$es_content.'</div>
                </div>
            </div>
          </div>
      ';
      }
    }
  }else{
    //ESを見るの一覧ページ
    $es_total = get_past_es($user_id,'all');
    foreach($es_total as $es){
      $post_id = $es->ID;
      $post = get_post($post_id);
      $post_user_id = get_userdata($post->post_author)->ID;
      $user_profile_image = get_user_profile_image($post_user_id);
      $post_status = get_post_meta($post_id,'correction',true);
      $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
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
      if($post_status == 'true'){
        $es_category = $es->post_title;
        $es_type = '実践チャレンジ';
        $es_description_image = '2020/03/max-bender-FuxYvi-hcWQ-unsplash-e1583138722808.jpg';
      }else{
        $es_category = get_field("投稿テーマ",$post_id);
        $es_type = '項目別練習';
        $es_url = get_es_url();
        $es_categories = get_es_categories("practice");
        $es_category_en = $es_url[$es_category];
        $es_description_image = $es_categories[$es_category_en][2];
      }
      $es_card_html .= '
        <div class="es-timeline__item">
          <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show">
            <section class="es-text-box">
              <div class="es-text__body">
                <div class="es-text__eyecatch">
                  <img src="'.$home_url.'/wp-content/uploads/'.$es_description_image.'">
                </div>
                <h3 class="es-text__title">'.$es_category.'</h3>
                <p class="es-text__description">'.$es_content.'</p>
                <div class="es-fav_status">
                  <div class="es-fav_status_item">
                    <div class="es-fav_status_icon">
                      <i class="far fa-heart"></i>
                    </div>
                    <div class="es-fav_status_label">42</div>
                  </div>
                  <div class="es-category_item">'.$es_type.'</div>
                </div>
              </div>
              <div class="es-timeline_footer">
                <div class="es-timeline_footer_avatar">
                  <div class="es-timeline_footer_icon">
                    <div class="es-avatar">
                      <img src="'.$user_profile_image.'">
                    </div>
                  </div>
                  <div class="es-timeline_footer_name">
                    <span>'.$user_name.'</span>
                  </div>
                  <div class="es-timeline_footer_date">
                    <span>'.$uploaded_date.'</span>
                  </div>
                </div>
                <div class="o-like">
                  <button aria-label="heart"></button>
                </div>
              </div>
            </section>
          </a>
        </div>
      ';
    }
    $es_count =  count($es_total);
    if($es_count>0){
      $html = '
        <div class="es-title-container">
          <h2 class="es-title">あなたのES</h2>
        </div>
        <div class="es-cards-container">'.$es_card_html.'</div>';
    }else{
      $html = '
        <div class="es-title-container">
          <h2 class="es-title">あなたのES</h2>
        </div>
        <div class="es-title-container">
          <p>過去のESがありません</br>基礎から学ぶや実践チャレンジに取り組みましょう</p>
        </div>';
    }
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
    exit();
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


//管理画面に添削(true or falseを追加)
function add_entry_sheet_column( $defaults ) {
  $defaults['correction'] = '添削';
  return $defaults;
  }
add_filter('manage_entry_sheet_posts_columns', 'add_entry_sheet_column');

function add_custom_column_id($column_name, $id) {
  if( $column_name == 'correction' ) {
    $correction = get_post_meta($id, 'correction', true);
    if($correction == 'true'){
      echo 'true';
    }else{
      echo 'false';
    }
  }
}
add_action('manage_entry_sheet_posts_custom_column', 'add_custom_column_id', 10, 2);

//削除されたときのリダイレクト先を指定
function post_unpublished( $new_status, $old_status, $post ) {
  if ( $old_status == 'publish'  &&  $new_status == 'trash' ) {
	$now_url = get_the_permalink();
    if($now_url == 'https://jobshot.jp/entry-sheet/view'){
      $home_url =esc_url( home_url( ));
      header('Location: '.$now_url);
      die();
    }
  }
}
add_action( 'transition_post_status', 'post_unpublished', 10, 3 );

//過去のESを取得する($user_idと$correctionで場合わけ)
function get_past_es($user_id,$correction){
  if($user_id == 'all' && $correction == 'all'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
      'orderby'          => 'date',
    );
  }elseif($user_id == 'all' && $correction != 'all'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
      'orderby'          => 'date',
      'meta_query' => array(
        array(
          'key' => 'correction',
          'value' => $correction
        )
      )
    );
  }elseif($user_id != 'all' && $correction == 'all'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
      'orderby'          => 'date',
      'meta_query' => array(
        array(
          'key' => 'author_id',
          'value' => $user_id
        )
      )
    );
  }else{
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
      'orderby'          => 'date',
      'meta_query' => array(
        array(
          'key' => 'author_id',
          'value' => $user_id
        ),
        array(
          'key' => 'correction',
          'value' => $correction
        )
      )
    );
  }
  $es = get_posts($args);
  return $es;
}

/**
 * 管理画面の投稿一覧にカスタムフィールドの絞り込み選択機能を追加します。
 */
function restrict_manage_posts_custom_field() {
	// 投稿タイプが投稿の場合 (カスタム投稿タイプのみに適用したい場合は 'post' をカスタム投稿タイプの内部名に変更してください)
	if ( 'entry_sheet' == get_current_screen()->post_type ) {
		// カスタムフィールドのキー(名称例)
		$meta_key = 'correction';

		// カスタムフィールドの値の一覧(例。「=>」の左側が保存されている値、右側がプルダウンに表示する名称です。)
		$items = array( '' => 'すべてのES', 'true' => '〇', 'false' => '-' );
		// Advanced Custom Fields を導入してフィールドタイプをセレクトボックスなど
		// 選択肢のあるタイプにしている場合は下記のような形でも可です。
		// $field = get_field_object($meta_key);
		// $items = array_merge( array( '' => 'すべての色' ), $field['choices'] );

		// 選択されている値
		// ( query_vars フィルタでカスタムフィールドのキーを登録している場合は get_query_var( $meta_key ) でも可です )
		$selected_value = filter_input( INPUT_GET, $meta_key );

		// プルダウンのHTML
		$output = '';
		$output .= '<select name="' . esc_attr($meta_key) . '">';
		foreach ( $items as $value => $text ) {
			$selected = selected( $selected_value, $value, false );
			$output .= '<option value="' . esc_attr($value) . '"' . $selected . '>' . esc_html($text) . '</option>';
		}
		$output .= '</select>';

		echo $output;
	}
}
add_action( 'restrict_manage_posts', 'restrict_manage_posts_custom_field' );

/**
 * 管理画面の投稿一覧に追加したカスタムフィールドの絞り込みの選択値を反映させます。
 * (絞り込みが必要なカスタムフィールドが1つの場合)]
 * $query クエリオブジェクト
 */
function pre_get_posts_admin_custom_field( $query ) {
	// 管理画面 / 投稿タイプが投稿 / メインクエリ、のすべての条件を満たす場合
	// (カスタム投稿タイプのみに適用したい場合は 'post' をカスタム投稿タイプの内部名に変更してください)
	if ( is_admin() && 'entry_sheet' == get_current_screen()->post_type && $query->is_main_query() ) {
		// カスタムフィールドのキー(名称例)
		$meta_key = 'correction';
		// 選択されている値
		// ( query_vars フィルタでカスタムフィールドのキーを登録している場合は get_query_var( $meta_key ) でも可です )
		$meta_value = filter_input( INPUT_GET, $meta_key );

		// クエリの検索条件に追加
		// (すでに他のカスタムフィールドの条件がセットされている場合は条件を引き継いで新しい条件を追加する形になります)
		if ( strlen( $meta_value ) ) {
			$meta_query = $query->get( 'meta_query' );
			if ( ! is_array( $meta_query ) ) $meta_query = array();

			$meta_query[] = array(
				'key' => $meta_key,
				'value' => $meta_value
			);

			$query->set( 'meta_query', $meta_query );
		}
	}
}
add_action( 'pre_get_posts', 'pre_get_posts_admin_custom_field' );

// プロフィール写真を取得する関数
function get_user_profile_image($user_id){
  $upload_dir = wp_upload_dir();
  $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
  if(!file_exists($upload_file_name)){
    $attachment_id=2632;
    $upload_file_name = wp_get_attachment_image_src($attachment_id)[0];
  }
  return $upload_file_name;
}