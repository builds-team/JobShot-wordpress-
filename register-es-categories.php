<?php

/*

ESのカテゴリを追加する場合には以下の３つの関数を変更する

*/

//esのカテゴリの取得（key：getパラメータ、value:題名、説明、イメージ画像）
function get_es_categories($type){
  if($type == "practice"){
    $es_categories = array(
      'gakutika' => array('学生時代力を入れたこと','あなたが普段どのような活動を行い何を学んできたのかを問う定番項目です。','2020/03/akson-1K8pIbIrhkQ-unsplash-e1583117897684.jpg'),
      'self-pr' => array('自己PR','あなたがどのような人物であるのかを問うことを目的とした定番項目です。','2020/03/obi-onyeador-nsYboB2RDwU-unsplash.jpg'),
      'weak' => array('短所','あなたが自分のことを客観的に見ることができているのかを問う定番項目です。','2020/03/jordan-whitt-b8rkmfxZjdU-unsplash-e1583135048633.jpg'),
      'motivation' => array('志望動機','あなたがどれだけ応募した企業へ入りたいのか、その熱意を確認する定番項目です。','2020/03/business-1853682_1920-e1583123241772.jpg'),
      'news' => array('最近のニュース','あなたがどれだけ社会に対する問題意識を持っているか確認する定番項目です。','2020/03/roman-kraft-_Zua2hyvTBk-unsplash-e1583123073166.jpg')
    );
  }else{
    $es_categories = array(
      'musojyuku' => array('就活無双塾','【3/9~3/31開催】<br>元JPMorgan新卒採用担当者によるエントリーシート添削企画開催！<br>※抽選で10名限定','2020/03/max-bender-FuxYvi-hcWQ-unsplash-e1583138722808.jpg')
    );
  }
  return $es_categories;
}

