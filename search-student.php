<?php
function admin_print_r($content, $tf){
    if(current_user_can( 'administrator' )){
    return print_r($content, $tf);
    }
    return '';
}

add_filter('wpcf7_spam', '__return_false');

function restrict_to_company_and_admin_func ($atts, $content = null ) {
    extract( shortcode_atts( array(
    'id' => '',
    ), $atts ) );
    $roles=wp_get_current_user()->roles;
    if(in_array("company", $roles) || in_array("officer", $roles) ||current_user_can('administrator')){
    return do_shortcode($content);
    }
    return '権限がありません。';
}
add_shortcode('restrict_to_company_and_admin','restrict_to_company_and_admin_func');


function get_choice_array($id){
    $choice_array=array();
    if($id=='experience_and_achievement_select'){
        $choice_array=array(
			'長期インターン' => array( 'value' => '長期インターン',  'checked' => false, ),
            '起業経験' => array( 'value' => '起業経験',  'checked' => false, ),
            'ボランティア' => array( 'value' => 'ボランティア',  'checked' => false, ),
            'サークル/学生団体代表' => array( 'value' => 'サークル/学生団体代表',  'checked' => false, ),
            '体育会所属' => array( 'value' => '体育会所属',  'checked' => false, ),
            'ビジコン出場' => array( 'value' => 'ビジコン出場',  'checked' => false, ),
            'ハッカソン出場' => array( 'value' => 'ハッカソン出場',  'checked' => false, ),
            'ミスコン出場' => array( 'value' => 'ミスコン出場',  'checked' => false, ),
        );
    }

    if($id=='faculty_lineage'){
        $choice_array=array(
            '文・人文' => array( 'value' => '文・人文',  'checked' => false, ),
            '社会・国際' => array( 'value' => '社会・国際',  'checked' => false, ),
            '法・政治' => array( 'value' => '法・政治',  'checked' => false, ),
            '経済・経営・商' => array( 'value' => '経済・経営・商',  'checked' => false, ),
            '教育' => array( 'value' => '教育',  'checked' => false, ),
            '理' => array( 'value' => '理',  'checked' => false, ),
            '工' => array( 'value' => '工',  'checked' => false, ),
            '農' => array( 'value' => '農',  'checked' => false, ),
            '医・歯・薬・保健' => array( 'value' => '医・歯・薬・保健',  'checked' => false, ),
            '生活科学' => array( 'value' => '生活科学',  'checked' => false, ),
            '芸術' => array( 'value' => '芸術',  'checked' => false, ),
            'スポーツ科学' => array( 'value' => 'スポーツ科学',  'checked' => false, ),
            '総合・環境・情報・人間' => array( 'value' => '総合・環境・情報・人間',  'checked' => false, ),
        );
    }
    return $choice_array;
}

function add_search_characteristic_func($chara_id, $chara_label, $array_flag, $input_type, $return_type, $choice_array, $compare, $relation){
    if($return_type=='checkbox' && $array_flag==true){
    $html='<div>'.$chara_label;
        foreach ( $choice_array as $key => $item ) {
            if($item['checked']==false){
                $html.='<label><input type="checkbox" name="'.$chara_id.'[]" value="'.$key.'">'.$item['value'].'</label>';
            }else{
                $html.='<label><input type="checkbox" name="'.$chara_id.'[]" value="'.$key.'" checked="'.$item['checked'].'">'.$item['value'].'</label>';
            }
        }
        $html.='</div>';
        return $html;
    }
    if($return_type=='checkbox' && $array_flag==false){
        $html='<div>';
        $html.='<label><input type="checkbox" name="'.$chara_id.'" value="'.$chara_label.'">'.$chara_label.'</label>';
        $html.='</div>';
        return $html;
    }
    if($return_type=='textform' && $array_flag==false){
        $html= '<div>'.$chara_label.'<br><input type="search" class="search-field" placeholder="キーワードを入力" value="" name="'.$chara_id.'" /></div>';
        return $html;
    }

    if($return_type=='query_arg' && $array_flag==true){
        if (isset($_GET[$chara_id])) {
            $input_data =$_GET[$chara_id];
            $_query_args=array('relation' => $relation,);
            foreach ( $input_data as $key => $item ) {
                array_push ($_query_args, array(
                    'key'     => $chara_id,
                    'value'   => $item,
                    'compare' => $compare
                ));
            }
            return $_query_args;
        }
    }

    if($return_type=='query_arg' && $array_flag==false){
        if (isset($_GET[$chara_id])) {
            //  $input_data =my_esc_sql($_GET[$chara_id]);
            if($input_type=='int'){
                $input_data =(int)($_GET[$chara_id]);
                if($input_data==0){return null;}
            }else{
                $input_data =$_GET[$chara_id];
            }
            return 	array(
                'key'     => $chara_id,
                'value'   => $input_data,
                'compare' => $compare
            );
        }
        return null;
    }
}


