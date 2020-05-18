<?php

function scholarship_index(){
  $home_url =esc_url( home_url( ));
    $html = '
    <div class="hero">
    <div class="contents">
      <div class="title_header" id="first">
          <h2>お祝い金制度って？</h2>
      </div><!--.title_header-->
      <div class="all_wrap" id="second">
        <h3 class="title_message">「お祝い金制度を通して、多くの人に長期インターンをはじめてほしい。」</h3>
        <div class="scholarship_wrap clearfix visible" data-scroll="once">
            <dl>
                <dt data-scroll="once" class="visible">長期インターンのイメージ</dt>
                <dd>長期インターンに興味・関心がある学生は75%を超えています（弊社調べ）。一方、実際に長期インターンを経験したことがある学生は10%以下であることが現状です。学生からは、「忙しいから時間がない…」「自分の能力で出来るのだろうか…」などの声が相次ぎ、アルバイトよりも壁が高いものだと位置付けられています。</dd>
            </dl>
            <div class="image_box">
                <img src="'.$home_url.'/wp-content/uploads/2019/09/samuel-zeller-_es6l-aPDA0-unsplash.jpg" alt="">
            </div><!-- .image_box -->
        </div><!-- .scholarship_wrap -->
        <div class="scholarship_wrap clearfix visible" data-scroll="once">
            <dl>
                <dt data-scroll="once" class="visible">実際に壁は高いの？</dt>
                <dd>しかし、いざ長期インターンを始めた学生にヒアリングをおこなうと、「大学とインターンは両立できる！」「バイトよりも長期インターンをはじめて本当によかった！」という感想を持つ学生がとても多いのです。また、長期インターンを行っている企業にそのまま就職したり、スキルをつけて起業をする学生も少なくありません。</dd>
            </dl>
            <div class="image_box">
                <img src="'.$home_url.'/wp-content/uploads/2019/09/studio-republic-fotKKqWNMQ4-unsplash.jpg" alt="">
            </div><!-- .image_box -->
        </div><!-- .scholarship_wrap -->
        <div class="scholarship_wrap clearfix visible" data-scroll="once">
            <dl>
                <dt data-scroll="once" class="visible">お祝い金とはなにか？</dt>
                <dd>「長期インターンを始めたい学生へ最大限の後押しをしたい」「長期インターン経験者の生の声を、はじめようか迷っている学生に伝えたい」という考えのもと、お祝い金制度を導入しました。「学生から学生へ、長期インターンに対するリアルな感想をJobShotを通して伝えていける」ために、ぜひお祝い金制度を活用してほしいです。</dd>
            </dl>
            <div class="image_box">
                <img src="'.$home_url.'/wp-content/uploads/2019/09/hunters-race-MYbhN8KaaEc-unsplash.jpg" alt="">
            </div><!-- .image_box -->
        </div><!-- .scholarship_wrap -->
        <div class="pages-apply-flow">
          <article class="scholarship-main-description">
            <h3 class="scholarship-flow-title">〜お祝い金支給までの流れ〜</h3>
            <p class="scholarship-flow-sub-title">最大10,000円プレゼント</p>
            <div class="scholarship-flow-figure">
              <ul class="scholarship-feature gift">
                <li class="scholarship-feature-1">
                  <p><i class="fas fa-pencil-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP1】<br>長期インターンに応募</span></p>
                </li>
                <li class="scholarship-feature-2">
                  <p><i class="far fa-calendar-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP2】<br>企業と面接日程の決定</span></p>
                </li>
                <li class="scholarship-feature-3>
                  <p><i class="far fa-handshake big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP3】<br>当日企業と面接を実施</span></p>
                </li>
                <li class="scholarship-feature-4">
                  <p><i class="fas fa-address-card big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP4】<br>採用、初出勤日を報告</span></p>
                </li>
                <li class="scholarship-feature-5">
                  <p><i class="fas fa-file-alt big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP5】<br>3ヶ月後体験記を記入</span></p>
                </li>
                <li class="scholarship-feature-6">
                  <p><i class="fas fa-coins big_icon"></i></p>
                  <p class="scholarship-flow-figure-text"><span class="emphasis-text">【STEP6】<br>お祝い金を獲得！</span></p>
                </li>
              </ul>
            </div>
            <section id="flow-section1">
              <h2>長期インターンに応募する</h2>
              <p>応募ボタンをクリックし、フィームに必要事項を入力後、送信で応募完了です。<br>選考には長くて1ヶ月以上かかる場合があるので、複数案件に応募するようにしましょう。</p>
            </section>
            <section id="flow-section2">
              <h2>応募した企業の採用担当者と面接日程を決定する</h2>
              <p>送信された応募フォームの内容と学生のプロフィールを元に書類選考を行います。<br>書類選考を通過した学生は、企業から面接日程に関してのメールが届きます。メールで企業の方と面接日程を決めましょう。</p>
            </section>
            <section id="flow-section3">
              <h2>企業の採用担当者と面接を実施する</h2>
              <p>メールで決めた時間帯に面接に向かいましょう。企業の方も忙しい中時間を取ってくださるので、無駄欠席や当日のキャンセルは厳禁です。</p>
            </section>
            <section id="flow-section4">
              <h2>採用決定！初出勤日をJobShotに報告する</h2>
              <p>採用が決定したら、企業の方と初出勤日を決めてJobShotに報告しましょう。<br>日程の報告は以下のフォームから行うようにしてください。<br><a href="'.$home_url.'/gift_money/entry">初出勤日の報告はこちらから</a></p>
            </section>
            <section id="flow-section5">
              <h2>長期インターンを3ヶ月続け、体験記を記入する</h2>
              <p>初出勤日から3ヶ月後、登録したメールアドレス宛にメールをお送りします。<br>そちらのメールに体験記を記載するためのフォームをお送りします。<br>フォーム記入を行うことにより、全行程が終了です。</p>
            </section>
            <section id="flow-section6">
              <h2>お祝い金を獲得！</h2>
              <p>ご登録済みのメールアドレス宛にお祝い金(Amazonギフト券)に関する詳細メールをお送りいたします。<br>そちらより詳細をご確認ください。</p>
            </section>
          </article>
        </div>
        <div class="under_area">
            <h4>先輩から後輩へ、体験記を残していきたい。<br>ぜひJobShotから長期インターンをはじめてください。</h4>
            <div class="gift_money_button" data-scroll="once"><a href="'.$home_url.'/internship">「長期インターン」を探す</a></div>
        </div><!-- .under_area -->
      </div>
    </div>
  </div>
    ';
    return $html;

}
add_shortcode("scholarship_index","scholarship_index");

function top_campaign(){
  $html = '
  <a href="https://jobshot.jp/gift_money">
    <div class="banner-container only-pc">
      <p>お祝い金<i class="fas fa-coins"></i>最大<span>10,000円</span>プレゼント！</p>
    </div>
  </a>';
  return $html;
}
add_shortcode("top_campaign","top_campaign");

?>