//esのポイントの取得（key：getパラメータ、value:ポイントの配列の取得）
function get_es_points($type){
  if($type == "practice"){
    $es_points = array(
      'gakutika' => array(
        array(
          'title'=>'【結論】どのようなことに取り組んだのか述べる',
          'text'=>'「私は大学時代に◯◯に従事しました。」'
        ),
        array(
          'title'=>'【理由】なぜ上記に取り組んだのかを述べる',
          'text'=>'「もともと◯◯が足りないことには気が付いており、大学時代には◯◯を身に付けたいと考えたため上記の活動に取り組むことにしました。」'
        ),
        array(
          'title'=>'【目標や課題】活動における目標や見つかった課題を述べる',
          'text'=>'「◯◯という目標のもと活動を行っていましたが、◯◯という壁に直面することになりました。」'
        ),
        array(
          'title'=>'【解決策と行動】課題から考え出した解決策や行動を述べる',
          'text'=>'「そこで私は、◯◯を改善することで問題を解決できると考え、◯◯という計画を実行しました。」'
        ),
        array(
          'title'=>'【成果】結果としてどのような成果を得られたのか述べる',
          'text'=>'「結果として、◯◯という成果をあげることができました。」'
        ),
        array(
          'title'=>'【学びと今後の展望】得た知見や、今後の活かし方について述べる',
          'text'=>'「この経験から◯◯を学び、これを貴社での◯◯業務にいかしていきたいと考えています。」'
        ),
      ),
      'self-pr' => array(
        array(
          'title'=>'【結論】強みや長所を述べる',
          'text'=>'「私の強みは◯◯です。」'
        ),
        array(
          'title'=>'【具体例】過去に強みや長所が発揮された具体例を述べる',
          'text'=>'「◯年生の時には◯◯を行いました。」'
        ),
        array(
          'title'=>'【目標や課題】活動における目標や見つかった課題を述べる',
          'text'=>'「◯◯という目標のもと活動を行っていましたが、◯◯という壁に直面することになりました。」'
        ),
        array(
          'title'=>'【解決策と行動】課題から考え出した解決策や行動を述べる',
          'text'=>'「そこで私は、◯◯を改善することで問題を解決できると考え、◯◯という計画を実行しました。」'
        ),
        array(
          'title'=>'【成果】結果としてどのような成果を得られたのか述べる',
          'text'=>'「結果として、◯◯という成果をあげることができました。」'
        ),
        array(
          'title'=>'【学びと今後の展望】得た知見や、今後の活かし方について述べる',
          'text'=>'「この経験から◯◯を学び、これを貴社での◯◯業務にいかしていきたいと考えています。」'
        ),
      ),
      'weak' => array(
        array(
          'title'=>'【概要】自分の短所を簡潔に述べる',
          'text'=>'「私の短所は、◯◯です。」'
        ),
        array(
          'title'=>'【具体例】過去に自分の短所が出てしまった例を述べる',
          'text'=>'「以前、◯◯の状況下において私の短所が出てしまいました。」'
        ),
        array(
          'title'=>'【改善理由】短所を改善すべき理由を述べる',
          'text'=>'「しかし会社に入ると、◯◯であるためこの短所は改善する必要があると感じています。」'
        ),
        array(
          'title'=>'【解決法】短所を改善するための解決法を述べる',
          'text'=>'「そこで私は、この短所を解決するために◯◯と考え、常に心がけています。」'
        ),
      ),
      'motivation' => array(
        array(
          'title'=>'【志望理由】その企業を志望する旨を述べる',
          'text'=>'「◯◯な貴社で◯◯に貢献したいため応募しました。」'
        ),
        array(
          'title'=>'【志望業界や企業の軸】業界の動向などから企業選びの軸を伝える',
          'text'=>'「◯◯という成長を続けている◯◯業界に置いて、◯◯な人材が必要であると考えております。」'
        ),
        array(
          'title'=>'【他社ではなく志望企業】応募企業を志望する理由を述べる',
          'text'=>'「貴社には◯◯や◯◯といった要素を兼ね備えている方が多数いると、インターンでのコミュニケーションを通して強く感じました。」'
        ),
        array(
          'title'=>'【自己PR】実体験に基づいた自分の強みを述べる',
          'text'=>'「◯◯という経験をもとに、私は◯◯が強みです。」'
        ),
        array(
          'title'=>'【マッチング】企業の求める人材と自分が一致している旨を述べる',
          'text'=>'「貴社では◯◯という活躍ができると考えているため、貴社を強く志望しています。」'
        ),
      ),
      'news' => array(
        array(
          'title'=>'【選んだニュース】志望業界に基づくニュースを述べる',
          'text'=>'「私が最近気になっているニュースは◯◯です。」'
        ),
        array(
          'title'=>'【理由】上記のニュースを選んだ理由を述べる',
          'text'=>'「このニュースを選んだ理由は◯◯です。」'
        ),
        array(
          'title'=>'【概要】上記のニュースの概要を簡潔に述べる',
          'text'=>'「今回のニュースでは、◯◯で、◯◯という影響がありました。」'
        ),
        array(
          'title'=>'【考え】今回のニュースで自分なりの考えを述べる',
          'text'=>'「私は今回のニュースを受けて◯◯と感じ、◯◯を改善したいと考えています。」'
        ),
      )
    );
  }
  else{
    $es_points = array(
      'musojyuku' => array(
        'point' =>  array(
          '元JPMorgan新卒採用担当によるES添削！',
          '抽選で10名限定でオンライン添削を実施！',
          'お題は定番項目から自由に選択可能！',
          '対象期間内に1度のみ提出可能！',
          '当選者は4/1に発表！<br>(※メールアドレスにご連絡いたします)'
        ),
        'profile' =>  array(
          'title' =>  '就活無双塾 藤木',
          'text'  =>  '大学を卒業後、新卒で財閥系の日系金融機関に就職し、ファンドマネージャーを経験。その後JPMorganに転職し3年連続トップ3%評価。新卒採用担当としてES選考、一次、二次面接を担当。面接の想定質問集、GDのテーマと評価シート作成。現在は米系金融機関で法人営業。2016年以降150人以上の就活生をサポート。2019年7月からTwitterで就活支援を行い、半年でフォロワー7,000人を達成。信念は「テクニックと人格を向上させれば就活は無双できる」。',
        )
      )
    );
  }
  return $es_points;
}

//追加するget_param
function get_es_url(){
    $es_url = array(
      '学生時代力を入れたこと' => 'gakutika',
      '自己PR' => 'self-pr',
      '短所' => 'weak',
      '志望動機' => 'motivation',
      '最近のニュース' => 'news',
      '就活無双塾' => 'musojyuku'
    );
  return $es_url;
}

