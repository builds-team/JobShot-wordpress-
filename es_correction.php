<?php

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

  //ボタン
  $post_button_html = '
  <div class="">
    <div class="">
	    <input type="hidden" name="es_category" value="'.$es_categories[$category][0].'">
      <input type="hidden" name="new_es_practice" value="new_es_practice">
      <input type="hidden" name="user_id" value="'.$user_id.'">
      <input type="hidden" name="correction" value="false">
      <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="保存">
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
      <div class="">
        <div class="">
          <input type="hidden" name="correction" value="true">
          <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="投稿">
        </div>
      </div>';
  }else{
    $post_button_html = '
      <div class="">
          <button type="submit" class="button button-primary button-large" disabled>投稿済み</button>
      </div>';
  }


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
        <select name="es_category" required>
            <option value=""></option>
            <option value="学生時代力を入れたこと">学生時代力を入れたこと</option>
            <option value="自己PR">自己PR</option>
            <option value="長所・短所">長所・短所</option>
            <option value="志望動機">志望動機</option>
            <option value="最近のニュース">最近のニュース</option>
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
        <input type="hidden" name="challenge_company" value="'.$es_categories[$category][0].'">
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

//ESを見るページ
function view_past_es(){
  $home_url =esc_url( home_url( ));
  $user = wp_get_current_user();
  $user_id = get_current_user_id();

  //詳細を見るボタンが押された時の表示
  if(!empty($_GET["post_id"]) && !empty($_GET["action"])){
    $post_id = $_GET["post_id"];
    $es = get_post($post_id);
    $post_status = get_post_meta($post_id,'correction',true);
    if($post_status == 'true'){
      $es_categories = get_es_categories('challenge');
      $es_points = get_es_points('challenge');
    }else{
      $es_categories = get_es_categories('practice');
      $es_points = get_es_points('practice');
    }
    if($es->post_author == $user_id){
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
      $es_correction = get_field("添削内容",$post_id);
      $points_html = '';
      foreach($es_points[$es_url] as $es_point){
        $points_html .= '<li>'.$es_point.'</li>';
      }
      if($post_status == 'true'){
       $html = '<h2 class="maintitle">ES添削チャレンジ('.$es_categories[$es_url][0].')</h2>
       <div class="">
         <h2 class="">'.$es_categories[$es_url][0].'の要項</h2>
         <ul class="">
           '.$points_html.'
         </ul>
       </div>
       <p>ESのテーマ*</p>
       <p>'.$es_category_sub.'</p>
       ';
       $es_category_sub = '/'.$es_category_sub;
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
                <h3>'.$es_category.$es_category_sub.'</h3>
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
      'posts_per_page' => 100,
      'meta_query' => array(
        array(
          'key' => 'correction',
          'value' => 'true'
        ),
        array(
          'key' => 'author_id',
          'value' => $user_id
        )
      )
    );
    $es_challenge = get_posts($args);
    $args = array(
      'post_type' => 'entry_sheet',
      'post_status' => array('publish'),
      'posts_per_page' => 100,
      'meta_query' => array(
        array(
          'key' => 'correction',
          'value' => 'false'
        ),
        array(
          'key' => 'author_id',
          'value' => $user_id
        )
      )
    );
    $es_practice = get_posts($args);
	  $practice_count =  count($es_practice);
	  $challenge_count =  count($es_challenge);
    $post_ids=array();
    $challenge_card_html = '';
    foreach($es_challenge as $es){
      $post_id = $es->ID;
      $es_category = $es->post_title;
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

    //実践チャレンジに投稿がないとき
    if($challenge_count == 0){
      $challenge_card_html = '
      <div class="es-title-container">
        <p>過去のESがありません</br>実践チャレンジから挑戦しましょう</p>
      </div>';
    }
    $html = '
    <div class="es-title-container">
      <h2 class="es-title">ES添削チャレンジ</h2>
    </div>
    '.$challenge_card_html;

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

    //項目別練習にESがないとき
    if($practice_count == 0){
      $practice_card_html = '
        <div class="es-title-container">
          <p>過去のESがありません</br>基礎から学ぶで練習しましょう</p>
        </div>';
    }
    $html .= '
      <div class="es-title-container">
        <h2 class="es-title">項目別練習</h2>
      </div>
      '.$practice_card_html;
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

//esのカテゴリの取得（key：getパラメータ、value:題名、説明、イメージ画像）
function get_es_categories($type){
  if($type == "practice"){
    $es_categories = array(
      'gakutika' => array('学生時代力を入れたこと','あなたが普段どのような活動を行い何を学んできたのかを問う定番項目です。','2020/03/akson-1K8pIbIrhkQ-unsplash-e1583117897684.jpg'),
      'self-pr' => array('自己PR','あなたがどのような人物であるのかを問うことを目的とした定番項目です。','2020/03/obi-onyeador-nsYboB2RDwU-unsplash.jpg'),
      'strong-weak' => array('長所・短所','あなたが自分のことを客観的に見ることができているのかを問う定番項目です。','2020/03/jordan-whitt-b8rkmfxZjdU-unsplash-e1583135048633.jpg'),
      'motivation' => array('志望動機','あなたがどれだけ応募した企業へ入りたいのか、その熱意を確認する定番項目です。','2020/03/business-1853682_1920-e1583123241772.jpg'),
      'news' => array('最近のニュース','あなたがどれだけ社会に対する問題意識を持っているか確認する定番項目です。','2020/03/roman-kraft-_Zua2hyvTBk-unsplash-e1583123073166.jpg')
    );
  }else{
    $es_categories = array(
      'musojyuku' => array('就活無双塾','【3/◯◯~3/◯◯開催】<br>元JPMorgan新卒採用担当者によるエントリーシート添削企画開催！<br>※抽選で10名限定','2020/03/max-bender-FuxYvi-hcWQ-unsplash-e1583138722808.jpg')
    );
  }
  return $es_categories;
}

//esのポイントの取得（key：getパラメータ、value:ポイントの配列の取得）
function get_es_points($type){
  if($type == "practice"){
    $es_points = array(
      'gakutika' => array(
        '【結論】どのようなことに取り組んだのか述べる<br>「私は大学時代に◯◯に従事しました。」',
        '【理由】なぜ上記に取り組んだのかを述べる<br>「もともと◯◯が足りないことには気が付いており、大学時代には◯◯を身に付けたいと考えたため上記の活動に取り組むことにしました。」',
        '【目標や課題】どのようなことを目標にして活動していたか、またそこから見つかった課題を述べる<br>「◯◯という目標のもと活動を行っていましたが、◯◯という壁に直面することになりました。」',
        '【解決策と行動】課題から考え出した解決策や行動を述べる<br>「そこで私は、◯◯を改善することで問題を解決できると考え、◯◯という計画を実行しました。」',
        '【成果】結果としてどのような成果を得られたのか述べる<br>「結果として、◯◯という成果をあげることができました。」',
        '【学びと今後の展望】ここから学んだことや、強みや長所を今後どのように生かしていくか述べる<br>「この経験から◯◯を学び、これを貴社での◯◯業務にいかしていきたいと考えています。」',
      ),
      'self-pr' => array(
        '【結論】強みや長所を述べる<br>「私の強みは◯◯です。」',
        '【具体例】過去に強みや長所が発揮された具体例を述べる<br>「◯年生の時には◯◯を行いました。」',
        '【目標や課題】どのようなことを目標にして活動していたか、またそこから見つかった課題を述べる<br>「◯◯という目標のもと活動を行っていましたが、◯◯という壁に直面することになりました。」',
        '【解決策と行動】課題から考え出した解決策や行動を述べる<br>「そこで私は、◯◯を改善することで問題を解決できると考え、◯◯という計画を実行しました。」',
        '【成果】結果としてどのような成果を得られたのか述べる<br>「結果として、◯◯という成果をあげることができました。」',
        '【学びと今後の展望】ここから学んだことや、強みや長所を今後どのように生かしていくか述べる<br>「この経験から◯◯を学び、これを貴社での◯◯業務にいかしていきたいと考えています。」'
      ),
      'strong-weak' => array(
        '【概要】自分の短所を簡潔に述べる<br>「私の短所は、◯◯です。」',
        '【具体例】過去に自分の短所が出てしまった例を述べる<br>「以前、◯◯の状況下において私の短所が出てしまいました。」',
        '【改善理由】短所を改善すべき理由を述べる<br>「しかし会社に入ると、◯◯であるためこの短所は改善する必要があると感じています。」',
        '【解決法】短所を改善するための解決法を述べる<br>「そこで私は、この短所を解決するために◯◯と考え、常に心がけています。」'
      ),
      'motivation' => array(
        '【志望理由】その企業を志望する旨を述べる<br>「◯◯な貴社で◯◯に貢献したいため応募しました。」',
        '【志望業界や企業の軸】業界の動向や人物像・能力から企業選びの軸を伝える<br>「◯◯という成長を続けている◯◯業界に置いて、◯◯な人材が必要であると考えております。」',
        "【他社ではなく志望企業】他の企業を差し置いて応募企業を志望する理由を述べる<br>「貴社には◯◯や◯◯といった要素を兼ね備えている方が多数いると、インターンでのコミュニケーションを通して強く感じました。」",
        "【自己PR】実体験に基づいた自分の強みを述べる<br>「◯◯という経験をもとに、私は◯◯が強みです。」",
        "【マッチング】企業の求める人材と自分が一致していることを述べる<br>「貴社では◯◯という活躍ができると考えているため、貴社を強く志望しています。」"
      ),
      'news' => array(
        "【選んだニュース】志望業界に基づくニュースを述べる<br>「私が最近気になっているニュースは◯◯です。」",
        "【理由】上記のニュースを選んだ理由を述べる<br>「このニュースを選んだ理由は◯◯です。」",
        "【概要】上記のニュースの概要を簡潔に述べる<br>「今回のニュースでは、◯◯で、◯◯という影響がありました。」",
        "【考え】今回のニュースで自分なりの考えを述べる<br>「私は今回のニュースを受けて◯◯と感じ、◯◯を改善したいと考えています。」",
        )
    );
  }
  else{
    $es_points = array(
      'musojyuku' => array('ES添削チャレンジは一つのチャレンジで一つしか提出出来ません','就活無双塾の要項２')
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
      '就活無双塾' => 'musojyuku'
    );
  return $es_url;
}

//管理画面に添削(true or falseを追加)
function add_entry_sheet_column( $defaults ) {
  $defaults['correction'] = '添削';
  return $defaults;
  }
add_filter('manage_entry_sheet_posts_columns', 'add_entry_sheet_column');

function add_custom_column_id($column_name, $id) {
  if( $column_name == 'correction' ) {
    echo get_post_meta($id, 'correction', true);
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