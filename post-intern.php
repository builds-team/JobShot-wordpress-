<?php

function internship_form(){
    $form_html = '
    <h2 class="maintitle">インターンシップ　新規募集</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <p>募集タイトルキャッチコピー:</p>
            <input type="text" name="post_title" id="" required>
        </div>
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
            <p>給与：</p>
            <input type="text" min="0" name="salary" id="" placeholder="(例) 時給1000円" required>
        </div>
        <div>
            <p>勤務可能時間：</p>
            <input type="text" name="worktime" id="" placeholder="(例) 平日9:00-19:00" required>
        </div>
        <div>
            <p>勤務条件：</p>
            <input type="text" name="day_requirements" id="" placeholder="(例) 1日4時間〜、週3日〜" required>
        </div>
        <div>
            <p>求める人物像:</p>
            <textarea name="require_person" id="" cols="30" rows="2"></textarea>
        </div>
        <div>
            <p>業務内容(100文字以上):</p>
            <textarea name="intern_contents" id="" cols="30" rows="5" required></textarea>
        </div>
        <div>
            <p>インターン生の1日の流れ：</p>
            <textarea name="intern_day" id="" cols="30" rows="5" placeholder="(例) &#13;&#10; 9:00-12:00 営業 &#13;&#10; 12:00-13:00 東京駅周辺でランチ &#13;&#10; 13:00-14:00 社員とミーティング &#13;&#10; 14:00-18:00 社内向けシステムの開発" required></textarea>
        </div>
        <div>
            <p>身につくスキル：</p>
            <textarea name="skills" id="" cols="30" rows="2"></textarea>
        </div>
        <div>
            <p>勤務地：</p>
            <input type="text" name="address" id="" required>
        </div>
        <div>
            <p>応募資格：</p>
            <textarea name="skill_requirements" id="" cols="30" rows="2" placeholder="求めるスキル等ご記入ください"></textarea>
        </div>
        <div>
            <p>インターン卒業生の内定先：</p>
            <textarea name="prospective_employer" id="" cols="30" rows="2"></textarea>
        </div>
        <div>
            <p>働いているインターン生の声：</p>
            <textarea name="intern_student_voice" id="" cols="30" rows="2"></textarea>
        </div>
        <div>
            <p>イメージ画像(600×400)：</p>
            <input type="file" name="picture" required>
        </div>
        <div>
            <p>特徴：</p>
            <input type="checkbox" name="feature[]" id="" value="時給1000円以上">時給1000円以上
            <input type="checkbox" name="feature[]" id="" value="時給1200円以上">時給1200円以上
            <input type="checkbox" name="feature[]" id="" value="時給1500円以上">時給1500円以上
            <input type="checkbox" name="feature[]" id="" value="時給2000円以上">時給2000円以上
            <input type="checkbox" name="feature[]" id="" value="週1日ok">週1日ok
            <input type="checkbox" name="feature[]" id="" value="週2日ok">週2日ok
            <input type="checkbox" name="feature[]" id="" value="週3日以下でもok">週3日以下でもok
            <input type="checkbox" name="feature[]" id="" value="1ヶ月からok">1ヶ月からok
            <input type="checkbox" name="feature[]" id="" value="3ヶ月以下歓迎">3ヶ月以下歓迎
            <input type="checkbox" name="feature[]" id="" value="未経験歓迎">未経験歓迎
            <input type="checkbox" name="feature[]" id="" value="1,2年歓迎">1,2年歓迎
            <input type="checkbox" name="feature[]" id="" value="新規事業立ち上げ">新規事業立ち上げ
            <input type="checkbox" name="feature[]" id="" value="理系学生おすすめ">理系学生おすすめ
            <input type="checkbox" name="feature[]" id="" value="外資系">外資系
            <input type="checkbox" name="feature[]" id="" value="ベンチャー">ベンチャー
            <input type="checkbox" name="feature[]" id="" value="エリート社員">エリート社員
            <input type="checkbox" name="feature[]" id="" value="社長直下">社長直下
            <input type="checkbox" name="feature[]" id="" value="起業ノウハウが身につく">起業ノウハウが身につく
            <input type="checkbox" name="feature[]" id="" value="インセンティブあり">インセンティブあり
            <input type="checkbox" name="feature[]" id="" value="英語力が活かせる">英語力が活かせる
            <input type="checkbox" name="feature[]" id="" value="英語力が身につく">英語力が身につく
            <input type="checkbox" name="feature[]" id="" value="留学生歓迎">留学生歓迎
            <input type="checkbox" name="feature[]" id="" value="土日のみでも可能">土日のみでも可能
            <input type="checkbox" name="feature[]" id="" value="リモートワーク可能">リモートワーク可能
            <input type="checkbox" name="feature[]" id="" value="テスト期間考慮">テスト期間考慮
            <input type="checkbox" name="feature[]" id="" value="短期間の留学考慮">短期間の留学考慮
            <input type="checkbox" name="feature[]" id="" value="女性おすすめ">女性おすすめ
            <input type="checkbox" name="feature[]" id="" value="少数精鋭">少数精鋭
            <input type="checkbox" name="feature[]" id="" value="交通費支給">交通費支給
            <input type="checkbox" name="feature[]" id="" value="曜日/時間が選べる">曜日/時間が選べる
            <input type="checkbox" name="feature[]" id="" value="夕方から勤務でも可能">夕方から勤務でも可能
            <input type="checkbox" name="feature[]" id="" value="服装自由">服装自由
            <input type="checkbox" name="feature[]" id="" value="髪色自由">髪色自由
            <input type="checkbox" name="feature[]" id="" value="ネイル可能">ネイル可能
            <input type="checkbox" name="feature[]" id="" value="有名企業への内定者多数">有名企業への内定者多数
            <input type="checkbox" name="feature[]" id="" value="プログラミングが未経験から学べる">プログラミングが未経験から学べる
        </div>
        <input type="hidden" name="post_intern" value="post_intern">
        <input type="submit" value="投稿">
    </form>';
    return $form_html;
}
add_shortcode('internship_form','internship_form');


