<?php

function about_interview(){
    $home_url =esc_url( home_url( ));
    if(is_user_logged_in()){
        $apply_url = 'https://jobshot.jp/interview/apply';
    }else{
        $apply_url = 'https://jobshot.jp/interview/login';
    }
    $html='
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .datalist dt:before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            padding-right: 15px;
            color: #03c4b0;
            }
            .table th {
            width: 25%;
            text-align: left
        }
        .table td, .table th {
            border-bottom: 2px solid #f0f0f0
        }
        .table td {
            padding: 12px 0 13px
        }
        @media screen and (min-width:768px) {
            .table {
                width: 100%
            }
        }
        .widget {
            font-size: 1.0em;
        }
        footer .widget {
            font-size: 0.8em;
        }
        .gmap {
            height: 0;
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
        }
        .gmap iframe {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
        }
    </style>
    <div class="siteorigin-widget-tinymce textwidget">
    <div class="background-img-container">
        <noscript><img src="https://i1.wp.com/jobshot.jp/wp-content/uploads/2020/02/photo-1555443712-22cd30585e5c.jpeg?w=1905&#038;ssl=1" alt data-recalc-dims="1"></noscript><img src="'.$home_url.'/wp-content/uploads/2020/06/charles-deluvio-Lks7vei-eAg-unsplash.jpg" alt="" data-src="https://jobshot.jp/wp-content/uploads/2020/02/photo-1555443712-22cd30585e5c.jpeg" class=" lazyloaded">
        <div class="background-img-text consult__bg-img__text">
            <p class="consult__bg-img__ele consult__bg-img__ele__first">講師　外コン・GAFA内定者</p>
            <h1 class="font-serif consult__bg-img__ele consult__bg-img__ele__second">長期インターン個別相談会</h1>
            <p class="consult__bg-img__ele consult__bg-img__ele__third">企業選びから<span class="consult-emphasis-color">内定</span>までサポート</p>
            <p class="consult__bg-img__ele consult__bg-img__ele__four">参加者限定　<span class="consult-emphasis-color">特別推薦</span>あり</p>
        </div>
    </div>
    <div class="consult__block consult__worry">
        <h2 class="menu_title consult__title">長期インターンでよくある悩み</h2>
        <div class="consult__worry__container">
          <ul class="consult__worry__feature">
            <li>
              <div class="consult__worry__icon consult__worry__icon-size"><img src="'.$home_url.'/wp-content/uploads/2020/06/consult__first.png" alt=""></div>
              <p class="menu_text consult-font-bold consult-font-size">自分に合う企業の選び方がわからない…</p>
            </li>
            <li>
              <div class="consult__worry__icon consult__worry__icon-size"><img src="'.$home_url.'/wp-content/uploads/2020/06/consult__second.png" alt=""></div>
              <p class="menu_text consult-font-bold consult-font-size">いきなり多忙になるのは大変そうかも…</p>
            </li>
            <li>
              <div class="consult__worry__icon consult__worry__icon-size"><img src="'.$home_url.'/wp-content/uploads/2020/06/consult__third.png" alt=""></div>
              <p class="menu_text consult-font-bold consult-font-size">スキル・経験が全くないので少し不安…</p>
            </li>
          </ul>
        </div>
    </div>
    <div class="consult__block consult__univ">
        <h2 class="menu_title consult__title only-pc">Jobshotの無料相談なら解決できます</h2>
        <h2 class="menu_title consult__title only-sp">Jobshotの無料相談なら解決</h2>
        <div class="consult__univ__container consult__flex__container">
            <div class="consult__univ__consultant">
                <div class="consult__univ__consultant__img"><img src="'.$home_url.'/wp-content/uploads/2020/06/takazawa.jpg" alt=""></div>
                <p class="consult-font-name consult-font-bold">JobShot事業部長 高澤優（21）</p>
            </div>
            <div class="consult__univ__comment">
                <p class="consult-font-bold">実績：</p>
                <p>中央大学法学部３年生。これまで数多くの学生のキャリア設計・長期インターン選びを支え、就活まで徹底したサポートを続けてきた。<br>自身も長期インターン経験を持ち、就職活動では外資IT、外資コンサルの内定実績有り。</p>
                <br>
                <p class="consult-font-bold">一言：</p>
                <p>良い学生生活が送れるよう、最適なインターン探しをお手伝いします！</p>
            </div>
        </div>
    </div>
    <div class="consult__block consult__solve">
        <h2 class="menu_title consult__title only-pc">JobShotの無料相談を学生が選ぶ理由</h2>
        <h2 class="menu_title consult__title only-sp">JobShotの無料相談を選ぶ理由</h2>
        <div class="consult__solve__reason">
            <ul class="consult__solve__reason__text consult__flex__container">
                <li class="consult__solve__reason__ele">
                    <span class="consult__solve__reason__ele__title">POINT<span class="consult__solve__reason__ele__num">1</span></span>
                    <p>相談してくれる学生の目標から逆算し、自分に合った<span class="consult-font-bold">ベストなキャリア設計</span>ができる！</p></li>
                <li class="consult__solve__reason__ele">
                    <span class="consult__solve__reason__ele__title">POINT<span class="consult__solve__reason__ele__num">2</span></span>
                    <p><span class="consult-font-bold">相談実績600件</span>の学生が自分と同じ目線で相談を受けてくれるから、サポートの質が高い！</p></li>
                <li class="consult__solve__reason__ele">
                    <span class="consult__solve__reason__ele__title">POINT<span class="consult__solve__reason__ele__num">3</span></span>
                    <p>求人の文章だけでは伝わらないことを説明するから、長期インターンを始めた時に<span class="consult-font-bold">後悔しない</span>！</p></li>
            </ul>
        </div>
    </div>
    <div class="consult__block consult__example">
        <h2 class="menu_title consult__title">実際に受けた相談例</h2>
        <div class="consult__example__container">
            <div class="sectionVoice consult__example__voice">
                <div class="sectionVoice__img consult__example__voice__student">
                    <noscript><img src="https://i0.wp.com/jobshot.jp/wp-content/uploads/2020/02/kazuki.jpg?w=1300&#038;ssl=1" alt data-recalc-dims="1"></noscript><img src="'.$home_url.'/wp-content/uploads/2020/06/student__first.png" alt="" data-src="'.$home_url.'/wp-content/uploads/2020/06/student__first.png" class=" ls-is-cached lazyloaded consult__example__voice__img">
                </div>
                <div class="sectionVoice__comment consult__example__voice__comment consult-font-size">
                    <p class="sectionVoice__ttl">国立文系・経済学部3年</p>
                    <p class="sectionVoice__txt">長期インターンを始めてみたい気持ちはあるのですが、どんな職種が自分に合うのかよくわかりません…</p>
                </div>
            </div>
            <div class="sectionVoice consult__example__voice">
                <div class="sectionVoice__img consult__example__voice__student">
                    <noscript><img src="https://i0.wp.com/jobshot.jp/wp-content/uploads/2020/02/kazuki.jpg?w=1300&#038;ssl=1" alt data-recalc-dims="1"></noscript><img src="'.$home_url.'/wp-content/uploads/2020/06/student__second.png" alt="" data-src="'.$home_url.'/wp-content/uploads/2020/06/student__second" class=" ls-is-cached lazyloaded consult__example__voice__img">
                </div>
                <div class="sectionVoice__comment consult__example__voice__comment consult-font-size">
                    <p class="sectionVoice__ttl">私立文系・経済学部2年</p>
                    <p class="sectionVoice__txt">将来、私はヘルスケアに関わっていきたいと思っているのですが、オススメの長期インターンってありますか…？</p>
                </div>
            </div>
            <div class="sectionVoice consult__example__voice">
                <div class="sectionVoice__img consult__example__voice__student">
                    <noscript><img src="https://i0.wp.com/jobshot.jp/wp-content/uploads/2020/02/kazuki.jpg?w=1300&#038;ssl=1" alt data-recalc-dims="1"></noscript><img src="'.$home_url.'/wp-content/uploads/2020/06/student__third.png" alt="" data-src="'.$home_url.'/wp-content/uploads/2020/06/student__third.png" class=" ls-is-cached lazyloaded consult__example__voice__img">
                </div>
                <div class="sectionVoice__comment consult__example__voice__comment consult-font-size">
                    <p class="sectionVoice__ttl">国立理系・工学部3年</p>
                    <p class="sectionVoice__txt">自己PRや面接のやり方がわからず、自分が就活で志望する企業の内定を取る自信がありません…</p>
                </div>
            </div>
        </div>
    </div>
    <div class="consult__block consult__solve__info consult__solve__info__margin">
        <h2 class="menu_title consult__title">申し込みはこちらから</h2>
        <div class="consult__solve__details">
            <table class="demo01">
                <tbody>
                    <tr>
                        <th>開催日時</th>
                        <td>
                            <div><a href="'.$apply_url.'">こちらからお選びください</a></div>
                        </td>
                    </tr>
                    <tr>
                        <th>場所</th>
                        <td>
                            <div>オンラインにて開催いたします</div>
                        </td>
                    </tr>
                    <tr>
                        <th>参加費</th>
                        <td>無料</td>
                    </tr>
                    <tr>
                        <th>持ち物</th>
                        <td>メモ帳・筆記用具</td>
                    </tr>
                    <tr>
                        <th>備考</th>
                        <td>コロナウイルスの影響により、安全面を考慮し、オンラインで開催いたしますオンライン面談ではZoom(※インストール不要)を使用する予定です</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="fixed-buttom">
        <a href="'.$apply_url.'">
            <button class="button button-apply">申し込みはこちらから</button>
        </a>
    </div>
