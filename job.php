<?php
function template_job2_func($content){
    global $post;
    $post_id=$post->ID;
    global $coauthors_plus;
    $author_terms = get_the_terms( $post_id, $coauthors_plus->coauthor_taxonomy);
    $company_user_login=$author_terms[0]->name;

    $company_ids =get_company_content_ids_func($company_user_login, 'company');
    $company_id = $company_ids[0];
    $company_url = get_permalink($company_id);

    $post_title = get_the_title($post_id);
    $mission = get_field("募集タイトル",$post_id);
    $job_description = get_field("仕事内容",$post_id);
    $mail = get_field("お問い合わせ",$post_id);
    $image = get_field("イメージ画像",$post_id);
    $image_url = $image["url"];
    $area = get_the_terms($post_id,"area")[0]->name;

    $skill = get_the_terms($post_id,"acquire")[0]->name;

    $occupation = get_the_terms($post_id,"occupation")[0]->name;
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;
    $selection_flows = get_field("選考の流れ",$post_id);
    $selection_flows = explode("\n", $selection_flows); // とりあえず行に分割
    $selection_flows = array_map('trim', $selection_flows); // 各行にtrim()をかける
    $selection_flows = array_filter($selection_flows, 'strlen'); // 文字数が0の行を取り除く
    $selection_flows = array_values($selection_flows); // これはキーを連番に振りなおしてるだけ

    if($occupation == ' その他'){
      $title_html = '<h2 class="mainhead">'.$occupation.'</h2>';
    }else{
      $title_html = '<h2 class="mainhead">'.$occupation.'職</h2>';
    }
    $selection_html = '<ul class="flowchart flowchart_job">';
    $counter = 1;
    foreach($selection_flows as $selection_flow){
      $selection_html .= '
      <li class="flowlist">
        <dl>
          <dt><span class="icon">STEP.0'.$counter.'</span></dt>
          <dd>'.$selection_flow.'</dd>
        </dl>
      </li>';
      $counter +=1;
    }
    $selection_html .= '
      <li class="flowlist">
        <dl>
          <dt><span class="icon">STEP.0'.$counter.'</span></dt>
          <dd>採用</dd>
        </dl>
      </li>
    </ul>';

    $require_person = nl2br(get_field("求める人物像",$post_id));
    $company_bussiness = nl2br(get_field("事業内容",$company_id));
    $job_contents = nl2br(get_field("業務内容",$post_id));
    $salary = nl2br(get_field("給与",$post_id));
    $recruit_capacity = get_field("採用予定人数",$post_id);
    $target = nl2br(get_field("応募資格",$post_id));
    $allowance = nl2br(get_field("待遇",$post_id));
    $welfare = nl2br(get_field("福利厚生",$post_id));
    $address = nl2br(get_field("勤務地",$post_id));
    $worktime = nl2br(get_field("勤務時間",$post_id));
    $holiday = nl2br(get_field("休日",$post_id));
    $picture1 = get_field("イメージ画像1",$post_id);
    if(is_array($picture1)){
      $picture1 = $picture1["url"];
    }else{
      $picture1 = wp_get_attachment_url($picture1);
    }
    $worker_name1 = get_field("社員名1",$post_id);
    $worker_voice1 = get_field("紹介文1",$post_id);
    $picture2 = get_field("イメージ画像2",$post_id);
    if(is_array($picture2)){
      $picture2 = $picture2["url"];
    }else{
      $picture2 = wp_get_attachment_url($picture2);
    }
    $worker_name2 = get_field("社員名2",$post_id);
    $worker_voice2 = get_field("紹介文2",$post_id);

    $voice_html = '';
    if(!empty($worker_name1)){
      $voice_html .= '
      <div class="voice">
        <div class="voice__title">'.$worker_name1.'</div>
        <div class="voice__main">
          <div class="voice__main__img">
            <img src="'.$picture1.'" alt="">
          </div>
          <p class="voice__main__message">'.$worker_voice1.'</p>
        </div>
      </div>';
    }
    if(!empty($worker_name2)){
      $voice_html .= '
      <h2 class="maintitle">先輩社員の声</h2>
      <div class="voice">
        <div class="voice__title">'.$worker_name2.'</div>
        <div class="voice__main">
          <div class="voice__main__img">
            <img src="'.$picture2.'" alt="">
          </div>
          <p class="voice__main__message">'.$worker_voice2.'</p>
        </div>
      </div>';
    }

    $recruit_url = nl2br(get_field("採用サイトURL",$post_id));
    if(!empty($recruit_url)){
      $entry_html = '
      <a href="'.$recruit_url.'">
          <button class="button button-apply">話を聞きに行きたい</button>
      </a>';
    }else{
      $entry_html = '
          <a href="[get_form_address formtype=apply form_id=3220 post_id='.$post_id.' title='.$post_title.']">
              <button class="button button-apply">話を聞きに行きたい</button>
          </a>';
    }

    $current_user = wp_get_current_user();
    $current_user_name = $current_user->data->display_name;
    $home_url =esc_url( home_url( ));
    if($company_name == $current_user_name){
      $button_html = '
      <div class="company_edit">
        <button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:#f9b539; border-radius: 5px;">戻る</button>
        <button class="button favorite innactive" style="width:40%; margin-top:15px; background-color:red; border-radius: 5px;">削除する</button>
      </div>';
      $button_html = '
      <div class="company_edit" style="text-align:right;">
        <a href="'.$home_url.'/edit_job?post_id='.$post_id.'" style="margin-right:5px;">編集する</a><a href="'.get_delete_post_link($post_id).'" style="margin-right:5px;">削除する</a>
      </div>';
    }else{
      $button_html = '';
    }

    // 社員の声「顔写真、名前、文章」
    /**
     * 「業務内容、選考の流れ、求める人物像、給与、応募資格、待遇、福利厚生、勤務地、勤務時間、休日、イメージ画像」
     */

    $html = $button_html.'
    <div class="container">
      <div class="recruit-img-container">
        <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1713&q=80" alt="">
        <div class="recruit-img">
          <h1>'.$mission.'</h1>
          <a href="'.esc_url($company_url).'"><p>'.$company_name.'</p></a>
        </div>
      </div>
      '.$title_html.'
      <section>
        <h2 class="maintitle">採用情報</h2>
        <section>
          <h3 class="subsubtitle">業務内容</h3>
          <p>'.$job_contents.'</p>
        </section>
        <section>
          <h3 class="subsubtitle">こんな方におすすめ</h3>
          <p>'.$require_person.'</p>
        </section>
        <section>
          <h3 class="subsubtitle">選考の流れ</h3>
          '.$selection_html.'
        </section>
      </section>

      <section>
        <!-- 複数.voiceがくる想定 -->
        '.$voice_html.'
      </section>

      <section>
        <h2 class="maintitle">募集要項</h2>
        <table class="table__base">
          <tbody>
            <tr>
              <th>募集職種</th>
              <td>'.$occupation.'職</td>
            </tr>
            <tr>
              <th>給与</th>
              <td>'.$salary.'</td>
            </tr>
            <tr>
              <th>採用予定人数</th>
              <td>'.$recruit_capacity.'</td>
            </tr>
            <tr>
              <th>応募条件</th>
              <td>'.$target.'</td>
            </tr>
            <tr>
              <th>待遇</th>
              <td>'.$allowance.'</td>
            </tr>
            <tr>
              <th>福利厚生</th>
              <td>'.$welfare.'</td>
            </tr>
            <tr>
              <th>勤務地</th>
              <td>'.$address.'</td>
            </tr>
            <tr>
              <th>勤務時間</th>
              <td>'.$worktime.'</td>
            </tr>
            <tr>
              <th>休日</th>
              <td>'.$holiday.'</td>
            </tr>
          </tbody>
        </table>
      </section>
      <div class="fixed-buttom">'.$entry_html.'</div>
    </div>';
    return $html;
}

