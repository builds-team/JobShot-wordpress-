<?php

function template_column2_func($content){
    global $post;
    $post_id = $post->ID;
    $column_sidebar = do_shortcode("[add_sidebar_column]");

    $first_category_values = CFS()->get('first_category',$post_id);
    foreach ($first_category_values as $first_category_value => $first_category_label) {
        $first_category = $first_category_value;
    }
    $second_category_values = CFS()->get('second_category',$post_id);
    foreach ($second_category_values as $second_category_value => $second_category_label) {
        $second_category = $second_category_value;
    }

    $second_category_column_array = array(
        'columm' => 'コラム',
        'experience' => '体験記',
        'basic_knowledge' => '就活の基礎知識',
        'schedule' => '就活スケジュール',
        'entry_sheet' => 'エントリーシート',
        'test' => '筆記試験・WEBテスト',
        'discussion' => 'グループディスカッション',
        'interview' => '面接',
        'case_interview' => 'ケース面接・フェミル推定',
        'internship' => 'インターンシップ・ジョブ',
        'recruiter' => 'OB訪問・リクルーター',
        'english' => '英語・TOEIC対策',
        'science' => '理系学生',
        'female_student' => '女子学生',
        'athlete' => '体育会系',
        'graduate' => '大学院生',
        'aboroad' => '留学経験者',
        'foreign_capital' => '外資系のキャリア',
        'japanese_company' => '日系大手のキャリア',
        'venture' => 'ベンチャー企業のキャリア',
        'others' => 'その他のキャリア',
        'after' => '内定後にやるべきこと',
    );
    $column_search_second_category = $second_category_column_array[$second_category];
    $first_category_column_array = array(
        'internship' => '長期インターン',
        'beginner' => '就活初心者向けコンテンツ',
        'industry' => '業界研究',
        'selection' => '選考ステップ別対策',
        'your_contents' => '自分にあったコンテンツを探す',
        'career_plan' => 'キャリアプランを考える',
        'after_contents' => '内定者向けコンテンツ',
        'other_contents' => 'その他のコンテンツ',
    );
    $column_search_first_category = $first_category_column_array[$first_category];
    $home_url =esc_url( home_url());
    if(!empty($column_search_second_category)){
        $html = '
        <div class="column_navigation_bar">
            <span>
                <a href="'.$home_url.'/column">
                    <span>コラム記事トップ</span>
                </a>
            </span>
            <i class="fa fa-angle-right"></i>
            <span>
                <a href="'.$home_url.'/column?first_category='.$first_category.'">
                    <span>'.$column_search_first_category.'</span>
                </a>
            </span>
            <i class="fa fa-angle-right"></i>
            <span>
                <a href="'.$home_url.'/column?second_category='.$second_category.'">
                    <span>'.$column_search_second_category.'</span>
                </a>
            </span>
        </div>';
    }
    $html .= $content;
    return $html;
}