</div>';

    return $html;
}
add_shortcode("about_interview","about_interview");

function recruit_interview($atts){
    $home_url =esc_url( home_url( ));
    extract(shortcode_atts(array(
        'graduate_year' => '',
    ), $atts));
    $top_image = array(
        '21'    =>  '/wp-content/uploads/2020/04/99df0b5ee83a50b1c98a06ba7146e8bd.png',
        '22'    =>  '/wp-content/uploads/2020/05/image-2.png'
    );
    if(is_user_logged_in()){
        $apply_url = 'https://jobshot.jp/interview/apply';
    }else{
        $apply_url = 'https://jobshot.jp/interview/login';
    }
    $html='
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .datalist dt:before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            padding-right: 15px;
            color: #03c4b0;
            }
            .table th {
            width: 25%;
            text-align: left
        }
        .table td, .table th {
            border-bottom: 2px solid #f0f0f0
        }
        .table td {
            padding: 12px 0 13px
        }
        @media screen and (min-width:768px) {
            .table {
                width: 100%
            }
        }
        .widget {
            font-size: 1.0em;
        }
        footer .widget {
            font-size: 0.8em;
        }
        .gmap {
            height: 0;
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
        }
        .gmap iframe {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
        }
    </style>
    <section>
        <img src="'.$home_url.$top_image[$graduate_year].'">
        <div class="card-category-container event">
            <div class="card-category">就活相談や面接対策＆ES添削が可能</div><br>
            <div class="card-category">優秀者には大手企業へご紹介</div><br>
        </div>
    </section>
    <section>
        <table class="demo01">
            <tbody>
                <tr>
                    <th>開催日時</th>
                    <td>
                        <div><a href="'.$apply_url.'">こちらからお選びください</a></div>
                    </td>
                </tr>
                <tr>
                    <th>場所</th>
                    <td>
                        <div>オンラインにて開催いたします</div>
                    </td>
                </tr>
                <tr>
                    <th>参加費</th>
                    <td>無料</td>
                </tr>
                <tr>
                    <th>持ち物</th>
                    <td>メモ帳・筆記用具</td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>コロナウイルスの影響により、安全面を考慮し、オンラインで開催いたします</br>オンライン面談ではZoom(※インストール不要)を使用する予定です</td>
                </tr>
            </tbody>
        </table>
    </section>
    <div class="fixed-buttom">
        <a href="'.$apply_url.'">
            <button class="button button-apply">申し込みはこちらから</button>
        </a>
    </div>';

    return $html;
}
add_shortcode("recruit_interview","recruit_interview");

