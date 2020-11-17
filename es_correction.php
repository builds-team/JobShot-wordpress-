<?php

//favoriteの更新関数
function update_favorite_count(){
  if(isset($_POST['post_id'])){
  $post_id = $_POST['post_id'];
  }
  $result = '';
  if(is_user_logged_in()){
    if (current_user_can('student') || current_user_can('administrator')) {
      $user_id = get_current_user_id();
      //favの配列
      $fav_array = get_post_meta($post_id,'favorite',true);
      if(empty($fav_array)){
        $fav_array = array();
      }
      //favを増やす時
      if(!in_array($user_id,$fav_array)){
        array_push( $fav_array,$user_id);
      }else{
        unset($fav_array[array_keys($fav_array, $user_id)[0]]);
      }
      update_post_meta($post_id,'favorite',$fav_array);
    }
  }else {
    $result = '
    <div class="modal__mask" style="display: block;">
      <div class="modal__login">
          <div class="modal__login__description">
              <p class="modal__login__first-line"><span class="modal__login__company-name">東大</span>２２卒学部就活生</p>
              <p class="modal__login__second-line">の<span class="modal__login__proportion">６人に１人</span>が</p>
              <p class="modal__login__third-line"><span style="font-size: 160%;"></span>登録しています</p>
          </div>
          <div class="modal__login__btn">
              <a class="modal__login__register-btn" href="https://jobshot.jp/regist" onclick="gtag(\'event\', \'click\', {\'event_category\': \'link\', \'event_label\': \'popup_new\'});">
                  <span>無料登録をする</span>
              </a>
              <p>または<a href="https://jobshot.jp/login" onclick="gtag(\'event\', \'click\', {\'event_category\': \'link\', \'event_label\': \'popup_login\'});">ログイン</a></p>
          </div>
          <div class="modal__cancel__btn google-icon" onclick="$(\'.modal__mask\').css(\'display\', \'none\')">
          </div>
      </div>
    </div>
    ';
  }
  echo $result;
  die();
}
add_action( 'wp_ajax_update_favorite_count', 'update_favorite_count' );
add_action( 'wp_ajax_nopriv_update_favorite_count', 'update_favorite_count' );


