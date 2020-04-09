<?php

function about_interview(){
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
    </style>
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

    return $html;
}
add_shortcode("about_interview","about_interview");

function recruit_interview(){
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
    </style>
    <section>
        <img src="'.$home_url.'/wp-content/uploads/2020/04/63423c476da69f145e9f241166a3c8f5.png">
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

    return $html;
}
add_shortcode("recruit_interview","recruit_interview");

/*カレッジワークスの場所

<div>カレッジワークススタジオ</div>
<div>渋谷区神南1-11-1</div>
<div><i class="fas fa-train"></i>渋谷駅徒歩8分</div>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.5970616463133!2d139.6990004153449!3d35.66229558019869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188ca880f4b6e7%3A0x6598c977001c85b3!2z44CSMTUwLTAwNDEg5p2x5Lqs6YO95riL6LC35Yy656We5Y2X77yR5LiB55uu77yR77yR4oiS77yR!5e0!3m2!1sja!2sjp!4v1560310092730!5m2!1sja!2sjp" width="100%" height="auto" frameborder="0" style="border:0" allowfullscreen=""></iframe>

*/
?>