function edit_job_info(){
  if($_GET["post_id"]){
    /**
     * 「業務内容、選考の流れ、求める人物像、給与、応募資格、待遇、福利厚生、勤務地、勤務時間、休日、イメージ画像」
     */

    $post_id= $_GET["post_id"];
    $post = get_post($post_id);
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;
    $regist_occupation = get_the_terms($post_id,"occupation")[0]->name;
    $occupation_array= array("engineer"=>"エンジニア","designer"=>"デザイナー","consulting"=>"コンサル","director"=>"ディレクター","marketer"=>"マーケティング","writer"=>"ライター","sales"=>"営業","corporate_staff"=>"事務/コーポレート・スタッフ","human_resources"=>"総務・人事・経理","planning"=>"企画","others"=>"その他");
    $occupation_html = '';
    foreach($occupation_array as $occupation_key => $occupation_value){
      if($regist_occupation == $occupation_value){
        $occupation_html .= '<div><input type="radio" name="occupation" value="'.$occupation_key.'" checked="checked" />'.$occupation_value.'</div>';
      }else{
        $occupation_html .= '<div><input type="radio" name="occupation" value="'.$occupation_key.'" />'.$occupation_value.'</div>';
      }
    }
    $mission = get_field("募集タイトル",$post_id);
    $job_contents = get_field("業務内容",$post_id);
    $require_person = get_field('求める人物像',$post_id);
    $salary = get_field("給与",$post_id);
    $recruit_capacity = get_field("採用予定人数",$post_id);
    $skill_requirements = get_field('応募資格',$post_id);
    $allowance =get_field("待遇",$post_id);
    $welfare =get_field("福利厚生",$post_id);
    $address = get_field("勤務地",$post_id);
    $worktime = get_field("勤務時間",$post_id);
    $holiday = get_field("休日",$post_id);
    $selection_flows = get_field("選考の流れ",$post_id);
    $picture1 = get_field("イメージ画像1",$post_id);
    $picture1 = $picture1["url"];
    $worker_name1 = get_field("社員名1",$post_id);
    $worker_voice1 = get_field("紹介文1",$post_id);
    $picture2 = get_field("イメージ画像2",$post_id);
    $picture2 = $picture2["url"];
    $worker_name2 = get_field("社員名2",$post_id);
    $worker_voice2 = get_field("紹介文2",$post_id);
    $home_url =esc_url( home_url( ));

    $style_html = "
    <style type='text/css'>
      .company_edit{
        text-align:center;
      }
      .feature-label{
        display: inline-block;
        width: 50%;
      }
      .input-width{
        width: 100%;
      }
      .input-file .preview {
        background-image: url(/hoge.jpg);
      }
      .input-file input[type='file'] {
        opacity: 0;
      }
    </style>";

    $post_button_html = '
    <div class="submitbox">
      <div id="minor-publishing">
        <div class="minor_publishing_actions">
          <div class="save_action">
            <input type="submit" name="save" id="save-post" value="下書きとして保存" class="button save_post_button">
          </div>
          <div class="preview_action">
            <input type="submit" name="preview" id="save-post" value="プレビュー" class="button save_post_button">
          </div>
        </div>
      </div>
      <div class="major_publishing_actions">
        <div class="publishing_action">
          <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="公開">
        </div>
      </div>
    </div>';

    $edit_html =  $style_html.'
    <h2 class="maintitle">新卒情報</h2>
    <form action="'.$home_url.'/edit_job?post_id='.$post_id.'" method="POST" enctype="multipart/form-data">
      <div class="tab_content_description">
        <p class="c-txtsp">
            <table class="demo01 new_intern_table">
                <tbody>
                    <tr>
                        <th align="left" nowrap="nowrap">キャッチコピー</th>
                        <td>
                          <div class="company-name"><input class="input-width" type="text" min="0" name="job_title" id="'.$mission.'" value="" placeholder="(例) 圧倒的なスピードで成長する〇〇ベンチャー"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">職種</th>
                        <td>
                          <div class="company-established new_intern_occupation">'.$occupation_html.'</div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">業務内容</th>
                        <td>
                            <div class="company-representative"><textarea name="job_contents" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;・社内イベントや表彰式等の企画、実施&#13;&#10;・営業成績管理や財務、経理の管理&#13;&#10;・採用業務や人材教育制度の企画、実施">'.$job_contents.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">こんな方におすすめ</th>
                        <td>
                            <div class="company-representative"><textarea name="require_person" id="" cols="30" rows="6" placeholder="(例)&#13;&#10;■コミュニケーション能力のある方&#13;&#10;■向上心のある方&#13;&#10;■自分の信念を持っている方&#13;&#10;■世の中をより良くしたいと考えている方">'.$require_person.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">給与</th>
                        <td>
                            <div class="company-established"><textarea name="salary" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;大卒 : 月給255,000円 / 大学院卒 : 月給300,000~（2017年4月入社実績）">'.$salary.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">採用予定人数</th>
                        <td>
                            <div class="company-established"><textarea name="recruit_capacity" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;10~20名程度">'.$recruit_capacity.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">応募資格</th>
                        <td>
                            <div class="company-capital"><textarea name="skill_requirements" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;2021年に卒業見込みの方">'.$skill_requirements.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">待遇</th>
                        <td>
                            <div class="company-capital"><textarea name="allowance" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;■昇給&#13;&#10;　年1回&#13;&#10;■賞与&#13;&#10;　年2回（6月・12月）&#13;&#10;■手当&#13;&#10;　通勤手当、資格手当（TOEIC,簿記など）&#13;&#10;　※資格手当は「報奨金・受験料の一部負担など」">'.$allowance.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">福利厚生</th>
                        <td>
                            <div class="company-capital"><textarea name="welfare" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;■私服勤務可&#13;&#10;■MVP制度（四半期ごとに表彰、副賞あり！）&#13;&#10;■英語学習補助&#13;&#10;■予防注射補助&#13;&#10;■企業年金基金&#13;&#10;■退職金制度&#13;&#10;■各種社会保険&#13;&#10;■企業年金制度&#13;&#10;■育児・介護休暇制度&#13;&#10;■社宅制度">'.$welfare.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務地</th>
                        <td>
                            <div class="company-capital"><textarea name="address" id="" cols="30" rows="6" placeholder="(例)&#13;&#10;東京、大阪、福岡">'.$address.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務時間</th>
                        <td>
                            <div class="company-address"><textarea name="worktime" id="" cols="30" rows="6" placeholder="(例)&#13;&#10;フレックスタイム制（コアタイム 11:00～14:00、標準労働時間7時間）">'.$worktime.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">休日</th>
                        <td>
                            <div class="company-capital"><textarea name="holiday" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;完全週休2日制（土・日）、祝日、年末年始（12月29日 ～ 1月3日）&#13;&#10;年次有給休暇 / 勤務年数に応じ15日 ～ 25日（ただし初年度は12日）&#13;&#10;年2回、 連続5日間の休暇制度">'.$holiday.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">選考の流れ</th>
                        <td>
                            <div class="company-capital"><textarea name="selection_flows" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;ES→GD→面接（複数回）→内定">'.esc_html($selection_flows).'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員名1</th>
                        <td>
                            <div class="company-capital"><input type="text" class="input-width" min="0" name="worker_name1" id="" value="'.$worker_name1.'" placeholder="(例)&#13;&#10;"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像1</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img"></div>
                                <img src="'.$picture1.'">
                                <input accept="image/*" id="imgFile" type="file" name="picture1">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員の声1</th>
                        <td>
                            <div class="company-capital"><textarea name="worker_voice1" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;やりたいことができる環境が整っている&#13;&#10;大学時代の長期インターンの経験から、「自分がやりたいこと、成し遂げたいことを実現できるか」ということを基準に企業選びを行っていました。&#13;&#10;その中で〇〇を選んだ理由は、若い方がどんどん活躍している（OB訪問やサイトから）ことを知り、年次に関係なく自分のやりたいことを挑戦できる環境だと思い、入社を決めました。&#13;&#10;実際に入社１年目でイベントの企画運営を任せて頂けたり、現在は新規事業の責任者を任せて頂いたりと、挑戦したい人にはどんどん任せて頂ける環境が整っている会社です。">'.$worker_voice1.'</textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員名2</th>
                        <td>
                            <div class="company-capital"><input type="text" class="input-width" min="0" name="worker_name2" id="" value="'.$worker_name2.'" placeholder="(例)&#13;&#10;"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像2</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img2"></div>
                                <img src="'.$picture2.'">
                                <input accept="image/*" id="imgFile" type="file" name="picture2">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員の声2</th>
                        <td>
                            <div class="company-capital"><textarea name="worker_voice2" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;">'.$worker_voice2.'</textarea></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </p>
        <input type="hidden" name="edit_job" value="edit_job">
        <div class="company_edit">
          '.$post_button_html.'
        </div>
      </div>
    </form>';
    return $edit_html;
  }else{
    header('Location: '.$home_url.'/');
    die();
  }
}
add_shortcode("edit_job_info","edit_job_info");