//ES用のサイドバーの追加
function add_sidebar_es(){
  $home_url =esc_url( home_url());
  $category_array = array(
    '/entry-sheet'  =>  '<i class="fas fa-home"></i>ホーム',
    '/entry-sheet?type=practice' =>  '<i class="fas fa-book-open"></i>基礎から学ぶ',
    '/entry-sheet?type=challenge'  =>  '<i class="fas fa-user-tie"></i>実践チャレンジ',
    '/entry-sheet/view'  =>  '<i class="far fa-address-card"></i>あなたのES',
    '/entry-sheet/view/favorite' => '<i class="far fa-heart"></i>お気に入りのES'
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
  $user_id = get_current_user_id();
  $es_total = get_past_es('all','all','publish');
  $es_timeline_html = '
    <div class="es-title-container">
      <h2 class="es-title">みんなのES</h1>
    </div>';
  $paged = get_query_var( 'paged' );
  $paged = $paged ?: 1;
  for($i=($paged-1)*5;$i<$paged*5;$i++){
	if($i<count($es_total)){
		$es_card_html .= view_other_es($es_total[$i],$user_id,100);
	}else{
	  break;
	}
  }
  $es_timeline_html .= '<div class="es-cards-container">'.$es_card_html.'</div>'.paginate(ceil(count($es_total)/5), get_query_var( 'paged' ), count($es_total), 5);
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
  if (!is_user_logged_in()){
    $html = '<p class="text-align-center"><i class="fas fa-lock"></i>エントリーシート機能は会員限定です。JobShotに登録すると利用することができます。</p>';
    $html .= apply_redirect();
    return $html;
  }
  //基礎から学ぶ、実践チャレンジの時はそれぞれ項目別練習、実践チャレンジのみを表示する
  if(isset($_GET['type'])){
    if($_GET['type'] == 'practice'){
      return $practice_card_html;
    }else{
      return $challenge_card_html;
    }
  }
  //一覧ページ
  
  $html .= $es_timeline_html.$practice_card_html.$challenge_card_html;
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
  $user_info = get_userdata($user_id);
  $user_name = $user_info->user_login;
  $es_categories = get_es_categories('practice');
  $es_points = get_es_points('practice');

  //投稿ボタン
  $post_button_html = '
  <div class="es-submit-box">
    <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
    <input type="hidden" name="new_es_practice" value="new_es_practice">
    <input type="hidden" name="user_id" value="'.$user_id.'">
    <input type="hidden" name="correction" value="false">
    <input type="submit" name="publish" id="publish" class="es-submit-button" value="公開する">
  </div>
  <div class="es-submit-box">
    <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
    <input type="hidden" name="new_es_practice" value="new_es_practice">
    <input type="hidden" name="user_id" value="'.$user_id.'">
    <input type="hidden" name="correction" value="false">
    <input type="submit" name="save" id="save" class="es-submit-button es__save" value="下書き保存する">
  </div>';

  $es_content = '';
  //項目別練習のESを見るで編集ボタンが押されたときの処理
  if(!empty($_GET['post_id']) && !empty($_GET['action'])){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_user_id = get_userdata($post->post_author)->ID;
    $user_profile_image = get_user_profile_image($post_user_id);
    $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
    $fav_array = get_post_meta($post_id,'favorite',true);
    $fav_count = count($fav_array);
    $comment_array = get_post_meta($post_id,'コメント',false)[0];
    $comment_count = count($comment_array);
    if(in_array($user_id,$fav_array)){
      $fav_button_class = 'btn favorite-button es-like-active';
    }else{
      $fav_button_class='btn favorite-button';
    }
    if($post->post_author == $user_id){
      $es_content = get_field("投稿内容",$post_id);
      $post_button_html = '
        <div class="es-submit-box">
          <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
          <input type="hidden" name="edit_es_practice" value="edit_es_practice">
          <input type="hidden" name="user_id" value="'.$user_id.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" name="publish" id="publish" class="es-submit-button" value="公開する">
        </div>
        <div class="es-submit-box">
          <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
          <input type="hidden" name="edit_es_practice" value="edit_es_practice">
          <input type="hidden" name="user_id" value="'.$user_id.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" name="save" id="save" class="es-submit-button es__save" value="下書き保存する">
        </div>
        ';
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
                    <button class="btn favorite-button_sub" value="'.$post_id.'">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                  <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
              </div>
              <div class="es-fav_status_item">
                <div class="comment__count">
                  <i class="far fa-comments"></i>
                </div>
                <div class="es-fav_status_label">'.$comment_count.'</div>
              </div>
              <div class="es-category_item">項目別練習</div>
              <div class="es-category_item">'.$es_categories[$category][0].'</div>
              <div class="es-like" style="margin:3px; height:24px;">
                <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                  <i class="fa fa-heart"></i>
                </button>
              </div>
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
  $es_company = get_es_company($category);
  $es_example = get_es_example($category);
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
            <h2 class="sc-ifAKCX hOCPBR">'.$es_point['title'].'</h2>
            <div>'.$es_point['text'].'</div>
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
      '.$points_html.$es_company.$es_example.'
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="es-content-box">
          <h3>実際にESを書いてみよう！</h3>
          <textarea class="es-content-textarea" name="es_content" placeholder="上記のフレームワークを活かしてESを書いてみよう!" height="100px" rows="4" required>'.$es_content.'</textarea>
        </div>
        '.$post_button_html.'
      </form>
    </div>';
  if (!is_user_logged_in()){
    $new_html = '<p class="text-align-center"><i class="fas fa-lock"></i>エントリーシート機能は会員限定です。JobShotに登録すると利用することができます。</p>';
    $new_html .= apply_redirect();
  }
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
  $user_info = get_userdata($user_id);
  $user_name = $user_info->user_login;
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
      </div>
      ';
  }else{
    $post_button_html = '
      <div class="es-submit-box">
          <button type="submit" class="es-submitted-button" disabled>投稿済み</button>
      </div>';
  }


  $points_html = '';
  $point_count = 0;
  foreach($es_points[$category]['point'] as $es_point_each){
    $point_count += 1;
    $points_html .= '
    <div class="es-framework-box">
      <div class="es-framework-num">
        <h1 font-size="48px">0'.$point_count.'</h1>
        <div></div>
      </div>
      <div class="es-framework-main">
          <div class="es-framework-main-text margin-5">
            <h2 class="sc-ifAKCX hOCPBR">'.$es_point_each.'</h2>
          </div>
      </div>
    </div>';
  }
  $profile_html = '
    <div class="es-framework-head-container">
      <h3 class="es-framework-head-title">添削者紹介</h3>
    </div>
    <section>
      <div class="sectionVoice">
          <div class="sectionVoice__img">
              <img src="'.$home_url.'/wp-content/uploads/2020/02/1544077823-1.png" alt="">
          </div>
          <div class="sectionVoice__comment">
              <p class="sectionVoice__ttl">'.$es_points[$category]['profile']['title'].'</p>
              <p class="sectionVoice__txt">'.$es_points[$category]['profile']['text'].'</p>
          </div>
      </div>
    </section>';
  $es_practice_cate = get_es_categories('practice');
  $es_categories_val= array_values($es_practice_cate);
  $selection_html = '<option value="">---下記からお選びください---</option>';
  foreach($es_categories_val as $es_category_val){
    $selection_html .= '<option value="'.$es_category_val[0].'">'.$es_category_val[0].'</option>';
  }
  $new_html =  '
    <div class="es-framework-container">
      <div class="es-framework-head-container">
          <h3 class="es-framework-head-title">'.$es_categories[$category][0].'チャレンジとは？</h3>
      </div>
      '.$points_html.'
      '.$profile_html.'
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="es-content-box">
          <h3>実際にESを書いてみよう！</h3>
          <p>ESのテーマ*</p>
          <div class="select_box select_box_01">
            <select name="es_category" required>
              '.$selection_html.'
            </select>
          </div>
          <textarea class="es-content-textarea" name="es_content" placeholder="上記のテーマを選んでESを提出してみよう!" height="100px" rows="4" required>'.$es_content.'</textarea>
        </div>
        '.$post_button_html.'
      </form>
    </div>';

  if (!is_user_logged_in()){
    $new_html = '<p class="text-align-center"><i class="fas fa-lock"></i>エントリーシート機能は会員限定です。JobShotに登録すると利用することができます。</p>';
    $new_html .= apply_redirect();
  }
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
      update_post_meta($insert_id,'favorite',array());
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
    if($user_id != $post_user_id){
      $post_user_graduate_year = get_user_meta($post_user_id,'graduate_year',false)[0];
      if(!empty($post_user_graduate_year)){
        $post_user_graduate_year = substr(strval($post_user_graduate_year),2,2).'年卒・';
      }
      $post_user_gender = get_user_meta($post_user_id,'gender',false)[0][0];
      $post_user_university = get_user_meta($post_user_id,'university',false)[0].'・';
      if($post_user_gender == '男性'){
        $user_profile_image = wp_get_attachment_image_src(9343)[0];
      }else{
        $user_profile_image = wp_get_attachment_image_src(9344)[0];
      }
    }else{
      $user_profile_image = get_user_profile_image($post_user_id);
    }
      
    
    $post_user_info = get_userdata($post_user_id);
    $post_user_name = $post_user_info->user_login;
    $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
    $post_status = get_post_meta($post_id,'correction',true);
    if($post_status == 'true'){
      $es_categories = get_es_categories('challenge');
      $es_points = get_es_points('challenge');
    }else{
      $es_categories = get_es_categories('practice');
      $es_points = get_es_points('practice');
    }
    
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
      $fav_array = get_post_meta($post_id,'favorite',true);
      $fav_count = count($fav_array);
      $comment_array = get_post_meta($post_id,'コメント',false)[0];
      $comment_count = count($comment_array);
      if(in_array($user_id,$fav_array)){
        $fav_button_class = 'btn favorite-button es-like-active';
      }else{
        $fav_button_class='btn favorite-button';
      }
      $user_roles = $user->roles;
      if($post->post_author == $user_id){
        $edit_html = '
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
      </div>';
      }


      if($post->post_author != $user_id  && !in_array("company", $user_roles)){
        $comment_button_html = '
          <div class="es-submit-box">
            <input type="hidden" name="user_id" value="'.$user_id.'">
            <input type="hidden" name="post_id" value="'.$post_id.'">
            <input type="submit" name="comment_es" class="es-submit-button" value="コメントする">
          </div>
        ';
        $comment_html = '
          <div class="es-framework-container">
            <div class="es-content-main">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="es-content-box">
                  <textarea class="es-content-textarea" name="comment" placeholder="" height="100px" rows="4" required></textarea>
                </div>
                '.$comment_button_html.'
              </form>
            </div>
          </div>
        ';
      }

      $comment_array = get_post_meta($post_id,'コメント',false)[0];
      if(!empty($comment_array)){
        $commented_html = '
          <div class="es-title-container">
            <h2 class="es-title">みんなからのコメント</h1>
          </div>
        ';
		  
        foreach($comment_array as $comment_set){
          $comment_user_id = $comment_set[0];
          $comment = $comment_set[1];
          $comment_user_graduate_year = get_user_meta($comment_user_id,'graduate_year',false)[0];
          if(!empty($comment_user_graduate_year)){
            $comment_user_graduate_year = substr(strval($comment_user_graduate_year),2,2).'年卒・';
          }
          $comment_user_gender = get_user_meta($comment_user_id,'gender',false)[0][0];
          $comment_user_university = get_user_meta($comment_user_id,'university',false)[0].'・';
          if($comment_user_gender == '男性'){
            $comment_user_profile_image = wp_get_attachment_image_src(9343)[0];
          }else{
            $comment_user_profile_image = wp_get_attachment_image_src(9344)[0];
          }
          $commented_html .= '
          <div class="es-framework-container">
              <div class="es-content-main">
                  <div class="es-timeline_footer_avatar">
                      <div class="es-timeline_footer_icon">
                        <div class="es-avatar">
                          <img src="'.$comment_user_profile_image.'">
                        </div>
                      </div>
                      <div class="es-timeline_footer_name">
                          <span>'.$comment_user_university.$comment_user_graduate_year.$comment_user_gender.'</span>
                      </div>
                  </div>
                  <div class="es-detail-content-box">
                    <div class="es-content-box-text">'.$comment.'</div>
                  </div>
              </div>
            </div>
        ';
        }
      }
      if($post_status == 'true'){
        if(!empty($es_correction)){
          $correction_html = '
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
          '.$commented_html.$comment_html;
        }
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
                        <span>'.$post_user_university.$post_user_graduate_year.$post_user_gender.'</span>
                    </div>
                    <div class="es-timeline_footer_date">
                        <span>'.$uploaded_date.'</span>
                    </div>
                </div>
                <div class="es-fav_status margin-10">
                    <div class="es-fav_status_item">
                        <div class="es-fav_status_icon">
                          <button class="btn favorite-button_sub" value="'.$post_id.'">
                            <i class="far fa-heart"></i>
                          </button>
                        </div>
                        <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
                    </div>
                    <div class="es-fav_status_item">
                      <div class="comment__count">
                        <i class="far fa-comments"></i>
                      </div>
                      <div class="es-fav_status_label">'.$comment_count.'</div>
                    </div>
                    <div class="es-category_item">実践チャレンジ</div>
                    <div class="es-category_item">'.$es_category_sub.'</div>
                    <div class="es-like" style="margin:3px; height:24px;">
                      <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                        <i class="fa fa-heart"></i>
                      </button>
                    </div>
                </div>
                <div class="es-detail-content-box">
                    <div class="es-content-box-text">'.$es_content.'</div>
                </div>
            </div>
            '.$correction_html.'
        </div>
        '.$commented_html.$comment_html;
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
                        <span>'.$post_user_university.$post_user_graduate_year.$post_user_gender.'</span>
                    </div>
                    <div class="es-timeline_footer_date">
                        <span>'.$uploaded_date.'</span>
                    </div>
                </div>
                '.$edit_html.'
                <div class="es-fav_status margin-10">
                    <div class="es-fav_status_item">
                        <div class="es-fav_status_icon">
                          <button class="btn favorite-button_sub" value="'.$post_id.'">
                            <i class="far fa-heart"></i>
                          </button>
                        </div>
                        <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
                    </div>
                    <div class="es-fav_status_item">
                      <div class="comment__count">
                        <i class="far fa-comments"></i>
                      </div>
                      <div class="es-fav_status_label">'.$comment_count.'</div>
                    </div>
                    <div class="es-category_item">項目別練習</div>
                    <div class="es-category_item">'.$es_category.'</div>
                    <div class="es-like" style="margin:3px; height:24px;">
                      <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                        <i class="fa fa-heart"></i>
                      </button>
                    </div>
                </div>
                <div class="es-detail-content-box">
                  <div class="es-content-box-text">'.$es_content.'</div>
                </div>
            </div>
          </div>
      '.$commented_html.$comment_html;
      }
    //}
  }else{
    //ESを見るの一覧ページ
    $es_total = get_past_es($user_id,'all','publish');
    $es_draft = get_past_es($user_id,'all','draft');
    $published_count = count($es_total);
    $count = 0;
    $es_total = array_merge($es_total,$es_draft);
    foreach($es_total as $es){
      $count += 1;
      $post_id = $es->ID;
      $post = get_post($post_id);
      $post_user_id = get_userdata($post->post_author)->ID;
      $post_user_info = get_userdata($post_user_id);
      $post_user_name = $post_user_info->user_login;
      $user_profile_image = get_user_profile_image($post_user_id);
      $post_status = get_post_meta($post_id,'correction',true);
      $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
      $es_content = get_field("投稿内容",$post_id);
      $es_corrector = get_field("添削者",$post_id);
      $es_category_ja = get_field("投稿先",$post_id);
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
        $es_url = get_es_url();
        $es_categories = get_es_categories("challenge");
        $es_category_en = $es_url[$es_category_ja];
        $es_description_image = $es_categories[$es_category_en][2];
      }else{
        $es_category = get_field("投稿テーマ",$post_id);
        $es_type = '項目別練習';
        $es_url = get_es_url();
        $es_categories = get_es_categories("practice");
        $es_category_en = $es_url[$es_category];
        $es_description_image = $es_categories[$es_category_en][2];
      }
      $fav_array = get_post_meta($post_id,'favorite',true);
      $fav_count = count($fav_array);
      $comment_array = get_post_meta($post_id,'コメント',false)[0];
      $comment_count = count($comment_array);
      if(in_array($user_id,$fav_array)){
        $fav_button_class = 'btn favorite-button es-like-active';
      }else{
        $fav_button_class='btn favorite-button';
      }
      if ($count == $published_count+1){
        $es_card_html .= '<div class="es-title-container"><h2 class="es-title">あなたのES(下書き)</h2></div>';
      }
      if($count > $published_count){
        $post_button_html = '
        <div class="es-submit-box">
          <input type="hidden" name="es_category" value="'.$es_categories[$es_category_en][0].'">
          <input type="hidden" name="edit_es_practice" value="edit_es_practice">
          <input type="hidden" name="user_id" value="'.$user_id.'">
          <input type="hidden" name="post_id" value="'.$post_id.'">
          <input type="submit" name="publish" id="publish" class="es-submit-button" value="公開する">
        </div>
        ';
        $publish_html = '
          <div style="height:25px">
            <form action="" method="POST" enctype="multipart/form-data">
              <textarea class="es-content-textarea" name="es_content" placeholder="" height="100px" rows="4" required style="display:none;">'.$es_content.'</textarea>
            '.$post_button_html.'
            </form>
          </div>';
      }
      $es_card_html .= '
        <div class="es-timeline__item">
          <div class="es-timeline__card">
            <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show">
              <div class="es-text__body">
                <div class="es-text__eyecatch">
                  <img src="'.$home_url.'/wp-content/uploads/'.$es_description_image.'">
                </div>
                <h3 class="es-text__title">'.$es_category.'</h3>
                <p class="es-text__description">'.$es_content.'</p>
                <div class="es-fav_status">
                  <div class="es-fav_status_item">
                    <div class="es-fav_status_icon">
                      <button class="btn favorite-button_sub" value="'.$post_id.'">
                        <i class="far fa-heart"></i>
                      </button>
                    </div>
                    <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
                  </div>
                  <div class="es-fav_status_item">
                    <div class="comment__count">
                      <i class="far fa-comments"></i>
                    </div>
                    <div class="es-fav_status_label">'.$comment_count.'</div>
                  </div>
                  <div class="es-category_item">'.$es_type.'</div>
                </div>
              </div>
            </a>
            <div class="es-timeline_footer">
              <div class="es-timeline_footer_avatar">
                <div class="es-timeline_footer_icon">
                  <div class="es-avatar">
                    <img src="'.$user_profile_image.'">
                  </div>
                </div>
                <div class="es-timeline_footer_name">
                  <span>'.$post_user_name.'</span>
                </div>
                <div class="es-timeline_footer_date">
                  <span>'.$uploaded_date.'</span>
                </div>
              </div>
              <div class="es-like">
                  <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                    <i class="fa fa-heart"></i>
                  </button>
              </div>
            </div>
          </div>
          '.$publish_html.'
        </div>
      ';
    }
    $es_count =  count($es_total);
    if($es_count>0){
      $html = '
        <div class="es-title-container">
          <h2 class="es-title">あなたのES（公開済み）</h2>
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
  if (!is_user_logged_in()){
    $html = '<p class="text-align-center"><i class="fas fa-lock"></i>エントリーシート機能は会員限定です。JobShotに登録すると利用することができます。</p>';
    $html .= apply_redirect();
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
    if(!empty($_POST["save"])){
      $post_status = "draft";
    }
    if(!empty($_POST["publish"])){
      $post_status = "publish";
    }
    wp_update_post(array(
      'ID'    =>  $post_id,
      'post_status'   =>  $post_status,
    ));
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
      echo "<a href="."https://jobshot.jp/wp-admin/edit.php?post_type=entry_sheet&correction=true".">〇</a>";
    }else{
      echo "<a href="."https://jobshot.jp/wp-admin/edit.php?post_type=entry_sheet&correction=false".">-</a>";
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
function get_past_es($user_id,$correction,$post_status){
  if($user_id == 'all' && $correction == 'all'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
	    'paged' => 1,
      'orderby'          => 'modified',
    );
  }elseif($user_id == 'all' && $correction != 'all'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
	  'paged' => 1,
      'orderby'          => 'modified',
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
	  'paged' => 1,
      'orderby'          => 'modified',
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
	  'paged' => 1,
      'orderby'          => 'modified',
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
  if($post_status == 'draft'){
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('draft'),
      'posts_per_page' => 100,
      'paged' => 1,
      'orderby'          => 'modified',
      'meta_query' => array(
        array(
          'key' => 'author_id',
          'value' => $user_id
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
	if ( is_admin() && 'entry_sheet' == $_GET['post_type'] && $query->is_main_query() ) {
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

//postメタからuser_idがあるものだけを取得して表示する
function view_fav_es($user_id){
  $home_url =esc_url( home_url( ));
  $user = wp_get_current_user();
  $user_id = get_current_user_id();
  $user_info = get_userdata($user_id);
  $user_name = $user_info->user_login;
  //ESを見るの一覧ペー
  $es_total = get_past_es('all','all','published');
  foreach($es_total as $es){
    //$es_card_html .= view_other_es($es,$user_id);
    $post_id = $es->ID;
    $post = get_post($post_id);
    $post_user_id = get_userdata($post->post_author)->ID;
    $post_user_info = get_userdata($post_user_id);
    $post_user_name = $post_user_info->user_login;
    if ($post_user_id != $user_id){
      $post_user_graduate_year = get_user_meta($post_user_id,'graduate_year',false)[0];
      if(!empty($post_user_graduate_year)){
        $post_user_graduate_year = substr(strval($post_user_graduate_year),2,2).'年卒・';
      }
      $post_user_gender = get_user_meta($post_user_id,'gender',false)[0][0];
      $post_user_university = get_user_meta($post_user_id,'university',false)[0].'・';
    }
    if($user_id == $post_user_id){
      $user_profile_image = get_user_profile_image($post_user_id);
    }else{
      if($post_user_gender == '男性'){
        $user_profile_image = wp_get_attachment_image_src(9343)[0];
      }else{
        $user_profile_image = wp_get_attachment_image_src(9344)[0];
      }
    }
    $post_status = get_post_meta($post_id,'correction',true);
    $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
    $es_content = get_field("投稿内容",$post_id);
    $es_corrector = get_field("添削者",$post_id);
    $es_category_ja = get_field("投稿先",$post_id);
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
      $es_url = get_es_url();
      $es_categories = get_es_categories("challenge");
      $es_category_en = $es_url[$es_category_ja];
      $es_description_image = $es_categories[$es_category_en][2];
    }else{
      $es_category = get_field("投稿テーマ",$post_id);
      $es_type = '項目別練習';
      $es_url = get_es_url();
      $es_categories = get_es_categories("practice");
      $es_category_en = $es_url[$es_category];
      $es_description_image = $es_categories[$es_category_en][2];
    }
    $fav_array = get_post_meta($post_id,'favorite',true);
    $fav_count = count($fav_array);
    $comment_array = get_post_meta($post_id,'コメント',false)[0];
    $comment_count = count($comment_array);
    if(in_array($user_id,$fav_array)){
      $fav_button_class = 'btn favorite-button es-like-active';
      $es_card_html .= '
        <div class="es-timeline__item">
          <div class="es-timeline__card">
            <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show">
              <div class="es-text__body">
                <div class="es-text__eyecatch">
                  <img src="'.$home_url.'/wp-content/uploads/'.$es_description_image.'">
                </div>
                <h3 class="es-text__title">'.$es_category.'</h3>
                <p class="es-text__description">'.$es_content.'</p>
                <div class="es-fav_status">
                  <div class="es-fav_status_item">
                    <div class="es-fav_status_icon">
                      <button class="btn favorite-button_sub" value="'.$post_id.'">
                        <i class="far fa-heart"></i>
                      </button>
                    </div>
                    <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
                  </div>
                  <div class="es-category_item">'.$es_type.'</div>
                  <div class="es-fav_status_item">
                    <div class="comment__count">
                      <i class="far fa-comments"></i>
                    </div>
                    <div class="es-fav_status_label">'.$comment_count.'</div>
                  </div>
                </div>
              </div>
            </a>
            <div class="es-timeline_footer">
              <div class="es-timeline_footer_avatar">
                <div class="es-timeline_footer_icon">
                  <div class="es-avatar">
                    <img src="'.$user_profile_image.'">
                  </div>
                </div>
                <div class="es-timeline_footer_name">
                  <span>'.$post_user_university.$post_user_graduate_year.$post_user_gender.'</span>
                </div>
                <div class="es-timeline_footer_date">
                  <span>'.$uploaded_date.'</span>
                </div>
              </div>
              <div class="es-like">
                  <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                    <i class="fa fa-heart"></i>
                  </button>
              </div>
            </div>
          </div>
        </div>
      ';
    }
  }
  $es_count =  count($es_total);
  if($es_count>0){
    $html = '
      <div class="es-title-container">
        <h2 class="es-title">お気に入りのES</h2>
      </div>
      <div class="es-cards-container">'.$es_card_html.'</div>';
  }else{
    $html = '
      <div class="es-title-container">
        <h2 class="es-title">お気に入りのES</h2>
      </div>
      <div class="es-title-container">
        <p>お気にいりのESはありません</p>
      </div>';
  }
  if (!is_user_logged_in()){
    $html = '<p class="text-align-center"><i class="fas fa-lock"></i>エントリーシート機能は会員限定です。JobShotに登録すると利用することができます。</p>';
    $html .= apply_redirect();
  }
return $html;
}
add_shortcode('view_fav_es','view_fav_es');

function view_other_es($es,$user_id,$num_content){
  $home_url =esc_url( home_url( ));
  $post_id = $es->ID;
  $user_info = get_userdata($user_id);
  $user_name = $user_info->user_login;
  $post = get_post($post_id);
  $post_user_id = get_userdata($post->post_author)->ID;
  $post_user_info = get_userdata($post_user_id);
  $post_user_name = $post_user_info->user_login;
  if ($post_user_id != $user_id){
    $post_user_graduate_year = get_user_meta($post_user_id,'graduate_year',false)[0];
    if(!empty($post_user_graduate_year)){
      $post_user_graduate_year = substr(strval($post_user_graduate_year),2,2).'年卒・';
    }
    $post_user_gender = get_user_meta($post_user_id,'gender',false)[0][0];
    $post_user_university = get_user_meta($post_user_id,'university',false)[0].'・';
  }
  if($user_id == $post_user_id){
    $user_profile_image = get_user_profile_image($post_user_id);
  }else{
    if($post_user_gender == '男性'){
      $user_profile_image = wp_get_attachment_image_src(9343)[0];
    }else{
      $user_profile_image = wp_get_attachment_image_src(9344)[0];
    }
  }
  $post_status = get_post_meta($post_id,'correction',true);
  $uploaded_date = get_the_modified_date('Y/n/j',$post_id);
  $es_content = get_field("投稿内容",$post_id);
  $es_corrector = get_field("添削者",$post_id);
  $es_category_ja = get_field("投稿先",$post_id);
  $es_correction = get_field("添削内容",$post_id);
  if(mb_strlen($es_content) > $num_content){
    $es_content = mb_substr($es_content, 0,$num_content);
    $es_content .= '...';
  }
  if(mb_strlen($es_correction) > $num_content){
    $es_correction = mb_substr($es_correction, 0,$num_content);
    $es_correction .= '...';
  }
  if($post_status == 'true'){
    $es_category = $es->post_title;
    $es_type = '実践チャレンジ';
    $es_url = get_es_url();
    $es_categories = get_es_categories("challenge");
    $es_category_en = $es_url[$es_category_ja];
    $es_description_image = $es_categories[$es_category_en][2];
  }else{
    $es_category = get_field("投稿テーマ",$post_id);
    $es_type = '項目別練習';
    $es_url = get_es_url();
    $es_categories = get_es_categories("practice");
    $es_category_en = $es_url[$es_category];
    $es_description_image = $es_categories[$es_category_en][2];
  }
  $fav_array = get_post_meta($post_id,'favorite',true);
  $fav_count = count($fav_array);
  if(in_array($user_id,$fav_array)){
    $fav_button_class = 'btn favorite-button es-like-active';
  }else{
    $fav_button_class='btn favorite-button';
  }
  $comment_array = get_post_meta($post_id,'コメント',false)[0];
  $comment_count = count($comment_array);
  $es_card_html = '';
    $es_card_html = '
      <div class="es-timeline__item">
        <div class="es-timeline__card">
          <a href = "'.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show">
            <div class="es-text__body">
              <div class="es-text__eyecatch">
                <img src="'.$home_url.'/wp-content/uploads/'.$es_description_image.'">
              </div>
              <h3 class="es-text__title">'.$es_category.'</h3>
              <p class="es-text__description">'.$es_content.'</p>
              <div class="es-fav_status">
                <div class="es-fav_status_item">
                  <div class="es-fav_status_icon">
                    <button class="btn favorite-button_sub" value="'.$post_id.'">
                      <i class="far fa-heart"></i>
                    </button>
                  </div>
                  <div class="es-fav_status_label" id="fav_count_'.$post_id.'">'.$fav_count.'</div>
                </div>
                <div class="es-fav_status_item">
                  <div class="comment__count">
                    <i class="far fa-comments"></i>
                  </div>
                  <div class="es-fav_status_label">'.$comment_count.'</div>
                </div>
                <div class="es-category_item">'.$es_type.'</div>
              </div>
            </div>
          </a>
          <div class="es-timeline_footer">
            <div class="es-timeline_footer_avatar">
            <div class="es-timeline_footer_icon">
                <div class="es-avatar">
                  <img src="'.$user_profile_image.'">
                </div>
              </div>
              <div class="es-timeline_footer_name">
                <span>'.$post_user_university.$post_user_graduate_year.$post_user_gender.'</span>
              </div>
              <div class="es-timeline_footer_date">
                <span>'.$uploaded_date.'</span>
              </div>
            </div>
            <div class="es-like">
                <button class="'.$fav_button_class.'" id="fav_button_'.$post_id.'"value="'.$post_id.'">
                  <i class="fa fa-heart"></i>
                </button>
            </div>
          </div>
        </div>
      </div>
    ';
  return $es_card_html;
}

function comment_es(){
  if(!empty($_POST["comment_es"])){
    $user = wp_get_current_user();
    $user_id = $_POST["user_id"];
    $post_id = $_POST["post_id"];
    $comment = $_POST["comment"];
    $comment_array = [$user_id,$comment];
    $original_comment_array = get_post_meta($post_id,'コメント',false)[0];
    if(!empty($original_comment_array)){
      $original_comment_array[] = $comment_array;
    }else{
      $original_comment_array = [$comment_array];
    }
    update_post_meta($post_id, 'コメント', $original_comment_array);
		$home_url =esc_url( home_url( ));
	  header('Location: '.$home_url.'/entry-sheet/view?post_id='.$post_id.'&action=show');
    die();
  }
}
add_action('template_redirect', 'comment_es');


function view_mypage_es(){
  $user_name = $_GET['um_user'];
  $user = get_user_by('login',$user_name);
  $user_id = $user->ID;
  if(get_current_user_id() == $user_id || current_user_can('administrator')){
    $es_total = get_past_es($user_id,'all','published');
    if(!empty($es_total)){
        foreach($es_total as $es){
            $es_card_html .= view_other_es($es,$user_id,1000);
        }
    }else{
      $es_card_html = '<p class="text-center">お気に入りがありません。</p>';
    }
    $html = '
    <h2 class="mypage__title">エントリーシート</h2>
    <div class="es-cards-container">
    '.$es_card_html.'
    </div>
    ';
  }
  return $html;
}
add_shortcode("view_mypage_es","view_mypage_es");