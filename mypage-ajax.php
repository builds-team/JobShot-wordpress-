<?php

function Ajax_Base(){
    $user_id = um_profile_id();
    $results = '
    <div class="um-field-label um-info-label-base">
        <label class="um-field-label-text"><i class="um-field-label-base"></i>基本情報</label>
        <span class="um-edit-btn um-edit-btn-base active" onclick="edit_base()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-base inactive">
        <div class="um-field-value">';
    $user_array = array(
        "都道府県"  =>  "region",
        "性別"  =>  "gender",
        "出身高校"  =>  "highschool",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'gender'){
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-6120">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_base', 'Ajax_Base' );
add_action( 'wp_ajax_nopriv_ajax_base', 'Ajax_Base' );

function Ajax_Univ(){
    $user_id = um_profile_id();
    $results = 
    '<div class="um-field-label um-info-label-univ">
        <label class="um-field-label-text"><i class="um-field-label-univ"></i>学歴</label>
        <span class="um-edit-btn um-edit-btn-univ active" onclick="edit_univ()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-univ inactive">
        <div class="um-field-value">';
    $user_array = array(
        "大学"  =>  "university",
        "学部系統"  =>  "faculty_lineage",
        "学部・学科"  =>  "faculty_department",
        "卒業年"  =>  "graduate_year",
        "ゼミ"  =>  "seminar",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'faculty_lineage' || $user_value == 'graduate_year'){
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_univ', 'Ajax_Univ' );
add_action( 'wp_ajax_nopriv_ajax_univ', 'Ajax_Univ' );

function Ajax_Abroad(){
    $user_id = um_profile_id();
    $results = 
    '<div class="um-field-label um-info-label-abroad">
        <label class="um-field-label-text"><i class="um-field-label-abroad"></i>留学</label>
        <span class="um-edit-btn um-edit-btn-abroad active" onclick="edit_abroad()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-abroad inactive">
        <div class="um-field-value">';
    $user_array = array(
        "留学経験"  =>  "studied_abroad",
        "留学先"  =>  "studied_ab_place",
        "その他"  =>  "lang_pr",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'studied_ab_place'){
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        if($user_value == 'studied_abroad'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_abroad', 'Ajax_Abroad' );
add_action( 'wp_ajax_nopriv_ajax_abroad', 'Ajax_Abroad' );

function Ajax_Programming(){
    $user_id = um_profile_id();
    if(isset($_POST['programming_languages'])) {
        $programming_languages = $_POST['programming_languages'];
        // Update/Create User Meta
        update_user_meta( $user_id, 'programming_languages', $programming_languages);
	}
    $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];
    $programming_lang_lv_array = array(
        "C言語"  => "programming_lang_lv_c",
        "C++"    => "programming_lang_lv_cpp",
        "C#"  =>  "programming_lang_lv_cs",
        "Objective-C"  =>  "programming_lang_lv_m",
        "Java"  =>  "programming_lang_lv_java",
        "JavaScript"  =>  "programming_lang_lv_js",
        "Python"  =>  "programming_lang_lv_py",
        "PHP"  =>  "programming_lang_lv_php",
        "Perl"  =>  "programming_lang_lv_pl",
        "Ruby"  =>  "programming_lang_lv_rb",
        "Go"  =>  "programming_lang_lv_go",
        "Swift"  =>  "programming_lang_lv_swift",
        "Visual Basic"  =>  "programming_lang_lv_vb",
    );
    $languages = "";
    foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
        if(isset($_POST[$programming_lang_lv])){
            $programming_lang_lv_skill = $_POST[$programming_lang_lv];
            update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
        }
        $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
        if($programming_lang_lv_skill > 0 and in_array($programming_lang_name, $programming_languages)) {
            $languages .='
            <div class=" um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-key="'.$programming_lang_lv.'">
                <div class="um-field-label">
                    <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area">
                    <div class="um-field-value">
                        <div class="um-rating-readonly um-raty" id="'.$programming_lang_lv.'" data-key="'.$programming_lang_lv.'" data-number="5" data-score="'.$programming_lang_lv_skill.'" title="'.$programming_lang_lv_skill.'">';
                        for($i = 1; $i < ($programming_lang_lv_skill+1); $i++){
                            $languages .= '<i data-alt="'.$i.'" class="star-on-png" title="'.$programming_lang_lv_skill.'"></i>';
                        }
                        for($i = $programming_lang_lv_skill+1; $i < 6; $i++){
                            $languages .= '<i data-alt="'.$i.'" class="star-off-png" title="'.$programming_lang_lv_skill.'"></i>';
                        }
            $languages .= 
                        '</div>
                    </div>
                </div>
            </div>';
        }
    }
    $results =
    '<div class="um-field-label um-info-label-programming">
        <label class="um-field-label-text"><i class="um-field-label-programming"></i>プログラミング</label>
        <span class="um-edit-btn um-edit-btn-programming active" onclick="edit_programming()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-programming inactive">
        <div class="um-field-value">';
    $user_array = array(
        "プログラミング経験"  =>  "experience_programming",
        "使用したことのあるフレームワーク・ライブラリ"  =>  "framework",
        "GitHubアカウント"  =>  "GitHub",
        "開発ソフトのスキル"  =>  "skill_dev",
        "使えるデザイン系アプリケーション"  =>  "skill_design",
        "プログラミング実務経験"  =>  "work",
    );
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'GitHub'){
            if(isset($_POST[$user_value.'-6120'])) {
                $user_meta_value = $_POST[$user_value.'-6120'];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }else{
            if(isset($_POST[$user_value])) {
                $user_meta_value = $_POST[$user_value];
                update_user_meta( $user_id, $user_value, $user_meta_value);
            }
        }
        if($user_value == 'experience_programming'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        if($user_value == 'skill_design' || $user_value == 'skill_dev'){
            $user_meta_value_sub = '';
            foreach($user_meta_value as $user_meta_value_each) {
                $user_meta_value_sub .= $user_meta_value_each.'</br>' ;
            }
            $user_meta_value = $user_meta_value_sub;
        }
        $language_result = '';
        if($user_value == 'experience_programming'){
            $language_result = $languages;
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>'.$language_result;
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_programming', 'Ajax_Programming' );
add_action( 'wp_ajax_nopriv_ajax_programming', 'Ajax_Programming' );

function Ajax_Skill(){
    $user_id = um_profile_id();
    if(isset($_POST['skill'])) {
        $skill = $_POST['skill'];
        update_user_meta( $user_id, 'skill', $skill);
    }
    $skill = get_user_meta($user_id,'skill',false)[0];

    $results = '
    <div class="um-field-label um-info-label-skill">
        <label class="um-field-label-text"><i class="um-field-label-skill"></i>資格・その他スキル</label>
        <span class="um-edit-btn um-edit-btn-skill active" onclick="edit_skill()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-skill inactive">
        <div class="um-field-value">
            <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill">
                <div class="um-field-label">
                    <label for="skill-1597">資格・その他スキル</label>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area">
                    <div class="um-field-value">'.$skill.'</div>
                </div>
            </div>
        </div>
    </div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_skill', 'Ajax_Skill' );
add_action( 'wp_ajax_nopriv_ajax_skill', 'Ajax_Skill' );

function Ajax_Community(){
    $user_id = um_profile_id();
    $results = '
    <div class="um-field-label um-info-label-community">
        <label class="um-field-label-text"><i class="um-field-label-community"></i>コミュニティ</label>
        <span class="um-edit-btn um-edit-btn-community active" onclick="edit_community()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-community inactive">
        <div class="um-field-value">';
    $user_array = array(
        "大学時代のコミュニティ"  =>  "univ_community_checkbox",
        "サークル・部活・団体名"  =>  "community_univ",
        "当コミュニティでどんなことをしたか？"  =>  "own_pr",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        if($user_value == 'univ_community_checkbox'){
            $univ_community_checkbox  = get_user_meta($user_id,$user_value,false)[0];
            foreach($univ_community_checkbox as $exp) {
                $user_meta_value .= $exp.'</br>';
            }
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_community', 'Ajax_Community' );
add_action( 'wp_ajax_nopriv_ajax_community', 'Ajax_Community' );

function Ajax_Intern(){
  $user_id = um_profile_id();
  $results = '
    <div class="um-field-label um-info-label-internship">
        <label class="um-field-label-text"><i class="um-field-label-internship"></i>長期インターン</label>
        <span class="um-edit-btn um-edit-btn-internship active" onclick="edit_internship()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-internship inactive">
        <div class="um-field-value">';
    $user_array = array(
        "長期インターン経験"  =>  "internship_experiences",
        "長期インターン経験先企業名"  =>  "internship_company",
        "長期インターン先でどんな経験をしたか？"  =>  "experience_internship",
        "自己PR"  =>  "self_internship_PR",
        "長期有給インターンへの興味の度合い"  =>  "degree_of_internship_interest",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        if($user_value == 'internship_experiences'){
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0][0];
        }else{
            $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_intern', 'Ajax_Intern' );
add_action( 'wp_ajax_nopriv_ajax_intern', 'Ajax_Intern' );

function Ajax_Interest(){
    $user_id = um_profile_id();
    $results = '
    <div class="um-field-label um-info-label-interest">
        <label class="um-field-label-text"><i class="um-field-label-interest"></i>興味・関心</label>
        <span class="um-edit-btn um-edit-btn-interest active" onclick="edit_interest()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-interest inactive">
        <div class="um-field-value">';
    $user_array = array(
        "興味のある業界"  =>  "bussiness_type",
        "職種"  =>  "future_occupations",
        "ベンチャーへの就職意欲"  =>  "will_venture",
    );
    foreach($user_array as $user_key => $user_value){
        if(isset($_POST[$user_value])) {
            $user_meta_value = $_POST[$user_value];
            update_user_meta( $user_id, $user_value, $user_meta_value);
        }
        $user_meta_value  = get_user_meta($user_id,$user_value,false)[0];
        if($user_value == 'future_occupations' || $user_value == 'bussiness_type'){
            $user_meta_value_sub = '';
            foreach($user_meta_value as $user_meta_value_each) {
                $user_meta_value_sub .= $user_meta_value_each.'</br>' ;
            }
            $user_meta_value = $user_meta_value_sub;
        }
        $results .= '
        <div class="um-field um-field-'.$user_value.' um-field-text um-field-type_text" data-key="'.$user_value.'">
            <div class="um-field-label">
                <label for="'.$user_value.'-1597">'.$user_key.'</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">'.$user_meta_value.'</div>
            </div>
        </div>';
    }
    $results .= '</div></div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_interest', 'Ajax_Interest' );
add_action( 'wp_ajax_nopriv_ajax_interest', 'Ajax_Interest' );

function Ajax_Experience(){
    $user_id = um_profile_id();
    if(isset($_POST['student_experience'])) {
        $student_experience = $_POST['student_experience'];
        update_user_meta( $user_id, 'student_experience', $student_experience);
    }
    $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
    if(isset($student_experience)) {
        foreach($student_experience as $exp) {
        $exps .= $exp.'</br>';
        }
    }
    $results = '
    <div class="um-field-label um-info-label-experience">
        <label class="um-field-label-text"><i class="um-field-label-experience"></i>学生時代の経験</label>
        <span class="um-edit-btn um-edit-btn-experience active" onclick="edit_experience()">編集</span>
        <div class="um-clear"></div>
    </div>
    <div class="um-field-area um-field-area-experience inactive">
        <div class="um-field-value">
            <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience">
                <div class="um-field-label">
                    <label for="student_experience-1597">学生時代の経験</label>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area">
                    <div class="um-field-value">'.$exps.'</div>
                </div>
            </div>
        </div>
    </div>';
    $score = update_user_total_profile_score($user_id);
    $list = array($results,$score);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_ajax_experience', 'Ajax_Experience' );
add_action( 'wp_ajax_nopriv_ajax_experience', 'Ajax_Experience' );

?>