<?php
function admin_print_r($content, $tf){
    if(current_user_can( 'administrator' )){
    return print_r($content, $tf);
    }
    return '';
}

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
    $home_url =esc_url( home_url( ));
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
        }
    </script>
    <form role="search" method="get" class="search-form" action="'.$home_url.'/scout_result/">
        <div class="tabs">
            <input id="all" type="radio" name="tab_item" checked>
                <label class="tab_item" for="all">基本情報</label>
            <input id="programming" type="radio" name="tab_item">
                <label class="tab_item" for="programming">スキル</label>
            <input id="design" type="radio" name="tab_item">
                <label class="tab_item" for="design">客観評価</label>
            <div class="tab_content" id="all_content">
			<p>フリーワード検索:</P>
    <div class="btn-group btn-group" data-toggle="buttons">
        <label class="btn active">
            <input type="text" name="freeword">
        </label>
    </div>
                <div class="tab_content_description">
                    <p>学生ステータス</p>
                    <table>
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
                                        <option value="">指定なし</option>
                                        <option value="1">1日以内</option>
                                        <option value="3">3日以内</option>
                                        <option value="7">1週間以内</option>
                                        <option value="14">2週間以内</option>
                                        <option value="30">1ヶ月以内</option>
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
                        </tbody>
                    </table>
                    <hr> 大学:
                    <div class="btn-group btn-group" data-toggle="buttons">
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="北海道大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 北海道大学</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="university[]" value="東北大学" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 東北大学</span>
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
                    <hr> 学部系統:
                    <div class="btn-group btn-group" data-toggle="buttons">
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
                    <hr> 卒業年度:
                    <div class="btn-group btn-group" data-toggle="buttons">
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2020" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 20卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2021" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 21卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2022" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 22卒</span>
                        </label>
                        <label class="btn active">
                            <input type="checkbox" name="graduate_year[]" value="2023" class="checkbox"><i class="fa fa-square-o fa-2x"></i><i class="fa fa-check-square-o fa-2x"></i><span> 23卒</span>
                        </label>
                    </div>
                    <hr> 職種:
    <div class="btn-group btn-group" data-toggle="buttons">
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="エンジニア" class="checkbox"><span> エンジニア</span>
        </label>
        <label class="btn active">
            <input type="checkbox" name="occupation[]" value="デザイナー" class="checkbox"><span> デザイナー</span>
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
	<hr> 留学経験:
    <div class="btn-group btn-group" data-toggle="buttons">
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
	<hr> 学生時代の経験:
    <div class="btn-group btn-group" data-toggle="buttons">
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
	<hr> 大学時代のコミュニティ:
    <div class="btn-group btn-group" data-toggle="buttons">
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
	<hr> 長期インターン経験:
    <div class="btn-group btn-group" data-toggle="buttons">
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
	<hr> 興味のある業界:
    <div class="btn-group btn-group" data-toggle="buttons">
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
    <div align="right">
        <i class="material-icons" onclick="removeCheck()">refresh</i>
    </div><br>';

  if(in_array("administrator", $user_roles)){
    $search_form_html.=
    '<div align="right">
        <label class="btn active">
            <input type="checkbox" name="mail_can_send" value="mail_can_send" class="checkbox"><span class="builds_mail">  Buildsからのメール配信希望者 </span>
        </label>
    </div><br>';
  }
  $search_form_html.= '
                    <div>
                        <input type="submit" value="検索" class="um-button um-alt" id="um-submit-btn">
                    </div>
                </div>
            </div>
            <div class="tab_content" id="programming_content">
                <div class="tab_content_description">
                    <p>プログラミングスキル:</P>
                    <table dir="ltr" border="1" cellspacing="0" cellpadding="0">
                        <colgroup>
                        <col width="100">
                        <col width="100"></colgroup>
                        <tbody>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;★1つ&quot;}">★1つ</td>
                                <td style="width: 338px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;独学(授業等含む)で学んだ程度で、実装の経験はない&quot;}">独学(授業等含む)で学んだ程度で、実装の経験はない</td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;★2つ&quot;}">★2つ</td>
                                <td style="width: 338px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;用語や文法は理解できるが他の人の指導は必要&quot;}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>用語や文法は理解できるが他の人の指導は必要</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;★3つ&quot;}">★3つ</td>
                                <td style="width: 338px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;用語や文法は理解でき、開発した経験がある&quot;}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>用語や文法は理解でき、開発した経験がある</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;★4つ&quot;}">★4つ</td>
                                    <td style="width: 338px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;フレームワークやライブラリ等を利用して、開発した経験がある&quot;}" data-sheets-formula="=R[0]C[-6]">
                                        <div>
                                            <div>フレームワークやライブラリ等を利用して、開発した経験がある</div>
                                        </div>
                                    </td>
                                </tr>
                            <tr>
                                <td style="width: 98px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;★5つ&quot;}">★5つ</td>
                                <td style="width: 338px;" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;その言語(フレームワーク等含む)を利用して一人でサービスを作ることができる&quot;}" data-sheets-formula="=R[0]C[-6]">
                                    <div>
                                        <div>その言語(フレームワーク等含む)を利用して一人でサービスを作ることができる</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn-group btn-group" data-toggle="buttons">
                        <label class="btn active">
                            <span class="programming_lang_name"> C言語  </span><input type="range" name="programming_lang_lv_c" value="0" min="0" max="5" step="1" oninput=document.getElementById("output1").value=this.value>
                            <output id="output1">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> C#  </span><input type="range" name="programming_lang_lv_cpp" value="0" min="0" max="5" step="1" oninput=document.getElementById("output2").value=this.value>
                            <output id="output2">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> C++  </span><input type="range" name="programming_lang_lv_cs" value="0" min="0" max="5" step="1" oninput=document.getElementById("output3").value=this.value>
                            <output id="output3">0</output>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Go  </span><input type="range" name="programming_lang_lv_go" value="0" min="0" max="5" step="1" oninput=document.getElementById("output4").value=this.value>
                            <output id="output4">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Java  </span><input type="range" name="programming_lang_lv_java" value="0" min="0" max="5" step="1" oninput=document.getElementById("output5").value=this.value>
                            <output id="output5">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> JavaScript  </span><input type="range" name="programming_lang_lv_js" value="0" min="0" max="5" step="1" oninput=document.getElementById("output6").value=this.value>
                            <output id="output6">0</output>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Kotlin  </span><input type="range" name="programming_lang_lv_kt" value="0" min="0" max="5" step="1" oninput=document.getElementById("output7").value=this.value>
                            <output id="output7">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Objective-C  </span><input type="range" name="programming_lang_lv_m" value="0" min="0" max="5" step="1" oninput=document.getElementById("output8").value=this.value>
                            <output id="output8">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> PHP  </span><input type="range" name="programming_lang_lv_php" value="0" min="0" max="5" step="1" oninput=document.getElementById("output9").value=this.value>
                            <output id="output9">0</output>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Perl  </span><input type="range" name="programming_lang_lv_pl" value="0" min="0" max="5" step="1" oninput=document.getElementById("output10").value=this.value>
                            <output id="output10">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Python  </span><input type="range" name="programming_lang_lv_py" value="0" min="0" max="5" step="1" oninput=document.getElementById("output11").value=this.value>
                            <output id="output11">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> R  </span><input type="range" name="programming_lang_lv_r" value="0" min="0" max="5" step="1" oninput=document.getElementById("output12").value=this.value>
                            <output id="output12">0</output>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> Ruby  </span><input type="range" name="programming_lang_lv_rb" value="0" min="0" max="5" step="1" oninput=document.getElementById("output13").value=this.value>
                            <output id="output13">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Swift  </span><input type="range" name="programming_lang_lv_scala" value="0" min="0" max="5" step="1" oninput=document.getElementById("output14").value=this.value>
                            <output id="output14">0</output>
                        </label>
                        <label class="btn active">
                            <span class="programming_lang_name"> Scala  </span><input type="range" name="programming_lang_lv_swift" value="0" min="0" max="5" step="1" oninput=document.getElementById("output15").value=this.value>
                            <output id="output15">0</output>
                        </label><br>
                        <label class="btn active">
                            <span class="programming_lang_name"> VisualBasic  </span><input type="range" name="programming_lang_lv_vb" value="0" min="0" max="5" step="1" oninput=document.getElementById("output16").value=this.value>
                            <output id="output16">0</output>
                        </label>
                    </div>
                    <div>
                        <input type="submit" value="検索" class="um-button um-alt" id="um-submit-btn">
                    </div>
                </div>
            </div>
            <div class="tab_content" id="design_content">
                <div class="tab_content_description">
                    '.$evaluation_form_html.'
                    <div>
                        <input type="number" name="inviter_user_login" value="">
                    </div>
                    <div>
                        <input type="submit" value="検索" class="um-button um-alt" id="um-submit-btn">
                    </div>
                </div>
            </div>
        </div>
    </form>';

    $search_form_html.=remove_check();

    return $search_form_html;
}
add_shortcode('student_search_form','student_search_form_func');