function ut_guild(){
    $home_url =esc_url( home_url( ));
    $html='
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <style>
        .datalist dt:before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            padding-right: 15px;
            color: #03c4b0;
            }
            .table th {
            width: 25%;
            text-align: left
        }
        .table td, .table th {
            border-bottom: 2px solid #f0f0f0
        }
        .table td {
            padding: 12px 0 13px
        }
        @media screen and (min-width:768px) {
            .table {
                width: 100%
            }
        }
        .widget {
            font-size: 1.0em;
        }
        footer .widget {
            font-size: 0.8em;
        }
        .gmap {
            height: 0;
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
        }
        .gmap iframe {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
        }
        .ut-grid {
            box-sizing: border-box;
            border: 1px solid #03c4b0;
            border-spacing: 0 20px;
            padding: 20px 15px 20px 15px;
            margin-bottom: 30px;
        }
    </style>
    <section>
        <img src="https://jobshot.jp/wp-content/uploads/2020/11/UT-GUILD-a.jpeg">
    </section>
    <section>
        <div class="ut-grid">
            <p>2020年10月末、Slackを利用した東大生限定のハイクラス就活コミュニティ「UT-GUILD」が誕生しました。
            就活において周りと圧倒的な差をつけられるコンテンツを配信しており、最難関企業の内定獲得を目指す東大生は参加必須です！</p><br>
            <h3>▼メリットその１▼</h3>
            <p>外資系トップティア企業出身役員直下インターンなど圧倒的に成長できる厳選長期インターンが分かる！</p><br>
            <h3>▼メリットその２▼</h3>
            <p>日系大手トップ企業/外資系トップティア企業の現役社員/出身者/内定者と直接話せるセミナーに参加できる！</p><br>
            <p>UT-GUILDに参加し、最難関企業の内定獲得に大きく近づく一歩を踏み出してみませんか？</p>
        </div>
    </section>
    <div class="fixed-buttom">
        <a href="https://bit.ly/3eiqYP4">
            <button class="button button-apply">1分で終わる登録はこちら</button>
        </a>
    </div>';

    return $html;
}
add_shortcode("ut_guild","ut_guild");

