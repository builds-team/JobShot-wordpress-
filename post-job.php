<?php

function job_form(){
    $form_html = '
    <h2 class="maintitle">新卒　新規募集</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <p>職種：</p>
            <input type="radio" name="occupation" value="engineer" checked="checked" />エンジニア
            <input type="radio" name="occupation" value="designer" />デザイナー
            <input type="radio" name="occupation" value="consulting" />コンサル
            <input type="radio" name="occupation" value="director" />ディレクター
            <input type="radio" name="occupation" value="marketer" />マーケティング
            <input type="radio" name="occupation" value="writer" />ライター
            <input type="radio" name="occupation" value="sales" />営業
            <input type="radio" name="occupation" value="corporate_staff" />事務/コーポレート・スタッフ
            <input type="radio" name="occupation" value="human_resources" />総務・人事・経理
            <input type="radio" name="occupation" value="planning" />企画
            <input type="radio" name="occupation" value="others" />その他
        </div>
        <div>
            <p>業務内容(100文字以上):</p>
            <textarea name="intern_contents" id="" cols="30" rows="5"></textarea>
        </div>
        <div>
            <p>選考の流れ:</p>
            <textarea name="" id="" cols="30" rows="5"></textarea>
        </div>
        <div>
            <p>求める人物像:</p>
            <textarea name="require_person" id="" cols="30" rows="2"></textarea>
        </div>
        <div>
            <p>給与：</p>
            <input type="text" min="0" name="salary" id="" placeholder="(例) 時給1000円">
        </div>
        <div>
            <p>応募資格：</p>
            <textarea name="skill_requirements" id="" cols="30" rows="2" placeholder=""></textarea>
        </div>
        <div>
            <p>待遇：</p>
            <textarea name="" id="" cols="30" rows="2" placeholder=""></textarea>
        </div>
        <div>
            <p>福利厚生：</p>
            <textarea name="" id="" cols="30" rows="2" placeholder=""></textarea>
        </div>
        <div>
            <p>勤務地：</p>
            <input type="text" name="address" id="">
        </div>
        <div>
            <p>勤務時間：</p>
            <input type="text" name="worktime" id="" placeholder="(例) 平日9:00-19:00">
        </div>
        <div>
            <p>休日：</p>
            <input type="text" name="holiday" id="" placeholder="(例) 土曜・日曜・祝日">
        </div>
        <div>
            <p>社員の声(画像)(400×400)：</p>
            <input type="file" name="picture">
        </div>
        <div>
            <p>社員の声(名前)：</p>
            <input type="text" name="" id="">
        </div>
        <div>
            <p>社員の声(紹介文)：</p>
            <textarea name="" id="" cols="30" rows="2" placeholder=""></textarea>
        </div>
        <input type="hidden" name="post_job" value="post_job">
        <input type="submit" value="投稿">
    </form>';
    return $form_html;
}
add_shortcode('job_form','job_form');


function company_post_job(){
    if(!empty($_POST["post_title"]) && !empty($_POST["post_job"])){
        $user = get_current_user_id();
        $post_title = $_POST["post_title"];
        $company_bussiness = $_POST["company_bussiness"];
        $intern_contents = $_POST["intern_contents"];
        $skills = $_POST["skills"];
        $address = $_POST["address"];
        preg_match("/(東京都|北海道|(?:京都|大阪)府|.{6,9}県)((?:四日市|廿日市|野々市|臼杵|かすみがうら|つくばみらい|いちき串木野)市|(?:杵島郡大町|余市郡余市|高市郡高取)町|.{3,12}市.{3,12}区|.{3,9}区|.{3,15}市(?=.*市)|.{3,15}市|.{6,27}町(?=.*町)|.{6,27}町|.{9,24}村(?=.*村)|.{9,24}村)(.*)/",$_POST["address"],$result);
        $prefecture = $result[1];
        $area = $result[2];
        $skill_requirements = $_POST["skill_requirements"];
        $prospective_employer = $_POST["prospective_employer"];
        $intern_student_voice = $_POST["intern_student_voice"];
        $features = $_POST["feature"];
        $occupation = $_POST["occupation"];
        $salary = $_POST["salary"];
        $intern_day = $_POST["intern_day"];
        $worktime = $_POST["worktime"];
        $day_requirements = $_POST["day_requirements"];
        $require_person = $_POST["require_person"];
        $picture = $_FILES["picture"];

        $post_value = array(
            'post_author' => get_current_user_id(),
            'post_title' => $post_title,
            'post_type' => 'job',
            'post_status' => 'draft'
        );
        $insert_id = wp_insert_post($post_value); //下書き投稿。
        if($insert_id) {
            //配列$post_valueに上書き用の値を追加、変更
            $post_value['ID'] = $insert_id; // 下書きした記事のIDを渡す。
            $post_value['post_status'] = 'draft'; // 公開ステータスをこの時点で公開にする。

            update_post_meta($insert_id, '事業内容', $company_bussiness);
            update_post_meta($insert_id, '募集タイトル', $post_title);
            update_post_meta($insert_id, '給与', $salary);
            update_post_meta($insert_id, '勤務可能時間', $worktime);
            update_post_meta($insert_id, '勤務条件', $day_requirements);
            update_post_meta($insert_id, '求める人物像', $require_person);
            update_post_meta($insert_id, '業務内容', $intern_contents);
            update_post_meta($insert_id, '1日の流れ', $intern_day);
            update_post_meta($insert_id, '身につくスキル', $skills);
            update_post_meta($insert_id, '勤務地', $address);
            update_post_meta($insert_id, '応募資格', $skill_requirements);
            update_post_meta($insert_id, 'インターン卒業生の内定先', $prospective_employer);
            update_post_meta($insert_id, '働いているインターン生の声', $intern_student_voice);
            update_post_meta($insert_id, '特徴', $features);
            add_custom_image($insert_id, 'イメージ画像', $picture);
            wp_set_object_terms( $insert_id, $occupation, 'occupation');
            if($prefecture == "東京都"){
                wp_set_object_terms( $insert_id, $area, 'area');
            }else{
                wp_set_object_terms( $insert_id, $prefecture, 'area');
            }
            $insert_id2 = wp_insert_post($post_value); //上書き（投稿ステータスを公開に）

            if($insert_id2) {
                /* 投稿に成功した時の処理等を記述 */
                header('Location: '.get_permalink($insert_id2));
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
add_action('template_redirect', 'company_post_job');

?>