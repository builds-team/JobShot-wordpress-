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
      'musojyuku' => array('就活無双塾','【3/◯◯~3/◯◯開催】<br>元JPMorgan新卒採用担当者によるエントリーシート添削企画開催！<br>※抽選で10名限定','2020/03/max-bender-FuxYvi-hcWQ-unsplash-e1583138722808.jpg')
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
      'musojyuku' => array('ES添削チャレンジは一つのチャレンジで一つしか提出出来ません','就活無双塾の要項２')
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

?>