function fill_interview_apply(){
    $user = wp_get_current_user();
    $last_name = $user->last_name;
    $first_name = $user->first_name;
    $email = $user->data->user_email;
    $user_id = $user->data->ID;
    $mobile_number = get_user_meta($user_id,'mobile_number',false)[0];
    $list = array($first_name,$last_name,$email,$mobile_number);
    header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
    echo json_encode($list);
    die();
}
add_action( 'wp_ajax_fill_interview_apply', 'fill_interview_apply' );
add_action( 'wp_ajax_fill_interview_apply', 'fill_interview_apply');

/*カレッジワークスの場所

<div>カレッジワークススタジオ</div>
<div>渋谷区神南1-11-1</div>
<div><i class="fas fa-train"></i>渋谷駅徒歩8分</div>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.5970616463133!2d139.6990004153449!3d35.66229558019869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188ca880f4b6e7%3A0x6598c977001c85b3!2z44CSMTUwLTAwNDEg5p2x5Lqs6YO95riL6LC35Yy656We5Y2X77yR5LiB55uu77yR77yR4oiS77yR!5e0!3m2!1sja!2sjp!4v1560310092730!5m2!1sja!2sjp" width="100%" height="auto" frameborder="0" style="border:0" allowfullscreen=""></iframe>


<section>
        <img src="'.$home_url.'/wp-content/uploads/2020/02/9628bacf8cc0154c6bec8a8ac88ced35.png">
        <div class="card-category-container event">
            <div class="card-category">将来の志望企業から逆算して最適なインターン選びをお手伝いします！</div><br>
            <div class="card-category">ESを一緒に作成し、通過率を高めます！</div><br>
            <div class="card-category">過去問による面接で採用率を高めます！</div><br>
        </div>
    </section>
    <section>
        <table class="demo01">
            <tbody>
                <tr>
                    <th>開催日時</th>
                    <td>
                        <div><a href="'.$home_url.'/interview/apply">こちらからお選びください</a></div>
                    </td>
                </tr>
                <tr>
                    <th>場所</th>
                    <td>
                        <div>オンラインにて開催いたします</div>
                    </td>
                </tr>
                <tr>
                    <th>参加費</th>
                    <td>無料</td>
                </tr>
                <tr>
                    <th>持ち物</th>
                    <td>メモ帳・筆記用具</td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td>コロナウイルスの影響により、安全面を考慮し、オンラインで開催いたします</br>オンライン面談ではZoom(※インストール不要)を使用する予定です</td>
                </tr>
            </tbody>
        </table>
    </section>
    <div class="fixed-buttom">
        <a href="'.$home_url.'/interview/apply">
            <button class="button button-apply">申し込みはこちらから</button>
        </a>
    </div>';
    */
?>