function company_post_internship(){
    if(!empty($_POST["post_title"]) && !empty($_POST["post_intern"])){
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
            'post_type' => 'internship',
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
add_action('template_redirect', 'company_post_internship');

function add_custom_image($post_id, $feild_name, $upload){
    $uploads = wp_upload_dir(); /*Get path of upload dir of wordpress*/
    // include_once ABSPATH . 'wp-admin/includes/media.php';
    // include_once ABSPATH . 'wp-admin/includes/file.php';
    // include_once ABSPATH . 'wp-admin/includes/image.php';
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
        require_once( ABSPATH . 'wp-admin/includes/media.php' );
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
    }
    /*Check if upload dir is writable*/
    if (is_writable($uploads['path'])){
        /*Check if uploaded image is not empty*/
        if ((!empty($upload['tmp_name']))){
            /*Check if image has been uploaded in temp directory*/
            if ($upload['tmp_name']){
                $file=handle_image_upload($upload); /*Call our custom function to ACTUALLY upload the image*/
                /*Create attachment for our post*/
                $attachment = array(
                    'post_mime_type' => $file['type'],  /*Type of attachment*/
                    'post_parent' => $post_id,  /*Post id*/
                    'post_status' => 'inherit',
                    'post_content' => '',
                );
                $attachment_id = wp_insert_attachment($attachment, $file['file'], $post_id);  /*Insert post attachment and return the attachment id*/
                $attachment_deta = wp_generate_attachment_metadata($attachment_id, $file['file'] );  /*Generate metadata for new attacment*/
                wp_update_attachment_metadata( $attach_id, $attachment_deta );
                $prev_img = get_post_meta($post_id, 'custom_image');  /*Get previously uploaded image*/
                if(is_array($prev_img)){
                    /*If image exists*/
                    if($prev_img[0] != ''){
                        wp_delete_attachment($prev_img[0]);  /*Delete previous image画像が増えていかないように*/
                    }
                }
                update_post_meta($post_id, $feild_name, $attachment_id);  /*Save the attachment id in meta data適当なフィールド名で！*/
                if(!is_wp_error($attachment_id)){
                    wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $file['file'] ) );  /*If there is no error, update the metadata of the newly uploaded image*/
                }
            }
        }else{
            echo 'Please upload the image.';
        }
    }
}
// add_action('save_post', 'add_custom_image');

function handle_image_upload($upload){
    global $post;
    /*Check if image*/
    if (is_image_file($upload['tmp_name'])){
        /*handle the uploaded file*/
        $file = wp_handle_upload($upload,array('test_form' => false,'action' => 'local'));
    }
    return $file;
}

//画像がどうか調べる。wpオリジナルの関数もある
function is_image_file($file_path){
    //まずファイルの存在を確認し、その後画像形式を確認する
    if(file_exists($file_path) && exif_imagetype($file_path)){
        return true;
    }else{
        return false;
    }
}

function tax_check($occupation,$area){
    $term_occupation=get_term_by("name", $occupation, "occupation");
    $occupation_name=$term_occupation->name;
    $term_area=get_term_by("name", $area, "area");
    $area_name=$term_area->name;
	?>
		<script type="text/javascript">
    	jQuery(function($) {
        $('input[name=$occupation_name]').prop('checked', true);
        $('input[name=$area_name]').prop('checked', true);
		});
		</script>
	<?php
}

function wpse132196_redirect_after_trashing() {
    wp_redirect( home_url('/') );
    exit;
}
add_action( 'trashed_post', 'wpse132196_redirect_after_trashing', 10 );
?>