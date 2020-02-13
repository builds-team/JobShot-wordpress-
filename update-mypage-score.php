<?php

// 基本情報を更新した時にスコアを更新する関数
function update_user_base_profile_score($user_id){
    $user_score_array = array(
        "都道府県"  =>  "region",
        "性別"  =>  "gender",
        "出身高校"  =>  "highschool",
    );
    $region  = get_user_meta($user_id,'region',false)[0];
    $highschool = get_user_meta($user_id,'highschool')[0];
    $gender = get_user_meta($user_id,'gender',false)[0][0];
    $user_base_profile_score = 0;
    if($region){
        $user_base_profile_score += 2;
    }
    if($highschool){
        $user_base_profile_score += 2;
    }
    if($gender){
        $user_base_profile_score += 2;
    }
    update_user_meta( $user_id, 'user_base_profile_score', $user_base_profile_score);
}
// 学歴情報を更新した時にスコアを更新する関数
function update_user_univ_profile_score($user_id){
    $user_score_array = array(
        "大学"  =>  "university",
        "学部系統"  =>  "faculty_lineage",
        "学部・学科"  =>  "faculty_department",
        "卒業年"  =>  "graduate_year",
        "ゼミ"  =>  "seminar",
    );
    $university = get_user_meta($user_id,'university',false)[0];
    $faculty_lineage = get_user_meta($user_id,'faculty_lineage',false)[0];
    $faculty_department = get_user_meta($user_id,'faculty_department',false)[0];
    $graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
    $seminar = get_user_meta($user_id,'seminar',false)[0];
    $user_univ_profile_score = 0;
    if($university){
        $user_univ_profile_score += 2;
    }
    if($faculty_lineage){
        $user_univ_profile_score += 2;
    }
    if($faculty_department){
        $user_univ_profile_score += 2;
    }
    if($graduate_year){
        $user_univ_profile_score += 2;
    }
    if($seminar){
        $user_univ_profile_score += 2;
    }
    update_user_meta( $user_id, 'user_univ_profile_score', $user_univ_profile_score);
}
// 留学情報を更新した時にスコアを更新する関数
function update_user_abroad_profile_score($user_id){
    $user_score_array = array(
        "留学経験"  =>  "studied_abroad",
        "留学先"  =>  "studied_ab_place",
        "その他"  =>  "lang_pr",
    );
    $studied_abroad = get_user_meta($user_id,'studied_abroad',false)[0][0];
    $studied_ab_place = get_user_meta($user_id,'studied_ab_place',false)[0];
    $lang_pr = get_user_meta($user_id,'lang_pr',false)[0];
    $user_abroad_profile_score = 0;
    if($studied_abroad){
        $user_abroad_profile_score += 2;
    }
    if($studied_ab_place){
        $user_abroad_profile_score += 3;
    }
    if($lang_pr){
        $user_abroad_profile_score += 2;
    }
    update_user_meta( $user_id, 'user_abroad_profile_score', $user_abroad_profile_score);
}
// プログラミング情報を更新した時にスコアを更新する関数
function update_user_programming_profile_score($user_id){
    $user_score_array = array(
        "プログラミング経験"    =>  "experience_programming",
        "使えるプログラミング言語"  =>  "programming_languages",
        "使用したことのあるフレームワーク・ライブラリ"  =>  "framework",
        "GitHubアカウント"  =>  "GitHub",
        "開発ソフトのスキル"  =>  "skill_dev",
        "使えるデザイン系アプリケーション"  =>  "skill_design",
        "プログラミング実務経験"  =>  "work",
    );
    $experience_programming = get_user_meta($user_id,'experience_programming',false)[0][0];
    $programming_languages = get_user_meta($user_id,'programming_languages',false)[0];
    $framework = get_user_meta($user_id,'framework',false)[0];
    $GitHub = get_user_meta($user_id,'GitHub',false)[0];
    $skill_dev = get_user_meta($user_id,'skill_dev',false)[0];
    $skill_design = get_user_meta($user_id,'skill_design',false)[0];
    $work = get_user_meta($user_id,'work',false)[0];
    $user_programming_profile_score = 0;
    if($experience_programming){
        $user_programming_profile_score += 2;
    }
    if($programming_languages){
        $user_programming_profile_score += 2;
    }
    if($framework){
        $user_programming_profile_score += 1;
    }
    if($GitHub){
        $user_programming_profile_score += 3;
    }
    if($skill_dev){
        $user_programming_profile_score += 1;
    }
    if($skill_design){
        $user_programming_profile_score += 1;
    }
    if($work){
        // 300文字以上→4,200:3,100:2,書いたら1
        $work_length = mb_strlen($work);
        if($work_length >= 300){
            $user_programming_profile_score += 4;
        }elseif($work_length >= 200 and $work_length < 300){
            $user_programming_profile_score += 3;
        }elseif($work_length >= 100 and $work_length < 200){
            $user_programming_profile_score += 2;
        }else{
            $user_programming_profile_score += 1;
        }
    }
    update_user_meta( $user_id, 'user_programming_profile_score', $user_programming_profile_score);
}
// 資格・その他スキル情報を更新した時にスコアを更新する関数
function update_user_skill_profile_score($user_id){
    $user_score_array = array(
        "資格・その他スキル"  =>  "skill",
    );
    $skill = get_user_meta($user_id,'skill',false)[0];
    $user_skill_profile_score = 0;
    if($skill){
        $skill_length = mb_strlen($skill);
        if($skill_length >= 200){
            $user_skill_profile_score += 3;
        }elseif($skill_length >= 100 and $skill_length < 200){
            $user_skill_profile_score += 2;
        }else{
            $user_skill_profile_score += 1;
        }
    }
    update_user_meta( $user_id, 'user_skill_profile_score', $user_skill_profile_score);
}
// コミュニティ情報を更新した時にスコアを更新する関数
function update_user_community_profile_score($user_id){
    $user_score_array = array(
        "大学時代のコミュニティ"  =>  "univ_community_checkbox",
        "サークル・部活・団体名"  =>  "community_univ",
        "当コミュニティでどんなことをしたか？"  =>  "own_pr",
    );
    $univ_community_checkbox = get_user_meta($user_id,'univ_community_checkbox',false)[0];
    $community_univ = get_user_meta($user_id,'community_univ',false)[0];
    $own_pr = get_user_meta($user_id,'own_pr',false)[0];
    $user_community_profile_score = 0;
    if($univ_community_checkbox){
        $user_community_profile_score += 2;
    }
    if($community_univ){
        $user_community_profile_score += 2;
    }
    if($own_pr){
        $own_pr_length = mb_strlen($own_pr);
        if($own_pr_length >= 400){
            $user_community_profile_score += 4;
        }elseif($own_pr_length >= 250 and $own_pr_length < 400){
            $user_community_profile_score += 3;
        }elseif($own_pr_length >= 100 and $own_pr_length < 250){
            $user_community_profile_score += 2;
        }else{
            $user_community_profile_score += 1;
        }
    }
    update_user_meta( $user_id, 'user_community_profile_score', $user_community_profile_score);
}