function remove_check(){
    return "
    <script type='text/javascript'>
    $('#removecheck').click(function () {
        $('.checkbox').prop('checked', false);
        $('.radio').prop('checked', false);
      }
    );
    </script>";
}

function student_search_result_func($atts){
    $home_url =esc_url( home_url( ));
    extract( shortcode_atts( array(
    ), $atts ) );

    $meta_query_args = array(
        'relation' => 'AND', // オプション、デフォルト値は "AND"
    );

    if (isset($_GET['sw'])) {
        $searchword = my_esc_sql($_GET['sw']);
    }
    if (isset($_GET['sort'])) {
        $sort = my_esc_sql($_GET['sort']);
    }

    $user=wp_get_current_user();
    $user_roles=$user->roles;

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
    if (isset($_GET['mail_can_send'])) {
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
    }

    // 性別による絞り込み
    if (!empty($_GET['gender'])) {
        $gender = $_GET['gender'];
        if($gender == 'male'){
            $gender = array('男性');
        }
        if($gender == 'female'){
            $gender = array ('女性');
        }
        array_push (
            $meta_query_args,
            array(
                'key'     => 'gender',
                'value'   =>  $gender[0],
                'compare' => 'LIKE'
            )
        );
    }

    // ログイン日時による絞り込み
    if (!empty($_GET['last_login']) ) {
        $last_login_value = $_GET["last_login"];
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
    if (!empty($_GET['degree_of_internship_interest']) ) {
        $degree_of_internship_interest = $_GET["degree_of_internship_interest"];
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
            'compare'   => 'LIKE'
        ));
    }
    // ベンチャー企業への就職意欲による絞り込み
    if (!empty($_GET['will_venture']) ) {
        $will_venture = $_GET["will_venture"];
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
            'compare'   => 'LIKE'
        ));
    }

    // 大学による絞り込み
    if (isset($_GET['university']) ) {
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

        $univ_meta_query = array('relation' => 'OR');
        foreach($universities as $university){
            array_push($univ_meta_query, array(
                'key'       => 'university',
                'value'     => $university,
                'compare'   => '='
            ));
        }
        array_push($meta_query_args, $univ_meta_query);
    }

    // 学部系統による絞り込み
    if (isset($_GET['faculty_lineage']) ) {
        $faculty_lineages = $_GET["faculty_lineage"];
        $faculty_lineage_meta_query = array('relation' => 'OR');
        foreach($faculty_lineages as $faculty_lineage){
            array_push($faculty_lineage_meta_query, array(
                'key'       => 'faculty_lineage',
                'value'     => $faculty_lineage,
                'compare'   => 'LIKE'
            ));
        }
        array_push($meta_query_args, $faculty_lineage_meta_query);
    }

    // 卒業年度による絞り込み
    if (isset($_GET['graduate_year']) ) {
        $graduate_years = $_GET["graduate_year"];
        if(in_array(2020,$graduate_years)){
            $graduate_year_sub = "2020(2019年4月時点で大学4年生/大学院2年生)";
            array_push($graduate_years,$graduate_year_sub);
        }
        if(in_array(2021,$graduate_years)){
            $graduate_year_sub = "2021(2019年4月時点で大学3年生/大学院1年生)";
            array_push($graduate_years,$graduate_year_sub);
        }
        if(in_array(2022,$graduate_years)){
            $graduate_year_sub = "2022(2019年4月時点で大学2年生)";
            array_push($graduate_years,$graduate_year_sub);
        }
        if(in_array(2023,$graduate_years)){
            $graduate_year_sub = "2023(2019年4月時点で大学1年生)";
            array_push($graduate_years,$graduate_year_sub);
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

    // 職種による絞り込み
    if (isset($_GET['occupation']) ) {
        $occupations = $_GET["occupation"];
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
    // 留学経験による絞り込み
    if (isset($_GET['studied_abroad']) ) {
        $studied_abroads = $_GET["studied_abroad"];
        $studied_abroad_meta_query = array('relation' => 'OR');
        foreach($studied_abroads as $studied_abroad){
            for($i=0;$i<=(4-$studied_abroad);$i++){
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
        }
        array_push($meta_query_args, $studied_abroad_meta_query);
    }
  // 学生時代の経験による絞り込み
    if (isset($_GET['student_experience']) ) {
        $student_experiences = $_GET["student_experience"];
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
    // 大学時代のコミュニティによる絞り込み
    if (isset($_GET['univ_community']) ) {
        $univ_communities = $_GET["univ_community"];
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
    // 長期インターン経験による絞り込み
    if (isset($_GET['internship_experiences']) ) {
        $internship_experiences = $_GET["internship_experiences"];
        $internship_experiences_meta_query = array('relation' => 'OR');
        foreach($internship_experiences as $internship_experience){
            for($i=0;$i<=(4-$internship_experience);$i++){
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
        }
        array_push($meta_query_args, $internship_experiences_meta_query);
    }
  // 興味のある業界による絞り込み
    if (isset($_GET['bussiness_type']) and(!empty($_GET['bussiness_type']))) {
        $bussiness_types = $_GET["bussiness_type"];
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
  //フリーワード検索による絞り込み
if (isset($_GET['freeword']) ) {
    $freeword =  my_esc_sql($_GET['freeword']);
    if(strlen(freeword)>1){
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
    // プログラミングスキルによる絞り込み
    for($i=1;$i<=16;$i++){
        switch($i){
            case 1:
                $language='c';
                break;
            case 2:
                $language='cpp';
                break;
            case 3:
                $language='cs';
                break;
            case 4:
                $language='go';
                break;
            case 5:
                $language='java';
                break;
            case 6:
                $language='js';
                break;
            case 7:
                $language='kt';
                break;
            case 8:
                $language='m';
                break;
            case 9:
                $language='php';
                break;
            case 10:
                $language='pl';
                break;
            case 11:
                $language='py';
                break;
            case 12:
                $language='r';
                break;
            case 13:
                $language='rb';
                break;
            case 14:
                $language='scala';
                break;
            case 15:
                $language='swift';
                break;
            case 16:
                $language='vb';
                break;
        }
        if ($_GET['programming_lang_lv_'.$language]!=0) {
            $skill[$i] = $_GET['programming_lang_lv_'.$language];
            $skill_meta_query[$i] = array('relation' => 'OR');
            array_push($skill_meta_query[$i], array(
                'key'       => 'programming_lang_lv_'.$language,
                'value'     => $skill[$i],
                'compare'   => '>='
            ));
            array_push($meta_query_args, $skill_meta_query[$i]);
        }
    }

    // 居住地による絞り込み
    if (isset($_GET['pref_name']) ) {
        $state =  my_esc_sql($_GET['pref_name']);
        if(strlen($state)>1){
            array_push (
                $meta_query_args,
                array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'thestate',
                        'value'   => array($state,mb_substr($state,0,-1)),
                        'compare' => 'IN'
                    ),
                    array(
                        'key'     => 'region',
                        'value'   => array($state,mb_substr($state,0,-1)),
                        'compare' => 'IN'
                    )
                )
            );
        }
    }
    // Builds社員の招待番号による絞り込み
    if (isset($_GET['inviter_user_login']) ) {
        $inviter_user_login = $_GET["inviter_user_login"];
        array_push($meta_query_args, array(
            'key'       => 'inviter_user_login',
            'value'     => $inviter_user_login,
            'compare'   => 'LIKE'
        ));
    }

    $choice_array=get_choice_array('experience_and_achievement_select');
    array_push ($meta_query_args, add_search_characteristic_func('experience_and_achievement_select', '経験/実績', true, '','query_arg', $choice_array, 'LIKE','AND'));
    array_push ($meta_query_args, add_search_characteristic_func('conditions_pay', '時給（円以下）', false,'int', 'query_arg', '', '<=',''));
    //$chara_id, $chara_label, $array_flag, $return_type, $choice_array, $compare)
    //faculty_lineage

    //'faculty_lineage','languages','programming_languages','region','skill_dev','skill',),
    if (isset($_GET['skillw']) ) {
        $skillw =  my_esc_sql($_GET['skillw']);
        if(strlen($skillw)>1){
            array_push ($meta_query_args,
            array('relation' => 'OR',
                array(
                    'key'     => 'faculty_lineage',
                    'value'   => esc_attr($skillw),
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'languages',
                    'value'   => esc_attr($skillw),
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'programming_languages',
                    'value'   => esc_attr($skillw),
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'languages',
                    'value'   => esc_attr($skillw),
                    'compare' => 'LIKE'
                ),
                array(
                    'key'     => 'skill_dev',
                    'value'   => esc_attr($skillw),
                    'compare' =>'LIKE'
                ),
                array(
                    'key'     => 'skill',
                    'value'   => esc_attr($skillw),
                    'compare' => 'LIKE'
            )));
        }
    }

    for ($i = 1; $i <= 6; $i++) {
        if (isset($_GET['eval'.$i]) ) {
            $eval[$i] =  my_esc_sql($_GET['eval'.$i]);
            if($eval[$i] >0){
                array_push ($meta_query_args, array(
                    'key'     => 'eval-'.$i,
                    'value'   => $eval[$i],
                    'compare' => '>'
                ));
            }
        }
    }


    $args = array(
        'blog_id'      => $GLOBALS['blog_id'],
        'role'         => 'student',
        'meta_key'     => '',
        'meta_value'   => '',
        'meta_compare' => '',
        'meta_query'   => $meta_query_args,
        'date_query'   => array(),
        'include'      => array(),
        'exclude'      => array(),
        //	'orderby'      => 'login',
        //	'order'        => 'ASC',
        'offset'       => '',
        'search'       => '*'.esc_attr($searchword).'*',
        'search_columns' => array( 'user_login','faculty_lineage','languages','programming_languages','region','skill_dev','skill',),
        //	'number'       => '',
        'count_total'  => true,
        'fields'       => 'all',
        'who'          => ''
    );


    if(isset($sort)){
        switch($sort){
            case '':
                break;
            case 'random':
                $args += array(
                    'orderby' => 'rand',
                );
                break;
            case 'date':
                $args += array(
                    'orderby' => 'registered',
                    'order'   => 'DESC',
                );
                break;
            case 'famous':
                $args += array(
                    'orderby' => 'login',
                    'order'   => 'DESC',
                );
            break;
        }
    }

    $user_login_name = wp_get_current_user()->data->user_login;

    $current_page = get_query_var('paged') ? (int) get_query_var('paged') : 1;
    $users_per_page = 20;
    if( $user_login_name == "kotaro" || $user_login_name == "amano1104"){
        $users_per_page = 100;
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
    if($company_name == "株式会社Builds"){
	    $result_html='' .'今月のスカウトメール送信可能件数は'.view_remain_num_func(wp_get_current_user(),'remain-mail-num').'<br>';
	}

    $total_users = $students->get_total(); // How many users we have in total (beyond the current page)
    $num_pages = ceil($total_users / $users_per_page);
    if ($total_users < $users_per_page) {$users_per_page = $total_users;}

    // $result_html.='
    // <h2>学生検索結果</h2>
    // IDキーワード：'.$args["search"].'<br>
    // スキルキーワード：'. my_esc_sql($_GET["skillw"]).'<br>
    // 大学：'.get_univ_name_sql('univ', array_filter($meta_query_args, function($a){return $a['key']=='university';})[0]['value']).'<br>
    // 居住地：'.implode(', ',array_values(array_filter($meta_query_args, function($a){return $a['key']=='thestate';}))[0]['value']).'<br>
    // 点数：';
    for ($i = 1; $i <= 6; $i++) {
        if($eval[$i]>0){
            $result_html.= name_of_student_item_func($i).'>'.$eval[$i].', ';
        }
    }

    $result_html.=paginate( $num_pages, $current_page, $total_users, $users_per_page);
    $result_html.='
    <font size="2">
        <table class="tbl02">
            <thead>
                <tr>
                    <th></th>
                    <th>性別</th>
                    <th>大学・所属</th>
                    <th>職種</th>
                    <th>ログイン日時</th>';
    if( in_array("company", $roles) ){
        $result_html.='<th>スカウト</th>';
    }
    if( in_array("officer", $roles) ){
        $result_html.='<th>接触記録</th>';
    }
    if( $user_login_name == "kotaro" || $user_login_name == "amano1104" || $user_login_name == "yuu"){
        $result_html.='<th>メールアドレス</th>';
    }
    $result_html.='
                </tr>
            </thead>
            <tbody>';

    if ( $students->get_results() ) foreach( $students->get_results() as $user )  {

        $user_id = $user->data->ID;
        $gender = get_user_meta($user_id,'gender',false)[0][0];
        $future_occupations = get_user_meta($user_id,'future_occupations',false)[0];
        $last_login = get_user_meta($user_id,'_um_last_login',false);
        $last_login_date = date('Y年m月d日',$last_login[0]).'<br>'.date('H時i分',$last_login[0]);
        $job_html = '';
        foreach($future_occupations as $future_occupation){
            $job_html .= $future_occupation.'<br>';
        }
        $email = get_user_by("id",$user_id)->data->user_email;
        $image_date = date("YmdHis");
        $upload_dir = wp_upload_dir();
        $upload_file_name = $upload_dir['basedir'] . "/" .'profile_photo'.$user_id.'.png';
        if(!file_exists($upload_file_name)){
            $photo = get_avatar($user_id);
        }
        else{
            $photo = '<img src="'.$upload_file_name.'?'.$image_date.'" class="gravatar avatar avatar-190 um-avatar avatar-search" />'; 
        }
        $result_html.='
                    <tr>
                        <th>
                            <a href="/user?um_user='.$user->user_login.'" style="color:white"><p>'.esc_html( $user->user_login ) .'<br></p><div>'.$photo.'</div></a>
                        </th>
                        <td label="性別">'.$gender.'</td>
                        <td label="大学・所属">'.esc_html( get_univ_name($user)).'<br>'. esc_html( get_faculty_name($user)).'</td>
                        <td label="職種">'.$job_html.'</td>
                        <td label="ログイン日時">'.$last_login_date.'</td>';
        if(in_array("company", $roles) ){
            $scout_status = get_remain_num_for_stu_func($user, 'remain-mail-num');
            $user_name = $user->data->user_login;
            $scouted_users = scout_manage_func();
            $user_link = $home_url.'/user?um_user='.$user_name;
            if($scout_status["remain"]>0){
                if(!in_array($user_name,$scouted_users,false)){
                    $result_html.='<td label="スカウト"><a href="'.scoutlink($user).'">'.$scout_status['status'].'<br>スカウトする</a></td>';
                }else{
                    $result_html.='<td label="スカウト"><a href="'.$user_link.'">'.$scout_status['status'].'<br>スカウト済み</a></td>';
                }
            }else{
                $result_html.='<td label="スカウト"><a href="'.$user_link.'">'.$scout_status['status'].'</a></td>';
            }
        }
        if( in_array("administrator", $roles) ){
            $result_html.='<td label="接触記録"><a href="'.student_contact_form_link($user).'">接触記録を入力</a></td>';
        }
        if( $user_login_name == "kotaro" || $user_login_name == "amano1104"|| $user_login_name == "yuu"){
            $result_html.='<td label="メールアドレス">'.$email.'</td>';
        }
    }
    $result_html.='
            </tbody>
        </table>
    </font>';

    $result_html.= paginate( $num_pages, $current_page, $total_users, $users_per_page);

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
?>