function get_es_example($category){
  $es_examples = array(
    'gakutika' => array('〜月間売り上げ10万円→340万円達成〜私はIT企業の営業部でインターン生として働いてた。<br>営業経験がない私は当初売り上げを全く上げることができなかった。<br>そこで、私は以下の施策を実施し、社内で【No1セールス】になることができた。<br>
    1 契約を取れている先輩方の同行回数を増やし、商談音声を録音し、隙間時間に録音をひたすら聴いた<br>
    2 契約率が低い原因は、提案力が低いからだと考え、商品理解を深めることはもちろんのこと、相手の企業の担当者の趣味や企業分析を事前に行った<br>
    3 質問に対しての答えが明確になっていなかったので、予想質問集などを作成し、模範解答を用意した。また、商談で新たに出た質問もストックした。<br>上記の3つの施策を実施することで、提案力高まり、契約率が上昇し、売り上げが徐々に上げることができた。インターンを始めて1年経った今では月間340万円の売り上げを上げることができ、【社内 No1セールス】になった。'),
    'self-pr' => array('私の強みはどんな状況でも粘り強く頑張れることです。<br>この強みが発揮できたのはインターン先での営業経験です。<br>私は営業する際に、「お客さまが本当に欲しているのは何か」を知るために、「相手の話をじ っくり聞く」営業を徹底して行ってきました。アイスブレイクなどの何気ない会話やちょっとしたお客さまの仕草などから、商品のどこに興味を持っているのかを判断していました。
    少しでも興味を持っていそうと判断したお客さまには、商談を何回も重ねアフターフォローをきめ細かく行うことを徹底して成果を上げてきました。<br>例えば、セミナーでお話ししたお客さまが見込みがありそうだったので、何度もお客さまの元に足を運び、昇段を重ね、新規でお取引をいただけるようになりました。<br>そのお客さまからは「こちらのニーズをしっかり聞いてくれていいご提案でした」というお言葉をいただきました。<br>貴社に入社後もこの粘り強い営業スタイルを生かして、お客さまのニーズを満たす提案をしていきたいです。'),
    'weak' => array('私の短所は、頑固なことです。自分の中で「こうあるべき」という考え方からなかなか考え方を変えることができませんでした。しかし、インターン先にて仕事でこだわるべきは自分の基準でないと気づき、さまざまな視点から物事を見る、同僚や先輩にこまめに意見を聞くなど優先すべき基準を見極め、目標達成のために最良の方法を取れるように注意しています。')
  );
  if($category == 'gakutika' || $category == 'self-pr' || $category == 'weak'){
    $es_content = $es_examples[$category][0];
    $home_url =esc_url( home_url( ));
    $es_categories = get_es_categories('practice');
    $es_category = $es_categories[$category][0];
    $es_description_image = $es_categories[$category][2];
    $es_example = '
    <div class="es-title-container">
      <h2 class="es-title">ES例</h1>
    </div>
    <div class="es-cards-container">
      <div class="es-timeline__item">
        <div class="es-timeline__card">
          <div class="es-text__body">
            <div class="es-text__eyecatch">
              <img src="'.$home_url.'/wp-content/uploads/'.$es_description_image.'">
            </div>
            <h3 class="es-text__title">'.$es_category.'</h3>
            <p class="es-text__description">'.$es_content.'</p>
          </div>
        </div>
      </div>
    </div>';
  }else{
    $es_total = get_past_es('all','all','publish');
    foreach($es_total as $es){
      $post_id = $es->ID;
      $user_id = get_current_user_id();
      $es_categories = get_es_categories('practice');
      $es_category = get_field("投稿テーマ",$post_id);
      if($es_category == $es_categories[$category][0]){
        $es_example = '
          <div class="es-title-container">
            <h2 class="es-title">ES例</h1>
          </div>
          <div class="es-cards-container">'.view_other_es($es,$user_id,1000).'</div>';
        break;
      }
    }
  }
  return $es_example;
}
function get_es_company($category){
  $es_companies = array(
    'gakutika' => array('三菱商事・ボストンコンサルティング・野村総合研究所・リクルート・丸紅など'),
    'self-pr' => array('伊藤忠商事・アビームコンサルティング・KPMG・J.P.モルガン・JR東海など'),
    'weak' => array('伊藤忠商事・デロイトトーマツコンサルティング・ANA・ゴールドマンサックス・富士フィルムなど'),
    'motivation' => array('三井物産・アクセンチュア・マッキンゼー・P&G・ベインアンドカンパニーなど'),
    'news' => array('ボストンコンサルティング・野村総合研究所・ローランド・ベルガー・A.T.カーニー・ソニーなど')
  );
  $es_company = $es_companies[$category][0];
  $es_categories = get_es_categories('practice');
  $es_category = $es_categories[$category][0];
  $es_company_html = '
  <div class="es-title-container">
    <h2 class="es-title">ESにおいて'.$es_category.'を使用する主な企業</h1>
  </div>
  <div class="es-cards-container"><p>'.$es_company.'</p></div>';
  return $es_company_html;
}
?>