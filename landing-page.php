<?php

function add_landing_page(){
    $contact_form_html = do_shortcode('[contact-form-7 id="2895" title="掲載のお問い合わせ"]');
    $html = '
    <div class="corp-contact-wrapper">
        <div class="corp-contact-cover row" style="background-image:  url(https://jobshot.jp/wp-content/uploads/2020/04/photo-1507679799987-c73779587ccf.jpeg) ">
            <div class="corp-contact-cover-inner">
                <div class="corp-contact-cover-left col s12 l6">
                    <img class="corp-contact-cover-logo" src="https://jobshot.jp/wp-content/uploads/2020/04/8d12a9f9f11d40a1dc7f06a7a45fe7ac.png" alt="">
                    <p class="corp-contact-cover-description">高学歴学生の求人・スカウトサービス</p>
                    <h1 class="corp-contact-cover-heading">学歴だけとは言わせない。<br><small>「賢さ」と「熱意」を兼ね備えた学生がすぐそこに。</small></h1>
                    <a href="#corp-contact-form-area" class="corp-contact-btn btn btn-large">資料請求・お問い合わせ</a>
                </div>
                <div class="corp-contact-cover-right col s12 l6">
                    <img class="corp-contact-cover-right-img" src="https://jobshot.jp/wp-content/uploads/2020/04/JobShot-img.png" alt="Infra トップページ掲載イメージ">
                </div>
            </div>
        </div>
        <div class="corp-contact-main-contents">
            <div id="corp-contact-listing-flow" class="even">
                <div class="corp-contact-each-content-inner">
                    <div class="student-service-future student-future">
                        <h2 class="corp-contact-main-heading">JobShotで採用できる学生の特徴</h2>
                        <div class="student-future-item rural-student">
                            <img class="student-future-img rural-student-img" src="https://jobshot.jp/wp-content/uploads/2020/04/7e7f2fa8e41d63018fc478b16acd84f7-e1586322552743.png" alt="">
                            <div class="student-service-future-text student-future-text hiring-feature-text">
                                <h2>高学歴の優秀な学生</h2>
                                <p>JobShotに登録しているのは東大生・早慶大生をはじめとする高学歴学生です。特に長期インターンを探している学生には、実務面でのスキルアップや社会経験を通じて自分の市場価値を高めることを目指す優秀な人材が多数を占めます。</p>
                            </div>
                        </div>
                        <div class="student-future-item">
                            <img class="student-future-img top-college-img-for-mobile" src="https://jobshot.jp/wp-content/uploads/2020/04/76401249838723d302b52ecc7d864dd2-e1586322941310.png" alt="">
                            <div class="student-service-future-text student-future-text hiring-feature-text">
                                <h2>東大学部就活生(22卒)のうち5人の1人が登録</h2>
                                <p>JobShotは22卒東大就活生のうち5人の1人に利用されており、東京大学・慶應大学・早稲田大学の学生が全ユーザーの50％以上を占めます。優秀層の中でも特に優秀な学生を採用できる可能性が高まります。</p>
                            </div>
                            <img class="student-future-img top-college-img-for-pc" src="https://jobshot.jp/wp-content/uploads/2020/04/76401249838723d302b52ecc7d864dd2-e1586322941310.png" alt="">
                        </div>
                        <div class="student-future-item">
                            <img class="student-future-img rural-student-img" src="https://jobshot.jp/wp-content/uploads/2020/04/2e62084f6c471563610ef44ce0d01b6d-e1586322866350.png" alt="">
                            <div class="student-service-future-text student-future-text hiring-feature-text">
                                <h2>長期で活躍できる人材</h2>
                                <p>「優秀な学生がうちに来ても、どうせすぐに辞めてしまうのでは…？」こんな不安を抱えた採用担当の方は多いと思います。しかしJobShotを利用する学生の約50％が22・23卒学生なので、せっかく教育したのに短期間で会社を離れてしまうといった事態を避けることができます。</p>
                            </div>
                        </div>
                    </div>
                    <div class="student-service-future service-future">
                      <h2 class="corp-contact-main-heading">サービス・機能の特徴</h2>
                      <div class="service-future-content">
                        <div class="service-future-item">
                          <img class="service-future-img" src="https://jobshot.jp/wp-content/uploads/2020/04/vasily-koloda-8CqDvPuo_kI-unsplash.jpg" >
                          <div class="student-service-future-text servise-future-text">
                            <p class="cmp">高学歴層特化</p>
                            <p class="ctt">東大・京大・早慶など高学歴特化の採用プラットフォームです。</p>
                          </div>
                        </div>
                        <div class="service-future-item aproach-with-scouts">
                          <img class="service-future-img aproach-with-scouts-img" src="https://jobshot.jp/wp-content/uploads/2020/04/austin-distel-Imc-IoZDMXc-unsplash.jpg" >
                          <div class="student-service-future-text servise-future-text">
                            <p class="cmp">スカウト機能</p>
                            <p class="ctt">最大35項目から学生に直接アプローチすることができます。</p>
                          </div>
                        </div>
                        <div class="service-future-item create-recruitment">
                          <img class="service-future-img create-recruitment-img" src="https://jobshot.jp/wp-content/uploads/2020/04/arlington-research-nFLmPAf9dVc-unsplash.jpg" >
                          <div class="student-service-future-text servise-future-text">
                            <p class="cmp">カスタマーサポート</p>
                            <p class="ctt">長期インターン初導入でも安心してご利用いただけます。</p>
                          </div>
                        </div>
                        <div class="service-future-item create-recruitment">
                          <img class="service-future-img create-recruitment-img" src="https://jobshot.jp/wp-content/uploads/2020/04/neonbrand-1-aA2Fadydc-unsplash.jpg" >
                          <div class="student-service-future-text servise-future-text">
                            <p class="cmp">イベント</p>
                            <p class="ctt">小規模イベントで意欲的な学生と直接接点を持つことができます。</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="inner-link-to-contact-form">
                      <a href="#corp-contact-form-area" class="corp-contact-btn btn btn-large">資料請求・お問い合わせ</a>
                        <p class="inner-link-to-contact-form-description">サービスを詳しく知りたい方、資料請求をご希望の方は<br>お気軽にお問い合わせください</p>
                    </div>
                  </div>
                </div>
                <div id="corp-contact-listing-flow" class="odd">
                  <div class="corp-contact-each-content-inner">
                    <div>
                      <h2 class="corp-contact-main-heading">掲載企業</h2>
                        <div class="corp-contact-posted-company-list">
                          <img class="corp-contact-posted-company-img" src="https://jobshot.jp/wp-content/uploads/2019/10/1fab54edd9273f883f2d9fe538ce5935.png" alt="">
                          <img class="corp-contact-posted-company-img" src="https://jobshot.jp/wp-content/uploads/2019/06/5c510c3eedb4fb4b32a9a2e972ebc010-e1559347271620.png" alt="">
                          <img class="corp-contact-posted-company-img" src="https://jobshot.jp/wp-content/uploads/2020/03/7c6bca29fd8bc1221792cba989776b46.png" alt="">
                          <img class="corp-contact-posted-company-img" src="https://jobshot.jp/wp-content/uploads/2020/02/mercari_logo_vertical.jpg" alt="">
                          <img class="corp-contact-posted-company-img" src="https://jobshot.jp/wp-content/uploads/2019/10/0c138320274fc8bd22c7713f7e247c1c.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id="corp-contact-listing-flow" class="even">
                    <div class="corp-contact-each-content-inner">
                      <div class="company-success">
                        <h2 class="corp-contact-main-heading">利用企業様の採用成功事例</h2>
                            <div class="">
                                <div class="testimonials__bg"></div>
                                <div class="tns-item tns-slide-active" id="testimonial-slider--dnd_area_main_banner-module-32-item0">
                                    <div class="testimonial__module flex mobile-col">
                                      <div class="testimonial__module__image" style="background-image: url(https://jobshot.jp/wp-content/uploads/2019/10/fad051fe6560eb907fcfd5b04d0a5757.png);" title="Placeholder Image">
                                    </div>
                                    <div class="testimonial__module__text">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                                        <path class="blockquote-icon" d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"></path>
                                      </svg>
                                      <div class="testimonial__module__text--quote">
                                        <blockquote><p>JobShotさんに掲載直後から多数のご応募をいただき、1ヶ月で東京大学、早稲田大学、慶応大学、上智大学などの学生をマーケティング職/エンジニア職で複数名採用することができました。みなさん非常に優秀でモチベーション高く取り組んでいただいております。今後も本サービスを利用し、学生インターンの活躍の場を広げていきたいと思います。</p></blockquote>
                                      </div>
                                      <div class="testimonial__module__text--author">HowTwo株式会社</div>
                                    </div>
                                </div>
                            </div>
                            <div class="testimonials__bg"></div>
                            <div class="tns-item tns-slide-active" id="testimonial-slider--dnd_area_main_banner-module-32-item0">
                                <div class="testimonial__module flex mobile-col">
                                    <div class="testimonial__module__image" style="background-image: url(https://jobshot.jp/wp-content/uploads/2019/08/499495b968c940a22f2ea0a15cfaca71.png);" title="Placeholder Image">
                                </div>
                                <div class="testimonial__module__text">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                                    <path class="blockquote-icon" d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"></path>
                                  </svg>
                                  <div class="testimonial__module__text--quote">
                                    <blockquote><p>新規事業の開発にあたり、学生エンジニアの仲間を探すために利用しました。結果、東京大学工学部システム創成学科（PSI）の非常に優秀な学生が採用できました。現在、リードエンジニアとして開発チームを牽引し、大きく貢献してくれています。本人の技術はもちろん、成長意欲の高い人材でとても頼もしい存在です。今後も優秀な学生との出会いを目的に利用していきたいです。</p></blockquote>
                                  </div>
                                  <div class="testimonial__module__text--author">エン婚活エージェント株式会社</div>
                                </div>
                            </div>
                        </div>
                        <div class="tns-item tns-slide-active" id="testimonial-slider--dnd_area_main_banner-module-32-item0">
                            <div class="testimonial__module flex mobile-col">
                                <div class="testimonial__module__image" style="background-image: url(https://jobshot.jp/wp-content/uploads/2019/05/30B0011E-699E-4292-A1F8-D740A325F67E.png);" title="Placeholder Image">
                                </div>
                                <div class="testimonial__module__text">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                                    <path class="blockquote-icon" d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"></path>
                                  </svg>
                                  <div class="testimonial__module__text--quote">
                                    <blockquote><p>JobShotを利用し、デザイナー職・人事職の長期有給インターン生を採用することができました。JobShotで採用した長期有給インターン生達は、私が想定していたインターン像をはるかに超えたレベルで、大きな強みを持ちながらも、ビジネスでの適切なコミュニケーションが可能な学生が多く存在し、当グループでは、すでに配属部署で重要な戦力になっています。私もインターン達から新鮮な学びを得ていて、気づきをもらえています。今後も、継続してJobShotを有効活用していきたいと強く考えております。</p></blockquote>
                                  </div>
                                  <div class="testimonial__module__text--author">電通イージス・ジャパングループ</div>
                                  <div class="testimonial__module__text--subtitle">人事部長　河野祐子氏</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="company-student-success student-success">
                <h2 class="corp-contact-main-heading"><span class="corp-contact-main-heading-underline">こんな学生が活躍しています</span></h2>
                    <div class="company-student-success-inner">
                        <div class="company-student-success-item company-student-success-item1 student-success-item card">
                        <a href="https://jobshot.jp/column/12003" target="_blank" rel="nofollow">
                            <img class="company-student-success-img student-success-img" src="https://jobshot.jp/wp-content/uploads/2020/04/236352a88472ea95eee13383169aff4a.png">
                            <div class="company-student-success-text student-success-text">
                            <p class="ttl">思考力向上と自己分析に役立つ？ 教育市場の変革を目指す理科大4年生の富田さんのインターンインタビュー</p>
                            </div>
                        </a>
                        </div>
                        <div class="company-student-success-item student-success-item card">
                        <a href="https://jobshot.jp/column/12039" target="_blank" rel="nofollow">
                            <img class="company-student-success-img student-success-img" src="https://jobshot.jp/wp-content/uploads/2020/04/defaff2c8dc343ebe4ba0347d8cf4add.png">
                            <div class="company-student-success-text student-success-text">
                            <p class="ttl">「メンバーどうしの刺激合いがあって楽しい！」明治3年の笠原剛さんに直撃インタビュー</p>
                            </div>
                        </a>
                        </div>
                        <div class="company-student-success-item company-student-success-item3 student-success-item card">
                        <a href="https://jobshot.jp/column/12158" target="_blank" rel="nofollow">
                            <img class="company-student-success-img student-success-img" src="https://jobshot.jp/wp-content/uploads/2020/04/78b7d4f75432db1e38c9c561c68079dc.png">
                            <div class="company-student-success-text student-success-text">
                            <p class="ttl">未経験から外資戦略コンサル出身起業家のもとでインターン！慶応2年遠藤遥加さんに迫る！</p>
                            </div>
                        </a>
                        </div>
                    </div>
              </div>
            </div>
          </div>
          <div id="corp-contact-form-area" class="corp-contact-form">
            <div class="corp-contact-each-content-inner">
              <h2 class="corp-contact-main-heading "><span class="corp-contact-main-heading-underline">資料請求・お問い合わせ</span></h2>
              <p class="corp-contact-description-under-heading">サービスを詳しく知りたい方、資料請求ご希望の方は<br>下記のフォームからご連絡ください</p>
              <div class="corp-contact-form-wrapper">'.$contact_form_html.'</div>
            </div>
          </div>
        </div>
      </div>';
return $html;
}
add_shortcode('add_landing_page','add_landing_page');
?>