function student_search_form_func($atts) {
    extract( shortcode_atts( array(
        'item_type' => '',
    ), $atts ) );
    $user=wp_get_current_user();
    $user_roles=$user->roles;
/*
    $evaluation_form_html = '
    <div>点数での絞り込み（点数の下限を選択）</div>
    <div class="point-range">'.name_of_student_item_func(1).'<input type="range" name="eval1" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <div class="point-range">'.name_of_student_item_func(2).'<input type="range" name="eval2" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <div class="point-range">'.name_of_student_item_func(3).'<input type="range" name="eval3" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <div class="point-range">'.name_of_student_item_func(4).'<input type="range" name="eval4" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <div class="point-range">'.name_of_student_item_func(5).'<input type="range" name="eval5" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <div class="point-range">'.name_of_student_item_func(6).'<input type="range" name="eval6" min="0" max="5" step="0.5" value="0"> <span>0</span></div>
    <script>
    　var elem = document.getElementsByClassName("point-range");
    　 var rangeValue = function (elem, target) {
    　 　　return function(evt){
    　　　 　　target.innerHTML = elem.value;
    　　　}
    　 }
    　 for(var i = 0, max = elem.length; i < max; i++){
    　　　bar = elem[i].getElementsByTagName("input")[0];
    　　　target = elem[i].getElementsByTagName("span")[0];
    　　　 bar.addEventListener("input", rangeValue(bar, target));
    　 }
    </script>';
    */
    $home_url =esc_url( home_url( ));

    if(in_array("administrator", $user_roles)){
        $builds_mail_html=
        '<hr>
            <h2>Buildsからのメール配信希望者</h2>
            <div class="btn-group btn-group scout-category" data-toggle="buttons">
                <label class="btn active">
                    <input type="checkbox" name="mail_can_send" value="mail_can_send" class="checkbox"><span>Buildsのメール配信希望者</span>
                </label>
            </div>
        <br>';
      }
    $search_form_html = '
    <style>
        .cp_ipselect {
            overflow: hidden;
            width: 90%;
            margin: 2em auto;
            text-align: center;
        }
        .cp_ipselect select {
            width: 100%;
            padding-right: 1em;
            cursor: pointer;
            text-indent: 0.01px;
            text-overflow: ellipsis;
            border: none;
            outline: none;
            background: transparent;
            background-image: none;
            box-shadow: none;
            -webkit-appearance: none;
            appearance: none;
        }
        .cp_ipselect select::-ms-expand {
            display: none;
        }
        .cp_ipselect.cp_sl03 {
            position: relative;
            border-radius: 2px;
            border: 2px solid #ddd;
            background: #ffffff;
        }
        .cp_ipselect.cp_sl03::before {
            position: absolute;
            top: 0.8em;
            right: 0.8em;
            width: 0;
            height: 0;
            padding: 0;
            content: " ";
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid black;
            pointer-events: none;
        }
        .cp_ipselect.cp_sl03 select {
            padding: 8px 38px 8px 8px;
            color: black;
        }
        /*タブ切り替え全体のスタイル*/
        .tabs {
            margin-top: 50px;
            padding-bottom: 40px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: auto;
            margin: 0 auto;}
            /*タブのスタイル*/
            .tab_item {
            width: calc(100%/3);
            height: 50px;
            border-bottom: 3px solid #03c4b0;
            background-color: #d9d9d9;
            line-height: 50px;
            font-size: 16px;
            text-align: center;
            color: #565656;
            display: block;
            float: left;
            text-align: center;
            font-weight: bold;
            transition: all 0.2s ease;
        }
        .tab_item:hover {
            opacity: 0.75;
        }
        /*ラジオボタンを全て消す*/
        input[name="tab_item"] {
            display: none;
        }
        /*タブ切り替えの中身のスタイル*/
        .tab_content {
            display: none;
            padding: 40px 40px 0;
            clear: both;
            overflow: hidden;
        }
        /*選択されているタブのコンテンツのみを表示*/
        #all:checked ~ #all_content,
        #programming:checked ~ #programming_content,
        #design:checked ~ #design_content {
            display: block;
        }
        /*選択されているタブのスタイルを変える*/
        .tabs input:checked + .tab_item {
            background-color: #03c4b0;
            color: #fff;
        }
        /*
        label.btn span {
            font-size: 1.5em ;
        }
        */

        label input[type="radio"] ~ i.fa.fa-circle-o{
            color: #c8c8c8;    display: inline;
        }
        label input[type="radio"] ~ i.fa.fa-dot-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-circle-o{
            display: none;
        }
        label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
            color: #7AA3CC;    display: inline;
        }
        label:hover input[type="radio"] ~ i.fa {
            color: #7AA3CC;
        }

        label input[type="checkbox"] ~ i.fa.fa-square-o{
            color: #c8c8c8;    display: inline;
        }
        label input[type="checkbox"] ~ i.fa.fa-check-square-o{
            display: none;
        }
        label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
            display: none;
        }
        label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
            color: #7AA3CC;    display: inline;
        }
        label:hover input[type="checkbox"] ~ i.fa {
        color: #7AA3CC;
        }

        div[data-toggle="buttons"] label.active{
            color: #7AA3CC;
        }

        div[data-toggle="buttons"] label {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 2em;
            text-align: left;
            white-space: nowrap;
            vertical-align: top;
            cursor: pointer;
            background-color: none;
            border: 0px solid#c8c8c8;
            border-radius: 3px;
            color: #c8c8c8;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none;
            user-select: none;
        }

        div[data-toggle="buttons"] label:hover {
            color: #7AA3CC;
        }

        div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        #um-submit-btn{
            color: #fff;
        }
    </style>
    <script type="text/javascript">
        function removeCheck(){
            $(".checkbox").prop("checked", false);
            $(".radio").prop("checked", false);
            $("select option").attr("selected", false);
            $(".search-field_test").val("");
            
        }
    </script>
    <form role="search" method="get" class="search-form" action="https://jobshot.jp/scout_result" id="form__scout" name="form__scout">
        <div class="tabs">
            <input id="all" type="radio" name="tab_item" checked="">
                <label class="tab_item" for="all">基本情報</label>
            <input id="programming" type="radio" name="tab_item">
                <label class="tab_item" for="programming">スキル</label>
            <div class="tab_content" id="all_content">
                <div class="tab_content_description">
                    <h2>フリーワード検索</h2>
                    <div class="btn-group btn-group freeword-search-container" data-toggle="buttons">
                        <div class="scout_freeword">
                            <label class="btn active scout_freeword_text">
                                <input type="text" name="freeword" class="search-field_test" placeholder="フリーワードから探す">
                            </label>
                        </div>
                        <div>
                            <input type="submit" value="検索" class="um-button um-alt search-submit scout_freeword_search" id="um-submit-btn">
                        </div>
                    </div>
                </div>
                <div class="tab_content_description">
                    <h2>学生ステータス</h2>
                    <table class="student_status">
                        <tbody>
                            <tr>
                                <th>性別</th>
                                <td class="cp_ipselect cp_sl03">
                                    <select name="gender">
                                        <option value="">指定なし</option>
                                        <option value="male">男性</option>
                                        <option value="female">女性</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>ログイン日時</th>
                                <td class="cp_ipselect cp_sl03">
                                    <select name="last_login">
                                        <option class="last_login" value="">指定なし</option>
                                        <option class="last_login" value="1">1日以内</option>
                                        <option class="last_login" value="3">3日以内</option>
                                        <option class="last_login" value="7">1週間以内</option>
                                        <option class="last_login" value="14">2週間以内</option>
                                        <option class="last_login" value="30">1ヶ月以内</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>活動状況</th>
                                <td class="cp_ipselect cp_sl03">
                                    <select name="degree_of_internship_interest">
                                        <option value="">指定なし</option>
                                        <option value="1">今すぐにでも長期インターンをやってみたい</option>
                                        <option value="2">話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい</option>
                                        <option value="3">全く興味がない</option>
                                    </select>
                                </td>
                            </tr>
							<tr>
                                <th>ベンチャー企業への就職意欲</th>
                                    <td class="cp_ipselect cp_sl03">
                                        <select name="will_venture">
                                            <option value="">指定なし</option>
                                            <option value="1">ファーストキャリアはベンチャー企業が良いと思っている</option>
                                            <option value="2">自分に合ったベンチャー企業ならば就職してみたい</option>
                                            <option value="3">ベンチャー企業に少しは興味がある</option>
                                            <option value="４">ベンチャー企業には全く興味がない</option>
                                        </select>
                                    </td>
                            </tr>
                            <tr>
                                <th>プロフィールスコア</th>
                                <td class="cp_ipselect cp_sl03">
                                    <select name="profile_score">
                                        <option value="">指定なし</option>
                                        <option value="20">20以上</option>
                                        <option value="40">40以上</option>
                                        <option value="60">60以上</option>
                                        <option value="80">80以上</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>スカウトの有無</th>
                                <td class="cp_ipselect cp_sl03">
                                    <select name="scouted_or">
                                        <option value="">指定なし</option>
                                        <option value="not_yet">未スカウトの学生</option>
                                        <option value="already">スカウト済みの学生</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h2>大学</h2>
                    <div class="btn-group btn-group scout-category" data-toggle="buttons">
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="北海道大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 北海道大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="東北大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東北大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="筑波大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 筑波大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="千葉大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 千葉大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="339" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東京大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="341" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東京工業大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="485" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 一橋大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="343" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東京外語大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="44" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> お茶の水女子大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="586" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 横浜国立大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="首都大学東京" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 首都大学東京</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="602" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 早稲田大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="166" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 慶應義塾大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="216" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 上智大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="354" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東京理科大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="173" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 国際基督教大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="学習院大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 学習院大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="566" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 明治大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="1" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 青山学院大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="592" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 立教大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="310" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 中央大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="532" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 法政大学</span>
                        </label><br>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="名古屋大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 名古屋大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="京都大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 京都大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="大阪大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 大阪大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="神戸大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 神戸大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="関西大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 関西大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="関西学院大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 関西学院大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="同志社大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 同志社大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="立命館大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 立命館大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="九州大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 九州大学</span>
                        </label>
                    </div>
                    <hr>
                    <h2>学部系統</h2>
                    <div class="btn-group btn-group scout-category" data-toggle="buttons">
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="文・人文" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 文・人文</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="社会・国際" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 社会・国際</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="法・政治" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 法・政治</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="経済・経営・商" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 経済・経営・商</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="教育" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 教育</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="理" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 理</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="工" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 工</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="農" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 農</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="医・歯・薬・保健" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 医・歯・薬・保健</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="生活科学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 生活科学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="芸術" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 芸術</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="スポーツ科学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> スポーツ科学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="faculty_lineage[]" value="総合・環境・情報・人間" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 総合・環境・情報・人間</span>
                        </label>
                    </div>
                    <hr>
                    <h2>卒業年度</h2>
                    <div class="btn-group btn-group scout-category" data-toggle="buttons">
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2021" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 21卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2022" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 22卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2023" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 23卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2024" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 24卒</span>
                        </label>
                    </div>
                    <hr>
                    <h2>職種</h2>
    <div class="btn-group btn-group scout-category" data-toggle="buttons">
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="エンジニア" class="checkbox"><span> エンジニア</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="デザイナー" class="checkbox"><span> デザイナー</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="コンサル" class="checkbox"><span> コンサル</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="ディレクター" class="checkbox"><span> ディレクター</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="マーケティング" class="checkbox"><span> マーケティング</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="ライター" class="checkbox"><span> ライター</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="営業" class="checkbox"><span> 営業</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="事務/コーポレート・スタッフ" class="checkbox"><span> 事務/コーポレート・スタッフ</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="総務・人事・経理" class="checkbox"><span> 総務・人事・経理</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="企画" class="checkbox"><span> 企画</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="その他" class="checkbox"><span> その他</span>
        </label>
    </div>
    <hr>
    <h2>留学経験</h2>
    <div class="btn-group btn-group scout-category" data-toggle="buttons">
		<label class="btn active">
            <input type="radio" name="studied_abroad[]" value="1" class="radio"><span> 期間は問わないが経験あり</span>
        </label>
        <label class="btn active">
            <input type="radio" name="studied_abroad[]" value="2" class="radio"><span> ３ヶ月以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="studied_abroad[]" value="3" class="radio"><span> ６ヶ月以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="studied_abroad[]" value="4" class="radio"><span> １年以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="studied_abroad[]" value="0" class="radio"><span> 指定なし</span>
        </label>
    </div>
    <hr>
    <h2>学生時代の経験</h2>
    <div class="btn-group btn-group scout-category scout-category-experiment" data-toggle="buttons">
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="起業経験" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 起業経験</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="体育会キャプテン" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 体育会キャプテン</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="サークル代表経験" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> サークル代表経験</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="学生団体代表経験" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 学生団体代表経験</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="サークル/学生団体創設経験" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> サークル/学生団体創設経験</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="ボランティア" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> ボランティア</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="海外ボランティア" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 海外ボランティア</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="ビジコン出場" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> ビジコン出場</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="ハッカソン出場" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> ハッカソン出場</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="ミスコン出場" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> ミスコン出場</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="東大TLPに選ばれた" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東大TLPに選ばれた</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="東大推薦入試合格" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東大推薦入試合格</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="首席をとった" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 首席をとった</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="未踏クリエーターに選抜された" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 未踏クリエーターに選抜された</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="0から1をつくりあげた" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 0から1をつくりあげた</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="何かで１番になった" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 何かで１番になった</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="バックパッカー経験あり" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> バックパッカー経験あり</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="高校時代に生徒会経験あり" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 高校時代に生徒会経験あり</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="student_experience[]" value="中高大の部活経験で全国大会出場経験あり" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 中高大の部活経験で全国大会出場経験あり</span>
        </label>
    </div>
    <hr>
    <h2>大学時代のコミュニティ</h2>
    <div class="btn-group btn-group scout-category" data-toggle="buttons">
        <label class="btn active">
            <input type="checkbox" name="univ_community[]" value="文化系サークル" class="checkbox"><span> 文化系サークル</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="univ_community[]" value="スポーツ系サークル" class="checkbox"><span> スポーツ系サークル</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="univ_community[]" value="体育会系部活" class="checkbox"><span> 体育会系部活</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="univ_community[]" value="文化系部活" class="checkbox"><span> 文化系部活</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="univ_community[]" value="学生団体" class="checkbox"><span> 学生団体</span>
        </label>
    </div>
    <hr>
    <h2>長期インターン経験</h2>
    <div class="btn-group btn-group scout-category" data-toggle="buttons">
        <label class="btn active">
            <input type="radio" name="internship_experiences[]" value="1" class="radio"><span> １ヶ月以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="internship_experiences[]" value="2" class="radio"><span> ３ヶ月以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="internship_experiences[]" value="3" class="radio"><span> ６ヶ月以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="internship_experiences[]" value="4" class="radio"><span> １年以上</span>
        </label>
        <label class="btn active">
            <input type="radio" name="internship_experiences[]" value="0" class="radio"><span> 指定なし</span>
        </label>
    </div>
    <hr>
    <h2>興味のある業界</h2>
    <div class="btn-group btn-group scout-category" data-toggle="buttons">
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="メーカー" class="checkbox"><span> メーカー</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="メディア" class="checkbox"><span> メディア</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="金融" class="checkbox"><span> 金融</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="広告" class="checkbox"><span> 広告</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="商社" class="checkbox"><span> 商社</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="人材" class="checkbox"><span> 人材</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="教育" class="checkbox"><span> 教育</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="不動産" class="checkbox"><span> 不動産</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="官公庁" class="checkbox"><span> 官公庁</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="IT" class="checkbox"><span> IT</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="VC/起業支援" class="checkbox"><span> VC/起業支援</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="ゲーム" class="checkbox"><span> ゲーム</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="コンサルティング" class="checkbox"><span> コンサルティング</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="ファッション/アパレル" class="checkbox"><span> ファッション/アパレル</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="ブライダル" class="checkbox"><span> ブライダル</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="旅行・観光" class="checkbox"><span> 旅行・観光</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="医療・福祉" class="checkbox"><span> 医療・福祉</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="bussiness_type[]" value="小売・流通" class="checkbox"><span> 小売・流通</span>
        </label>
    </div>
    '.$builds_mail_html.'
    <div class="scout_all_clear">
        <i onclick="removeCheck()" style="cursor: pointer;">すべての条件をクリアする</i>
    </div><br>
                    <div>
                        <input type="submit" value="この条件で検索する" class="um-button um-alt scout_search" id="um-submit-btn">
                    </div>
                </div>
            </div>
            <div class="tab_content" id="programming_content">
                <div class="tab_content_description">
                    <h2>プログラミングスキル</h2>
                    <table dir="ltr" border="1" cellspacing="0" cellpadding="0">
                        <colgroup>
                        <col width="100">
                        <col width="100"></colgroup>
                        <tbody>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{"1":2,"2":"★1つ"}">★1つ</td>
                                <td style="width: 338px;" data-sheets-value="{"1":2,"2":"独学(授業等含む)で学んだ程度で、実装の経験はない"}">独学(授業等含む)で学んだ程度で、実装の経験はない</td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{"1":2,"2":"★2つ"}">★2つ</td>
                                <td style="width: 338px;" data-sheets-value="{"1":2,"2":"用語や文法は理解できるが他の人の指導は必要"}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>用語や文法は理解できるが他の人の指導は必要</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{"1":2,"2":"★3つ"}">★3つ</td>
                                <td style="width: 338px;" data-sheets-value="{"1":2,"2":"用語や文法は理解でき、開発した経験がある"}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>用語や文法は理解でき、開発した経験がある</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{"1":2,"2":"★4つ"}">★4つ</td>
                                    <td style="width: 338px;" data-sheets-value="{"1":2,"2":"フレームワークやライブラリ等を利用して、開発した経験がある"}" data-sheets-formula="=R[0]C[-6]">
                                        <div>
                                            <div>フレームワークやライブラリ等を利用して、開発した経験がある</div>
                                        </div>
                                    </td>
                                </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{"1":2,"2":"★5つ"}">★5つ</td>
                                <td style="width: 338px;" data-sheets-value="{"1":2,"2":"その言語(フレームワーク等含む)を利用して一人でサービスを作ることができる"}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>その言語(フレームワーク等含む)を利用して一人でサービスを作ることができる</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group btn-group scout-programming-category" data-toggle="buttons">
                        <label class="btn active">
                            <span class="programming_lang_name"> C言語  </span><input type="range" name="programming_lang_lv_c" value="0" min="0" max="5" step="1" oninput=document.getElementById("output1").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output1">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> C#  </span><input type="range" name="programming_lang_lv_cpp" value="0" min="0" max="5" step="1" oninput=document.getElementById("output2").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output2">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> C++  </span><input type="range" name="programming_lang_lv_cs" value="0" min="0" max="5" step="1" oninput=document.getElementById("output3").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output3">0<span></span></output></div></div>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Go  </span><input type="range" name="programming_lang_lv_go" value="0" min="0" max="5" step="1" oninput=document.getElementById("output4").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output4">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Java  </span><input type="range" name="programming_lang_lv_java" value="0" min="0" max="5" step="1" oninput=document.getElementById("output5").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output5">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> JavaScript  </span><input type="range" name="programming_lang_lv_js" value="0" min="0" max="5" step="1" oninput=document.getElementById("output6").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output6">0<span></span></output></div></div>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Kotlin  </span><input type="range" name="programming_lang_lv_kt" value="0" min="0" max="5" step="1" oninput=document.getElementById("output7").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output7">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Objective-C  </span><input type="range" name="programming_lang_lv_m" value="0" min="0" max="5" step="1" oninput=document.getElementById("output8").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output8">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> PHP  </span><input type="range" name="programming_lang_lv_php" value="0" min="0" max="5" step="1" oninput=document.getElementById("output9").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output9">0<span></span></output></div></div>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Perl  </span><input type="range" name="programming_lang_lv_pl" value="0" min="0" max="5" step="1" oninput=document.getElementById("output10").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output10">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Python  </span><input type="range" name="programming_lang_lv_py" value="0" min="0" max="5" step="1" oninput=document.getElementById("output11").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output11">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> R  </span><input type="range" name="programming_lang_lv_r" value="0" min="0" max="5" step="1" oninput=document.getElementById("output12").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output12">0<span></span></output></div></div>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Ruby  </span><input type="range" name="programming_lang_lv_rb" value="0" min="0" max="5" step="1" oninput=document.getElementById("output13").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output13">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Swift  </span><input type="range" name="programming_lang_lv_scala" value="0" min="0" max="5" step="1" oninput=document.getElementById("output14").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output14">0<span></span></output></div></div>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Scala  </span><input type="range" name="programming_lang_lv_swift" value="0" min="0" max="5" step="1" oninput=document.getElementById("output15").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output15">0<span></span></output></div></div>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> VisualBasic  </span><input type="range" name="programming_lang_lv_vb" value="0" min="0" max="5" step="1" oninput=document.getElementById("output16").value=this.value>
                            <div class="level-container"><div class="level-subcontainer"><output id="output16">0<span></span></output></div></div>
                        </label>
                    </div>
                    <div>
                        <input type="submit" value="この条件で検索する" class="um-button um-alt scout_search" id="um-submit-btn">
                    </div>
                    <div class="num__student"></div>
                </div>
            </div>
        </div>
    </form>';
    return $search_form_html;
}
add_shortcode('student_search_form','student_search_form_func');