function update_job_info(){
  $home_url =esc_url( home_url( ));
  if(!empty($_POST["occupation"]) && !empty($_POST["edit_job"])){
    $post_id = $_GET["post_id"];
    $post = get_post($post_id);
    $post_title = $post->post_title;
    $company = get_userdata($post->post_author);
    $company_name = $company->data->display_name;

    $occupation = $_POST["occupation"];
    $job_contents = $_POST["job_contents"];
    $require_person = $_POST["require_person"];
    $salary = $_POST["salary"];
    $recruit_capacity = $_POST["recruit_capacity"];
    $skill_requirements = $_POST["skill_requirements"];
    $allowance = $_POST["allowance"];
    $welfare = $_POST["welfare"];
    $address = $_POST["address"];
    $worktime = $_POST["worktime"];
    $holiday = $_POST["holiday"];
    $selection_flows = $_POST["selection_flows"];
    $picture1 = $_FILES["picture1"];
    $worker_name1 = $_POST["worker_name1"];
    $worker_voice1 = $_POST["worker_voice1"];
    $picture2 = $_FILES["picture2"];
    $worker_name2 = $_POST["worker_name2"];
    $worker_voice2 = $_POST["worker_voice2"];

    if($_POST["occupation"]){
      wp_set_object_terms( $post_id, $occupation, 'occupation');
    }
    if($_POST["job_contents"]){
      update_post_meta($post_id, "業務内容", esc_html($job_contents));
    }
    if($_POST["require_person"]){
      update_post_meta($post_id, "求める人物像", esc_html($require_person));
    }
    if($_POST["salary"]){
      update_post_meta($post_id, "給与", $salary);
    }
    if($_POST["recruit_capacity"]){
      update_post_meta($post_id, "採用予定人数", $recruit_capacity);
    }
    if($_POST["skill_requirements"]){
      update_post_meta($post_id, "応募資格", esc_html($skill_requirements));
    }
    if($_POST["allowance"]){
      update_post_meta($post_id, "待遇", esc_html($allowance));
    }
    if($_POST["welfare"]){
      update_post_meta($post_id, "福利厚生", esc_html($welfare));
    }
    if($_POST["address"]){
      update_post_meta($post_id, "勤務地", $address);
      preg_match("/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$_POST["address"],$result);
      $prefecture = $result[1];
      $area = $result[2];
      if($prefecture == "東京都"){
        wp_set_object_terms( $post_id, $area, 'area');
      }else{
        wp_set_object_terms( $post_id, $prefecture, 'area');
      }
    }
    if($_POST["worktime"]){
      update_post_meta($post_id, "勤務時間", $worktime);
    }

    if($_POST["holiday"]){
      update_post_meta($post_id, "休日", $holiday);
    }
    if($_POST["selection_flows"]){
      update_post_meta($post_id, "選考の流れ", esc_html($selection_flows));
    }
    if($_FILES["picture1"]){
      add_custom_image($post_id, "イメージ画像1", $picture1);
    }
    if($_POST["worker_name1"]){
      update_post_meta($post_id, "社員名1", $worker_name1);
    }
    if($_POST["worker_voice1"]){
      update_post_meta($post_id, "紹介文1", esc_html($worker_voice1));
    }
    if($_FILES["picture2"]){
      add_custom_image($post_id, "イメージ画像2", $picture2);
    }
    if($_POST["worker_name2"]){
      update_post_meta($post_id, "社員名2", $worker_name2);
    }
    if($_POST["worker_voice2"]){
      update_post_meta($post_id, "紹介文2", esc_html($worker_voice2));
    }
    if(!empty($_POST["save"])){
      $post_status = "draft";
    }
    if(!empty($_POST["preview"])){
      $post_status = "draft";
    }
    if(!empty($_POST["publish"])){
      $post_status = "publish";
    }
    $post_value = array(
      'post_author' => get_current_user_id(),
      'post_title' => $post_title,
      'post_type' => 'job',
      'post_status' => $post_status,
      'ID' => $post_id,
    );
    $insert_id2 = wp_insert_post($post_value); //上書き（投稿ステータスを公開に）

    if($insert_id2) {
        /* 投稿に成功した時の処理等を記述 */
        if(!empty($_POST["publish"])){
          header('Location: '.get_permalink($insert_id2));
        }
        if(!empty($_POST["preview"])){
          header('Location: '.get_permalink($insert_id2));
        }
        if(!empty($_POST["save"])){
          header('Location: '.$home_url.'/manage_post?posttype=job');
        }
        die();
        $html = '<p>success</p>';
    } else {
        /* 投稿に失敗した時の処理等を記述 */
        $html = '<p>error1</p>';
    }
    header('Location: '.$home_url.'/manage_post?posttype=job');
    die();
  }
}
add_action('template_redirect', 'update_job_info');

function new_job_form(){
  $home_url =esc_url( home_url( ));
  $occupation_array= array("engineer"=>"エンジニア","designer"=>"デザイナー","consulting"=>"コンサル","director"=>"ディレクター","marketer"=>"マーケティング","writer"=>"ライター","sales"=>"営業","corporate_staff"=>"事務/コーポレート・スタッフ","human_resources"=>"総務・人事・経理","planning"=>"企画","others"=>"その他");
  $occupation_html = '<div class="company-established new_intern_occupation">';
  foreach($occupation_array as $occupation_key => $occupation_value){
    $occupation_html .= '<div><input type="radio" name="occupation" value="'.$occupation_key.'" />'.$occupation_value.'</div>';
  }
  $occupation_html .= '</div>';
  $style_html = "
    <style type='text/css'>
      .company_edit{
        text-align:center;
      }
      .feature-label{
        display: inline-block;
        width: 50%;
      }
      .input-width{
        width: 100%;
      }
      .input-file .preview {
        background-image: url(/hoge.jpg);
      }
      .input-file input[type='file'] {
        opacity: 0;
      }
    </style>";
    $post_button_html = '
    <div class="submitbox">
      <div id="minor-publishing">
        <div class="minor_publishing_actions">
          <div class="save_action">
            <input type="submit" name="save" id="save-post" value="下書きとして保存" class="button save_post_button">
          </div>
          <div class="preview_action">
            <input type="submit" name="preview" id="save-post" value="プレビュー" class="button save_post_button">
          </div>
        </div>
      </div>
      <div class="major_publishing_actions">
        <div class="publishing_action">
          <input type="submit" name="publish" id="publish" class="button button-primary button-large" value="公開">
        </div>
      </div>
    </div>';

    $edit_html =  $style_html.'
    <h2 class="maintitle">新卒情報</h2>
    <form action="'.$home_url.'/new_post_job" method="POST" enctype="multipart/form-data">
      <div class="tab_content_description">
        <p class="c-txtsp">
            <table class="demo01 new_intern_table">
                <tbody>
                    <tr>
                        <th align="left" nowrap="nowrap">キャッチコピー</th>
                        <td>
                          <div class="company-name"><input class="input-width" type="text" min="0" name="job_title" id="" value="" placeholder="(例) 圧倒的なスピードで成長する〇〇ベンチャー"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">職種</th>
                        <td>
                            '.$occupation_html.'
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">業務内容</th>
                        <td>
                            <div class="company-representative"><textarea name="job_contents" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;・社内イベントや表彰式等の企画、実施&#13;&#10;・営業成績管理や財務、経理の管理&#13;&#10;・採用業務や人材教育制度の企画、実施"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">こんな方におすすめ</th>
                        <td>
                            <div class="company-representative"><textarea name="require_person" id="" cols="30" rows="6" placeholder="(例)&#13;&#10■コミュニケーション能力のある方&#13;&#10;■向上心のある方&#13;&#10;■自分の信念を持っている方&#13;&#10;■世の中をより良くしたいと考えている方"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">給与</th>
                        <td>
                            <div class="company-established"><textarea name="salary" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;大卒 : 月給255,000円 / 大学院卒 : 月給300,000~（2017年4月入社実績）"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">採用予定人数</th>
                        <td>
                            <div class="company-established"><textarea name="recruit_capacity" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;10~20名程度"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">応募資格</th>
                        <td>
                            <div class="company-capital"><textarea name="skill_requirements" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;2021年に卒業見込みの方"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">待遇</th>
                        <td>
                            <div class="company-capital"><textarea name="allowance" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;■昇給&#13;&#10;　年1回&#13;&#10;■賞与&#13;&#10;　年2回（6月・12月）&#13;&#10;■手当&#13;&#10;　通勤手当、資格手当（TOEIC,簿記など）&#13;&#10;　※資格手当は「報奨金・受験料の一部負担など」"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">福利厚生</th>
                        <td>
                            <div class="company-capital"><textarea name="welfare" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;■私服勤務可&#13;&#10;■MVP制度（四半期ごとに表彰、副賞あり！）&#13;&#10;■英語学習補助&#13;&#10;■予防注射補助&#13;&#10;■企業年金基金&#13;&#10;■退職金制度&#13;&#10;■各種社会保険&#13;&#10;■企業年金制度&#13;&#10;■育児・介護休暇制度&#13;&#10;■社宅制度"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務地</th>
                        <td>
                            <div class="company-capital"><textarea name="address" id="" cols="30" rows="6" placeholder="(例)&#13;&#10;東京、大阪、福岡"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">勤務時間</th>
                        <td>
                            <div class="company-address"><textarea name="worktime" id="" cols="30" rows="6" placeholder="(例)&#13;&#10;フレックスタイム制（コアタイム 11:00～14:00、標準労働時間7時間）"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">休日</th>
                        <td>
                            <div class="company-capital"><textarea name="holiday" id="" cols="30" rows="4" placeholder="(例)&#13;&#10;完全週休2日制（土・日）、祝日、年末年始（12月29日 ～ 1月3日）&#13;&#10;年次有給休暇 / 勤務年数に応じ15日 ～ 25日（ただし初年度は12日）&#13;&#10;年2回、 連続5日間の休暇制度"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">選考の流れ</th>
                        <td>
                            <div class="company-capital"><textarea name="selection_flows" id="" cols="30" rows="8" placeholder="(例)&#13;&#10;ES→GD→面接（複数回）→内定"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員名1</th>
                        <td>
                            <div class="company-capital"><input type="text" class="input-width" min="0" name="worker_name1" id="" value="" placeholder="◯◯ ◯◯さん(営業職2年目)"></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像1</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img"></div>
                                <img src="">
                                <input accept="image/*" id="imgFile" type="file" name="picture1">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員の声1</th>
                        <td>
                            <div class="company-capital"><textarea name="worker_voice1" id="" cols="30" rows="12" placeholder="(例)&#13;&#10;やりたいことができる環境が整っている&#13;&#10;大学時代の長期インターンの経験から、「自分がやりたいこと、成し遂げたいことを実現できるか」ということを基準に企業選びを行っていました。&#13;&#10;その中で〇〇を選んだ理由は、若い方がどんどん活躍している（OB訪問やサイトから）ことを知り、年次に関係なく自分のやりたいことを挑戦できる環境だと思い、入社を決めました。&#13;&#10;実際に入社１年目でイベントの企画運営を任せて頂けたり、現在は新規事業の責任者を任せて頂いたりと、挑戦したい人にはどんどん任せて頂ける環境が整っている会社です。"></textarea></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員名2</th>
                        <td>
                            <div class="company-capital"><input type="text" class="input-width" min="0" name="worker_name2" id="" value=""></div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">イメージ画像2</th>
                        <td>
                            <div class="input_file">
                              <div class="preview">
                                <div class="preview-img"></div>
                                <input accept="image/*" id="imgFile" type="file" name="picture2">
                              </div>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <th align="left" nowrap="nowrap">社員の声2</th>
                        <td>
                            <div class="company-capital"><textarea name="worker_voice2" id="" cols="30" rows="12"></textarea></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </p>
        <input type="hidden" name="new_post_job" value="new_post_job">
        <div class="company_edit">
          '.$post_button_html.'
        </div>
      </div>
    </form>';
    return $edit_html;
}
add_shortcode('new_job_form','new_job_form');


function new_company_post_job(){
  $home_url =esc_url( home_url( ));
  if(!empty($_POST["occupation"]) && !empty($_POST["new_post_job"])){
      $user = get_current_user_id();
      $company = wp_get_current_user();
      $mission = $_POST["job_title"];
      $occupation = $_POST["occupation"];
      $company_name = $company->data->display_name;
      $company_bussiness = $_POST["company_bussiness"];
      $job_contents = $_POST["job_contents"];
      $require_person = $_POST["require_person"];
      $salary = $_POST["salary"];
      $recruit_capacity = $_POST["recruit_capacity"];
      $skill_requirements = $_POST["skill_requirements"];
      $allowance = $_POST["allowance"];
      $welfare = $_POST["welfare"];
      $address = $_POST["address"];
      $worktime = $_POST["worktime"];
      $holiday = $_POST["holiday"];
      $selection_flows = $_POST["selection_flows"];
      $worker_name1 = $_POST["worker_name1"];
      $worker_name2 = $_POST["worker_name2"];
      $worker_voice1 = $_POST["worker_voice1"];
      $worker_voice2 = $_POST["worker_voice2"];
      $picture1 = $_FILES["picture1"];
      $picture2 = $_FILES["picture2"];

      $post_value = array(
          'post_author' => get_current_user_id(),
          'post_title' => $company_name.' '.$occupation.'職',
          'post_type' => 'job',
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
          $post_value['post_status'] = $post_status; // 公開ステータスをこの時点で公開にする。

          if($_POST["occupation"]){
            wp_set_object_terms( $insert_id, $occupation, 'occupation');
          }
          update_post_meta($insert_id, "募集タイトル", $mission);
          update_post_meta($insert_id, "業務内容", $job_contents);
          update_post_meta($insert_id, "求める人物像", $require_person);
          update_post_meta($insert_id, "給与", $salary);
          update_post_meta($insert_id, "採用予定人数", $recruit_capacity);
          update_post_meta($insert_id, "応募資格", $skill_requirements);
          update_post_meta($insert_id, "待遇", $allowance);
          update_post_meta($insert_id, "福利厚生", $welfare);
          if($_POST["address"]){
            update_post_meta($insert_id, "勤務地", $address);
            preg_match("/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$_POST["address"],$result);
            $prefecture = $result[1];
            $area = $result[2];
            if($prefecture == "東京都"){
              wp_set_object_terms( $insert_id, $area, 'area');
            }else{
              wp_set_object_terms( $insert_id, $prefecture, 'area');
            }
          }
          update_post_meta($insert_id, "勤務時間", $worktime);
          update_post_meta($insert_id, "休日", $holiday);
          update_post_meta($insert_id, "選考の流れ", $selection_flows);
          if($_FILES["picture1"]){
            add_custom_image($insert_id, "イメージ画像1", $picture1);
          }
          update_post_meta($insert_id, "社員名1", $worker_name1);
          update_post_meta($insert_id, "紹介文1", $worker_voice1);
          if($_FILES["picture2"]){
            add_custom_image($insert_id, "イメージ画像2", $picture2);
          }
          update_post_meta($insert_id, "社員名2", $worker_name2);
          update_post_meta($insert_id, "紹介文2", $worker_voice2);

          $insert_id2 = wp_insert_post($post_value); //上書き（投稿ステータスを公開に）

          if($insert_id2) {
              /* 投稿に成功した時の処理等を記述 */
              if(!empty($_POST["save"])){
                header('Location: '.$home_url.'/manage_post?posttype=job');
              }
              if(!empty($_POST["preview"])){
                header('Location: '.get_permalink($insert_id2));
              }
              if(!empty($_POST["publish"])){
                header('Location: '.get_permalink($insert_id2));
              }
              die();
              $html = '<p>success</p>';
          } else {
              /* 投稿に失敗した時の処理等を記述 */
              $html = '<p>error1</p>';
          }
      } else {
          /* 投稿に失敗した時の処理等を記述 */
          $html = '<p>error2</p>';
          $html .= '<p>'.$insert_id.'</p>';
      }
  }
}
add_action('template_redirect', 'new_company_post_job');


?>



<div class="container">
			<div class="recruit-img-container">
				<img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1713&q=80" alt="">
				<div class="recruit-img">
					<h1>最新のLotやICTサービスを届ける「ITの総合商社」</h1>
					<a href="https://jobshot.jp/?company=%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%bewiz"><p>株式会社Wiz</p></a>
				</div>
			</div>
		<h2 class="mainhead">事務/コーポレート・スタッフ職</h2>

		</div>