function manage_column_posts_columns($columns) {
    if(current_user_can( 'administrator' )){
        $columns['first_category'] = '大項目';
        $columns['second_category'] = '中項目';
        unset($columns['date']);
        unset($columns['seotitle']);
        unset($columns['seodesc']);
    }
    return $columns;
}
function add_column_category($column_name, $post_id) {
    if(current_user_can( 'administrator' )){
        if ( $column_name == 'first_category' ) {
            $first_category_values = CFS()->get('first_category',$post_id);
            foreach ($first_category_values as $first_category_value => $first_category_label) {
                $first_category = $first_category_value;
            }
            $first_category_column_array = array(
                'internship' => '長期インターン',
                'beginner' => '就活初心者向けコンテンツ',
                'industry' => '業界研究',
                'selection' => '選考ステップ別対策',
                'your_contents' => '自分にあったコンテンツを探す',
                'career_plan' => 'キャリアプランを考える',
                'after_contents' => '内定者向けコンテンツ',
                'other_contents' => 'その他のコンテンツ',
            );
            $column_search_first_category = $first_category_column_array[$first_category];
            if ( isset($column_search_first_category) && $column_search_first_category ) {
                echo attribute_escape($column_search_first_category);
            } else {
                echo __('None');
            }
        }
        if ( $column_name == 'second_category' ) {
            $second_category_values = CFS()->get('second_category',$post_id);
            foreach ($second_category_values as $second_category_value => $second_category_label) {
                $second_category = $second_category_value;
            }
            $second_category_column_array = array(
                'columm' => 'コラム',
                'experience' => '体験記',
                'basic_knowledge' => '就活の基礎知識',
                'schedule' => '就活スケジュール',
                'entry_sheet' => 'エントリーシート',
                'test' => '筆記試験・WEBテスト',
                'discussion' => 'グループディスカッション',
                'interview' => '面接',
                'case_interview' => 'ケース面接・フェミル推定',
                'internship' => 'インターンシップ・ジョブ',
                'recruiter' => 'OB訪問・リクルーター',
                'english' => '英語・TOEIC対策',
                'science' => '理系学生',
                'female_student' => '女子学生',
                'athlete' => '体育会系',
                'graduate' => '大学院生',
                'aboroad' => '留学経験者',
                'foreign_capital' => '外資系のキャリア',
                'japanese_company' => '日系大手のキャリア',
                'venture' => 'ベンチャー企業のキャリア',
                'others' => 'その他のキャリア',
                'after' => '内定後にやるべきこと',
            );
            $column_search_second_category = $second_category_column_array[$second_category];
            if ( isset($column_search_second_category) && $column_search_second_category ) {
                echo attribute_escape($column_search_second_category);
            } else {
                echo __('None');
            }
        }
    }
}
add_filter( 'manage_column_posts_columns', 'manage_column_posts_columns' );
add_action( 'manage_column_posts_custom_column', 'add_column_category', 10, 2 );