// 長期インターン情報を更新した時にスコアを更新する関数
function update_user_internship_profile_score($user_id){
    $user_score_array = array(
        "長期インターン経験"  =>  "internship_experiences",
        "長期インターン経験先企業名"  =>  "internship_company",
        "長期インターン先でどんな経験をしたか？"  =>  "experience_internship",
        "自己PR"  =>  "self_internship_PR",
        "長期有給インターンへの興味の度合い"  =>  "degree_of_internship_interest",
    );
    $internship_experiences = get_user_meta($user_id,'internship_experiences',false)[0][0];
    $internship_company = get_user_meta($user_id,'internship_company',false)[0];
    $experience_internship = get_user_meta($user_id,'experience_internship',false)[0];
    $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
    $degree_of_internship_interest = get_user_meta($user_id,'degree_of_internship_interest',false)[0];
    $user_internship_profile_score = 0;
    if($internship_experiences){
        $user_internship_profile_score += 3;
    }
    if($internship_company){
        $user_internship_profile_score += 3;
    }
    if($experience_internship){
        $length = mb_strlen($experience_internship);
        if($length >= 400){
            $user_internship_profile_score += 4;
        }elseif($length >= 250 and $length < 400){
            $user_internship_profile_score += 3;
        }elseif($length >= 100 and $length < 250){
            $user_internship_profile_score += 2;
        }else{
            $user_internship_profile_score += 1;
        }
    }
    if($self_internship_PR){
        $length = mb_strlen($self_internship_PR);
        if($length >= 400){
            $user_internship_profile_score += 5;
        }elseif($length >= 250 and $length < 400){
            $user_internship_profile_score += 3;
        }elseif($length >= 100 and $length < 250){
            $user_internship_profile_score += 2;
        }else{
            $user_internship_profile_score += 1;
        }
    }
    if($degree_of_internship_interest){
        $user_internship_profile_score += 3;
    }
    update_user_meta( $user_id, 'user_internship_profile_score', $user_internship_profile_score);
}
// 興味・関心情報を更新した時にスコアを更新する関数
function update_user_interest_profile_score($user_id){
    $user_score_array = array(
        "興味のある業界"  =>  "bussiness_type",
        "職種"  =>  "future_occupations",
        "ベンチャーへの就職意欲"  =>  "will_venture",
    );
    $bussiness_type = get_user_meta($user_id,'bussiness_type',false)[0];
    $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
    $will_venture = get_user_meta($user_id,'will_venture',false)[0];

    $user_interest_profile_score = 0;
    if($bussiness_type){
        $user_interest_profile_score += 4;
    }
    if($future_occupations){
        $user_interest_profile_score += 4;
    }
    if($will_venture){
        $user_interest_profile_score += 4;
    }
    update_user_meta( $user_id, 'user_interest_profile_score', $user_interest_profile_score);
}
// 学生時代の経験情報を更新した時にスコアを更新する関数
function update_user_experience_profile_score($user_id){
    $user_score_array = array(
        "学生時代の経験"    =>  "student_experience",
    );
    $student_experience = get_user_meta( $user_id, 'student_experience',false)[0];

    $user_experience_profile_score = 0;
    if($student_experience){
        $user_experience_profile_score += 5;
    }
    update_user_meta( $user_id, 'user_experience_profile_score', $user_experience_profile_score);
}
// プロフィール画像の情報をもとにスコアを更新する関数
function update_user_picture_profile_score($user_id){
    $user_picture_profile_score = 0;
    $upload_dir = wp_upload_dir();
    $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
    if(file_exists($upload_file_name)){
        $user_picture_profile_score += 15;
    }
    $upload_cover_name = $upload_dir['basedir']."/".'cover_photo'.$user_id.'.png';
    if(file_exists($upload_cover_name)){
        $user_picture_profile_score += 10;
    }
    update_user_meta( $user_id, 'user_picture_profile_score', $user_picture_profile_score);
}
// 全てのカテゴリーの点数を合計して更新する関数
function update_user_total_profile_score($user_id){
    $user_profile_total_score = 0;
    update_user_base_profile_score($user_id);
    update_user_univ_profile_score($user_id);
    update_user_abroad_profile_score($user_id);
    update_user_programming_profile_score($user_id);
    update_user_skill_profile_score($user_id);
    update_user_community_profile_score($user_id);
    update_user_internship_profile_score($user_id);
    update_user_interest_profile_score($user_id);
    update_user_experience_profile_score($user_id);
    update_user_picture_profile_score($user_id);
    $user_base_profile_score = get_user_meta( $user_id, 'user_base_profile_score',false)[0];
    $user_univ_profile_score = get_user_meta( $user_id, 'user_univ_profile_score',false)[0];
    $user_abroad_profile_score = get_user_meta( $user_id, 'user_abroad_profile_score',false)[0];
    $user_programming_profile_score = get_user_meta( $user_id, 'user_programming_profile_score',false)[0];
    $user_skill_profile_score = get_user_meta( $user_id, 'user_skill_profile_score',false)[0];
    $user_community_profile_score = get_user_meta( $user_id, 'user_community_profile_score',false)[0];
    $user_internship_profile_score = get_user_meta( $user_id, 'user_internship_profile_score',false)[0];
    $user_interest_profile_score = get_user_meta( $user_id, 'user_interest_profile_score',false)[0];
    $user_experience_profile_score = get_user_meta( $user_id, 'user_experience_profile_score',false)[0];
    $user_picture_profile_score = get_user_meta( $user_id, 'user_picture_profile_score',false)[0];
    $user_profile_total_score = array_sum(array($user_base_profile_score,$user_univ_profile_score,$user_abroad_profile_score,$user_programming_profile_score,$user_skill_profile_score,$user_community_profile_score,$user_internship_profile_score,$user_interest_profile_score,$user_experience_profile_score,$user_picture_profile_score));
    update_user_meta( $user_id, 'user_profile_total_score', $user_profile_total_score);
    return $user_profile_total_score;
}
?>