function remove_check(){
    return "
    <script type='text/javascript'>
    $('#removecheck').click(function () {
        $('.checkbox').prop('checked', false);
        $('.radio').prop('checked', false);
        $('select option').attr('selected', false);
        $('#sampletext').val('<input type='text' name='freeword' class='search-field_test' placeholder='フリーワードから探す'>');
      }
    );
    </script>";
}

function student_search_result_func($atts){
    $search_count = 0;
    $search_total_count = 0;
    $ids = array();
    $home_url =esc_url( home_url( ));
    extract( shortcode_atts( array(
    ), $atts ) );

    $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );

    $meta_query_args2 = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );

    if (isset($_GET['sw'])) {
        $searchword = my_esc_sql($_GET['sw']);
    }
    /*
    if (isset($_GET['sort'])) {
        $sort = my_esc_sql($_GET['sort']);
    }
    */

    $user=wp_get_current_user();
    $user_roles=$user->roles;

    $form_html = 
        '<div onclick="openStudentForm()" class="select-modal-open">
            <div>検索フォームを表示する</div>
        </div>
        <div class="search-student__form">';
    $form_html .= do_shortcode('[student_search_form]');
    $form_html .= '</div>';

    // 企業からのスカウトメールを希望しない学生の除外
    // if(in_array("company", $user_roles)){
    //     $company_mail_meta_query = array('relation' => 'OR');
    //     array_push($company_mail_meta_query, array(
    //         'key'       => 'mail_settings',
    //         'value'     => '企業からのスカウトメールを希望しない',
    //         'compare'   => 'NOT LIKE'
    //     ));
    //     array_push($company_mail_meta_query, array(
    //         'key'       => 'mail_settings',
    //         'compare' => 'NOT EXISTS'
    //     ));
    //     array_push($meta_query_args, $company_mail_meta_query);
    // }
    // Buildsからのメール配信を希望しない学生の除外
    $condition_html = '';
    $search_mail_count = 0;
    if (isset($_GET['mail_can_send'])) {
        $search_mail_count = 1;
        $form_html = str_replace('name="mail_can_send"','name="mail_can_send" checked="checked"',$form_html);
        $condition_html .= '<span>メール配信：</span><div class="card-category__scout">配信を希望する</div><br>';
        $builds_mail_meta_query = array('relation' => 'OR');
        array_push($builds_mail_meta_query, array(
            'key'       => 'mail_settings',
            'value'     => 'Buildsからのメール配信を希望しない',
            'compare'   => 'NOT LIKE'
        ));
        array_push($builds_mail_meta_query, array(
            'key'       => 'mail_settings',
            'compare' => 'NOT EXISTS'
        ));
        array_push($meta_query_args, $builds_mail_meta_query);
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      $ids += $students_ids->get_results();
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    
    // 性別による絞り込み
    if (!empty($_GET['gender'])) {
        $search_count += 1;
        $search_total_count += 1;
        $gender = $_GET['gender'];
        if($gender == 'male'){
            $form_html = str_replace('<option value="male">','<option value="male" selected>',$form_html);
            $gender = '男性';
            $condition_html .= '<span>性別：</span><div class="card-category__scout">男性</div><br>';
        }
        if($gender == 'female'){
            $form_html = str_replace('<option value="female">','<option value="female" selected>',$form_html);
            $gender = '女性';
            $condition_html .= '<span>性別：</span><div class="card-category__scout">女性</div><br>';
        }
        array_push (
            $meta_query_args,
            array(
                'key'     => 'gender',
                'value'   =>  $gender,
                'compare' => 'LIKE'
            )
        );
    }

    // ログイン日時による絞り込み
    if (!empty($_GET['last_login']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $last_login_value = $_GET["last_login"];
        if($last_login_value == 30){
            $compare_time = date("Y/m/d H:i:s",strtotime("-1 month"));
            $condition_html .= '<span>ログイン日時：</span><div class="card-category__scout">１ヶ月以内</div><br>';
        }else{
            $compare_time = date("Y/m/d H:i:s",strtotime("-".$last_login_value." day"));
            $condition_html .= '<span>ログイン日時：</span><div class="card-category__scout">'.$last_login_value.'日以内</div><br>';
        }
        $form_html = str_replace('<option class="last_login" value="'.$last_login_value.'">','<option class="last_login" value="'.$last_login_value.'" selected>',$form_html);
        $compare_unixtime = strtotime($compare_time);
        array_push($meta_query_args, array(
            'key'       => '_um_last_login',
            'value'     => $compare_unixtime,
            'compare'   => '>'
        ));
    }
    // 活動状況による絞り込み
    if (!empty($_GET['degree_of_internship_interest']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $degree_of_internship_interest = $_GET["degree_of_internship_interest"];
	  	if($degree_of_internship_interest==1){
            $degree_of_internship_interest=array('今すぐにでも長期インターンをやってみたい');
            $form_html = str_replace('<option value="1">'.$degree_of_internship_interest[0],'<option value="1" selected>'.$degree_of_internship_interest[0],$form_html);
            $condition_html .= '<span>活動状況：</span><div class="card-category__scout">今すぐにでも長期インターンをやってみたい</div><br>';
		}
	  	if($degree_of_internship_interest==2){
            $degree_of_internship_interest=array('話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい');
            $form_html = str_replace('<option value="2">'.$degree_of_internship_interest[0],'<option value="2" selected>'.$degree_of_internship_interest[0],$form_html);
            $condition_html .= '<span>活動状況：</span><div class="card-category__scout">話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい</div><br>';
		}
	  	if($degree_of_internship_interest==3){
            $degree_of_internship_interest=array('全く興味がない');
            $form_html = str_replace('<option value="3">'.$degree_of_internship_interest[0],'<option value="3" selected>'.$degree_of_internship_interest[0],$form_html);
            $condition_html .= '<span>活動状況：</span><div class="card-category__scout">全く興味がない</div><br>';   
		}
        array_push($meta_query_args, array(
            'key'       => 'degree_of_internship_interest',
            'value'     => $degree_of_internship_interest[0],
            'compare'   => '='
        ));
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }


    // ベンチャー企業への就職意欲による絞り込み
    if (!empty($_GET['will_venture']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $will_venture = $_GET["will_venture"];
	  	if($will_venture==1){
            $will_venture=array('ファーストキャリアはベンチャー企業が良いと思っている');
            $form_html = str_replace('<option value="1">'.$will_venture[0],'<option value="1" selected>'.$will_venture[0],$form_html);
            $condition_html .= '<span>ベンチャーへの就職意欲：</span><div class="card-category__scout">ファーストキャリアはベンチャー企業が良いと思っている</div><br>'; 
		}
	  	if($will_venture==2){
            $will_venture=array('自分に合ったベンチャー企業ならば就職してみたい');
            $form_html = str_replace('<option value="2">'.$will_venture[0],'<option value="2" selected>'.$will_venture[0],$form_html);
            $condition_html .= '<span>ベンチャーへの就職意欲：</span><div class="card-category__scout">自分に合ったベンチャー企業ならば就職してみたい</div><br>'; 
		}
	  	if($will_venture==3){
            $will_venture=array('ベンチャー企業に少しは興味がある');
            $form_html = str_replace('<option value="3">'.$will_venture[0],'<option value="3" selected>'.$will_venture[0],$form_html);
            $condition_html .= '<span>ベンチャーへの就職意欲：</span><div class="card-category__scout">ベンチャー企業に少しは興味がある</div><br>'; 
		}
	  	if($will_venture==4){
            $will_venture=array('ベンチャー企業には全く興味がない');
            $form_html = str_replace('<option value="4">'.$will_venture[0],'<option value="4" selected>'.$will_venture[0],$form_html);
            $condition_html .= '<span>ベンチャーへの就職意欲：</span><div class="card-category__scout">ベンチャー企業には全く興味がない</div><br>'; 
		}
        array_push($meta_query_args, array(
            'key'       => 'will_venture',
            'value'     => $will_venture[0],
            'compare'   => '='
        ));
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 大学による絞り込み
    if (isset($_GET['university']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $universities = $_GET["university"];
        if(in_array(339,$universities)){
            $university_sub = "東京大学";
            array_push($universities,$university_sub);
        }
        if(in_array(341,$universities)){
            $university_sub = "東京工業大学";
            array_push($universities,$university_sub);
        }
        if(in_array(485,$universities)){
            $university_sub = "一橋大学";
            array_push($universities,$university_sub);
        }
        if(in_array(343,$universities)){
            $university_sub = "東京外語大学";
            array_push($universities,$university_sub);
        }
        if(in_array(44,$universities)){
            $university_sub = "お茶の水女子大学";
            array_push($universities,$university_sub);
        }
        if(in_array(586,$universities)){
            $university_sub = "横浜国立大学";
            array_push($universities,$university_sub);
        }
        if(in_array(602,$universities)){
            $university_sub = "早稲田大学";
            array_push($universities,$university_sub);
        }
        if(in_array(166,$universities)){
            $university_sub = "慶應義塾大学";
            array_push($universities,$university_sub);
        }
        if(in_array(216,$universities)){
            $university_sub = "上智大学";
            array_push($universities,$university_sub);
        }
        if(in_array(354,$universities)){
            $university_sub = "東京理科大学";
            array_push($universities,$university_sub);
        }
        if(in_array(173,$universities)){
            $university_sub = "国際基督教大学";
            array_push($universities,$university_sub);
        }
        if(in_array(566,$universities)){
            $university_sub = "明治大学";
            array_push($universities,$university_sub);
        }
        if(in_array(1,$universities)){
            $university_sub = "青山学院大学";
            array_push($universities,$university_sub);
        }
        if(in_array(592,$universities)){
            $university_sub = "立教大学";
            array_push($universities,$university_sub);
        }
        if(in_array(310,$universities)){
            $university_sub = "中央大学";
            array_push($universities,$university_sub);
        }
        if(in_array(532,$universities)){
            $university_sub = "法政大学";
            array_push($universities,$university_sub);
        }
        $condition_html .= '<span>大学：</span>';
        $univ_meta_query = array('relation' => 'OR');
        foreach($universities as $university){
            if (!is_numeric($university)){
            $condition_html .= '<div class="card-category__scout">'.$university.'</div>';
            }
            $form_html = str_replace('<input type="checkbox" name="university[]" value="'.$university.'" class="checkbox">','<input type="checkbox" name="university[]" value="'.$university.'" class="checkbox" checked="checked">',$form_html);
            array_push($univ_meta_query, array(
                'key'       => 'university',
                'value'     => $university,
                'compare'   => '='
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $univ_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 学部系統による絞り込み
    if (isset($_GET['faculty_lineage']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $faculty_lineages = $_GET["faculty_lineage"];
        $condition_html .= '<span>学部系統：</span>';
        $faculty_lineage_meta_query = array('relation' => 'OR');
        foreach($faculty_lineages as $faculty_lineage){
            $form_html = str_replace('<input type="checkbox" name="faculty_lineage[]" value="'.$faculty_lineage.'" class="checkbox">','<input type="checkbox" name="faculty_lineage[]" value="'.$faculty_lineage.'" class="checkbox" checked="checked">',$form_html);
            $condition_html .= '<div class="card-category__scout">'.$faculty_lineage.'</div>';
            array_push($faculty_lineage_meta_query, array(
                'key'       => 'faculty_lineage',
                'value'     => $faculty_lineage,
                'compare'   => '='
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $faculty_lineage_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
    
    $graduate_html = '';
    // 卒業年度による絞り込み
    if (isset($_GET['graduate_year']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $graduate_years = $_GET["graduate_year"];
        if(in_array(2021,$graduate_years)){
            $graduate_year_sub = "2021(2019年4月時点で大学3年生/大学院1年生)";
            //$graduate_year_sub_1 = "2021";
            $graduate_html .= '<div class="card-category__scout">21卒</div>';
            //array_push($graduate_years,$graduate_year_sub);
            //array_push($graduate_years,$graduate_year_sub_1);
        }
        if(in_array(2022,$graduate_years)){
            $graduate_year_sub = "2022(2019年4月時点で大学2年生)";
            //$graduate_year_sub_1 = "2022";
            $graduate_html .= '<div class="card-category__scout">22卒</div>';
            //array_push($graduate_years,$graduate_year_sub);
            //array_push($graduate_years,$graduate_year_sub_1);
        }
        if(in_array(2023,$graduate_years)){
            $graduate_year_sub = "2023(2019年4月時点で大学1年生)";
            //$graduate_year_sub_1 = "2023";
            $graduate_html .= '<div class="card-category__scout">23卒</div>';
            //array_push($graduate_years,$graduate_year_sub);
            //array_push($graduate_years,$graduate_year_sub_1);
        }
        if(in_array(2024,$graduate_years)){
            $graduate_year_sub = "2024(2020年4月時点で大学1年生)";
            //$graduate_year_sub_1 = "2024";
            $graduate_html .= '<div class="card-category__scout">24卒</div>';
            //array_push($graduate_years,$graduate_year_sub);
            //array_push($graduate_years,$graduate_year_sub_1);
        }
        $condition_html .= '<span>卒業年度：</span>'.$graduate_html.'<br>';
        $graduate_year_meta_query = array('relation' => 'OR');
        foreach($graduate_years as $graduate_year){
            $form_html = str_replace('<input type="checkbox" name="graduate_year[]" value="'.$graduate_year.'" class="checkbox">','<input type="checkbox" name="graduate_year[]" value="'.$graduate_year.'" class="checkbox" checked="checked">',$form_html);
            array_push($graduate_year_meta_query, array(
                'key'       => 'graduate_year',
                'value'     => $graduate_year,
                'compare'   => '='
            ));
        }
        array_push($meta_query_args, $graduate_year_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 職種による絞り込み
    if (isset($_GET['occupation']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $occupations = $_GET["occupation"];
        $condition_html .= '<span>職種：</span>';
        $occupation_meta_query = array('relation' => 'OR');
        foreach($occupations as $occupation){
            $condition_html .= '<div class="card-category__scout">'.$occupation.'</div>';
            $form_html = str_replace('<input type="checkbox" name="occupation[]" value="'.$occupation.'" class="checkbox">','<input type="checkbox" name="occupation[]" value="'.$occupation.'" class="checkbox" checked="checked">',$form_html);
            array_push($occupation_meta_query, array(
                'key'       => 'future_occupations',
                'value'     => $occupation,
                'compare'   => 'LIKE'
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $occupation_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 留学経験による絞り込み
    if (isset($_GET['studied_abroad']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $studied_abroads = $_GET["studied_abroad"];
        $form_html = str_replace('<input type="radio" name="studied_abroad[]" value="'.$studied_abroads[0].'" class="radio">','<input type="radio" name="studied_abroad[]" value="'.$studied_abroads[0].'" class="radio" checked="checked">',$form_html);
        $studied_abroad_meta_query = array('relation' => 'OR');
        for($i=0;$i<(5-$studied_abroads[0]);$i++){
            switch($i){
                case 0:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '１年以上',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 1:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '６ヶ月以上1年未満',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 2:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '３ヶ月以上６ヶ月未満',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 3:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '3ヶ月未満',
                        'compare'   => 'LIKE'
                    ));
                break;
                case 4:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '経験なし',
                        'compare'   => 'LIKE'
                    ));
                    break;
            }
        }
        switch($studied_abroads[0]){
            case 1:
                $condition_html .= '<span>留学経験：</span><div class="card-category__scout">期間は問わないが経験あり</div><br>';
            break;
            case 2:
                $condition_html .= '<span>留学経験：</span><div class="card-category__scout">３ヶ月以上</div><br>';
            break;
            case 3:
                $condition_html .= '<span>留学経験：</span><div class="card-category__scout">６ヶ月以上</div><br>';
            break;
            case 4:
                $condition_html .= '<span>留学経験：</span><div class="card-category__scout">1年以上</div><br>';
            break;
        }
        array_push($meta_query_args, $studied_abroad_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

  // 学生時代の経験による絞り込み
    if (isset($_GET['student_experience']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $student_experiences = $_GET["student_experience"];
        $condition_html .= '<span>学生時代の経験：</span>';
        $student_experience_meta_query = array('relation' => 'OR');
        foreach($student_experiences as $student_experience){
            $form_html = str_replace('<input type="checkbox" name="student_experience[]" value="'.$student_experience.'" class="checkbox">','<input type="checkbox" name="student_experience[]" value="'.$student_experience.'" class="checkbox" checked="checked">',$form_html);
            $condition_html .= '<div class="card-category__scout">'.$student_experience.'</div>';
            array_push($student_experience_meta_query, array(
                'key'       => 'student_experience',
                'value'     => $student_experience,
                'compare'   => 'LIKE'
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $student_experience_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
    // 大学時代のコミュニティによる絞り込み
    if (isset($_GET['univ_community']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $univ_communities = $_GET["univ_community"];
        $condition_html .= '<span>大学時代のコミュニティ：</span>';
        $univ_community_meta_query = array('relation' => 'OR');
        foreach($univ_communities as $univ_community){
            $form_html = str_replace('<input type="checkbox" name="univ_community[]" value="'.$univ_community.'" class="checkbox">','<input type="checkbox" name="univ_community[]" value="'.$univ_community.'" class="checkbox" checked="checked">',$form_html);
            $condition_html .= '<div class="card-category__scout">'.$univ_community.'</div>';
            array_push($univ_community_meta_query, array(
                'key'       => 'univ_community',
                'value'     => $univ_community,
                'compare'   => 'LIKE'
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $univ_community_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
    // 長期インターン経験による絞り込み
    if (isset($_GET['internship_experiences']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $internship_experiences = $_GET["internship_experiences"];
        $form_html = str_replace('<input type="radio" name="internship_experiences[]" value="'.$internship_experiences[0].'" class="radio">','<input type="radio" name="internship_experiences[]" value="'.$internship_experiences[0].'" class="radio" checked="checked">',$form_html);
        $internship_experiences_meta_query = array('relation' => 'OR');
        for($i=0;$i<=(4-$internship_experiences[0]);$i++){
            switch($i){
                case 0:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '1年以上',
                    'compare'   => 'LIKE'
                ));
                break;
                case 1:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '6ヶ月以上1年未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 2:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '3ヶ月以上6ヶ月未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 3:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '1ヶ月以上3ヶ月未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 4:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => 'なし',
                    'compare'   => 'LIKE'
                ));
                break;
            }
        }
        array_push($meta_query_args, $internship_experiences_meta_query);
        switch($internship_experiences[0]){
            case 1:
                $condition_html .= '<span>長期インターン経験経験：</span><div class="card-category__scout">１ヶ月以上</div><br>';
            break;
            case 2:
                $condition_html .= '<span>長期インターン経験経験：</span><div class="card-category__scout">３ヶ月以上</div><br>';
            break;
            case 3:
                $condition_html .= '<span>長期インターン経験：</span><div class="card-category__scout">６ヶ月以上</div><br>';
            break;
            case 4:
                $condition_html .= '<span>長期インターン経験経験：</span><div class="card-category__scout">1年以上</div><br>';
            break;
        }
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
  // 興味のある業界による絞り込み
    if (isset($_GET['bussiness_type']) and(!empty($_GET['bussiness_type']))) {
        $search_count += 1;
        $search_total_count += 1;
        $bussiness_types = $_GET["bussiness_type"];
        $condition_html .= '<span>業界：</span>';
        $bussiness_type_meta_query = array('relation' => 'OR');
        foreach($bussiness_types as $bussiness_type){
            $form_html = str_replace('<input type="checkbox" name="bussiness_type[]" value="'.$bussiness_type.'" class="checkbox">','<input type="checkbox" name="bussiness_type[]" value="'.$bussiness_type.'" class="checkbox" checked="checked">',$form_html);
            $condition_html .= '<div class="card-category__scout">'.$bussiness_type.'</div>';
            array_push($bussiness_type_meta_query, array(
                'key'       => 'bussiness_type',
                'value'     => $bussiness_type,
                'compare'   => 'LIKE'
            ));
        }
        $condition_html .= '<br>';
        array_push($meta_query_args, $bussiness_type_meta_query);
    }


    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
    //プロフィールスコアによる絞り込み
    if(isset($_GET['profile_score'])){
        $search_count += 1;
        $search_total_count += 1;
        $profile_score = $_GET['profile_score'];
        $form_html = str_replace('<option value="'.$profile_score.'">','<option value="'.$profile_score.'" selected>',$form_html);
        $condition_html .= '<span>プロフィールスコア：</span><div class="card-category__scout">'.$profile_score.'以上</div><br>';
        $profile_score_query = array(
            'key'       => 'user_profile_total_score',
            'value'     => $profile_score,
            'compare'   => '>=',
            'type'=>'NUMERIC'
        );
        array_push($meta_query_args, $profile_score_query);
    }


    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
  //フリーワード検索による絞り込み
    if (isset($_GET['freeword']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $freeword =  my_esc_sql($_GET['freeword']);
        $form_html = str_replace('<input type="text" name="freeword" class="search-field_test" placeholder="フリーワードから探す">','<input type="text" name="freeword" class="search-field_test" placeholder="フリーワードから探す" value="'.$freeword.'">',$form_html);
        $condition_html .= '<span>フリーワード：</span><div class="card-category__scout">'.$freeword.'</div><br>';
        if(strlen($freeword)>1){
            array_push ($meta_query_args,
                array('relation' => 'OR',
                    array(
                        'key'     => 'last_name',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'first_name',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'last_name_ruby',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'first_name_ruby',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'region',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'highschool',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'seminar',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'studied_ab_place',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'lang_pr',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'skill',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'community_univ',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'internship_company',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'experience_internship',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'self_internship_PR',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'gender',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'university',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'faculty',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'faculty_lineage',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'school_year',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'graduate_year',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'programming_languages',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'skill_dev',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'own_pr',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'univ_community',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'student_experience',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'bussiness_type',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'future_occupations',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    )
                )
            );
        }
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }
    $programming_html = '';
    // プログラミングスキルによる絞り込み
    if(strpos($_SERVER['REQUEST_URI'],'programming') !== false){
        $languages_list = ['none','c','cpp','cs','go','java','js','kt','m','php','pl','py','r','rb','scala','swift','vb'];
        for($i=1;$i<=16;$i++){
            $language = $languages_list[$i];
            if ($_GET['programming_lang_lv_'.$language]!=0) {
                $search_count += 1;
                $search_total_count += 1;
                $skill[$i] = $_GET['programming_lang_lv_'.$language];
                $form_html = str_replace('<input type="range" name="programming_lang_lv_'.$language.'" value="0" min="0" max="5" step="1" oninput=document.getElementById("output'.$i.'").value=this.value>','<input type="range" name="programming_lang_lv_'.$language.'" value="'.$skill[$i].'" min="0" max="5" step="1" oninput=document.getElementById("output'.$i.'").value=this.value>',$form_html);
                $form_html = str_replace('<output id="output'.$i.'">0','<output id="output'.$i.'">'.$skill[$i].'',$form_html);
                $programming_html .= '<div class="card-category__scout">'.$language.'(星'.$skill[$i].')</div>';
                $skill_meta_query[$i] = array('relation' => 'OR');
                array_push($skill_meta_query[$i], array(
                    'key'       => 'programming_lang_lv_'.$language,
                    'value'     => $skill[$i],
                    'compare'   => '>='
                ));
                array_push($meta_query_args, $skill_meta_query[$i]);
                if($search_count == 3){
                    $args = array(
                        'blog_id'      => $GLOBALS['blog_id'],
                        'role'         => 'student',
                        'meta_query'   => $meta_query_args,
                        'fields'       => 'ID',
                    );
                  $students_ids = new WP_User_Query( $args );
                  if($search_total_count == 3 && $search_mail_count == 0){
                    $ids += $students_ids->get_results();
                  }else{
                    $ids = array_intersect($ids,$students_ids->get_results());
                  }
                  $search_count = 0;
                  $meta_query_args = array(
                    'relation' => 'AND', // オプション、デフォルト値は "AND"
                );
                }
            }
        }
        if(!empty($programming_html)){
            $condition_html .= '<span>プログラミングスキル：</span>'.$programming_html.'<br>';
        }
    }

    if($search_count > 0 || $search_total_count == 0){
        if($search_mail_count == 0){
            $args = array(
                'blog_id'      => $GLOBALS['blog_id'],
                'role'         => 'student',
                'meta_query'   => $meta_query_args,
                'fields'       => 'ID',
            );
          $students_ids = new WP_User_Query( $args );
          if($search_total_count < 4){
            $ids += $students_ids->get_results();
          }else{
            $ids = array_intersect($ids,$students_ids->get_results());
          }
          $search_count = 0;
          $meta_query_args = array(
            'relation' => 'AND', // オプション、デフォルト値は "AND"
        );
        }else {
            $args = array(
                'blog_id'      => $GLOBALS['blog_id'],
                'role'         => 'student',
                'meta_query'   => $meta_query_args,
                'fields'       => 'ID',
            );
            $students_ids = new WP_User_Query( $args );
            $ids = array_intersect($ids,$students_ids->get_results());
            $search_count = 0;
            $meta_query_args = array(
              'relation' => 'AND', // オプション、デフォルト値は "AND"
          );
        }
    }
    $company_id = wp_get_current_user()->ID;
    $scouted_user_ids = array();
    //スカウト済みかどうか
    if (!empty($_GET['scouted_or'])) {
        $scouted = $_GET['scouted_or'];
        if($scouted == 'not_yet'){
            $form_html = str_replace('<option value="not_yet">','<option value="not_yet" selected>',$form_html);
            $condition_html .= '<span>スカウトの有無：</span><div class="card-category__scout">未スカウト学生</div><br>';
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            foreach($scouted_users as $scouted_user){
                $user_id = get_user_by('login',$scouted_user)->ID;
                $scouted_user_ids[] = $user_id;
            }
            $scouted_user_ids = array_unique($scouted_user_ids);
            $ids = array_diff($ids, $scouted_user_ids);
            //indexを詰める
            $ids = array_values($ids);
        }
        if($scouted == 'already'){
            $form_html = str_replace('<option value="already">','<option value="already" selected>',$form_html);
            $condition_html .= '<span>スカウトの有無：</span><div class="card-category__scout">スカウト済み学生</div><br>';
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            foreach($scouted_users as $scouted_user){
                $user_id = get_user_by('login',$scouted_user)->ID;
                $scouted_user_ids[] = $user_id;
            }
            $scouted_user_ids = array_unique($scouted_user_ids);
            $ids = array_intersect($ids,$scouted_user_ids);
        }
    }

    if(count($ids)==0){
        $ids = [999999999];
    }

    $args = array(
        'include'      => $ids,
        'count_total'  => true,
    );
    $args += array('meta_key' => 'user_profile_total_score','orderby' => 'meta_value_num','order'=> 'DESC',);

    $user_login_name = wp_get_current_user()->data->user_login;

    $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
    $users_per_page = 20;
    if( $user_login_name == "kotaro" || $user_login_name == "TABATASYUNSUKE"){
        $users_per_page = 1000;
    }

    $args+=array(
        'number' => $users_per_page, // How many per page
        'paged' => $current_page // What page to get, starting from 1.
    );


    $roles=wp_get_current_user()->roles;


    //$result_html='' .'残りスカウトメール送信可能件数は'.view_remain_mail_num_func(wp_get_current_user()).'<br>';
    $result_html='';
    $students=new WP_User_Query( $args );//get_users($args);
    $company_name = wp_get_current_user()->data->display_name;
    if(in_array("company", $roles)){
	    $result_html='' .'今月のスカウトメール送信可能件数は'.view_remain_num_func(wp_get_current_user(),'remain-mail-num').'<br>';
    }
    
    //検索条件の表示
    $result_html .= '
        <table class="condition_table">
            <tbody>
            <tr>
                <th>検索条件</th>
                <td>'.$condition_html.'</td>
            </tr>
            </tbody>
        </table>';
    $result_html .= $form_html;
    $total_users = $students->get_total(); // How many users we have in total (beyond the current page)
    $num_pages = ceil($total_users / $users_per_page);
    if ($total_users < $users_per_page) {$users_per_page = $total_users;}

    $result_html.=paginate( $num_pages, $current_page, $total_users, $users_per_page);
    $result_html .= '<div class="cards-container">';
    if(in_array("company", $roles) ){
        $result_html .= '<form action="./scout_form" method="POST">';
    }
    if ( $students->get_results() ) foreach( $students->get_results() as $user )  {

        $user_id = $user->data->ID;
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
        $bussiness_types = get_user_meta($user_id,'bussiness_type',false)[0];
        $types_html = '';
        if(isset($bussiness_types)) {
            foreach($bussiness_types as $type) {
                if ($type === end($bussiness_types)) {
                    $types_html .= $type;
                }else{
                    $types_html .= $type.'/';
                }
            }
        }
        $self_internship_PR = get_user_meta($user_id,'self_internship_PR',false)[0];
        if(mb_strlen($self_internship_PR) > 100){
            $self_internship_PR = mb_substr(nl2br($self_internship_PR),0,100).'...';
          }
        $last_login = get_user_meta($user_id,'_um_last_login',false);
        $last_login_date = date('Y年m月d日',$last_login[0]).'<br>'.date('H時i分',$last_login[0]);
        $job_html = '';
        foreach($future_occupations as $future_occupation){
            if ($future_occupation === end($future_occupations)) {
                $job_html .= $future_occupation;
            }else{
                $job_html .= $future_occupation.'/';
            }
        }
        $email = get_user_by("id",$user_id)->data->user_email;
        $image_date = date("YmdHis");
        $upload_dir = wp_upload_dir();
        $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
        $profile_score = get_user_meta( $user_id, 'user_profile_total_score',false)[0];
        if(!file_exists($upload_file_name)){
            $photo = get_avatar($user_id);
        }
        else{
            $photo = '<img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar avatar-search lazyloaded scout__image__img">'; 
        }

        $user_graduate_year = get_user_meta($user_id,'graduate_year',false)[0];
        if(!empty($user_graduate_year)){
            $user_graduate_year = substr(strval($user_graduate_year),2,2).'卒';
        }
        if(in_array("company", $roles)){
            $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
            $user_name = $user->data->user_login;
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            if($scout_status["remain"]>0){
                $scout_html = '
                <div class="scout__check">
                    <div class="scout__check__wrap"><input type="checkbox" name="user_ids[]" value="'.$user_id.'" class="checkbox"><span></span></div>
                </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span></span>','<span>スカウト済み</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }else{
                $scout_html = '
                    <div class="scout__check">
                        <div class="scout__check__wrap"><span>上限に達しています</span></div>
                    </div>
                ';
                if(in_array($user_name,$scouted_users,false)){
                    $scout_html = str_replace('<span>上限に達しています</span>','<span>スカウト済み</br></br>上限に達しています</span>',$scout_html);
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card scout-already">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-already scout-engineer">';
                    }
                }else{
                    if($scout_status['status'] == '一般学生'){
                        $status_html =  '<div class="card scout__card">';
                    }else{
                        $status_html =  '<div class="card scout__card scout-engineer">';
                    }
                }
            }
        }else {
            $status_html = '<div class="card scout__card">';
            $scout_html = '
        ';
        }

        if( in_array("administrator", $roles) ){
            $mail_html = '<div class="scout__content scout__content_s scout__mail-field"><p>'.$email.'</p></div>';
            $touch_html = '<div class="scout__content scout__content_s"><a href="'.student_contact_form_link($user).'">接触記録を入力</a></div>';
        }
        $result_html .= '
            '.$status_html.'
                <div class="full-card-main scout__card__main">
                    <div class="scout__image">
                        <div class="scout__image__wrap">
                            <a href="/user?um_user='.$user->user_login.'" class="">
                                <div class="scout__image__container">
                                    <div class="scout__image__img__container"><noscript>'.$photo.'</noscript>'.$photo.'</div>
                                    <div class="scout__prof-score only-pc">'.$profile_score.'</div>
                                    <div class="scout__prof__base only-sp">
                                        <div class="scout__prof-score">
                                            <span class="scout__prof-score-num">'.$profile_score.'</span>
                                            <span class="scout__prof-score-text">Profile Score</span>
                                        </div>
                                        <p class="scout__name">'.esc_html( $user->user_login ) .'</p>
                                    </div>
                                </div>
                            </a>
                            <a href="/user?um_user='.$user->user_login.'" class="only-pc"><p class="scout__name">'.esc_html( $user->user_login ) .'</p></a>
                        </div>
                    </div>
                    <div class="scout__text">
                        <div class="scout__text__wrap">
                            <div class="scout__content scout__univ"><p>'.esc_html( get_univ_name($user)). esc_html( get_faculty_name($user)).'</p></div>
                            <div class="scout__content scout__content_s scout__base"><p>'.$gender.'/'.$user_graduate_year.'</p></div>
                            <div class="scout__content scout__content_s scout__occupations"><p>'.$job_html.'</p></div>
                            <div class="scout__content scout__content_s scout__business-field"><p>'.$types_html.'</p></div>
                            '.$mail_html.$touch_html.'
                            <div class="scout__content scout__pr"><p>'.$self_internship_PR.'</p></div>
                        </div>
                    </div>
                </div>
              '.$scout_html.'
            </div>
        ';
    }
    $result_html.= paginate( $num_pages, $current_page, $total_users, $users_per_page);
    if(in_array("company", $roles)){
        $result_html .= '
        <div class="fixed-buttom hidden">
            <button class="button button-apply">まとめてスカウトメールを送る</button>
        </div></form>';
    }
    $result_html .= '</div>';
    if(isset($_GET['redirected'])){
        echo '<div class="message__scout" role="alert" aria-hidden="true" style="">ありがとうございます。メッセージは送信されました。</div>';
    }
    return do_shortcode($result_html);
}
add_shortcode('student_search_result','student_search_result_func');

function scout_manage_func(){
    $company = wp_get_current_user();
    $company_user_login=$company->data->display_name;
    $scouted_user = do_shortcode('[cfdb-value form="企業スカウトメール送信フォーム" filter="your-name='.$company_user_login.'" show="partner-id"]');
    $scouted_user  = str_replace(array(" ", "　"), "", $scouted_user);
    $scouted_users = explode(",",$scouted_user);
    return $scouted_users;
}

function Scout_Students_Link(){
    if(isset($_POST['user_ids'])){
        $vals = get_remain_num_func(wp_get_current_user(),'remain-mail-num');
        $user_ids = $_POST['user_ids'];
        $link = '';
        $normal_count = 0;
        $engineer_count = 0;
        foreach($user_ids as $user_id){
            $user = get_user_by('id',$user_id);
            $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
            if($scout_status['status'] == '一般学生'){
                $normal_count += 1;
            }else{
                $engineer_count += 1;
            }
        }
        if (($vals['engineer']>= $engineer_count) && ($vals['general']>= $normal_count)){
            $html = 'safe';
        }else {
            $html = 'miss';
        }
    }
    echo $html;
    die();
}
add_action( 'wp_ajax_scout_students_link', 'Scout_Students_Link' );
add_action( 'wp_ajax_nopriv_scout_students_link', 'Scout_Students_Link');


function Ajax_Search_Student(){
    $search_count = 0;
    $search_total_count = 0;
    $ids = array();
    $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );

    $search_mail_count = 0;
    if (isset($_POST['mail'])) {
        $search_mail_count = 1;
        $builds_mail_meta_query = array('relation' => 'OR');
        array_push($builds_mail_meta_query, array(
            'key'       => 'mail_settings',
            'value'     => 'Buildsからのメール配信を希望しない',
            'compare'   => 'NOT LIKE'
        ));
        array_push($builds_mail_meta_query, array(
            'key'       => 'mail_settings',
            'compare' => 'NOT EXISTS'
        ));
        array_push($meta_query_args, $builds_mail_meta_query);
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      $ids += $students_ids->get_results();
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }


    if(!empty($_POST['gender'])) {
      $gender = $_POST['gender'];
      $search_count += 1;
      $search_total_count += 1;
      if($gender == 'male'){
        $gender = '男性';
      }
    if($gender == 'female'){
        $gender = '女性';
    }
      array_push (
          $meta_query_args,
          array(
              'key'     => 'gender',
              'value'   =>  $gender,
              'compare' => 'LIKE'
          )
      );
    }

    if (!empty($_POST['login']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $last_login_value = $_POST["login"];
        if($last_login_value == 30){
            $compare_time = date("Y/m/d H:i:s",strtotime("-1 month"));
        }else{
            $compare_time = date("Y/m/d H:i:s",strtotime("-".$last_login_value." day"));
        }
        $compare_unixtime = strtotime($compare_time);
        array_push($meta_query_args, array(
            'key'       => '_um_last_login',
            'value'     => $compare_unixtime,
            'compare'   => '>'
        ));
    }

    // 活動状況による絞り込み
    if (!empty($_POST['degree_of_internship_interest']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $degree_of_internship_interest = $_POST["degree_of_internship_interest"];
            if($degree_of_internship_interest==1){
            $degree_of_internship_interest=array('今すぐにでも長期インターンをやってみたい');
        }
            if($degree_of_internship_interest==2){
            $degree_of_internship_interest=array('話を聞いてみて、もし自分に合いそうなのであれば長期インターンをやってみたい');
        }
            if($degree_of_internship_interest==3){
            $degree_of_internship_interest=array('全く興味がない');
        }
        array_push($meta_query_args, array(
            'key'       => 'degree_of_internship_interest',
            'value'     => $degree_of_internship_interest[0],
            'compare'   => '='
        ));
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // ベンチャー企業への就職意欲による絞り込み
    if (!empty($_POST['will_venture']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $will_venture = $_POST["will_venture"];
            if($will_venture==1){
            $will_venture=array('ファーストキャリアはベンチャー企業が良いと思っている');
        }
            if($will_venture==2){
            $will_venture=array('自分に合ったベンチャー企業ならば就職してみたい');
        }
            if($will_venture==3){
            $will_venture=array('ベンチャー企業に少しは興味がある');
        }
            if($will_venture==4){
            $will_venture=array('ベンチャー企業には全く興味がない');
        }
        array_push($meta_query_args, array(
            'key'       => 'will_venture',
            'value'     => $will_venture[0],
            'compare'   => '='
        ));
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
        $students_ids = new WP_User_Query( $args );
        if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
        }else{
        $ids = array_intersect($ids,$students_ids->get_results());
        }
        $search_count = 0;
        $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    //プロフィールスコアによる絞り込み
    if(!empty($_POST['profile_score'])){
        $search_count += 1;
        $search_total_count += 1;
        $profile_score = $_POST['profile_score'];
        $profile_score_query = array(
            'key'       => 'user_profile_total_score',
            'value'     => $profile_score,
            'compare'   => '>=',
            'type'=>'NUMERIC'
        );
        array_push($meta_query_args, $profile_score_query);
    }


    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
        $students_ids = new WP_User_Query( $args );
        if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
        }else{
        $ids = array_intersect($ids,$students_ids->get_results());
        }
        $search_count = 0;
        $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 大学による絞り込み
    if (isset($_POST['university']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $universities = $_POST["university"];
        $univ_meta_query = array('relation' => 'OR');
        if(in_array(339,$universities)){
            $university_sub = "東京大学";
            array_push($universities,$university_sub);
        }
        if(in_array(341,$universities)){
            $university_sub = "東京工業大学";
            array_push($universities,$university_sub);
        }
        if(in_array(485,$universities)){
            $university_sub = "一橋大学";
            array_push($universities,$university_sub);
        }
        if(in_array(343,$universities)){
            $university_sub = "東京外語大学";
            array_push($universities,$university_sub);
        }
        if(in_array(44,$universities)){
            $university_sub = "お茶の水女子大学";
            array_push($universities,$university_sub);
        }
        if(in_array(586,$universities)){
            $university_sub = "横浜国立大学";
            array_push($universities,$university_sub);
        }
        if(in_array(602,$universities)){
            $university_sub = "早稲田大学";
            array_push($universities,$university_sub);
        }
        if(in_array(166,$universities)){
            $university_sub = "慶應義塾大学";
            array_push($universities,$university_sub);
        }
        if(in_array(216,$universities)){
            $university_sub = "上智大学";
            array_push($universities,$university_sub);
        }
        if(in_array(354,$universities)){
            $university_sub = "東京理科大学";
            array_push($universities,$university_sub);
        }
        if(in_array(173,$universities)){
            $university_sub = "国際基督教大学";
            array_push($universities,$university_sub);
        }
        if(in_array(566,$universities)){
            $university_sub = "明治大学";
            array_push($universities,$university_sub);
        }
        if(in_array(1,$universities)){
            $university_sub = "青山学院大学";
            array_push($universities,$university_sub);
        }
        if(in_array(592,$universities)){
            $university_sub = "立教大学";
            array_push($universities,$university_sub);
        }
        if(in_array(310,$universities)){
            $university_sub = "中央大学";
            array_push($universities,$university_sub);
        }
        if(in_array(532,$universities)){
            $university_sub = "法政大学";
            array_push($universities,$university_sub);
        }
        foreach($universities as $university){
            array_push($univ_meta_query, array(
                'key'       => 'university',
                'value'     => $university,
                'compare'   => '='
            ));
        }
        array_push($meta_query_args, $univ_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
        $students_ids = new WP_User_Query( $args );
        if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
        }else{
        $ids = array_intersect($ids,$students_ids->get_results());
        }
        $search_count = 0;
        $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 学部系統による絞り込み
    if (isset($_POST['faculty_lineage']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $faculty_lineages = $_POST["faculty_lineage"];
        $faculty_lineage_meta_query = array('relation' => 'OR');
        foreach($faculty_lineages as $faculty_lineage){
            array_push($faculty_lineage_meta_query, array(
                'key'       => 'faculty_lineage',
                'value'     => $faculty_lineage,
                'compare'   => '='
            ));
        }
        array_push($meta_query_args, $faculty_lineage_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
        $students_ids = new WP_User_Query( $args );
        if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
        }else{
        $ids = array_intersect($ids,$students_ids->get_results());
        }
        $search_count = 0;
        $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 卒業年度による絞り込み
    if (isset($_POST['graduate_year']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $graduate_years = $_POST["graduate_year"];
        if(in_array(2021,$graduate_years)){
            $graduate_year_sub = "2021(2019年4月時点で大学3年生/大学院1年生)";
        }
        if(in_array(2022,$graduate_years)){
            $graduate_year_sub = "2022(2019年4月時点で大学2年生)";
        }
        if(in_array(2023,$graduate_years)){
            $graduate_year_sub = "2023(2019年4月時点で大学1年生)";
        }
        if(in_array(2024,$graduate_years)){
            $graduate_year_sub = "2024(2020年4月時点で大学1年生)";
        }
        $graduate_year_meta_query = array('relation' => 'OR');
        foreach($graduate_years as $graduate_year){
            array_push($graduate_year_meta_query, array(
                'key'       => 'graduate_year',
                'value'     => $graduate_year,
                'compare'   => '='
            ));
        }
        array_push($meta_query_args, $graduate_year_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
        $students_ids = new WP_User_Query( $args );
        if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
        }else{
        $ids = array_intersect($ids,$students_ids->get_results());
        }
        $search_count = 0;
        $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 職種による絞り込み
    if (isset($_POST['occupation']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $occupations = $_POST["occupation"];
        $occupation_meta_query = array('relation' => 'OR');
        foreach($occupations as $occupation){
            array_push($occupation_meta_query, array(
                'key'       => 'future_occupations',
                'value'     => $occupation,
                'compare'   => 'LIKE'
            ));
        }
        array_push($meta_query_args, $occupation_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 留学経験による絞り込み
    if (isset($_POST['studied_abroad']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $studied_abroads = $_POST["studied_abroad"];
        $studied_abroad_meta_query = array('relation' => 'OR');
        for($i=0;$i<(5-$studied_abroads[0]);$i++){
            switch($i){
                case 0:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '１年以上',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 1:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '６ヶ月以上1年未満',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 2:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '３ヶ月以上６ヶ月未満',
                        'compare'   => 'LIKE'
                    ));
                    break;
                case 3:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '3ヶ月未満',
                        'compare'   => 'LIKE'
                    ));
                break;
                case 4:
                    array_push($studied_abroad_meta_query, array(
                        'key'       => 'studied_abroad',
                        'value'     => '経験なし',
                        'compare'   => 'LIKE'
                    ));
                    break;
            }
        }
        array_push($meta_query_args, $studied_abroad_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

  // 学生時代の経験による絞り込み
    if (isset($_POST['student_experience']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $student_experiences = $_POST["student_experience"];
        $student_experience_meta_query = array('relation' => 'OR');
        foreach($student_experiences as $student_experience){
            array_push($student_experience_meta_query, array(
                'key'       => 'student_experience',
                'value'     => $student_experience,
                'compare'   => 'LIKE'
            ));
        }
        array_push($meta_query_args, $student_experience_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 大学時代のコミュニティによる絞り込み
    if (isset($_POST['univ_community']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $univ_communities = $_POST["univ_community"];
        $univ_community_meta_query = array('relation' => 'OR');
        foreach($univ_communities as $univ_community){
            array_push($univ_community_meta_query, array(
                'key'       => 'univ_community',
                'value'     => $univ_community,
                'compare'   => 'LIKE'
            ));
        }
        array_push($meta_query_args, $univ_community_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 長期インターン経験による絞り込み
    if (isset($_POST['internship_experiences']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $internship_experiences = $_POST["internship_experiences"];
        $internship_experiences_meta_query = array('relation' => 'OR');
        for($i=0;$i<=(4-$internship_experiences[0]);$i++){
            switch($i){
                case 0:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '1年以上',
                    'compare'   => 'LIKE'
                ));
                break;
                case 1:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '6ヶ月以上1年未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 2:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '3ヶ月以上6ヶ月未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 3:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => '1ヶ月以上3ヶ月未満',
                    'compare'   => 'LIKE'
                ));
                break;
                case 4:
                array_push($internship_experiences_meta_query, array(
                    'key'       => 'internship_experiences',
                    'value'     => 'なし',
                    'compare'   => 'LIKE'
                ));
                break;
            }
        }
        array_push($meta_query_args, $internship_experiences_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // 興味のある業界による絞り込み
    if (isset($_POST['bussiness_type']) and(!empty($_POST['bussiness_type']))) {
        $search_count += 1;
        $search_total_count += 1;
        $bussiness_types = $_POST["bussiness_type"];
        $bussiness_type_meta_query = array('relation' => 'OR');
        foreach($bussiness_types as $bussiness_type){
            array_push($bussiness_type_meta_query, array(
                'key'       => 'bussiness_type',
                'value'     => $bussiness_type,
                'compare'   => 'LIKE'
            ));
        }
        array_push($meta_query_args, $bussiness_type_meta_query);
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    //フリーワード検索による絞り込み
    if (!empty($_POST['sw']) ) {
        $search_count += 1;
        $search_total_count += 1;
        $freeword =  my_esc_sql($_POST['sw'][0]);
        if(strlen($freeword)>1){
            array_push ($meta_query_args,
                array('relation' => 'OR',
                    array(
                        'key'     => 'last_name',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'first_name',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'last_name_ruby',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'first_name_ruby',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'region',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'highschool',
                        'value'   => esc_attr($freeword),
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key'     => 'seminar',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'studied_ab_place',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'lang_pr',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'skill',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'community_univ',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'internship_company',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'experience_internship',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'self_internship_PR',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'gender',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'university',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'faculty',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'faculty_lineage',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'school_year',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'graduate_year',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'programming_languages',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'skill_dev',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'own_pr',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'univ_community',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'student_experience',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'bussiness_type',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    ),
                    array(
                        'key'     => 'future_occupations',
                        'value'   => esc_attr($freeword),
                        'compare' =>'LIKE'
                    )
                )
            );
        }
    }

    if($search_count == 3){
        $args = array(
            'blog_id'      => $GLOBALS['blog_id'],
            'role'         => 'student',
            'meta_query'   => $meta_query_args,
            'fields'       => 'ID',
        );
      $students_ids = new WP_User_Query( $args );
      if($search_total_count == 3 && $search_mail_count == 0){
        $ids += $students_ids->get_results();
      }else{
        $ids = array_intersect($ids,$students_ids->get_results());
      }
      $search_count = 0;
      $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );
    }

    // プログラミングスキルによる絞り込み
    $languages_list = ['c','cpp','cs','go','java','js','kt','m','php','pl','py','r','rb','scala','swift','vb'];
    $languages_score = $_POST['programming'];
    for($i=0;$i<=15;$i++){
        $language = $languages_list[$i];
        if ($languages_score[$i]!=0) {
            $search_count += 1;
            $search_total_count += 1;
            $skill_meta_query[$i] = array('relation' => 'OR');
            array_push($skill_meta_query[$i], array(
                'key'       => 'programming_lang_lv_'.$language,
                'value'     => $languages_score[$i],
                'compare'   => '>='
            ));
            array_push($meta_query_args, $skill_meta_query[$i]);
            if($search_count == 3){
                $args = array(
                    'blog_id'      => $GLOBALS['blog_id'],
                    'role'         => 'student',
                    'meta_query'   => $meta_query_args,
                    'fields'       => 'ID',
                );
                $students_ids = new WP_User_Query( $args );
                if($search_total_count == 3 && $search_mail_count == 0){
                $ids += $students_ids->get_results();
                }else{
                $ids = array_intersect($ids,$students_ids->get_results());
                }
                $search_count = 0;
                $meta_query_args = array(
                'relation' => 'AND', // オプション、デフォルト値は "AND"
            );
            }
        }
    }

    if($search_count > 0 || $search_total_count == 0){
        if($search_mail_count == 0){
            $args = array(
                'blog_id'      => $GLOBALS['blog_id'],
                'role'         => 'student',
                'meta_query'   => $meta_query_args,
                'fields'       => 'ID',
            );
          $students_ids = new WP_User_Query( $args );
          if($search_total_count < 4){
            $ids += $students_ids->get_results();
          }else{
            $ids = array_intersect($ids,$students_ids->get_results());
          }
          $search_count = 0;
          $meta_query_args = array(
            'relation' => 'AND', // オプション、デフォルト値は "AND"
        );
        }else {
            $args = array(
                'blog_id'      => $GLOBALS['blog_id'],
                'role'         => 'student',
                'meta_query'   => $meta_query_args,
                'fields'       => 'ID',
            );
            $students_ids = new WP_User_Query( $args );
            $ids = array_intersect($ids,$students_ids->get_results());
            $search_count = 0;
            $meta_query_args = array(
              'relation' => 'AND', // オプション、デフォルト値は "AND"
          );
        }
    }
    $company_id = wp_get_current_user()->ID;
    $scouted_user_ids = array();
    //スカウト済みかどうか
    if (!empty($_POST['scouted_or'])) {
        $scouted = $_POST['scouted_or'];
        if($scouted == 'not_yet'){
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            foreach($scouted_users as $scouted_user){
                $user_id = get_user_by('login',$scouted_user)->ID;
                $scouted_user_ids[] = $user_id;
            }
            $scouted_user_ids = array_unique($scouted_user_ids);
            $ids = array_diff($ids, $scouted_user_ids);
            //indexを詰める
            $ids = array_values($ids);
        }
        if($scouted == 'already'){
            $scouted_users = get_user_meta($company_id,'scouted_users',false)[0];
            foreach($scouted_users as $scouted_user){
                $user_id = get_user_by('login',$scouted_user)->ID;
                $scouted_user_ids[] = $user_id;
            }
            $scouted_user_ids = array_unique($scouted_user_ids);
            $ids = array_intersect($ids,$scouted_user_ids);
        }
    }
    $html = '（'.count($ids).'件ヒット）';
    echo $html;
    die();
}
add_action( 'wp_ajax_ajax_search_student', 'Ajax_Search_Student' );
add_action( 'wp_ajax_nopriv_ajax_search_student', 'Ajax_Search_Student' );


function mail_many(){
    $motourl = $_SERVER['HTTP_REFERER'];
    $user_ids = array();
    $html = '';
    $text = '';
    $submit = '';
    $subject = '';
    $submit_over = '';
    $login_user_names = '';
    $name_array = array();
    if(isset($_POST['user_ids'])){
        for ($i=0;$i<count($_POST['user_ids']); $i++){
            $user_ids[] = $_POST['user_ids'][$i];
            $user_id = $_POST['user_ids'][$i];
            $user = get_user_by('id',$user_id);
            $user_email = $user->data->user_email;
            $user_login_name = $user->data->user_login;
            if($i == 0){
                $html .= do_shortcode('[contact-form-7 id="1583" title="企業スカウトメール送信フォーム" html_id="scout_test'.$i.'"]');
            }
            else{
                $html .= do_shortcode('[contact-form-7 id="1583" title="企業スカウトメール送信フォーム" html_id="scout_test'.$i.'" html_class="hidden"]');
            }
            $html = str_replace('name="partner-email" value="" size="40"','name="partner-email" value="'.$user_email.'" size="40"',$html);
            $html = str_replace('name="partner-id" value="" size="40"','name="partner-id" value="'.$user_login_name.'" size="40"',$html);
            $submit .= '
            $("#scout_test'.$i.'").submit();
            ';
            $login_user_names .= $user_login_name.'';
            if($i != count($_POST['user_ids']-1)){
                $login_user_names .= ', ';
            }
            $name_array[] = $user_login_name;
            if($i>0){
                $text .= '$("#scout_test'.$i.' .wpcf7-textarea").val(text);';
                $subject .= '$("#scout_test'.$i.' .your-subject").val(subject);';
            }
        }
    }
    $name_array = json_encode($name_array);
    $partner_id = '
    <p>
        <label class="scout__form__to__content">
            <span>宛先</span>
            <span class="wpcf7-form-control-wrap">
                <input type="text" name="partner-id" value="'.$login_user_names.'" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required scout__form__ele scout__form__to__ele" readonly="readonly" aria-required="true" aria-invalid="false">
            </span>
        </label>
    </p>';
    $html = str_replace('<label class="partner-id">','<label class="partner-id hidden">',$html);
    $html .= '<div class="scout__back"><a href="'.$motourl.'" class="back scout__back__btn">検索結果に戻る</a></div>';
    $html = str_replace('name="your-message"','name="your-message" placeholder="ここから本文"',$html);
    $vals = get_remain_num_func(wp_get_current_user(),'remain-mail-num');
    $vals_en = $vals['engineer'];
    $vals_ge = $vals['general'];
    $normal_count = 0;
    $engineer_count = 0;
    foreach($user_ids as $user_id){
        $user = get_user_by('id',$user_id);
        $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
        if($scout_status['status'] == '一般学生'){
            $normal_count += 1;
        }else{
            $engineer_count += 1;
        }
    }
    $re_count_n = $vals_ge - $normal_count;
    $re_count_e = $vals_en - $engineer_count;
    $script = '
    <script type="text/javascript">
    jQuery(function($){
        $(".partner-id").after(\''.$partner_id.'\');
    });
    jQuery(function($){
        $("#scout_test0 .wpcf7-textarea").keyup(function(){
            var text = $(this).val();
            '.$text.'
        });
    });
    jQuery(function($){
        $("#scout_test0 .your-subject").keyup(function(){
            var subject = $(this).val();
            if (subject != "") {
            '.$subject.'
        }
        });
    });
    jQuery(function($){
        $(".scout_test").click(function(event) {
            event.preventDefault();
            $(this).off("submit");//一旦submitをキャンセルして、
            $(this).css("pointer-events","none");
            $(".wpcf7-response-output").addClass("hidden");
            const startTime = performance.now();
            '.$submit.'
            const endTime = performance.now(); // 終了時間
            console.log(endTime - startTime); // 何ミリ秒かかったかを表示する
            var scouted_user_name = '.$name_array.';
            var re_count_n = '.$re_count_n.';
            var re_count_e = '.$re_count_e.';
            $.ajax({
                type: "POST",
                url: ajaxurl,
                data: {
                    "action":"update_scouted_user",
                    "name_array":scouted_user_name,
                    "re_count_n":re_count_n,
                    "re_count_e":re_count_e,
                },
                success: function( response ){
                    console.log("成功!");
                },
                error: function( response ){
                   console.log("失敗!");
                }
            });
            return false;
        });
    });
    </script>
    '.$html;
    return $script;
}
add_shortcode('mail_many','mail_many');
?>