function add_sidebar_column(){
    $home_url =esc_url( home_url());
    // $html = '
    // <div class="column-navi">
    //     <h2>カテゴリー</h2>
    //     <ul class="column-container">
    //         <li class="column-section">
    //             <p>長期インターン</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=internship">長期インターン一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=columm">コラム</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=experience">体験記</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>就活初心者向け</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=beginner">就活初心者向け一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=basic_knowledge">就活の基礎知識</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=schedule">就活スケジュール</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>業界研究</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=industry">業界研究一覧</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>選考ステップ別対策</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=selection">選考ステップ別対策一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=entry_sheet">エントリーシート</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=test">筆記試験・WEBテスト</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=discussion">グループディスカッション</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=interview">面接</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=case_interview">ケース面接・フェルミ推定</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=internship">インターンシップ・ジョブ</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=recruiter">OB訪問・リクルーター</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=english">英語・TOEIC対策</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>自分にあったコンテンツ</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=your_contents">自分にあったコンテンツ一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=science">理系学生</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=female_student">女子学生</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=athlete">体育会系</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=graduate">大学院生</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=aboroad">留学経験者</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>キャリアプランを考える</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=career_plan">キャリアプランを考える一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=foreign_capital">外資系キャリア</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=japanese_company">日系大手のキャリア</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=venture">ベンチャー企業のキャリア</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=others">その他のキャリア</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>内定者向けコンテンツ</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=after_contents">内定者向けコンテンツ一覧</a>
    //                 </li>
    //                 <li>
    //                     <a href="'.$home_url.'/column?second_category=after">内定後にやること</a>
    //                 </li>
    //             </ul>
    //         </li>
    //         <li class="column-section">
    //             <p>その他のコンテンツ</p>
    //             <ul>
    //                 <li>
    //                     <a href="'.$home_url.'/column?first_category=other_contents">その他のコンテンツ一覧</a>
    //                 </li>
    //             </ul>
    //         </li>
    //     </ul>
    // </div>';
    $html = '
        <div class="column-navi">
            <h2>カテゴリー</h2>
            <ul class="column-container">
                <li class="column-section">
                    <p>選考ステップ別対策</p>
                    <ul>
                        <li>
                            <a href="'.$home_url.'/column?first_category=selection">選考ステップ別対策一覧</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=entry_sheet">エントリーシート</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=test">筆記試験・WEBテスト</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=discussion">グループディスカッション</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=interview">面接</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=case_interview">ケース面接・フェルミ推定</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=internship">インターンシップ・ジョブ</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=recruiter">OB訪問・リクルーター</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=english">英語・TOEIC対策</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>';
    if(isset($_GET["first_category"]) || isset($_GET["second_category"])){
        // $html = '
        // <div class="column-navi only-pc">
        //     <h2>カテゴリー</h2>
        //     <ul class="column-container">
        //         <li class="column-section">
        //             <p>長期インターン</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=internship">長期インターン一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=columm">コラム</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=experience">体験記</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>就活初心者向け</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=beginner">就活初心者向け一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=basic_knowledge">就活の基礎知識</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=schedule">就活スケジュール</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>業界研究</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=industry">業界研究一覧</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>選考ステップ別対策</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=selection">選考ステップ別対策一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=entry_sheet">エントリーシート</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=test">筆記試験・WEBテスト</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=discussion">グループディスカッション</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=interview">面接</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=case_interview">ケース面接・フェルミ推定</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=internship">インターンシップ・ジョブ</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=recruiter">OB訪問・リクルーター</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=english">英語・TOEIC対策</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>自分にあったコンテンツ</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=your_contents">自分にあったコンテンツ一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=science">理系学生</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=female_student">女子学生</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=athlete">体育会系</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=graduate">大学院生</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=aboroad">留学経験者</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>キャリアプランを考える</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=career_plan">キャリアプランを考える一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=foreign_capital">外資系キャリア</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=japanese_company">日系大手のキャリア</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=venture">ベンチャー企業のキャリア</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=others">その他のキャリア</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>内定者向けコンテンツ</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=after_contents">内定者向けコンテンツ一覧</a>
        //                 </li>
        //                 <li>
        //                     <a href="'.$home_url.'/column?second_category=after">内定後にやること</a>
        //                 </li>
        //             </ul>
        //         </li>
        //         <li class="column-section">
        //             <p>その他のコンテンツ</p>
        //             <ul>
        //                 <li>
        //                     <a href="'.$home_url.'/column?first_category=other_contents">その他のコンテンツ一覧</a>
        //                 </li>
        //             </ul>
        //         </li>
        //     </ul>
        // </div>';
        $html = '
        <div class="column-navi only-pc">
            <h2>カテゴリー</h2>
            <ul class="column-container">
                <li class="column-section">
                    <p>選考ステップ別対策</p>
                    <ul>
                        <li>
                            <a href="'.$home_url.'/column?first_category=selection">選考ステップ別対策一覧</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=entry_sheet">エントリーシート</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=test">筆記試験・WEBテスト</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=discussion">グループディスカッション</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=interview">面接</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=case_interview">ケース面接・フェルミ推定</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=internship">インターンシップ・ジョブ</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=recruiter">OB訪問・リクルーター</a>
                        </li>
                        <li>
                            <a href="'.$home_url.'/column?second_category=english">英語・TOEIC対策</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>';
    }
    return $html;
}
add_shortcode("add_sidebar_column","add_sidebar_column");

function add_top_bar_column(){
    $home_url =esc_url( home_url());
    $html = '
    <div class="background-img-container">
        <img src="https://images.unsplash.com/photo-1555443712-22cd30585e5c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80" alt="">
        <div class="background-img-text">
            <h1 class="font-serif">就活記事</h1>
            <p>就活で勝ち抜くために必要な情報や体験談が多数投稿されています。<br>就活初心者から選考中の人まで様々な人を対象にコンテンツを網羅。コラム記事を読んで万全の対策をしよう！</p>
        </div>
    </div>';
    return $html;
}
add_shortcode("add_top_bar_column","add_top_bar_column");

?>