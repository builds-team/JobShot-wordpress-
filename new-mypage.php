<?php
add_filter('script_loader_tag', 'add_defer', 10, 2);
function add_defer($tag, $handle) {
  if($handle !== 'jquery3') {
    return $tag;
  }
  return str_replace(' src=', ' defer src=', $tag);
}

function new_mypage_func(){
    $user_id = um_profile_id();
    $user_array = array(
        "都道府県"  =>  "region",
        "性別"  =>  "gender",
        "出身高校"  =>  "highschool",
        "学部系統"  =>  "faculty_lineage",
        "学部・学科"  =>  "faculty_department",
        "卒業年"  =>  "graduate_year",
        "ゼミ"  =>  "seminar",
        "留学経験"  =>  "studied_abroad",
        "留学先"  =>  "studied_ab_place",
        "その他"  =>  "lang_pr",
        "プログラミング経験"  =>  "experience_programming",
        "使用したことのあるフレームワーク・ライブラリ"  =>  "framework",
        "GitHubアカウント"  =>  "GitHub",
        "開発ソフトのスキル"  =>  "skill_dev",
        "使えるデザイン系アプリケーション"  =>  "skill_design",
        "プログラミング実務経験"  =>  "work",
        "資格・その他スキル"    =>  "skill",
        "大学時代のコミュニティ"  =>  "univ_community",
        "サークル・部活・団体名"  =>  "community_univ",
        "当コミュニティでどんなことをしたか？"  =>  "own_pr",
        "長期インターン経験"  =>  "internship_experiences",
        "長期インターン経験先企業名"  =>  "internship_company",
        "長期インターン先でどんな経験をしたか？"  =>  "experience_internship",
        "自己PR"  =>  "self_internship_PR",
        "長期有給インターンへの興味の度合い"  =>  "degree_of_internship_interest",
        "興味のある業界"  =>  "bussiness_type",
        "職種"  =>  "future_occupations",
        "ベンチャーへの就職意欲"  =>  "will_venture",
        "学生時代の経験"    =>  "student_experience",
    );
    $user_profile_total_score = update_user_total_profile_score($user_id);
    foreach($user_array as $user_key => $user_value){
        if($user_value == 'region' || $user_value == 'highschool' || $user_value == 'faculty_department' || $user_value == 'seminar' || $user_value == 'studied_ab_place' || $user_value == 'GitHub'){
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
    }
    $prefecture  = get_user_meta($user_id,'region',false)[0];
    $highschool = get_user_meta($user_id,'highschool')[0];
    $gender = get_user_meta($user_id,'gender',false)[0][0];
    $university = get_user_meta($user_id,'university',false)[0];
    $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];
    $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];
    $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
    $seminar = get_user_meta($user_id,'seminar',false)[0];
    $studied_abroad = get_user_meta($user_id,'studied_abroad',false)[0][0];
    $studied_ab_place = get_user_meta($user_id,'studied_ab_place',false)[0];
    $lang_pr = get_user_meta($user_id,'lang_pr',false)[0];
    $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
    $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];
    $framework = get_user_meta($user_id,'framework',false)[0];
    $GitHub = get_user_meta($user_id,'GitHub',false)[0];
    $skill_dev = get_user_meta($user_id,'skill_dev',false)[0];
    if(isset($skill_dev)) {
        foreach($skill_dev as $dev) {
            $devs .= $dev.'</br>' ;
        }
    }
    $skill_design = get_user_meta($user_id,'skill_design',false)[0];
    if(isset($skill_design)) {
        foreach($skill_design as $design) {
            $designs .= $design.'</br>' ;
        }
    }
    $work = get_user_meta($user_id,'work',false)[0];
    $skill = get_user_meta($user_id,'skill',false)[0];
    $univ_community_checkbox = get_user_meta($user_id,'univ_community_checkbox',false)[0];
    if(isset($univ_community_checkbox)) {
        foreach($univ_community_checkbox as $exp) {
            $univ_community .= $exp.'</br>';
        }
    }
    $community_univ = get_user_meta($user_id,'community_univ',false)[0];
    $own_pr = get_user_meta($user_id,'own_pr',false)[0];
    $internship_experiences = get_user_meta($user_id,'internship_experiences',false)[0][0];
    $internship_company = get_user_meta($user_id,'internship_company',false)[0];
    $experience_internship = get_user_meta($user_id,'experience_internship',false)[0];
    $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
    $degree_of_internship_interest = get_user_meta($user_id,'degree_of_internship_interest',false)[0];
    $bussiness_type = get_user_meta($user_id,'bussiness_type',false)[0];
    if(isset($bussiness_type)) {
        foreach($bussiness_type as $type) {
            $types .= $type.'</br>';
        }
    }
    $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
    if(isset($future_occupations)) {
        foreach($future_occupations as $occupation) {
            $occupations .= $occupation.'</br>';
        }
    }
    $will_venture = get_user_meta($user_id,'will_venture',false)[0];
    $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];
    if(isset($student_experience)) {
        foreach($student_experience as $exp) {
            $exps .= $exp.'</br>';
        }
    }

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
    $language_result_html = "";
    $option_languages_html = "";
    foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
        if(isset($_POST[$programming_lang_lv])){
            $programming_lang_lv_skill = $_POST[$programming_lang_lv];
            update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
        }
        $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
        $languages .='
        <div class=" um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-key="'.$programming_lang_lv.'" style="display:none;">
            <div class="um-field-label">
                <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
                <div class="um-clear"></div>
            </div>
            <div class="um-field-area">
                <div class="um-field-value">
                    <div class="um-rating-readonly um-raty" id="'.$programming_lang_lv.'" data-key="'.$programming_lang_lv.'" data-number="5" data-score="'.$programming_lang_lv_skill.'" title="'.$programming_lang_lv_skill.'">
                    </div>
                </div>
            </div>
        </div>';
        $language_result_html .= '
        <div class="um-field um-field-'.$programming_lang_lv.' um-field-rating um-field-type_rating" data-cond-0-action="show" data-cond-0-field="programming_languages" data-cond-0-operator="contains" data-cond-0-value="'.$programming_lang_name.'" id="'.$programming_lang_name.'" data-key="'.$programming_lang_lv.'" style="display:none;">
            <div class="um-field-label">
                <label for="'.$programming_lang_lv.'-6120">'.$programming_lang_name.'のレベル</label>
            <div class="um-clear"></div>
        </div>
        <div class="um-field-area">
            <div class="um-rating um-raty" id='.$programming_lang_lv.' data-key='.$programming_lang_lv.' data-number="5" data-score="'.$programming_lang_lv_skill.'" style="cursor: pointer;"></div>
            </div>
        </div>';
        $option_languages_html .= '<option value="'.$programming_lang_name.'">'.$programming_lang_name.'</option>';
    }
    $univ_community_edit_html = get_univ_community_edit_html($user_id);

    //プロフィール写真
    $upload_dir = wp_upload_dir();
    $login_user = wp_get_current_user();
    $login_user_id = $login_user->data->ID;
    $user_roles = $login_user->roles;
    $user_info = get_userdata($user_id);
    $user_name = $user_info->user_login;
    $image_date = date("YmdHis");
    $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
    if(!file_exists($upload_file_name)){
      $attachment_id=2632;
      $upload_file_name = wp_get_attachment_image_src($attachment_id)[0];
    }
    $upload_cover_name = $upload_dir['basedir']."/".'cover_photo'.$user_id.'.png';
    if(!file_exists($upload_cover_name)){
      $attachment_id=2631;
      $upload_cover_name = wp_get_attachment_image_src($attachment_id,'full')[0];
    }
    $home_url =esc_url( home_url( ));
    $cover_html = '
    <div class="um-cover has-cover um-trigger-menu-on-click" data-user_id="'.$user_id.'" data-ratio="2.7:1" style="height: 296px;">
        <div class="um-cover-e zindex1" data-ratio="2.7:1" style="height: 296px;">
            <img src="'.$upload_cover_name.'?'.$image_date.'" scale="2" />
        </div>
        <span class="um-cover-overlay zindex3" style="display: none;">
            <span class="um-cover-overlay-s">
                <ins>
                    <i class="um-faicon-picture-o"></i>
                    <span class="um-cover-overlay-t" style="color: rgb(255, 255, 255);">カバー写真を変更</span>
                </ins>
            </span>
        </span>
    </div>';
    $upload_html = '
    <div class="wrap">
        <table class="wp-list-table widefat striped posts upload-photo">
            <tr>
                <td class="photo-title">プロフィール写真</td>
                <td class="photo-upload widthmax">
                    <form method="post" action="" enctype="multipart/form-data" id="profile">
                        <div class="photo-img-preview">
                            <div></div>
                        </div>
                        <input accept="image/*" type="file" name="upfilename" />
                        <input type="hidden" name="user_id" value="'.$user_id.'">
                        <input type="submit" value="アップロード">
                    </form>
                </td>
                <td class="photo-cancel">
                    <button class="button favorite innactive">キャンセル</button>
                </td>
            </tr>
        </table>
        <table class="wp-list-table widefat striped posts upload-coverphoto">
            <tr>
                <td class="photo-title">カバー写真</td>
                <td class="photo-upload widthmax">
                    <form method="post" action="" enctype="multipart/form-data" id="cover">
                        <div class="coverphoto-img-preview">
                            <div></div>
                        </div>
                        <input accept="image/*" type="file" name="upcovername" />
                        <input type="hidden" name="user_id" value="'.$user_id.'">
                        <input type="submit" value="アップロード">
                    </form>
                </td>
                <td class="photo-cancel">
                    <button class="button favorite innactive">キャンセル</button>
                </td>
            </tr>
        </table>
    </div>';

    if($login_user_id == $user_id){
        $header_html = '
        <div class="um-header">
            <div class="um-profile-edit um-profile-headericon um-trigger-menu-on-click">
                <a href="javascript:void(0);" class="um-profile-edit-a"><i class="um-faicon-cog"></i></a>
                <div class="um-dropdown" data-element="div.um-profile-edit" data-position="bc" data-trigger="click" style="width: 200px; right: auto; text-align: center;">
                    <div class="um-dropdown-b">
                        <div class="um-dropdown-arr" style="top: -17px; left: 87px; right: auto;"><i class="um-icon-arrow-up-b"></i>
                        </div>
                        <ul>
                            <li></li>
                            <li><a href="'.$home_url.'/user_account" class="real_url">マイアカウント</a></li>
                            <li><a href="'.$home_url.'/?page_id=1603" class="real_url">ログアウト</a></li>
                            <li><a href="javascript:void(0);" class="um-dropdown-hide">キャンセル</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="um-profile-photo um-trigger-menu-on-click" data-user_id="'.$user_id.'">
                <a href="'.$home_url.'/user?um_user='.$user_name.'" class="um-profile-photo-img zindex4" title="'.$user_name.'">
                <span class="um-profile-photo-overlay">
                    <span class="um-profile-photo-overlay-s">
                        <ins>
                            <i class="um-faicon-camera"></i>
                        </ins>
                    </span>
                </span>
                <img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar" />
                </a>
            </div>
            <div class="um-profile-meta">
                <div class="um-main-meta zindex4">
                    <div class="um-name">
                        <a href="'.$home_url.'/user?um_user='.$user_name.'" title="'.$user_name.'">'.$user_name.'</a>
                    </div>
                    <div class="um-clear"></div>
                    <div class="um-profile-connect um-member-connect"></div>
                </div>
                <div class="um-profile-status">
                </div>
            </div>
            <div class="profile_score_area only-pc">
                <div class="user_score_circle zindex2">
                    <h5 class="user_profile_score_title">プロフィールスコア</h5>
                    <p class="user_profile_score_value">'.$user_profile_total_score.'</p>
                </div>
            </div>
            <div class="score-card only-sp">
                <div class="score-area">
                    <p>'.$user_profile_total_score.'</p>
                </div>
                <div class="info-area">
                    <h3>プロフィールスコア</h3>
                    <p>プロフィールを充実させてスカウトを受け取ろう</p>
                </div>
            </div>
        </div>
        ';

    }
    elseif(in_array("administrator", $user_roles)){
        $header_html =
        '<div class="um-header">
            <div class="um-profile-edit um-profile-headericon um-trigger-menu-on-click">
                <a href="javascript:void(0);" class="um-profile-edit-a"><i class="um-faicon-cog"></i></a>
                <div class="um-dropdown" data-element="div.um-profile-edit" data-position="bc" data-trigger="click" style="width: 200px; right: auto; text-align: center; display: none;">
                    <div class="um-dropdown-b">
                        <div class="um-dropdown-arr" style="top: -17px; left: 87px; right: auto;"><i class="um-icon-arrow-up-b"></i></div>
                        <ul>
                            <li><a href="/user?um_user='.$user_name.'&amp;um_action=um_put_as_pending&amp;uid='.$user_id.'" class="real_url um_put_as_pending-item">承認待ちにする</a></li>
                            <li><a href="/user?um_user='.$user_name.'&amp;um_action=um_deactivate&amp;uid='.$user_id.'" class="real_url um_deactivate-item">このアカウントを無効化</a></li>
                            <li><a href="/user?um_user='.$user_name.'&amp;um_action=um_delete&amp;uid='.$user_id.'" class="real_url um_delete-item">このユーザーを削除</a></li>
                            <li><a href="/user?um_user='.$user_name.'&amp;um_action=um_switch_user&amp;uid='.$user_id.'" class="real_url um_switch_user-item">このユーザーとしてログイン</a></li>
                            <li><a href="'.$home_url.'/user?um_user='.$user_name.'&amp;um_action=edit" class="real_url">プロフィールを編集</a></li>
                            <li><a href="javascript:void(0);" class="um-dropdown-hide">キャンセル</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="um-profile-photo um-trigger-menu-on-click" data-user_id="'.$user_id.'">
                <a href="'.$home_url.'/user?um_user='.$user_name.'" class="um-profile-photo-img" title="'.$user_name.'">
                <span class="um-profile-photo-overlay">
                    <span class="um-profile-photo-overlay-s">
                        <ins>
                            <i class="um-faicon-camera"></i>
                        </ins>
                    </span>
                </span>
                <img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar" />
                </a>
            </div>
            <div class="um-profile-meta">
                <div class="um-main-meta">
                    <div class="um-name">
                        <a href="'.$home_url.'/user?um_user='.$user_name.'" title="'.$user_name.'">'.$user_name.'</a>
                    </div>
                    <div class="um-clear"></div>
                    <div class="um-profile-connect um-member-connect"></div>
                </div>
                <div class="um-profile-status">
                </div>
            </div>
            <div class="profile_score_area only-pc">
                <div class="user_score_circle">
                    <h5 class="user_profile_score_title">プロフィールスコア</h5>
                    <p class="user_profile_score_value">'.$user_profile_total_score.'</p>
                </div>
            </div>
            <div class="score-card only-sp">
                <div class="score-area">
                    <p>'.$user_profile_total_score.'</p>
                </div>
                <div class="info-area">
                    <h3>プロフィールスコア</h3>
                    <p>プロフィールを充実させてスカウトを受け取ろう</p>
                </div>
            </div>
        </div>
        ';
    }
    elseif(in_array("company", $user_roles)){
        $header_html = '
        <div class="um-header">
            <div class="um-profile-photo um-trigger-menu-on-click" data-user_id="'.$user_id.'">
                <a href="'.$home_url.'/user?um_user='.$user_name.'" class="um-profile-photo-img" title="'.$user_name.'">
                <span class="um-profile-photo-overlay">
                    <span class="um-profile-photo-overlay-s">
                        <ins>
                            <i class="um-faicon-camera"></i>
                        </ins>
                    </span>
                </span>
                <img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar" />
                </a>
            </div>
            <div class="um-profile-meta">
                <div class="um-main-meta">
                    <div class="um-name">
                        <a href="'.$home_url.'/user?um_user='.$user_name.'" title="'.$user_name.'">'.$user_name.'</a>
                    </div>
                    <div class="um-clear"></div>
                    <div class="um-profile-connect um-member-connect"></div>
                </div>
                <div class="um-profile-status">
                </div>
            </div>
            <div class="profile_score_area only-pc">
                <div class="user_score_circle">
                    <h5 class="user_profile_score_title">プロフィールスコア</h5>
                    <p class="user_profile_score_value">'.$user_profile_total_score.'</p>
                </div>
            </div>
            <div class="score-card only-sp">
                <div class="score-area">
                    <p>'.$user_profile_total_score.'</p>
                </div>
                <div class="info-area">
                    <h3>プロフィールスコア</h3>
                    <p>プロフィールを充実させてスカウトを受け取ろう</p>
                </div>
            </div>
        </div>
        ';
    }
    if($login_user_id == $user_id){
      $html .= $upload_html;
    }
    $html .= $cover_html;
    $html .= $header_html;
    //$html .= $nav_html;
    $html.='
    <!-- これより上はclassとdivが被っているので不要 -->
    <div class="um-profile-infomation">
        <div class="um-info">
            <div class="um-field um-field-profile" id="base">
                <div class="um-field-label um-info-label-base">
                    <label class="um-field-label-text"><i class="um-field-label-base"></i>基本情報</label>
                    <span class="um-edit-btn um-edit-btn-base" onclick="edit_base()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-base">
                    <div class="um-field-value">
                        <div class="um-field um-field-region um-field-text um-field-type_text" data-key="region"><div class="um-field-label"><label for="region-6120">都道府県</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$prefecture.'</div></div></div>
                        <div class="um-field um-field-gender um-field-radio um-field-type_radio" data-key="gender"><div class="um-field-label"><label for="gender-6120">性別</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$gender.'</div></div></div>
                        <div class="um-field um-field-highschool um-field-text um-field-type_text" data-key="highschool"><div class="um-field-label"><label for="highschool-6120">出身高校</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$highschool.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-base">
              <form method="post" id="testform">
                <div class="um-field um-field-region um-field-text um-field-type_text" data-key="region">
                  <div class="um-field-label"><label for="region-6120">都道府県</label>
                    <div class="um-clear"></div>
                  </div>
                  <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="region-6120" id="region-6120" value="'.$prefecture.'" placeholder="" data-validate="" data-key="region"></div>
                </div>
                <div class="um-field um-field-gender um-field-radio um-field-type_radio" data-key="gender">
                  <div class="um-field-label"><label for="gender-6120">性別</label>
                    <div class="um-clear"></div>
                  </div>
                  <div class="um-field-area"><label class="um-field-radio um-field-half "><input type="radio" name="gender[]" value="男性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">男性</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="gender[]" value="女性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">女性</span></label>
                    <div class="um-clear"></div>
                    <div class="um-clear"></div>
                  </div>
                </div>
                <div class="um-field um-field-highschool um-field-text um-field-type_text" data-key="highschool">
                  <div class="um-field-label"><label for="highschool-6120">出身高校</label>
                    <div class="um-clear"></div>
                  </div>
                  <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="highschool-6120" id="highschool-6120" value="'.$highschool.'" placeholder="" data-validate="" data-key="highschool"></div>
                </div>
                <div class="um-editor-btn">
                  <input type="submit" value="更新" class="um-editor-update2">
                  <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                </div>
              </form>
            </div>
            <div class="result_area" id="resultarea"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile"  id="univ">
                <div class="um-field-label um-info-label-univ">
                    <label class="um-field-label-text"><i class="um-field-label-univ"></i>学歴</label>
                    <span class="um-edit-btn um-edit-btn-univ" onclick="edit_univ()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-univ">
                    <div class="um-field-value">
                        <div class="um-field um-field-university um-field-text um-field-type_text" data-key="university"><div class="um-field-label"><label for="university-1597">大学</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$university.'</div></div></div>
                        <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage"><div class="um-field-label"><label for="faculty_lineage-1597">学部系統</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$faculty_lineage.'</div></div></div>
                        <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department"><div class="um-field-label"><label for="faculty_department-1597">学部・学科</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$faculty_department.'</div></div></div>
                        <div class="um-field um-field-graduate_year um-field-select um-field-type_select" data-key="graduate_year"><div class="um-field-label"><label for="graduate_year-1597">卒業年</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$graduate_year.'</div></div></div>
                        <div class="um-field um-field-seminar um-field-text um-field-type_text" data-key="seminar"><div class="um-field-label"><label for="seminar-1597">ゼミ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$seminar.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-univ">
                <form method="post" id="testform2">
                    <div class="um-field um-field-university um-field-text um-field-type_text" data-key="university">
                        <div class="um-field-label"><label for="university-1597">大学<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="university-6120" id="university-6120" value="'.$university.'" placeholder="" data-validate="" data-key="university"></div>
                    </div>
                    <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage">
                        <div class="um-field-label"><label for="faculty_lineage-6120">学部系統<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select data-default="" name="faculty_lineage" id="faculty_lineage" data-validate="" data-key="faculty_lineage" class="um-form-field valid um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="文・人文">文・人文</option><option value="社会・国際">社会・国際</option><option value="法・政治">法・政治</option><option value="経済・経営・商">経済・経営・商</option><option value="教育">教育</option><option value="理">理</option><option value="工">工</option><option value="農">農</option><option value="医・歯・薬・保健">医・歯・薬・保健</option><option value="生活科学">生活科学</option><option value="芸術">芸術</option><option value="スポーツ科学">スポーツ科学</option><option value="総合・環境・情報・人間">総合・環境・情報・人間</option></select>
                        </div>
                    </div>
                    <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department">
                        <div class="um-field-label"><label for="faculty_department-1597">学部・学科<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="faculty_department-6120" id="faculty_department-6120" value="'.$faculty_department.'" placeholder="" data-validate="" data-key="faculty_department"></div>
                    </div>
                    <div class="um-field um-field-graduate_year um-field-select um-field-type_select" data-key="graduate_year">
                        <div class="um-field-label"><label for="graduate_year-6120">卒業年</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select data-default="" name="graduate_year" id="graduate_year" data-validate="" data-key="graduate_year" class="um-form-field valid not-required um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true">
                            <option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="その他">その他</option></select>
                        </div>
                    </div>
                    <div class="um-field um-field-seminar um-field-text um-field-type_text" data-key="seminar">
                        <div class="um-field-label"><label for="seminar-6120">ゼミ<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="seminar-6120" id="seminar-6120" value="'.$seminar.'" placeholder="" data-validate="" data-key="seminar"></div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea2"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile" id="abroad">
                <div class="um-field-label um-info-label-abroad">
                    <label class="um-field-label-text"><i class="um-field-label-abroad"></i>留学</label>
                    <span class="um-edit-btn um-edit-btn-abroad" onclick="edit_abroad()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-abroad">
                    <div class="um-field-value">
                        <div class="um-field um-field-studied_abroad um-field-radio um-field-type_radio" data-key="studied_abroad"><div class="um-field-label"><label for="studied_abroad-1597">留学経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$studied_abroad.'</div></div></div>
                        <div class="um-field um-field-studied_ab_place um-field-text um-field-type_text" data-key="studied_ab_place"><div class="um-field-label"><label for="studied_ab_place-1597">留学先</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$studied_ab_place.'</div></div></div>
                        <div class="um-field um-field-lang_pr um-field-textarea um-field-type_textarea" data-key="lang_pr">  <div class="um-field-label"><label for="lang_pr-1597">その他</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$lang_pr.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-abroad">
                <form method="post" id="testform3">
                    <div class="um-field um-field-studied_abroad um-field-radio um-field-type_radio" data-key="studied_abroad">
                        <div class="um-field-label"><label for="studied_abroad-1597">留学経験</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="経験なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験なし</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">3ヶ月未満</span></label>
                            <div class="um-clear"></div><p><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="３ヶ月以上６ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">３ヶ月以上６ヶ月未満</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="６ヶ月以上1年未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">６ヶ月以上1年未満</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="１年以上"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">１年以上</span></label></p>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-field um-field-studied_ab_place um-field-text um-field-type_text" data-key="studied_ab_place">
                        <div class="um-field-label"><label for="studied_ab_place-1597">留学先</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><input autocomplete="off" class="um-form-field valid not-required " type="text" name="studied_ab_place-6120" id="studied_ab_place-1597" value="'.$studied_ab_place.'" placeholder="" data-validate="" data-key="studied_ab_place"></div>
                    </div>
                    <div class="um-field um-field-lang_pr um-field-textarea um-field-type_textarea" data-key="lang_pr">
                        <div class="um-field-label"><label for="lang_pr-1597">その他</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-lang_pr-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="lang_pr" id="lang_pr" aria-hidden="true">'.$lang_pr.'</textarea>
                            </div>
                            <p><span class="description">TOIEC、TOEFLや英検などの英語のスキルがわかるものを記入してみよう</span></p>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea3"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile" id="programming">
                <div class="um-field-label um-info-label-programming">
                    <label class="um-field-label-text"><i class="um-field-label-programming"></i>プログラミング</label>
                    <span class="um-edit-btn um-edit-btn-programming" onclick="edit_programming()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-programming">
                    <div class="um-field-value">
                        <div class="um-field um-field-experience_programming um-field-radio um-field-type_radio" data-key="experience_programming"><div class="um-field-label"><label for="experience_programming-1597">プログラミング経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_programming.'</div></div></div>'.$languages.'
                        <div class="um-field um-field-framework um-field-textarea um-field-type_textarea" data-key="framework"><div class="um-field-label"><label for="framework-1597">使用したことのあるフレームワーク・ライブラリ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$framework.'</div></div></div>
                        <div class="um-field um-field-GitHub um-field-url um-field-type_url" data-key="GitHub"><div class="um-field-label"><label for="GitHub-1597">GitHubアカウント</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$GitHub.'</div></div></div>
                        <div class="um-field um-field-skill_dev um-field-multiselect um-field-type_multiselect" data-key="skill_dev"><div class="um-field-label"><label for="skill_dev-1597">開発ソフトのスキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$devs.'</div></div></div>
                        <div class="um-field um-field-skill_design um-field-multiselect um-field-type_multiselect" data-key="skill_design"><div class="um-field-label"><label for="skill_design-1597">使えるデザイン系アプリケーション</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$designs.'</div></div></div>
                        <div class="um-field um-field-work um-field-textarea um-field-type_textarea" data-key="work"><div class="um-field-label"><label for="">プログラミング実務経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$work.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-programming">
                <form method="post" id="testform4">
                    <div class="um-field um-field-experience_programming um-field-radio um-field-type_radio" data-key="experience_programming">
                        <div class="um-field-label"><label for="experience_programming-6120">プログラミング経験<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-radio  um-field-half "><input type="radio" name="experience_programming[]" value="経験なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験なし</span></label><label class="um-field-radio um-field-half right"><input type="radio" name="experience_programming[]" value="経験あり"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">経験あり</span></label>
                            <div class="um-clear"></div>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-field um-field-programming_languages um-field-multiselect um-field-type_multiselect" data-key="programming_languages">
                        <div class="um-field-label">
                            <label for="programming_languages-6120">使えるプログラミング言語</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <select multiple="multiple" name="programming_languages[]" id="programming_languages" data-maxsize="0" data-validate="" data-key="programming_languages" class="um-form-field valid not-required um-s1 um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true">
                            '.$option_languages_html.'
                            </select>
                        </div>
                    </div>
                    '.$language_result_html.'
                    <div class="um-field um-field-framework um-field-textarea um-field-type_textarea" data-key="framework">
                        <div class="um-field-label"><label for="framework-1597">使用したことのあるフレームワーク・ライブラリ</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-framework-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="framework" id="framework" aria-hidden="true">'.$framework.'</textarea>
                            </div>
                            <p><span class="description"></span></p>
                        </div>
                    </div>
                    <div class="um-field um-field-GitHub um-field-url um-field-type_url" data-key="GitHub">
                        <div class="um-field-label"><label for="GitHub-6120">GitHubアカウント</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><input class="um-form-field valid not-required " type="text" name="GitHub-6120" id="GitHub-1597" value="'.$GitHub.'" placeholder="" data-validate="" data-key="GitHub"></div>
                    </div>
                    <div class="um-field um-field-skill_dev um-field-multiselect um-field-type_multiselect" data-key="skill_dev">
                        <div class="um-field-label"><label for="skill_dev-1597">開発ソフトのスキル</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select multiple="" name="skill_dev[]" id="skill_dev" data-maxsize="0" data-validate="" data-key="skill_dev" class="um-form-field valid not-required um-s1  um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="Unity">Unity</option><option value="Blender">Blender</option><option value="3Dプリンター">3Dプリンター</option><option value="建築CAD">建築CAD</option><option value="土木CAD">土木CAD</option><option value="機械CAD">機械CAD</option><option value="電気CAD">電気CAD</option><option value="Microsoft Office Word">Microsoft Office Word</option><option value="Microsoft Office Excel">Microsoft Office Excel</option><option value="Microsoft Office PowerPoint">Microsoft Office PowerPoint</option></select>
                        </div>
                    </div>
                    <div class="um-field um-field-skill_design um-field-multiselect um-field-type_multiselect" data-key="skill_design">
                        <div class="um-field-label"><label for="skill_design-1597">使えるデザイン系アプリケーション</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select multiple="" name="skill_design[]" id="skill_design" data-maxsize="0" data-validate="" data-key="skill_design" class="um-form-field valid not-required um-s1  um-user-keyword_0 select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="Adobe Illustrator">Adobe Illustrator</option><option value="Adobe Photoshop">Adobe Photoshop</option><option value="After Effects">After Effects</option><option value="Premire">Premire</option><option value="CINEMA 4D">CINEMA 4D</option><option value="Maya">Maya</option></select>
                        </div>
                    </div>
                    <div class="um-field um-field-work um-field-textarea um-field-type_textarea" data-key="work">
                        <div class="um-field-label"><label for="">プログラミング実務経験</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-work-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="work" id="work" aria-hidden="true">'.$work.'</textarea>
                            </div>
                            <p><span class="description"></span></p>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea4"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile"  id="skills">
                <div class="um-field-label um-info-label-skill">
                    <label class="um-field-label-text"><i class="um-field-label-skill"></i>資格・その他スキル</label>
                    <span class="um-edit-btn um-edit-btn-skill" onclick="edit_skill()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-skill">
                    <div class="um-field-value">
                      <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill"><div class="um-field-label"><label for="skill-1597">資格・その他スキル</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$skill.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-skill">
                <form method="post" id="testform5">
                    <div class="um-field um-field-skill um-field-textarea um-field-type_textarea" data-key="skill">
                        <div class="um-field-label"><label for="skill">資格・その他スキル</label><span class="um-tip um-tip-w" original-title="その他のスキルや、特にアピールしたいポイントを記入してください。"><i class="um-icon-help-circled"></i></span>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-skill-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="skill" id="skill" aria-hidden="true">'.$skill.'</textarea>
                            </div>
                            <p><span class="description">保有資格や大学で学んだ専門スキル（経済学、経営学など）を記入してみよう<br>また、これから取得見込みの資格も記入してアピールしてみよう</span></p>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea5"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile"  id="community">
                <div class="um-field-label um-info-label-community">
                    <label class="um-field-label-text"><i class="um-field-label-community"></i>コミュニティ</label>
                    <span class="um-edit-btn um-edit-btn-community" onclick="edit_community()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-community">
                    <div class="um-field-value">
                        <div class="um-field um-field-univ_community_checkbox um-field-radio um-field-type_radio" data-key="univ_community_checkbox"><div class="um-field-label"><label for="univ_community-1597">大学時代のコミュニティ</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$univ_community.'</div></div></div>
                        <div class="um-field um-field-community_univ um-field-textarea um-field-type_textarea" data-key="community_univ"><div class="um-field-label"><label for="community_univ-1597">サークル・部活・団体名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$community_univ.'</p></div></div></div>
                        <div class="um-field um-field-own_pr um-field-textarea um-field-type_textarea" data-key="own_pr"><div class="um-field-label"><label for="own_pr-1597">当コミュニティでどんなことをしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value"><p>'.$own_pr.'</p></div></div></div>
                </div>
            </div>
        </div>
        <div class="um-editor um-editor-community">
            <form method="post" id="testform6">
                <div class="um-field um-field-univ_community_checkbox um-field-radio um-field-type_radio" data-key="univ_community_checkbox">
                    <div class="um-field-label"><label for="univ_community_checkbox">大学時代のコミュニティ<span class="um-req" title="必須">*</span></label>
                        <div class="um-clear"></div>
                    </div>
                    '.$univ_community_edit_html.'
                </div>
                    <div class="um-field um-field-community_univ um-field-textarea um-field-type_textarea" data-key="community_univ">
                        <div class="um-field-label"><label for="community_univ">サークル・部活・団体名</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-community_univ-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="community_univ" id="community_univ" aria-hidden="true">'.$community_univ.'</textarea>
                            </div>
                            <p><span class="description"></span></p>
                        </div>
                    </div>
                    <div class="um-field um-field-own_pr um-field-textarea um-field-type_textarea" data-key="own_pr">
                        <div class="um-field-label"><label for="own_pr">当コミュニティでどんなことをしたか？</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-own_pr-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="own_pr" id="own_pr" aria-hidden="true">'.$own_pr.'</textarea>
                            </div>
                            <p><span class="description">自分の役職だけでなく、その経験を通して何を学んだのか書いてみよう<br>また、解決した問題や成功させてイベントなどあったら成果も書こう！</span></p>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
            </form>
        </div>
        <div class="result_area" id="resultarea6"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile" id="intern">
                <div class="um-field-label um-info-label-internship">
                    <label class="um-field-label-text"><i class="um-field-label-internship"></i>長期インターン</label>
                    <span class="um-edit-btn um-edit-btn-internship" onclick="edit_internship()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-internship">
                    <div class="um-field-value">
                        <div class="um-field um-field-internship_experiences um-field-radio um-field-type_radio" data-key="internship_experiences"><div class="um-field-label"><label for="internship_experiences-1597">長期インターン経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_experiences.'</div></div></div>
                        <div class="um-field um-field-internship_company um-field-textarea um-field-type_textarea" data-key="internship_company"><div class="um-field-label"><label for="internship_company-1597">長期インターン経験先企業名</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$internship_company.'</div></div></div>
                        <div class="um-field um-field-experience_internship um-field-textarea um-field-type_textarea" data-key="experience_internship"><div class="um-field-label"><label for="experience_internship-1597">長期インターン先でどんな経験をしたか？</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$experience_internship.'</div></div></div>
                        <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR"><div class="um-field-label"><label for="self_internship_PR-1597">その他自己PR</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$self_internship_PR.'</div></div></div>
                        <div class="um-field um-field-degree_of_internship_interest um-field-select um-field-type_select" data-key="degree_of_internship_interest"><div class="um-field-label"><label for="degree_of_internship_interest-1597">長期有給インターンへの興味の度合い</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$degree_of_internship_interest.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-internship">
                <form method="post" id="testform7">
                    <div class="um-field um-field-internship_experiences um-field-radio um-field-type_radio" data-key="internship_experiences">
                        <div class="um-field-label"><label for="internship_experiences">長期インターン経験<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="なし"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">なし</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="1ヶ月以上3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">1ヶ月以上3ヶ月未満</span></label>
                            <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="3ヶ月以上6ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">3ヶ月以上6ヶ月未満</span></label><label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="6ヶ月以上1年未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">6ヶ月以上1年未満</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="1年以上"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off"></i></span><span class="um-field-radio-option">1年以上</span></label></p>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-field um-field-internship_company um-field-textarea um-field-type_textarea" data-key="internship_company">
                        <div class="um-field-label"><label for="internship_company">長期インターン経験先企業名</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-internship_company-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 50px; overflow: auto;" autocomplete="off" cols="40" name="internship_company" id="internship_company" aria-hidden="true">'.$internship_company.'</textarea>
                            </div>
                            <p><span class="description"></span></p>
                        </div>
                    </div>
                    <div class="um-field um-field-experience_internship um-field-textarea um-field-type_textarea" data-key="experience_internship">
                        <div class="um-field-label"><label for="experience_internship">長期インターン先でどんな経験をしたか？</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-experience_internship-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="experience_internship" id="experience_internship" aria-hidden="true">'.$experience_internship.'</textarea>
                            </div>
                            <p><span class="description">自分に任せられた仕事だけでなく、その当時の課題からどのように解決したかまでの過程と成果を具体的に書いてみよう！</span></p>
                        </div>
                    </div>
                    <div class="um-field um-field-self_internship_PR um-field-textarea um-field-type_textarea" data-key="self_internship_PR">
                        <div class="um-field-label"><label for="self_internship_PR">その他自己PR</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area">
                            <div id="wp-self_internship_PR-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                                <textarea class="um-form-field valid not-required  wp-editor-area" style="height: 100px; overflow: auto;" autocomplete="off" cols="40" name="self_internship_PR" id="self_internship_PR" aria-hidden="true">'.$self_internship_PR.'</textarea>
                            </div>
                            <p><span class="description">自分の強みだけでなく具体的なエピソードを添えて書いてみよう！</span></p>
                        </div>
                    </div>
                    <div class="um-field um-field-degree_of_internship_interest um-field-select um-field-type_select" data-key="degree_of_internship_interest">
                        <div class="um-field-label"><label for="degree_of_internship_interest">長期有給インターンへの興味の度合い<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select data-default="" name="degree_of_internship_interest" id="degree_of_internship_interest" data-validate="" data-key="degree_of_internship_interest" class="um-form-field valid um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="今すぐにでも長期インターンをやってみたい">今すぐにでも長期インターンをやってみたい</option><option value="話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい">話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい</option><option value="全く興味がない">全く興味がない</option></select>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea7"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile"  id="interest">
                <div class="um-field-label um-info-label-interest">
                    <label class="um-field-label-text"><i class="um-field-label-interest"></i>興味・関心</label>
                    <span class="um-edit-btn um-edit-btn-interest" onclick="edit_interest()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-interest">
                    <div class="um-field-value">
                        <div class="um-field um-field-bussiness_type um-field-checkbox um-field-type_checkbox" data-key="bussiness_type"><div class="um-field-label"><label for="bussiness_type-1597">興味のある業界</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$types.'</div></div></div>
                        <div class="um-field um-field-future_occupations um-field-checkbox um-field-type_checkbox" data-key="future_occupations"><div class="um-field-label"><label for="future_occupations-1597">職種</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$occupations.'</div></div></div>
                        <div class="um-field um-field-will_venture um-field-select um-field-type_select" data-key="will_venture"><div class="um-field-label"><label for="will_venture-1597">ベンチャーへの就職意欲</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$will_venture.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-interest">
                <form method="post" id="testform8">
                    <div class="um-field um-field-bussiness_type um-field-checkbox um-field-type_checkbox" data-key="bussiness_type">
                        <div class="um-field-label"><label for="bussiness_type">興味のある業界<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="メーカー"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">メーカー</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="メディア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">メディア</span></label>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="金融"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">金融</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="広告"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">広告</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="商社"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">商社</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="人材"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">人材</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="教育"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">教育</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="不動産"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">不動産</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="官公庁"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">官公庁</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="IT"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">IT</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="VC/起業支援"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">VC/起業支援</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="ゲーム"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ゲーム</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="コンサルティング"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">コンサルティング</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="ファッション/アパレル"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ファッション/アパレル</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="ブライダル"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ブライダル</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="旅行・観光"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">旅行・観光</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="医療・福祉"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">医療・福祉</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="小売・流通"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">小売・流通</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="未定"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">未定</span></label></p>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-field um-field-future_occupations um-field-checkbox um-field-type_checkbox" data-key="future_occupations">
                        <div class="um-field-label"><label for="future_occupations">職種<span class="um-req" title="必須">*</span></label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="エンジニア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">エンジニア</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="デザイナー"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">デザイナー</span></label>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="ディレクター"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ディレクター</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="マーケティング"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">マーケティング</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="ライター"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ライター</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="営業"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">営業</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="事務/コーポレート・スタッフ"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">事務/コーポレート・スタッフ</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="総務・人事・経理"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">総務・人事・経理</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="企画"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">企画</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="コンサル"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">コンサル</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="その他"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">その他</span></label></p>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-field um-field-will_venture um-field-select um-field-type_select" data-key="will_venture">
                        <div class="um-field-label"><label for="will_venture">ベンチャーへの就職意欲</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><select data-default="" name="will_venture" id="will_venture" data-validate="" data-key="will_venture" class="um-form-field valid not-required um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true"><option value="ファーストキャリアはベンチャー企業が良いと思っている">ファーストキャリアはベンチャー企業が良いと思っている</option><option value="自分に合ったベンチャー企業ならば就職してみたい">自分に合ったベンチャー企業ならば就職してみたい</option><option value="ベンチャー企業に少しは興味がある">ベンチャー企業に少しは興味がある</option><option value="ベンチャー企業には全く興味がない">ベンチャー企業には全く興味がない</option></select>
                        </div>
                        <div class="um-editor-btn">
                            <input type="submit" value="更新" class="um-editor-update2">
                            <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea8"></div>
        </div>
        <div class="um-info">
            <div class="um-field um-field-profile" id="experience">
                <div class="um-field-label um-info-label-experience">
                    <label class="um-field-label-text"><i class="um-field-label-experience"></i>学生時代の経験</label>
                    <span class="um-edit-btn um-edit-btn-experience" onclick="edit_experience()">編集</span>
                    <div class="um-clear"></div>
                </div>
                <div class="um-field-area um-field-area-experience">
                    <div class="um-field-value">
                        <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience"><div class="um-field-label"><label for="student_experience-1597">学生時代の経験</label><div class="um-clear"></div></div><div class="um-field-area"><div class="um-field-value">'.$exps.'</div></div></div>
                    </div>
                </div>
            </div>
            <div class="um-editor um-editor-experience">
                <form method="post" id="testform9">
                    <div class="um-field um-field-student_experience um-field-checkbox um-field-type_checkbox" data-key="student_experience">
                        <div class="um-field-label"><label for="student_experience">学生時代の経験</label>
                            <div class="um-clear"></div>
                        </div>
                        <div class="um-field-area"><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="起業経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">起業経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="体育会キャプテン"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">体育会キャプテン</span></label>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="サークル代表経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">サークル代表経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="学生団体代表経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">学生団体代表経験</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="サークル/学生団体創設経験"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">サークル/学生団体創設経験</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ボランティア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ボランティア</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="海外ボランティア"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">海外ボランティア</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ビジコン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ビジコン出場</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="ハッカソン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ハッカソン出場</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="ミスコン出場"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">ミスコン出場</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="東大TLPに選ばれた"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">東大TLPに選ばれた</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="東大推薦入試合格"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">東大推薦入試合格</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="首席をとった"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">首席をとった</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="未踏クリエーターに選抜された"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">未踏クリエーターに選抜された</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="0から1をつくりあげた"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">0から1をつくりあげた</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="何かで１番になった"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">何かで１番になった</span></label></p>
                            <div class="um-clear"></div><p><label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="高校時代に生徒会経験あり"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">高校時代に生徒会経験あり</span></label><label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="中高大の部活経験で全国大会出場経験あり"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">中高大の部活経験で全国大会出場経験あり</span></label></p>
                            <div class="um-clear"></div>
                        </div>
                    </div>
                    <div class="um-editor-btn">
                        <input type="submit" value="更新" class="um-editor-update2">
                        <span onclick="cancel()" class="um-editor-cancel">キャンセル</span>
                    </div>
                </form>
            </div>
            <div class="result_area" id="resultarea9"></div>
        </div>
    </div>
    ';

    if ($gender == '男性') {
    $html = str_replace('<label class="um-field-radio um-field-half "><input type="radio" name="gender[]" value="男性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half "><input type="radio" name="gender[]" value="男性" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    }
    if ($gender == '女性') {
    $html = str_replace('><label class="um-field-radio  um-field-half right"><input type="radio" name="gender[]" value="女性"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','><label class="um-field-radio active um-field-half right"><input type="radio" name="gender[]" value="女性" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    }
    if(isset($faculty_lineage)) {
    $html = str_replace('value="'.$faculty_lineage.'"','value="'.$faculty_lineage.'" selected=""',$html);
    }
    if(isset($graduate_year)) {
    $html = str_replace('value="'.$graduate_year.'"','value="'.$graduate_year.'" selected=""',$html);
    }
    if(isset($studied_abroad)) {
    $html = str_replace('<label class="um-field-radio um-field-half "><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    $html = str_replace('<label class="um-field-radio um-field-half right"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="studied_abroad[]" value="'.$studied_abroad.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    
    '<label class="um-field-radio  um-field-half right"><input type="radio" name="studied_abroad[]" value="3ヶ月未満"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">';
    }
    if(isset($experience_programming)) {
    $html = str_replace('<label class="um-field-radio  um-field-half "><input type="radio" name="experience_programming[]" value="'.$experience_programming.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half "><input type="radio" name="experience_programming[]" value="'.$experience_programming.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    $html = str_replace('<label class="um-field-radio um-field-half right"><input type="radio" name="experience_programming[]" value="'.$experience_programming.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="experience_programming[]" value="'.$experience_programming.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    }
    if(isset($programming_languages)) {
    foreach($programming_languages as $language) {
    $html = str_replace('<option value="'.$language.'">','<option value="'.$language.'" selected="">',$html); 
    }
    }
    if(isset($skill_dev)) {
    foreach($skill_dev as $dev){
        $html = str_replace('<option value="'.$dev.'">','<option value="'.$dev.'" selected="">',$html);
    }
    }
    if(isset($skill_design)) {
    foreach($skill_design as $design){
        $html = str_replace('<option value="'.$design.'">','<option value="'.$design.'" selected="">',$html);
    }
    }
    if(isset($internship_experiences)) {
    $html =str_replace('<label class="um-field-radio  um-field-half"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    $html = str_replace('<label class="um-field-radio  um-field-half right"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'"><span class="um-field-radio-state"><i class="um-icon-android-radio-button-off">','<label class="um-field-radio active um-field-half right"><input type="radio" name="internship_experiences[]" value="'.$internship_experiences.'" checked=""><span class="um-field-radio-state"><i class="um-icon-android-radio-button-on">',$html);
    }
    if(isset($degree_of_internship_interest)) {
    $html = str_replace('<option value="'.$degree_of_internship_interest.'">','<option value="'.$degree_of_internship_interest.'" selected="">',$html);
    }
    if(isset($bussiness_type)) {
        foreach($bussiness_type as $type) {
    $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="bussiness_type[]" value="'.$type.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="bussiness_type[]" value="'.$type.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="bussiness_type[]" value="'.$type.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="bussiness_type[]" value="'.$type.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    }
    }
    if(isset($future_occupations)) {
        foreach($future_occupations as $occupation) {
    $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="future_occupations[]" value="'.$occupation.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="future_occupations[]" value="'.$occupation.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="future_occupations[]" value="'.$occupation.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="future_occupations[]" value="'.$occupation.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    }
    }
    if(isset($will_venture)) {
    $html = str_replace('<option value="'.$will_venture.'">','<option value="'.$will_venture.'" selected="">',$html);
    }
    if(isset($student_experience)) {
    foreach($student_experience as $exp) {
        $html = str_replace('<label class="um-field-checkbox  um-field-half "><input type="checkbox" name="student_experience[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="student_experience[]" value="'.$exp.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    $html = str_replace('<label class="um-field-checkbox  um-field-half right"><input type="checkbox" name="student_experience[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="student_experience[]" value="'.$exp.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$html);
    }
    }

    foreach( $programming_lang_lv_array as $programming_lang_name => $programming_lang_lv){
        if(isset($_POST[$programming_lang_lv])){
            $programming_lang_lv_skill = $_POST[$programming_lang_lv];
            update_user_meta( $user_id, $programming_lang_lv, $programming_lang_lv_skill);
        }
        $programming_lang_lv_skill = get_user_meta($user_id,$programming_lang_lv,false)[0];
        if(($programming_lang_lv_skill)>0 and in_array($programming_lang_name, $programming_languages)) {
            $html = str_replace('<option value="'.$programming_lang_name.'">','<option value="'.$programming_lang_name.'" selected="">',$html);
            $html = str_replace('data-key="'.$programming_lang_lv.'" style="display:none;"', 'data-key="'.$programming_lang_lv.'" style="display:block;"',$html);
        }
    }
    $html = str_replace('<li class="select2-selection__choice" title=""><span class="select2-selection__choice__remove" role="presentation">×</span></li>','',$html);
    $login_user = wp_get_current_user();
    $login_user_id = $login_user->data->ID;
    $edits = ['base','univ','abroad','programming','skill','community','internship','interest','experience'];
    if($login_user_id != $user_id){
    foreach($edits as $edit){
    $html = str_replace('<span class="um-edit-btn um-edit-btn-'.$edit.'" onclick="edit_'.$edit.'()">編集</span>','',$html);
    }
    }
    return do_shortcode($html);
}
add_shortcode('new_mypage','new_mypage_func');

//プロフィール写真の更新
function regist_file_up() {
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
    }
    $home_url =esc_url( home_url( ));
    $user_info = get_userdata($user_id);
    $user_name = $user_info->user_login;
    if (!empty($_FILES["upfilename"])){
    if (is_uploaded_file($_FILES["upfilename"]["tmp_name"])) {
	    $chk = chk_ext($_FILES["upfilename"]["name"],$allow_exts=array( "png", "jpeg", "jpg","heic" ));
	    if($chk == false){
		  $alert = "<script type='text/javascript'>console('拡張子が異なります');</script>";
		  header('Location: '.$home_url.'/user?um_user='.$user_name);
    	  die();
		}
	    $size = size_ext($_FILES["upfilename"]["size"]);
	    if($size == false){
            $image = wp_get_image_editor($_FILES["upfilename"]["tmp_name"]);
            $image->resize( 150, 150, true );
            $upload_dir = wp_upload_dir();
            $upload_file_name_kari = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'kari.png';
            $image->save($upload_file_name_kari);
            $size_re = size_ext(filesize($upload_file_name_kari));
            if($size_re == false){
                header('Location: '.$home_url.'/user?um_user='.$user_name);
                die();
            }
        else{
			$upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
			$image->save($upload_file_name);
			if(file_exists($upload_file_name_kari)){
			  unlink($upload_file_name_kari);
			}
			if (! is_wp_error($image)) {
				$exif = exif_read_data($upload_file_name);
				$orientation = $exif['Orientation'];
				if (! empty($orientation)) {
					switch ($orientation) {
						case 8:
							$image->rotate(90);
							break;
						case 3:
							$image->rotate(180);
							break;
						case 6:
							$image->rotate(-90);
							break;
					}
					$image->save($upload_file_name);
				}
			}
		  }
		  header('Location: '.$home_url.'/user?um_user='.$user_name);
		  die();
		}
        $upload_dir = wp_upload_dir();
		$upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
	    if(file_exists($upload_file_name)){
			unlink($upload_file_name);
		}
        if (move_uploaded_file($_FILES["upfilename"]["tmp_name"], $upload_file_name)) {
            chmod($upload_file_name, 0777);
		    $image = wp_get_image_editor($upload_file_name);
			if (! is_wp_error($image)) {
				$exif = exif_read_data($upload_file_name);
				$orientation = $exif['Orientation'];
				if (! empty($orientation)) {
					switch ($orientation) {
						case 8:
							$image->rotate(90);
							break;
						case 3:
							$image->rotate(180);
							break;
						case 6:
							$image->rotate(-90);
							break;
					}
					$image->save($upload_file_name);
				}
			}
        }
    }
    header('Location: '.$home_url.'/user?um_user='.$user_name);
    die();
	}
}
//add_shortcode('regist_file_up','regist_file_up');
add_action('template_redirect', 'regist_file_up');


//カバー写真の更新
function regist_cover_up() {
    if(isset($_POST['user_id'])){
        $user_id = $_POST['user_id'];
   }
    $home_url =esc_url( home_url( ));
	$user_info = get_userdata($user_id);
    $user_name = $user_info->user_login;
    if (!empty($_FILES["upcovername"])){
    if (is_uploaded_file($_FILES["upcovername"]["tmp_name"])) {
	    $chk = chk_ext($_FILES["upcovername"]["name"],$allow_exts=array( "png", "jpeg", "jpg","heic" ));
	    if($chk == false){
		  header('Location: '.$home_url.'/user?um_user='.$user_name);
    	  die();
		}
	    $size = size_ext($_FILES["upcovername"]["size"]);
	    if($size == false){
		   $image = wp_get_image_editor($_FILES["upcovername"]["tmp_name"]);
		  $image->resize( 400, 150, true );
		  $upload_dir = wp_upload_dir();
		  $upload_file_name_kari = $upload_dir['basedir'] . "/" .'cover_photo'.$user_id.'kari.png';
		  $image->save($upload_file_name_kari);
		  $size_re = size_ext(filesize($upload_file_name_kari));
		  if($size_re == false){
			header('Location: '.$home_url.'/user?um_user='.$user_name);
			die();
		  }
		  else{
			$upload_file_name = $upload_dir['basedir'] . "/" .'cover_photo'.$user_id.'.png';
			$image->save($upload_file_name);
			if(file_exists($upload_file_name_kari)){
			  unlink($upload_file_name_kari);
			}
			if (! is_wp_error($image)) {
				$exif = exif_read_data($upload_file_name);
				$orientation = $exif['Orientation'];
				if (! empty($orientation)) {
					switch ($orientation) {
						case 8:
							$image->rotate(90);
							break;
						case 3:
							$image->rotate(180);
							break;
						case 6:
							$image->rotate(-90);
							break;
					}
					$image->save($upload_file_name);
				}
			}
		  }
		  header('Location: '.$home_url.'/user?um_user='.$user_name);
		  die();
		}
        $upload_dir = wp_upload_dir();
		$upload_file_name = $upload_dir['basedir'] . "/" .'cover_photo'.$user_id.'.png';
	    if(file_exists($upload_file_name)){
			unlink($upload_file_name);
		}
        if (move_uploaded_file($_FILES["upcovername"]["tmp_name"], $upload_file_name)) {
            chmod($upload_file_name, 0777);
		    $image = wp_get_image_editor($upload_file_name);
			if (! is_wp_error($image)) {
				$exif = exif_read_data($upload_file_name);
				$orientation = $exif['Orientation'];
				if (! empty($orientation)) {
					switch ($orientation) {
						case 8:
							$image->rotate(90);
							break;
						case 3:
							$image->rotate(180);
							break;
						case 6:
							$image->rotate(-90);
							break;
					}
					$image->save($upload_file_name);
				}
			}
        }
	}
	header('Location: '.$home_url.'/user?um_user='.$user_name);
    die();
    }
}
add_action('template_redirect', 'regist_cover_up');;

//拡張子のチェック
function chk_ext( $chk_name, $allow_exts=array( "png", "jpeg", "jpg","heic" ) ) {
        //使用出来ない拡張子のチェック
        $ext_err = true;//エラーフラグは初期値 真
        $exts = preg_split( "/[.]/", $chk_name );// ファイル名を.で分割する。
        if( count( $exts ) < 2 ) return false;
        $ext = $exts[ count( $exts ) - 1 ];//.で分割した最後のブロックの文字列を取得する
        foreach(  $allow_exts as $val ) {
            if( !empty( $val ) ) {
                //$len = strlen( $val );
                //if( strncasecmp( strtoupper($val), strtoupper($ext), $len ) == 0 ) {
                if( strcasecmp( $val, $ext ) == 0 ) { //修正しました(2016/03/23/01:22)
                    $ext_err = false;//エラーフラグ 偽に変更
                    break;
                }
            }
        }
        $ret = !$ext_err;//戻り値はエラーフラグを反転
        return $ret;
    }

//サイズの大きさのチェック
function size_ext($image_size){
	$MAXSIZE = 2097152;
    $size_err = true;
    if( ( $image_size > 0 )  && ( $image_size < $MAXSIZE ) ) {
        //サイズがOKな場合の処理
	    $size_err = false;
	}
    $ret = !$size_err;
    return $ret;
}

function get_univ_community_edit_html($user_id){
    $univ_community_array = array('文化系サークル','スポーツ系サークル','体育会系部活','文化系部活','学生団体');
    $univ_community_checkbox = get_user_meta($user_id,'univ_community_checkbox',false)[0];
    $univ_community_edit_html = '<div class="um-field-area">';
    foreach($univ_community_array as $key => $univ_community_each){
        if(($key+1) %2 == 0){
            $univ_community_edit_html .= '<label class="um-field-checkbox um-field-half right"><input type="checkbox" name="univ_community_checkbox[]" value="'.$univ_community_each.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">'.$univ_community_each.'</span></label>';
            $univ_community_edit_html .= '<div class="um-clear"></div>';
        } else {
            $univ_community_edit_html .= '<label class="um-field-checkbox um-field-half"><input type="checkbox" name="univ_community_checkbox[]" value="'.$univ_community_each.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank"></i></span><span class="um-field-checkbox-option">'.$univ_community_each.'</span></label>';
        }
        if($key == (count($univ_community_array)-1)){
            $univ_community_edit_html .= '<div class="um-clear"></div>';
        }
    }
    $univ_community_edit_html .= '</div>';
    if(isset($univ_community_checkbox)) {
        foreach($univ_community_checkbox as $exp) {
            $univ_community_edit_html = str_replace('<label class="um-field-checkbox um-field-half"><input type="checkbox" name="univ_community_checkbox[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half "><input type="checkbox" name="univ_community_checkbox[]" value="'.$exp.'" checked><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$univ_community_edit_html);
            $univ_community_edit_html = str_replace('<label class="um-field-checkbox um-field-half right"><input type="checkbox" name="univ_community_checkbox[]" value="'.$exp.'"><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline-blank">','<label class="um-field-checkbox active um-field-half right"><input type="checkbox" name="univ_community_checkbox[]" value="'.$exp.'" checked=""><span class="um-field-checkbox-state"><i class="um-icon-android-checkbox-outline">',$univ_community_edit_html);
        }
    }
    return $univ_community_edit_html;
}

function profilepage(){
    if ( is_user_logged_in() ) {
        //echo 'Welcome, registered user!';
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $user_info = get_userdata($user_id);
        $user_name = $user_info->user_login;
        if(!in_array("company", $user_roles)){
            header('Location: https://jobshot.jp/user?um_user='.$user_name);
            exit;
        }else{
            header('Location: https://jobshot.jp/');
            exit;
        }
    }
}
add_shortcode('profilepage','profilepage');

?>