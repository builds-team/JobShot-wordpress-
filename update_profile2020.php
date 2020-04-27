<?php
    function all_student_id(){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_key'     => '',
            'meta_value'   => '',
            'meta_compare' => '',
            'meta_query'   => '',
            'date_query'   => array(),
            'include'      => array(),
            'exclude'      => array(),
            'search_columns' => array(),
            'count_total'  => true,
            'fields'       => 'all',
            'who'          => ''
        );
        $students=new WP_User_Query( $args );
        $count = 0;
        $user_ids = array();
        if ( $students->get_results())foreach( $students->get_results() as $user )  {
            $user_id = $user->data->ID;
            update_user_meta( $user_id, 'profile_update_2020', 0);
        }
    }

    //profile_update_2020で0かつ卒業年度が20or21の人(登録日が2020/3以下の人)はリダイレクトされるようにする
    function redirect_login_front_page() {
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $register_day = $user->data->user_registered;
        $register_day = strtotime($register_day);
        $update_day = strtotime("2020-04-01 00:00:00");
        $updated_profile = get_user_meta($user_id, 'profile_update_2020',false)[0];
        $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        if(current_user_can('student') && $updated_profile == 0 && $register_day < $update_day){
            if($graduate_year == 2020 || $graduate_year == 2021){
                $home_url = esc_url( home_url( ));
                wp_safe_redirect($home_url.'/profile_update');
                exit();
            }
        }

    }
    add_action('wp_login', 'redirect_login_front_page');

    function update_profile2020(){
        $user = wp_get_current_user();
        $user_id = $user->data->ID;
        $university = get_user_meta($user_id,'university',false)[0];
        $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];
        $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];
        $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        $seminar = get_user_meta($user_id,'seminar',false)[0];
        update_user_meta( $user_id, 'profile_update_2020', 1);
        $html = '
        <h3 class="widget-title">プロフィール更新のお願い</h3>
        <div class="um-editor um-editor-univ">
            <p>学年更新時期になりましたので、変更がある場合には以下のプロフィールの更新をお願いいたします。</p>
            <form method="post" id="testform10">
                <div class="um-field um-field-university um-field-text um-field-type_text" data-key="university">
                    <div class="um-field-label"><label for="university-1597">大学<span class="um-req" title="必須">*</span></label>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="university-6120" id="university-6120" value="'.$university.'" placeholder="" data-validate="" data-key="university" required></div>
                </div>
                <div class="um-field um-field-faculty_lineage um-field-select um-field-type_select" data-key="faculty_lineage">
                    <div class="um-field-label"><label for="faculty_lineage-6120">学部系統<span class="um-req" title="必須">*</span></label>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-field-area"><select data-default="" name="faculty_lineage" id="faculty_lineage" data-validate="" data-key="faculty_lineage" class="um-form-field valid um-s1  select2-hidden-accessible" style="width: 100%; display: block;" data-placeholder="" tabindex="-1" aria-hidden="true" required><option value="文・人文">文・人文</option><option value="社会・国際">社会・国際</option><option value="法・政治">法・政治</option><option value="経済・経営・商">経済・経営・商</option><option value="教育">教育</option><option value="理">理</option><option value="工">工</option><option value="農">農</option><option value="医・歯・薬・保健">医・歯・薬・保健</option><option value="生活科学">生活科学</option><option value="芸術">芸術</option><option value="スポーツ科学">スポーツ科学</option><option value="総合・環境・情報・人間">総合・環境・情報・人間</option></select>
                    </div>
                </div>
                <div class="um-field um-field-faculty_department um-field-text um-field-type_text" data-key="faculty_department">
                    <div class="um-field-label"><label for="faculty_department-1597">学部・学科<span class="um-req" title="必須">*</span></label>
                        <div class="um-clear"></div>
                    </div>
                    <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="faculty_department-6120" id="faculty_department-6120" value="'.$faculty_department.'" placeholder="" data-validate="" data-key="faculty_department" required></div>
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
                    <div class="um-field-area"><input autocomplete="off" class="um-form-field valid " type="text" name="seminar-6120" id="seminar-6120" value="'.$seminar.'" placeholder="" data-validate="" data-key="seminar" required></div>
                </div>
                <div class="um-editor-btn">
                    <input type="submit" value="更新" class="um-editor-update2">
                </div>
            </form>
        </div>
		   <div class="result_area" id="resultarea10"></div>';

        if(isset($faculty_lineage)) {
            $html = str_replace('value="'.$faculty_lineage.'"','value="'.$faculty_lineage.'" selected=""',$html);
            }
            if(isset($graduate_year)) {
            $html = str_replace('value="'.$graduate_year.'"','value="'.$graduate_year.'" selected=""',$html);
            }
	  return $html;
    }

add_shortcode('update_profile2020', 'update_profile2020');
?>