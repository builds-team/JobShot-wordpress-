<?php


function show_tech_build_lp()
{
    $contactform_html = do_shortcode('[contact-form-7 id="14008" title="JobShot×TECH-BUILD"]');
    $style_html = '
    <style type="text/css">
    #post-14004{
        padding-top: 0;
    }

    .techbuild-img-container {
        position: relative;
        height: 800px !important;
        left: 50%;
        transform: translateX(-50%);
        width: 100vw;
        overflow: hidden;
    }
    
    .techbuild-img-container img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
    }
    
    .techbuild-img-container::before {
        background: linear-gradient( 135deg, rgba(3, 196, 176, 0.5), rgba(3, 98, 196, 0.5));
        content: " ";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 800px;
        z-index: 1;
    }
    
    .techbuild-img-title {
        letter-spacing: 0.5rem;
        font-size: 48px;
        font-weight: 700 !important;
        margin-bottom: 40px;
        line-height: 160%;
    }
    
    .techbuild-img-title-container {
        width: 800px;
        margin: 0px auto;
        backdrop-filter: blur(3px);
    }
    
    .techbuild-img-title-container .techbuild-apply {
        border-radius: 10em;
        font-size: 1.2rem;
        background-color: #f9b539;
        box-shadow: #bb9 0 5px 22px;
        margin: 40px 0 16px;
    }
    
    .techbuild-section-content {
        max-width: 1200px;
        margin: 80px auto;
    }
    
    .techbuild-section-title {
        font-size: 2.5em !important;
        line-height: 1.5;
        letter-spacing: 0.1rem;
        color: #3e3c3c;
        font-weight: 700 !important;
        text-align: center;
    }
    
    .techbuild-section-title::after {
        position: absolute;
        content: " ";
        display: block;
        background-color: #fff;
        border-bottom: solid 5px;
        border-image: linear-gradient(45deg, #03c4b0, #2CE3F1);
        border-image-slice: 1;
        width: 15%;
        margin-top: 10px;
        left: 42.5%;
    }
    
    .techbuild-section-main-container {
        text-align: center;
        max-width: 1200px;
        margin: 60px auto;
        font-size: 16px;
        line-height: 2;
    }
    
    .techbuild-section-text-container {
        text-align: left;
        max-width: 762px;
        margin: 40px auto;
    }
    
    .techbuild-feature-inner {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 40px 0;
    }
    
    .techbuild-feature-inner .card {
        width: auto;
        margin: auto;
        text-align: center;
    }
    
    .techbuild-feature-inner .card .ttl {
        font-weight: 700 !important;
    }
    
    .techbuild-feature-inner .text {
        line-height: 200%;
        text-align: left;
        margin: 20px;
    }
    
    .techbuild-company-list {
        text-align: center;
        padding: 40px 0;
    }
    
    .techbuild-company-img {
        width: 120px;
        margin: 0 24px;
        -webkit-box-shadow: 0 2px 12px rgba(33, 33, 33, .2);
        box-shadow: 0 2px 12px rgba(33, 33, 33, .2);
    }
    
    .techbuild-support-content {
        padding: 60px 0;
        text-align: center;
    }
    
    .techbuild-support-title {
        font-size: 2rem;
        font-weight: 700 !important;
        color: #03c4b0;
        margin-bottom: 40px;
        text-align: center;
    }
    
    .techbuild-support-title .xx-small {
        font-size: 0.4em;
    }
    
    .techbuild-support-title .xx-large {
        font-size: 4rem;
        margin-top: -5px;
        margin-bottom: 30px;
        font-weight: 700;
    }
    
    .techbuild-support-title .small {
        font-size: 0.6em;
        margin-bottom: 10px;
    }
    
    .techbuild-support-image {
        max-width: 600px;
        margin: auto;
    }
    
    .techbuild-support-image img {
        width: 400px;
    }
    
    .techbuild-support-image p {
        margin-top: 16px !important;
        font-size: 16px;
        text-align: center;
    }
    
    .techbuild-support-coach {
        margin-top: 64px !important;
        font-size: 1.5rem;
        color: #03c4b0;
        font-weight: 700 !important;
    }
    
    .techbuild-support-ex-title {
        display: inline-block;
        text-align: center;
        color: #fff;
        padding: 10px 20px;
        margin-bottom: 40px;
        border-radius: 25px;
        background: linear-gradient(45deg, #03c4b0, #3decda);
    }
    
    .techbuild-support-ex-image {
        max-width: 600px;
        margin: auto;
        text-align: left;
    }
    
    .techbuild-support-ex-image img {
        margin: 0px 0 16px;
        width: 600px;
    }
    
    .techbuild-support-ex-image p {
        font-size: 16px;
    }
    
    .techbuild-section-flow {
        max-width: 800px !important;
    }
    
    .techbuild-section-flow ul {
        padding: 0;
    }
    
    .techbuild-section-flow li {
        list-style-type: none;
    }
    
    .techbuild-section-flow dd {
        margin-left: 0;
    }
    
    .techbuild-section-flow .flow>li {
        position: relative;
    }
    
    .techbuild-section-flow .flow>li:not(:last-child) {
        margin-bottom: 40px;
    }
    
    .techbuild-section-flow .flow>li:not(:first-child)::before {
        content: "";
        height: 60px;
        display: block;
        border-left: 4px dotted #e5e5e5;
        position: absolute;
        top: -40px;
        left: -webkit-calc(10% + 30px - 2px);
        left: calc(10% + 30px - 2px);
        z-index: 10;
    }
    
    .techbuild-section-flow .flow>li dl {
        width: 100%;
        padding: 20px 30px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        border: 2px solid #03c4b0;
        border-radius: 10px;
        position: relative;
    }
    
    .techbuild-section-flow .flow>li:not(:last-child) dl::before, .techbuild-section-flow .flow>li:not(:last-child) dl::after {
        content: "";
        border: solid transparent;
        position: absolute;
        top: 100%;
        left: 50%;
        -webkit-transform: translateX(-50%);
        transform: translateX(-50%);
    }
    
    .techbuild-section-flow .flow>li:not(:last-child) dl::before {
        border-width: 22px;
        border-top-color: #03c4b0;
    }
    
    .techbuild-section-flow .flow>li:not(:last-child) dl::after {
        border-width: 20px;
        border-top-color: #fff;
    }
    
    .techbuild-section-flow .flow>li dl dt {
        font-size: 20px;
        font-weight: 600;
        color: #03c4b0;
        -ms-flex-preferred-size: 20%;
        flex-basis: 20%;
        margin-right: 2vw;
        text-align: center;
    }
    
    .techbuild-section-flow .flow>li dl dt .icon {
        font-size: 12px;
        color: #fff;
        background: #03c4b0;
        background: -moz-linear-gradient(left, #03c4b0, #3decda);
        background: -webkit-linear-gradient(left, #03c4b0, #3decda);
        background: linear-gradient(45deg, #03c4b0, #3decda);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#6b90db", endColorstr="#66d5e9", GradientType=1);
        padding: 5px 10px;
        margin-bottom: 10px;
        display: block;
        border-radius: 20px;
        position: relative;
        z-index: 100;
    }
    
    .techbuild-section-merit-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 900px;
        padding: 0 0 40px;
        margin: 0 auto;
    }
    
    .techbuild-section-merit-each {
        width: 400px;
        height: 60px;
        background: linear-gradient(45deg, #03c4b0, #3decda);
        margin: 20px 10px;
        padding: 20px 10px;
        border-radius: 5px;
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .techbuild-section-merit-each p {
        font-size: 1.2em;
        font-weight: 700;
        letter-spacing: 0.1rem;
        color: #fff;
    }
    
    .techbuild-price-inner {
        margin: auto;
        max-width: 800px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
    }
    
    .price-title {
        padding: 20px;
        background: linear-gradient(45deg, #03c4b0, #3decda);
        color: #fff;
        text-align: center;
    }
    
    .techbuild-section-main-container .card {
        border-radius: 10px;
    }
    
    .techbuild-price-inner .price {
        text-align: center;
        position: relative;
    }
    
    .techbuild-price-inner .price h4 {
        font-size: 16px;
        margin: 64px 0 40px;
    }
    
    .techbuild-price-inner .price h4 span {
        font-size: 2em;
        margin: 0 5px;
    }
    
    .techbuild-price-inner .price h4::after {
        position: absolute;
        content: " ";
        display: block;
        background-color: #fff;
        border-bottom: solid 2px;
        border-image: linear-gradient(45deg, #03c4b0, #2CE3F1);
        border-image-slice: 1;
        width: 60%;
        margin-top: 10px;
        left: 20%;
    }
    
    .techbuild-price-inner .price p:first-of-type {
        position: relative;
        border-bottom: solid 1px #666666;
        width: 20%;
        left: 40%;
    }
    
    .techbuild-price-inner .price p:last-of-type {
        margin-top: 8px;
        font-size: 1.2em;
    }
    
    .price-notice {
        padding: 20px;
        font-size: 10px;
        text-align: left;
    }
    
    .cp_qa *, .cp_qa *:after, .cp_qa *:before {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    
    .cp_qa {
        overflow-x: hidden;
        margin: 0 auto;
        color: #666666;
        text-align: left;
        max-width: 800px;
    }
    
    .cp_qa .cp_actab {
        padding: 20px 0;
        border-bottom: 1px dotted #cccccc;
    }
    
    .cp_qa label {
        font-size: 1.2em;
        position: relative;
        display: block;
        width: 100%;
        margin: 0;
        padding: 10px 10px 0 48px;
        cursor: pointer;
    }
    
    .cp_qa .cp_actab-content {
        font-size: 1em;
        position: relative;
        overflow: hidden;
        height: 0;
        margin: 0 40px;
        padding: 0 14px;
        -webkit-transition: 0.4s ease;
        transition: 0.4s ease;
        opacity: 0;
    }
    
    .cp_qa .cp_actab input[type=checkbox]:checked~.cp_actab-content {
        height: auto;
        padding: 14px;
        opacity: 1;
    }
    
    .cp_qa .cp_plus {
        font-size: 2.4em;
        line-height: 100%;
        position: absolute;
        z-index: 5;
        margin: 3px 0 0 10px;
        -webkit-transition: 0.2s ease;
        transition: 0.2s ease;
    }
    
    .cp_qa .cp_actab input[type=checkbox]:checked~.cp_plus {
        -webkit-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    
    .cp_qa .cp_actab input[type=checkbox] {
        display: none;
    }
    
    .techbuild-coach-inner {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        flex-wrap: wrap;
        margin: 40px 0;
    }
    
    .techbuild-coach-inner .ttl::after {
        position: relative;
        content: " ";
        display: block;
        background-color: #fff;
        border-bottom: solid 2px;
        border-image: linear-gradient(45deg, #03c4b0, #2CE3F1);
        border-image-slice: 1;
        width: 40%;
        margin-top: 10px;
        left: 30%;
    }
    
    .techbuild-coach-inner .ttl{
        margin-top: 20px;
    }
    
    .techbuild-coach-inner .text {
        font-size: 12px;
        line-height: 200%;
        text-align: left;
        margin: 20px;
    }
    
    .techbuild-contact-wrapper{
        max-width: 480px;
        text-align: left;
        margin: auto;
    }

    .techbuild-contact-wrapper input[type=submit]{
        width: 40%;
        height: 40px;
        border-radius: 20px;
        position: relative;
        left: 30%;
        border-radius: 10em;
        font-size: 1.2rem;
        background-color: #f9b539;
        box-shadow: #bb9 0 5px 22px;
    }

    @media only screen and (max-width: 1024px) {
        .techbuild-img-title-container {
            width: 100%;
        }
        .techbuild-section-flow .flow>li dl {
            width: 80%;
        }
    }
    
    @media screen and (max-width: 782px) {
        .techbuild-img-container .background-img-text {
            top: 10%;
        }
        .techbuild-img-container {
            height: 550px !important;
        }
        .techbuild-img-title-container {
            padding: 100px 0;
        }
        .techbuild-img-title-container p {
            text-align: left;
            line-height: 200%;
            padding: 0 15px;
        }
        .techbuild-section-main-container {
            text-align: left;
            font-size: 12px;
        }
        .techbuild-section-title {
            font-size: 2em !important;
        }
        .techbuild-section-title::after {
            border-bottom: solid 3px;
            width: 30%;
            margin-top: 10px;
            left: 35%;
        }
        .techbuild-feature-inner {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            margin: 0;
        }
        .techbuild-feature-inner .ttl {
            text-align: center;
        }
        .techbuild-company-img {
            width: 80px;
            margin: 0 8px;
        }
        .techbuild-support-content {
            padding: 24px 0;
        }
        .techbuild-support-image p {
            font-size: 12px;
        }
        .techbuild-support-ex-image p {
            font-size: 12px;
        }
        .techbuild-section-flow .flow>li dl dt {
            font-size: 14px;
            flex-basis: 60%;
        }
        .techbuild-section-main-container {
            margin: 40px auto;
        }
        .techbuild-support-title {
            margin-bottom: 16px;
        }
        .techbuild-section-merit-container {
            padding-bottom: 0;
        }
        .techbuild-section-merit-each {
            margin: 10px;
        }
        .techbuild-company-list {
            padding: 24px 0;
        }
        .techbuild-section-content {
            margin: 60px auto;
        }
        .techbuild-support-ex-title {
            margin-bottom: 24px;
        }
    }
    </style>
    ';
    $onclick_href = "location.href='https://jobshot.jp/jobshot_tech-build#contact'";
    $html = '
            <div class="techbuild-img-container">
                <img src="https://images.unsplash.com/photo-1542546068979-b6affb46ea8f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80"
                    alt="">
                <div class="background-img-text">
                    <div class="techbuild-img-title-container">
                        <h1 class="techbuild-img-title">プログラミングで<br>キャリアの選択肢を広げよう
                        </h1>
                        <p>TECH-BUILDなら文理学年問わず、プログラミング未経験の学生がたった2カ月で最先端エンジニアを目指せます。<br>
                            いつでもどこでもコーチに相談できるから、簡単にモチベーションを維持することが可能。<br>
                            「なかなか学習に手をつけられない…」そんな不安を無くします。<br>
                        </p>
                        <button
                            class="button techbuild-apply" onclick="'.$onclick_href.'">無料カウンセリングに申し込む</button>
                    </div>
                </div>
            </div>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">JobShot×TECH-BUILDとは</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-section-text-container">
                        <p>
                            「TECH-BUILD」はプログラミング学習者がつまずきやすいポイントを押さえた有名IT企業所属の優秀な現役エンジニアコーチと伴走して実力をつけていくプログラミングスクールです。<br><br>
                            オンラインコーチング型のプログラミングスクール「TECH-BUILD」で学んだスキルを活かして、「JobShot」の長期インターンで実践的に利用することができます。<br><br>
                            「インターンを始める前にポートフォリオを求められたけど、まだ何も持っていない。。。」、「学生のうちに何か他の人と差別化できるスキルを身につけたい」といった悩みなど解決いたします。
                        </p>
                    </div>
                    <div class="techbuild-feature-inner">
                        <div class="card">
                            <img class=""
                                src="https://jobshot.jp/wp-content/uploads/2020/06/social-media-attraction-2040561.png">
                            <h3 class="ttl">マンツーマンの手厚いサポート</h3>
                            <p class="text">
                                毎週オンライン面談で学習の進捗に合わせて計画の見直しやモチベーションの管理を行います。</p>
                        </div>
                        <div class="card">
                            <img class=""
                                src="https://jobshot.jp/wp-content/uploads/2020/06/social-network-1551999.png">
                            <h3 class="ttl">チャットサポート</h3>
                            <p class="text">
                                学習の質を高めるチャットでの質問に対して的確なアドバイスを行い、分からないを解消します。
                            </p>
                        </div>
                        <div class="card">
                            <img class=""
                                src="https://jobshot.jp/wp-content/uploads/2020/06/study.png">
                            <h3 class="ttl">最適な学習方法の提案</h3>
                            <p class="text">
                                コーチングによる独学力(セルフマネジメント・問題解決力)の向上を図り、最適な学習方法を提案します。
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">プログラミングを学ぶメリット</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-section-text-container">
                        <p>
                            「プログラミングを学んだ方が将来に活きるのではないか。」<br>そんな漠然とした不安を持っていないでしょうか？<br><br>
                            一方で、将来に活きるだろうとは思うものの、実際に今どのように活用することができるのかなかなかイメージができない方も多いと思います。<br><br>
                            実際に学生のうちからプログラミングを学ぶことには多くのメリットがあります。社会人になって勉強をしようと思っても時間が取れずにできなかった声も多いため、時間のある学生のうちに学んでおくことがおすすめです。<br>
                        </p>
                    </div>
                    <div class="techbuild-section-merit-container">
                        <div class="techbuild-section-merit-each">
                            <p>1.インターン/バイトの時給が高い</p>
                        </div>
                        <div class="techbuild-section-merit-each">
                            <p>2.スキマ時間で稼ぐことができる</p>
                        </div>
                        <div class="techbuild-section-merit-each">
                            <p>3.就職活動に活かすことができる</p>
                        </div>
                        <div class="techbuild-section-merit-each">
                            <p>4.年齢に関係なく稼ぐことができる</p>
                        </div>
                        <div class="techbuild-section-merit-each">
                            <p>5.論理的思考を養うことができる</p>
                        </div>
                        <div class="techbuild-section-merit-each">
                            <p>6.企業に雇用されない働き方ができる</p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">TECH-BUILDなら<br>あなたを徹底サポート</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-support-content">
                        <h3 class="techbuild-support-title">
                            <p class="xx-small">サポート</p>
                            <p class="xx-large">01</p>
                            <p class="small">現場のエンジニアが考える</p>
                            最適なカリキュラム
                        </h3>
                        <div class="techbuild-support-image">
                            <img src="https://jobshot.jp/wp-content/uploads/2020/06/personal_data_.png"
                                alt="">
                            <p>目的に応じた最適なカリキュラムを作成します。<br>
                                だから、プログラミング学習を挫折することなく「最短・最速」で学ぶことができます。</p>
                        </div>
                    </div>
                </div>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-support-content">
                        <h3 class="techbuild-support-title">
                            <p class="xx-small">サポート</p>
                            <p class="xx-large">02</p>
                            <p class="small">あなた専属の</p>
                            優秀な現役エンジニアコーチ
                        </h3>
                        <div class="techbuild-support-image">
                            <img src="https://jobshot.jp/wp-content/uploads/2020/06/cto.png"
                                alt="">
                            <p>コーチは全員、有名IT企業所属のエンジニア・ベンチャー企業のCTO。開発経験が豊富なエンジニアコーチがあなたの目的達成に向けてサポート致します。
                            </p>
                        </div>
                        <h3 class="techbuild-support-coach">現役エンジニアコーチ例</h3>
                        <div class="techbuild-coach-inner">
                            <div class="card">
                                <img class="company-student-success-img student-success-img"
                                    src="https://jobshot.jp/wp-content/uploads/2020/06/D07476F1-96A0-4CE6-B1CB-55524C382E0C-26607-00000B361547ECD8-e1592481918599.jpg">
                                <h3 class="ttl">米山 輝一</h3>
                                <p class="text">
                                    2003年に新卒で楽器メーカーに入社し、サーバーサイドエンジニアとして音楽系サービスの開発を担当。その後Androidエンジニアに転向してスマートフォン向け音楽サービスの開発をリード。2012年にITメガベンチャーに移り、音楽アプリの開発やライブストリーミングサービスの立ち上げを担当。現在は自動車系サービスのプロダクトマネージャーを務める。
                                </p>
                            </div>
                            <div class="card">
                                <img class="company-student-success-img student-success-img"
                                    src="https://jobshot.jp/wp-content/uploads/2020/06/image-5-e1592482044740.png">
                                <h3 class="ttl">大橋 拓矢</h3>
                                <p class="text">
                                    株式会社トリピアCTO
                                    慶應義塾大学理工学部情報工学科卒。大学1年生の冬から未経験でITベンチャー（渋谷）にインターン。大学2年生の夏からITベンチャー（新宿）に移り自社開発、受託開発を経験、社内学生CTOとして活躍。大学3,4年生では外部企業へのSESを経験、2019年秋から株式会社トリピアに参画してCTOとして活動。趣味はカメラ、旅行、テニス、モータースポーツなど。
                                </p>
                            </div>
                            <div class="card">
                                <img class="company-student-success-img student-success-img"
                                    src="https://jobshot.jp/wp-content/uploads/2020/06/105945-e1592481953100.jpg">
                                <h3 class="ttl">安達 悠希也</h3>
                                <p class="text">
                                    東京大学工学部卒。学生時代は人材系IT企業のインターンで開発経験を積みながら、インターンチームのリーダーとしてプログラミング未経験の学生の技術指導を行う。2019年に新卒でヤフーに入社し、広告プランニングツールのバックエンドを担当。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-support-content">
                        <h3 class="techbuild-support-title">
                            <p class="xx-small">サポート</p>
                            <p class="xx-large">03</p>
                            <p class="small">分からないを解消！</p>
                            チャットサポート
                        </h3>
                        <div class="techbuild-support-image">
                            <img src="https://jobshot.jp/wp-content/uploads/2020/06/chat.png"
                                alt="">
                            <p>分からないことがあったときはコーチに質問することができます。自分で解決出来ない課題や、より良い実装方法など現役エンジニアに質問して現場のスキルを身につけましょう。
                            </p>
                        </div>
                    </div>
                </div>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-support-content">
                        <h3 class="techbuild-support-title">
                            <p class="xx-small">サポート</p>
                            <p class="xx-large">04</p>
                            <p class="small">スムーズなサポートを提供</p>
                            TECH-BUILD運営事務局
                        </h3>
                        <div class="techbuild-support-image">
                            <img src="https://jobshot.jp/wp-content/uploads/2020/06/project_presentation_.png"
                                alt="">
                            <p>あなたのこれまでの学習状況やプログラミング勉強のヒアリングを行い、あなた専属の担当コーチのマッチングを行います。またサービスの利用開始までガイダンスサポートをするため、スムーズな利用開始を提供します。
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">JobShot×TECH-BUILD<br>サポート例</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-section-main-container">
                        <div class="techbuild-support-content">
                            <h3 class="techbuild-support-ex-title">サポート例①</h3>
                            <h3 class="techbuild-support-title">
                                <p class="small">現状ヒアリング</p>
                                学習開始時のガイダンス
                            </h3>
                            <div class="techbuild-support-ex-image">
                                <img src="https://jobshot.jp/wp-content/uploads/2020/06/gabrielle-henderson-HJckKnwCXxQ-unsplash.jpg"
                                    alt="">
                                <p>あなたのこれまでの学習状況やプログラミング勉強のヒアリングを行い、目的にあったカリキュラムを作成します。エンジニア就職・転職をしたい方、フリーランスになりたい方などそれぞれに応じたカリキュラムに対応することができます。
                                </p>
                            </div>
                        </div>
                        <div class="techbuild-support-content">
                            <h3 class="techbuild-support-ex-title">サポート例②</h3>
                            <h3 class="techbuild-support-title">
                                <p class="small">コーチからのナレッジ紹介</p>
                                週1回のオンライン面談
                            </h3>
                            <div class="techbuild-support-ex-image">
                                <img src="https://jobshot.jp/wp-content/uploads/2020/06/austin-distel-gUIJ0YszPig-unsplash.jpg"
                                    alt="">
                                <p>あなた専属の現役エンジニアコーチを週1回のオンライン面談を行います。オンライン面談では学習時の悩み相談や分からなかったところの質問対応、今後の学習方針などを相談することができます。
                                </p>
                            </div>
                        </div>
                        <div class="techbuild-support-content">
                            <h3 class="techbuild-support-ex-title">サポート例③</h3>
                            <h3 class="techbuild-support-title">
                                <p class="small">振り返りして実力をつけていこう</p>
                                毎週の学習ペース管理
                            </h3>
                            <div class="techbuild-support-ex-image">
                                <img src="https://jobshot.jp/wp-content/uploads/2020/06/eric-rothermel-FoKO4DpXamQ-unsplash.jpg"
                                    alt="">
                                <p>学習が予定通り進んでいるか、何か困っていることなどないか定期的に学習ペース管理をしながら確認を行います。定期的な振り返りをすることにより、これまでの成長を実感することができます。
                                </p>
                            </div>
                        </div>
                        <div class="techbuild-support-content">
                            <h3 class="techbuild-support-ex-title">サポート例④</h3>
                            <h3 class="techbuild-support-title">
                                <p class="small">時期に応じた</p>
                                公式アカウントからのコラム配信
                            </h3>
                            <div class="techbuild-support-ex-image">
                                <img src="https://jobshot.jp/wp-content/uploads/2020/06/jeshoots-com-Lu9FNRCqPys-unsplash.jpg"
                                    alt="">
                                <p>これまでのプログラミング学習者の経験を踏まえ、TECH-BUILD公式アカウントから学習につまずきやすいポイントや、ありがちなミスなどをコラムとして配信いたします。
                                </p>
                            </div>
                        </div>
                        <div class="techbuild-support-content">
                            <h3 class="techbuild-support-ex-title">サポート例⑤</h3>
                            <h3 class="techbuild-support-title">
                                <p class="small">現場で実戦しよう</p>
                                インターン開始までのサポート
                            </h3>
                            <div class="techbuild-support-ex-image">
                                <img src="https://jobshot.jp/wp-content/uploads/2020/06/mimi-thian-LVooQvKjLjw-unsplash.jpg"
                                    alt="">
                                <p>2ヶ月の学習終了後、あなた専属のキャリアアドバイザーがインターン開始までのサポートをいたします。インターンとして採用された方には最大3万円のキャッシュバックもございます！
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">サービスの流れ</h2>
                <div
                    class="techbuild-section-main-container techbuild-section-flow">
                    <ul class="flow">
                        <li>
                            <dl>
                                <dt><span class="icon">STEP.01</span>無料相談</dt>
                                <dd>相談のお申し込みをいただいてから24時間以内にご連絡いたします。</dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><span class="icon">STEP.02</span>キックオフ</dt>
                                <dd>コーチとのマッチングの前に初めにキックオフ面談を行います。</dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><span class="icon">STEP.03</span>学習期間</dt>
                                <dd>コーチのサポートを受けながら、プログラミングを学習していきます。</dd>
                            </dl>
                        </li>

                        <li>
                            <dl>
                                <dt><span class="icon">STEP.04</span>インターン</dt>
                                <dd>2ヶ月の学習終了後、アドバイザーがインターン開始までのサポートを行います。</dd>
                            </dl>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">卒業後のインターン先企業例</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-company-list">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/10/1fab54edd9273f883f2d9fe538ce5935.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2020/05/a6aa4b17d5a01e6f493a47c6bb229254.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2020/06/ee853603b1c4522be3e043e524c387ab.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2020/02/mercari_logo_vertical.jpg"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/10/0c138320274fc8bd22c7713f7e247c1c.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2020/03/23aa4adfa6a892134060e93c8302326d-1.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/07/3a94612aed7f9f96d134efe31fd516d0.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/10/fad051fe6560eb907fcfd5b04d0a5757.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/09/51599ebd3e5817d47ffe3acb69705b10.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2020/03/142e9da8d3135290f5ce31c0bc2cd6e3.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/03/bc5ef6de9e734a932342d3f67f8f79da.png"
                            alt="">
                        <img class="techbuild-company-img"
                            src="https://jobshot.jp/wp-content/uploads/2019/04/C3C901AA-951E-490D-93EC-810D5B411A86-e1572136951859.jpeg"
                            alt="">
                    </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">料金</h2>
                <div class="techbuild-section-main-container">
                    <div class="techbuild-price-inner">
                        <div class="card">
                            <h3 class="price-title">2ヶ月集中コース</h3>
                            <div class="price">
                                <h4>月額<span>13,330円</span>(税込)〜</h4>
                                <p>一括料金</p>
                                <p>165,000円(税込)</p>
                            </div>
                            <p class="price-notice">
                                ※1ヶ月目は月々の支払いとは別に入会金29,800円(税込)が必要となります。(入会金は一括料金に含まれます)<br>※受講の延長も50,000円で承っております。<br>※年率はカード会社によって異なります。支払い回数、最大12回
                            </p>
                        </div>
                        <div class="card">
                            <h3 class="price-title">3ヶ月継続コース</h3>
                            <div class="price">
                                <h4>月額<span>16,690円</span>(税込)〜</h4>
                                <p>一括料金</p>
                                <p>200,000円(税込)</p>
                            </div>
                            <p class="price-notice">
                                ※1ヶ月目は月々の支払いとは別に入会金29,800円(税込)が必要となります。(入会金は一括料金に含まれます)<br>※受講の延長も50,000円で承っております。<br>※年率はカード会社によって異なります。支払い回数、最大12回
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content">
                <h2 class="techbuild-section-title">よくある質問</h2>
                <div class="techbuild-section-main-container">
                    <div class="cp_qa">
                        <div class="cp_actab">
                            <input id="cp_tabfour021" type="checkbox" name="tabs">
                            <div class="cp_plus">+</div>
                            <label for="cp_tabfour021">
                                初心者ですが問題ありませんか？</label>
                            <div class="cp_actab-content">
                                問題ありません。TECH-BUILDでは現役の厳選されたコーチによって全力サポートさせていただきます。
                            </div>
                        </div>
                        <div class="cp_actab">
                            <input id="cp_tabfour022" type="checkbox" name="tabs">
                            <div class="cp_plus">+</div>
                            <label for="cp_tabfour022">
                                授業がなくてもスキルは身につくのでしょうか？</label>
                            <div class="cp_actab-content">
                                TECH-BUILDではコーチング学習によって従来の学習方法にはない独学力や自己管理能力を身に付けることができます。この能動的な学習によって卒業後も自立したエンジニアになることができます。
                            </div>
                        </div>
                        <div class="cp_actab">
                            <input id="cp_tabfour023" type="checkbox" name="tabs">
                            <div class="cp_plus">+</div>
                            <label for="cp_tabfour023">
                                仕事が忙しく、毎日学習時間が取れるか心配です。</label>
                            <div class="cp_actab-content">
                                専属コーチの徹底サポートによって学習の計画や進捗状況に合わせた質の高い学習方法を提案させていただきます方法を提案させていただきます。そのため最短で目標達成をすることができます。
                            </div>
                        </div>
                        <div class="cp_actab">
                            <input id="cp_tabfour024" type="checkbox" name="tabs">
                            <div class="cp_plus">+</div>
                            <label for="cp_tabfour024">
                                地方からの参加は可能ですか？</label>
                            <div class="cp_actab-content">
                                TECH-BUILDは全てオンラインでの対応となっていますのでどこからでも受講可能となっています。週一回のビデオ面談も行っていますのでしっかりとしたサポートを受けられます。
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="techbuild-section-content" id="contact">
                <h2 class="techbuild-section-title">まずは無料相談へ</h2>
                <div class="techbuild-section-main-container" id="techbuild_contactform_wrapper">
                    <div class="techbuild-contact-wrapper">'.$contactform_html.'</div>
                </div>
            </section>
    ';
    return  $style_html . $html;
}
add_shortcode('show_tech_build_lp', 'show_tech_build_lp');
