<?php

function apply_management_func($atts){
    $home_url =esc_url( home_url( ));
    extract(shortcode_atts(array(
        'item_type' => '',
    ), $atts));
    $paged = get_query_var('paged')? get_query_var('paged') : 1;  //pagedに渡す変数
    $args = array(
      //'numberposts'     => 20,
      'post_status' => array('publish','private'),
      'post_type' => array($item_type),
      'posts_per_page' => 10,                                     //posts_per_pageの指定
      'paged' => $paged,                                          //pagedの指定
    );
    if (!empty($_GET['sw'])) {
        $keyword = my_esc_sql($_GET['sw']);
        $args += array('s' => $keyword);
    }
    if(isset($_GET["feature"])){
        $features = $_GET["feature"];
        foreach($features as $feature){
            $metaquerysp[] = array('key'=>'特徴','value'=> $feature,'compare'=>'LIKE');
        }
        $args += array('meta_query' => $metaquerysp);
    }
    if($item_type=="event"){
        $args += array('orderby' => 'meta_value','meta_key' => '開催日','order'   => 'DESC','meta_query' => array('value' => date('Y/m/d'),'compare' => '>=','type' => 'DATE'));
    }
    //新卒投稿をしている企業のみを取得
    if($item_type=="company"){
        $args1=array('post_type' => array('job'),'posts_per_page' => -1);
        $job_posts=get_posts($args1);
        $author_id = array();
        foreach($job_posts as $job_post){
            if (!in_array($job_post->post_author, $author_id)) {
                $author_id[]= $job_post->post_author;
            }
        }
        $args += array('author__in'=>$author_id,);
    }
    //コラムのカテゴリー取得
    if($item_type=="column"){
        if(isset($_GET["first_category"])){
            $first_category = $_GET["first_category"];
            $first_category_metaquery = array('key'=>'first_category','value'=> $first_category,'compare'=>'LIKE');
            $args += array('meta_query' => array($first_category_metaquery));
        }
        if(isset($_GET["second_category"])){
            $second_category = $_GET["second_category"];
            $second_category_metaquery = array('key'=>'second_category','value'=> $second_category,'compare'=>'LIKE');
            $args += array('meta_query' => array($second_category_metaquery));
        }
    }

    // 業種のタクソノミーは企業情報に基づいているので該当する企業投稿を検索→authorに追加
    if (!empty($_GET['business_type'])) {
        if($item_type!="company"){
            $args2=array('post_type' => array('company'),'posts_per_page' => -1);
            $tax_obj2=get_taxonomy('business_type');
            $terms2= get_view_get_values('business_type',$tax_obj2->labels->name,true);
            $taxq2 = array('relation' => 'AND',);
            array_push($taxq2, array(
                'taxonomy' => 'business_type',
                'field' => 'slug',
                'terms' => $terms2,
                'include_children' => true,
                'operator' => 'IN',
            ));
            $args2 += array('tax_query' => $taxq2);
            $company_posts=get_posts($args2);
            $author_id2 = array();
            foreach($company_posts as $company_post){
                if (!in_array($company_post->post_author, $author_id2)) {
                    $author_id2[]= $company_post->post_author;
                }
            }
            $args+=array('author__in'=>$author_id2,);
        }
    }

    $tax_query = array('relation' => 'AND',);
    $tax_slugs = array('occupation','area','business_type');
    foreach ($tax_slugs as $tax_slug){
        if(!($tax_slug =='business_type' and ($item_type=="internship" or $item_type=="summer_internship" or $item_type=="autumn_internship"))){
            $tax_obj = get_taxonomy($tax_slug);
            $terms = get_view_get_values($tax_slug,$tax_obj->labels->name,true);
            if(!empty($terms)){
                array_push($tax_query, array(
                    'taxonomy' => $tax_slug,
                    'field' => 'slug',
                    'terms' => $terms,
                    'include_children' => true,
                    'operator' => 'IN',
                ));
            }
        }
    }
    $args += array('tax_query' => $tax_query);

    if (isset($_GET['sort'])) {
        $sort = my_esc_sql($_GET['sort']);
        switch($sort){
            case 'popular':
                $args += array('meta_key' => 'week_views_count','orderby' => 'meta_value_num',);
                break;
            case 'new':
                $args += array('order'   => 'DESC',);
                break;
            case 'recommend':
            	unset($args['posts_per_page']);
            	$args += array(
                	'posts_per_page' => -1,
            	);
                break;
        }
    }

    if($sort == 'recommend'){
    	$the_query = recommend_score($args);
    }else{
      $the_query = new WP_Query($args);
    }
    $html = "";
    $posts_per_page = 10;
    $html .= paginate( $the_query->max_num_pages, get_query_var( 'paged' ),$the_query->found_posts, $posts_per_page);
    if($item_type == "internship"){
      $html .= '<p style="text-align: right;"><a href="'.$home_url.'/?page_id=4899">応募者一覧はこちら</a></p>';
    }
    if ($the_query->have_posts()) :
      while ($the_query->have_posts()) :
        $the_query->the_post();
        $now_id = get_the_ID();
        $html .= view_apply_card_func($now_id);
        //各投稿のループ
      endwhile;
    endif;
    $html .= paginate( $the_query->max_num_pages, get_query_var( 'paged' ),$the_query->found_posts, $posts_per_page);
    wp_reset_postdata();
    return $html;
}
add_shortcode('apply_management', 'apply_management_func');

function view_applylist_func ( $atts ) {
  if(!current_user_can('administrator') && !current_user_can('company')){
    header('Location: '.$home_url.'/');
    die();
  }
  $home_url =esc_url( home_url( ));
  extract(shortcode_atts(array(
    'type' => '',
  ),$atts));

  if($_GET){
    $post_id = $_GET['pid'];
    $mode = $_GET['mode'];
  }

  if(get_post_type($post_id)=='internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'インターン応募';
  }else if(get_post_type($post_id)=='event'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'イベント応募';
    if($post_id == 7554){
      $formname = 'ベイカレント';
    }
    if($post_id == 7842){
      $formname = '【就活無双塾×JobShot】';
    }
  }else if(get_post_type($post_id)=='summer_internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = 'サマーインターン';
  }else if(get_post_type($post_id)=='autumn_internship'){
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $entry_url = CFS()->get('リダイレクト先URL',$post_id);
    if($entry_url == ""){
      $formname = 'サマーインターン';
    }else{
      $formname = '秋インターン';
    }
  }else{
    $phtml = '<h3 class="widget-title">'.get_the_title($post_id).'</h3>';
    $formname = '新卒応募';
  }

  $f=false;
  $f=is_this_my_content($post_id);
  $style_html = '';

  $participant_num = do_shortcode(' [cfdb-count form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
  if($type == 'print'){
      if(get_post_type($post_id)=='event'){
          $style_html = '
          <style>
          /* イベント印刷用 */
          table.event_management_tbl02 tbody th {
            padding: 10px 15px;
            color: #000;
            vertical-align: middle;
            background: #A9A9A9;
            border-right: #000 solid 1px;
            border-bottom: #000 solid 1px;
            font-size: 15px;
          }
          table.event_management_tbl02 tbody td {
            padding: 10px 15px;
            vertical-align: middle;
            background: #FFF;
            border-bottom: #000 solid 1px;
            border-left: #000 solid 1px;
            color:#000;
            font-size: 12px;
          }
          table.event_management_tbl02 tbody tr:last-child th {
            border-bottom: #000 solid 1px;
          }
          .event_management_info table {
            margin: 40px;
            table-layout:fixed;
            font-size: 10px;
            width:320px;
            border-collapse: collapse;
            color:#000
          }
          table.event_management_info_tbl02 tbody, td, tr {
            border-collapse: collapse;
            border: 1px solid black;
          }
          .event_management_info {
            display:inline-block;
          }
          .event_management_center {
            text-align: center;
          }
          .event_management_name td{
            font-weight: bold;
            font-size: 15px !important;
          }
          td.event_management_furigana{
            border-bottom:#000 dotted 1px !iomportant;
          }
          .event_management_over td{
            word-wrap: break-word;
          }
          table.event_management_info_tbl02 tbody tr:last-child td {
            width: 320px;
          }
          .event_management_sottunen td{
              height="20" 
              width="300"
              /*height="20" width="300"*/
          }
          .event_management_kyomi_gyo {
              height="100"
          }
          .all_event_management_table {
              font-size = 2;
          }
          </style>
          ';
          $phtml.='<p>'."全".$participant_num."件".'<p>';
          $phtml.=
          do_shortcode('[cfdb-html form="/'.$formname.'.*/" orderby="Submitted desc" filter="job-id='.$post_id.'"]
          <font size="2">
            <div class = "event_management_info">
              <table class="event_management_info_tbl02">
                <tbody>
                  <tr>
                    <th>フリガナ</th>
                    <td class="event_management_modi event_management_center event_management_furigana"><p>[get_user_ruby field=login value="${your-id}"]</p></td>
                    <td class="event_management_modi event_management_center" rowspan="2">[get_user_sex field=login value="${your-id}"]</td>
                  </tr>
                    <th>名前</th>
                    <td class="event_management_modi event_management_center event_management_name"><p>${your-name}</p></td>
                  <tr>
                    <th>大学・学部</th>
                    <td class="event_management_modi event_management_center" colspan="2"><p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p></td>
                  </tr>
                  <tr>
                    <th>卒業年度</th>
                    <td class="event_management_modi event_management_center event_management_sottunen" colspan="2"><p>[get_user_graduate_year field=login value="${your-id}"]</p><p>[get_user_school_year ield=login value="${your-id}"]</p></td>
                  </tr>
                  <tr>
                    <th>資格</th>
                    <td class="event_management_modi event_management_center" colspan="2"><p>[get_user_skill field=login value="${your-id}"]</td>
                  </tr>
                    <th>経歴</th>
                    <td class="event_management_modi event_management_center " colspan="2"><p>プログラミング：[get_user_experience_programming field=login value="${your-id}"]<br>留学：[get_user_studied_abroad field=login value="${your-id}"]</p></td>
                  <tr>
                    <th>興味ある業界</th>
                    <td  colspan="2" class="event_management_over event_management_kyomi_gyo"><div class="event_management_modi event_management_center" ><p>[get_user_bussiness_type field=login value="${your-id}"]</div></p></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </font>
          [/cfdb-html]');
          $phtml.='<p>'."全".$participant_num."件".'<p>';
          return $style_html.$phtml;
      }
  }
  if($mode=='dbview'){
    $phtml.='<a href="'.str_replace('mode=dbview','',$_SERVER["REQUEST_URI"]).'">通常表示に切り替え</a>';
    $phtml.=do_shortcode(' [cfdb-datatable form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
  }else{
    if(get_post_type($post_id)=='event'){
      $phtml.='
      <a href="'.$_SERVER["REQUEST_URI"].'&mode=dbview">データベース表示に切り替え（検索・並べ替え可能）</a>';
      $phtml.='<p><a href="'.$home_url.'/manage_application_print?pid='.$post_id.'">印刷用はこちら</a><p>';
      $phtml.='<p>'."全".$participant_num."件".'<p>';
      $phtml.=
      do_shortcode('[cfdb-html form="/'.$formname.'.*/" orderby="Submitted desc" filter="job-id='.$post_id.'"]
      {{BEFORE}}
      <font size="2">
        <table class="tbl02" style="font-size: small;">
          <thead>
            <tr>
              <th width="15%"></th>
              <th>大学</th>
              <th>性別</th>
              <th>学年</th>
              <th>卒業年度</th>
              <th>応募日時</th>
              <th>連絡先</th>
              <th>資格・その他スキル</th>
              <th>プログラミング・留学経験</th>
              <th>所属団体</th>
              <th>興味のある業界</th>
            </tr>
          </thead>
          <tbody>
          {{/BEFORE}}
            <tr>
              <th>
                <a href="/user?um_user=${your-id}" style="color:white"><p><font size="1">[get_user_ruby field=login value="${your-id}"]</font><br>${your-name}</p><div>[get_avatar_sc_re user_login="${your-id}"]</div></a>
              </th>
              <td label="大学">
                <p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p>
              </td>
              [get_user_meta_info field=login value="${your-id}"]
              <td label="応募日時">
                <p>[submitted2str sbm="${Submitted}"]</p>
              </td>
              <td label="連絡先">
                <p>[get_user_mobile_number field=login value="${your-id}"]<br>[get_user_email field=login value="${your-id}"]</p>
              </td>
              <td label="資格・その他スキル">
                <p>[get_user_skill field=login value="${your-id}"]</p>
              </td>
              <td label="プログラミング・留学経験">
                <p>プログラミング：[get_user_experience_programming field=login value="${your-id}"]<br>留学：[get_user_studied_abroad field=login value="${your-id}"]</p>
              </td>
              <td label="所属団体">
                <p>[get_user_univ_community field=login value="${your-id}"]<br>[get_user_community_univ field=login value="${your-id}"]</p>
              </td>
              <td label="興味のある業界">
                <p>[get_user_bussiness_type field=login value="${your-id}"]</p>
              </td>
            </tr>
          {{AFTER}}
          </tbody>
        </table>
      </font>
      {{/AFTER}}
      [/cfdb-html]');
      $phtml.='<p>'."全".$participant_num."件".'<p>';
    }elseif(get_post_type($post_id)=='internship'){
      $phtml.='
        <a href="'.$_SERVER["REQUEST_URI"].'&mode=dbview">データベース表示に切り替え（検索・並べ替え可能）</a>';
      $phtml.='<p>'."全".$participant_num."件".'<p>';
        $phtml.=
        do_shortcode('[cfdb-html form="/'.$formname.'.*/" orderby="Submitted desc" filter="job-id='.$post_id.'"]
        {{BEFORE}}
        <font size="2">
          <table class="tbl02">
            <thead>
              <tr>
                <th width="15%"></th>
                <th>大学</th>
                <th>性別</th>
                <th>学年</th>
                <th>卒業年度</th>
                <th>応募日時</th>
                <th>連絡先</th>
                <th>選考状況</th>
              </tr>
            </thead>
            <tbody>
            {{/BEFORE}}
              <tr>
                <th>
                  <a href="/user?um_user=${your-id}" style="color:white"><p><font size="1">[get_user_ruby field=login value="${your-id}"]</font><br>${your-name}</p><div>[get_avatar_sc_re user_login="${your-id}"]</div></a>
                </th>
                <td label="大学">
                  <p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p>
                </td>
                [get_user_meta_info field=login value="${your-id}"]
                <td label="応募日時">
                  <p>[submitted2str sbm="${Submitted}"]</p>
                </td>
                <td label="連絡先">
                  <p>[get_user_mobile_number field=login value="${your-id}"]<br>[get_user_email field=login value="${your-id}"]</p>
                </td>
                <td label="選考状況">
                  <form action="" method="POST">
                    <div>
                      <p>[get_user_selection_status post_id='.$post_id.' value="${your-id}" ]<p>
                      <input type="hidden" name="update_user_selection_status" value="update_user_selection_status">
                      <input type="hidden" name="post_id" value="'.$post_id.'">
                      <input type="hidden" name="user_login_name" value="${your-id}">
                      <input type="submit" value="更新" class="status-update-button">
                    </div>
                  </form>
                </td>
              </tr>
            {{AFTER}}
            </tbody>
          </table>
        </font>
        {{/AFTER}}
        [/cfdb-html]');
        $phtml.='<p>'."全".$participant_num."件".'<p>';
    }else{
      $phtml.='
        <a href="'.$_SERVER["REQUEST_URI"].'&mode=dbview">データベース表示に切り替え（検索・並べ替え可能）</a>';
        $phtml.='<p>'."全".$participant_num."件".'<p>';
        $phtml.=
        do_shortcode('[cfdb-html form="/'.$formname.'.*/" orderby="Submitted desc" filter="job-id='.$post_id.'"]
        {{BEFORE}}
        <font size="2">
          <table class="tbl02">
            <thead>
              <tr>
                <th width="15%"></th>
                <th>大学</th>
                <th>性別</th>
                <th>学年</th>
                <th>卒業年度</th>
                <th>応募日時</th>
                <th>連絡先</th>
              </tr>
            </thead>
            <tbody>
            {{/BEFORE}}
              <tr>
                <th>
                  <a href="/user?um_user=${your-id}" style="color:white"><p><font size="1">[get_user_ruby field=login value="${your-id}"]</font><br>${your-name}</p><div>[get_avatar_sc_re user_login="${your-id}"]</div></a>
                </th>
                <td label="大学">
                  <p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p>
                </td>
                [get_user_meta_info field=login value="${your-id}"]
                <td label="応募日時">
                  <p>[submitted2str sbm="${Submitted}"]</p>
                </td>
                <td label="連絡先">
                <p>[get_user_mobile_number field=login value="${your-id}"]<br>[get_user_email field=login value="${your-id}"]</p>
                </td>
              </tr>
            {{AFTER}}
            </tbody>
          </table>
        </font>
        {{/AFTER}}
        [/cfdb-html]');
        $phtml.='<p>'."全".$participant_num."件".'<p>';
    }
  }
  return $style_html.$phtml;
}
add_shortcode('view_applylist','view_applylist_func');

function view_intern_all_applylist_func ( $atts ) {
  if(!current_user_can('administrator')){
    header('Location: '.$home_url.'/');
    die();
  }
  extract(shortcode_atts(array(
    'type' => '',
  ),$atts));

  if($_GET){
    $post_id = $_GET['pid'];
    $mode = $_GET['mode'];
  }

  $formname = 'インターン応募フォーム';

  $f=false;
  $f=is_this_my_content($post_id);

  $participant_num = do_shortcode(' [cfdb-count form="/'.$formname.'.*/"]');
  if($mode=='dbview'){
    $phtml.='<a href="'.str_replace('mode=dbview','',$_SERVER["REQUEST_URI"]).'">通常表示に切り替え</a>';
    $phtml.=do_shortcode(' [cfdb-datatable form="/'.$formname.'.*/"]');
  }else{
    $phtml.='
    <a href="'.$_SERVER["REQUEST_URI"].'&mode=dbview">データベース表示に切り替え（検索・並べ替え可能）</a>';
    $phtml.='<p>'."全".$participant_num."件".'<p>';
    $phtml.=
    do_shortcode('[cfdb-html form="'.$formname.'" orderby="Submitted desc"]
    {{BEFORE}}
    <font size="2">
      <table class="tbl02">
          <thead>
            <tr>
              <th></th>
              <th>大学</th>
              <th>卒業年度</th>
              <th>応募日時</th>
              <th>応募案件名</th>
              <th>連絡先</th>
              <th>選考状況</th>
              <th style="width:10%;">面接対策</th>
            </tr>
          </thead>
          <tbody>
          {{/BEFORE}}
            <tr>
              <th>
                <a href="/user?um_user=${your-id}" style="color:white"><p>${your-name}<br><font size="1">${your-id}</font></p><div>[get_avatar_sc_re user_login="${your-id}"]</div></a>
              </th>
              <td label="大学">
                <p>[my_get_userdata_by field=login value="${your-id}" data=univ]<br>[my_get_userdata_by field=login value="${your-id}" data=faculty]</p>
              </td>
              <td label="卒業年度">
                <p>[get_user_graduate_year field=login value="${your-id}"]</p>
              </td>
              <td label="応募日時">
                <p>[submitted2str sbm="${Submitted}"]</p>
              </td>
              <td label="応募案件名">
                <p>[get_user_meta_data field=login post_id="${job-id}"]</p>
              </td>
              <td label="連絡先">
                <p>[get_user_mobile_number field=login value="${your-id}"]<br>[get_user_email field=login value="${your-id}"]</p>
              </td>
              <td label="選考状況">
                <form action="" method="POST">
                  <div>
                    <p>[get_user_selection_status post_id="${job-id}" value="${your-id}" ]<p>
                    <input type="hidden" name="update_user_selection_status" value="update_user_selection_status">
                    <input type="hidden" name="post_id" value="${job-id}">
                    <input type="hidden" name="user_login_name" value="${your-id}">
                    <input type="submit" value="更新" class="status-update-button">
                  </div>
                </form>
              </td>
              <td label="面接対策">
                <p>${interview_practice}</p>
              </td>
            </tr>
          {{AFTER}}
          </tbody>
      </table>
    </font>
    {{/AFTER}}
    [/cfdb-html]');
    $phtml.='<p>'."全".$participant_num."件".'<p>';
  }
  return $phtml;
}
add_shortcode('view_intern_all_applylist','view_intern_all_applylist_func');


function view_apply_card_func($post_id){
  if(!in_the_loop()){
    global $post;
    $post_id=$post->ID;
  }
  switch(get_post_type($post_id)){
    case 'job':
      return view_apply_fullwidth_job_card_func($post_id);
    case 'internship':
      return view_apply_fullwidth_intern_card_func($post_id);
    case 'event':
      return view_apply_fullwidth_event_card_func($post_id);
    case 'company':
      return view_apply_company_card_func($post_id);
    case 'summer_internship':
      return view_apply_fullwidth_summer_intern_card_func($post_id);
    case 'autumn_internship':
      return view_apply_fullwidth_autumn_intern_card_func($post_id);
    break;
  }
  return;
}
add_shortcode('view-card','view_card_func');

//////////////////縦長のカードの関数///////////////////////////

function view_apply_company_card_func($post_id){
  $image_id = get_post_thumbnail_id($post_id);
  $image_url = wp_get_attachment_image_src($image_id, thumbnail);

  $test = view_terms_func($post_id, array('area','occupation','business_type','feature','acquire'),'<object>','','</object>');
  //$card_html='<div class="card card-company"><div class="card-bigimg-wrap"><img src="https://www.pakutaso.com/shared/img/thumb/MIYA2012DSCF8671_TP_V.jpg" class="card-bigimg-inner"></div><div class="card-text-content">';
  $card_html='<a class="card card-company" href="'. esc_url(get_permalink($post_id)).'"><div class="card-bigimg-wrap"><img src="https://www.pakutaso.com/shared/img/thumb/MIYA2012DSCF8671_TP_V.jpg" class="card-bigimg-inner"></div><div class="card-text-content card-text-content-company><h4 class="card-title">'.get_post_meta($post_id , '社名' ,true).'</h4><div class="card-category-container">'
  .get_favorites_button($post_id)
  .view_terms_func($post_id, array('area','occupation','business_type','feature','acquire'),'<object>','','</object>')

  .'</div></div></a>';
  //    $card_html.='</div></div></div>';
  return $card_html;
}
add_shortcode('view-company-card','view_company_card_func');

//////////////////fullwidthカードの関数///////////////////////////

/**
 * 項目を「業種・従業員数・場所・平均初任給・写真・お気に入りボタン・詳細を見るボタン」に変更する
 */

function view_apply_fullwidth_job_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $company_id = get_company_id($company);
  $company_url = get_permalink($company_id);
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $salary = get_field("給与",$post_id);
  $requirements = get_field("応募資格",$post_id);
  $work_contents = get_field("業務内容",$post_id);
  $favorite_url = $home_url.'/manage-favorite?pid='.$post_id;
  $detai_url = $home_url.'/manage_application?pid='.$post_id;

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-text">
        <div class="full-card-text-title">'.$occupation.'職</div>
        <div class="full-card-text-caption">
          <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
        </div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th width="25%" style="text-align:center;" >給与</th>
              <td>'.$salary.'</td>
            </tr>
            <tr>
              <th width="25%" style="text-align:center;" >応募条件</th>
              <td>'.$requirements.'</td>
            </tr>
            <tr>
              <th width="25%" style="text-align:center; vertical-align:top;">業務内容</th>
              <td>'.$work_contents.'</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">
      <a href = "'.esc_url($favorite_url).'"><button class="button favorite innactive">☆お気に入り</button></a>
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-job-card','view_fullwidth_job_card_func');


function view_apply_fullwidth_intern_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $post_content = $post->post_content;
  $post_content = mb_substr($post_content,0,50).'...';
  $catchphrase = get_field("キャッチコピー",$post_id);
  $salary = get_field("給与",$post_id);
  $requirements =get_field("勤務条件",$post_id);
  $image = get_field("イメージ画像",$post_id);
  if(is_array($image)){
    $image_url = $image["url"];
  }else{
    $image_url = wp_get_attachment_url($image);
  }
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;
  $skill = get_the_terms($post_id,"acquire")[0]->name;
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $company_bussiness = get_field("事業内容",$post_id);
  $company_id = get_company_id($company);
  $company_url = get_permalink($company_id);
  $company_image = get_field("企業ロゴ",$company_id);
  if(is_array($company_image)){
    $company_image_url = $company_image["url"];
  }else{
    $company_image_url = wp_get_attachment_url($company_image);
  }
  if(empty($image_url)){
    $image_url = $company_image_url;
  }
  if(empty($company_bussiness)){
    $company_bussiness = get_field("事業内容",$company_id);
  }
  if(mb_strlen($company_bussiness) > 100){
    $company_bussiness = mb_substr($company_bussiness,0,100).'...';
  }
  $features = get_field('特徴',$post_id);

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }

  $favorite_url = $home_url.'/manage-favorite?pid='.$post_id;
  $detai_url = $home_url.'/manage_application?pid='.$post_id;

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title">'.$post_title.'</div>
        <div class="full-card-text-caption">
        <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
          <div class="card-category-container">
            <div class="card-category">'.$area.'</div>
            <div class="card-category">'.$occupation.'</div>
          </div>
        </div>
        <div>'.$company_bussiness.'</div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>勤務条件</th>
              <td>'.$requirements.'</td>
            </tr>
            <tr>
              <th>給与</th>
              <td>'.$salary.'</td>
            </tr>
          </tbody>
        </table>'.
        $features_html
      .'</div>
    </div>
    <div class="full-card-buttons">
      <a href = "'.esc_url($favorite_url).'"><button class="button favorite innactive">☆お気に入り</button></a>
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-intern-card','view_fullwidth_intern_card_func');

function view_apply_fullwidth_event_card_func($post_id){
  $post_title = get_the_title($post_id);
  $image = get_field("イメージ画像",$post_id);
  $image_url = $image["url"];
  $event_date = get_field('開催日時1',$post_id)['日付'].' '.get_field('開催日時1',$post_id)['開始時刻'].'〜'.get_field('開催日時1',$post_id)['終了時刻'];
  $event_day=get_field('開催日',$post_id);
  $today=date("Y/m/d");
  $area = get_the_terms($post_id,"area")[0]->name;
  $event_target = get_field('募集対象_短文',$post_id);
  $event_capacity = get_field('定員',$post_id);
  $sankas=get_field('参加企業',$post_id);
  $sanka_html='<div>';
  foreach((array)$sankas as $sanka){
    $sanka_html.=  '<div><a href="'.get_the_permalink($sanka->ID).'">'.$sanka->post_title.'</a></div>';
  }
  $sanka_html.='</div>';
  $home_url =esc_url( home_url( ));
  $detai_url = $home_url.'/manage_application?pid='.$post_id;
  $favorite_url = $home_url.'/manage-favorite?pid='.$post_id;
  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt>
      </div>
      <div class="full-card-text">';
  if($event_day<$today){
  $card_html.='
        <div class="full-card-text-title">
          <font color = "gray">'.$post_title.'【終了】</font>
        </div>';
  }else{
  $card_html.='
        <div class="full-card-text-title">'.$post_title.'</div>';
  }
  $card_html .='
        <table class="full-card-table">
          <tbody>';
  if(!empty($sankas)){
  $card_html.='
            <tr>
              <th>参加企業</th>
              <td>'.$sankas.'</td>
            </tr>';
  }
  $card_html .='
            <tr>
              <th>開催エリア</th>
              <td>'.$area.'</td>
            </tr>
            <tr>
              <th>開催日時</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>募集対象</th>
              <td>'.$event_target.'</td>
            </tr>
            <tr>
              <th>定員</th>
              <td>'.$event_capacity.'</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="full-card-buttons">
      <a href = "'.esc_url($favorite_url).'"><button class="button favorite innactive">☆お気に入り</button></a>
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';
  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-event-card','view_fullwidth_event_card_func');

function view_apply_fullwidth_summer_intern_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $intern_contents = get_field("インターン内容",$post_id);
  if(mb_strlen($intern_contents) > 100){
    $intern_contents = mb_substr($intern_contents,0,100).'...';
  }
  $event_date = get_field("開催日",$post_id);
  $deadline = get_field("締め切り日",$post_id);
  $image = get_field("トップイメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url=$home_url.'/?company='.$company_name;
  $features = get_field('特徴',$post_id);

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }
  $detai_url = $home_url.'/manage_application?pid='.$post_id;

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></div>
        <div class="full-card-text-caption">
        <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
        <div class="card-category-container">
            <div class="card-category">'.$area.'</div>
            <div class="card-category">'.$occupation.'</div>
          </div>
        </div>
        <div>'.$intern_contents.'</div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>開催日</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>締め切り日</th>
              <td>'.$deadline.'</td>
            </tr>
          </tbody>
        </table>'.$features_html
      .'</div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-intern-card','view_fullwidth_intern_card_func');

function view_apply_fullwidth_autumn_intern_card_func($post_id){
  $home_url =esc_url( home_url( ));
  $post = get_post($post_id);
  $post_title = get_the_title($post_id);
  $company = get_userdata($post->post_author);
  $company_name = $company->data->display_name;
  $intern_contents = get_field("インターン内容",$post_id);
  if(mb_strlen($intern_contents) > 100){
    $intern_contents = mb_substr($intern_contents,0,100).'...';
  }
  $event_date = get_field("開催日",$post_id);
  $deadline = get_field("締め切り日",$post_id);
  $image = get_field("トップイメージ画像",$post_id);
  $image_url = $image["url"];
  $area = get_the_terms($post_id,"area")[0]->name;
  $occupation = get_the_terms($post_id,"occupation")[0]->name;

  $current_user = wp_get_current_user();
  $current_user_name = $current_user->data->display_name;
  if($company_name == $current_user_name){
    $button_html = '<a href="#"><button class="button favorite innactive">編集をする</button></a>';
  }else{
    $button_html = '<button class="button favorite innactive">'.get_favorites_button($post_id).'</button>';
  }
  $company_url=$home_url.'/?company='.$company_name;
  $features = get_field('特徴',$post_id);

  if($features){
    $features_html = '';
    foreach($features as $feature){
      $features_html .=  '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }
  $detai_url = $home_url.'/manage_application?pid='.$post_id;

  $card_html = '
  <div class="card full-card">
    <div class="full-card-main">
      <div class="full-card-img">
        <img src="'.$image_url.'" alt="">
      </div>
      <div class="full-card-text">
        <div class="full-card-text-title"><a href="'.esc_url(get_permalink($post_id)).'">'.$post_title.'</a></div>
        <div class="full-card-text-caption">
        <div class="full-card-text-company"><a href="'.esc_url($company_url).'"><b>'.$company_name.'</b></a></div>
        <div class="card-category-container">
            <div class="card-category">'.$area.'</div>
            <div class="card-category">'.$occupation.'</div>
          </div>
        </div>
        <div>'.$intern_contents.'</div>
        <table class="full-card-table">
          <tbody>
            <tr>
              <th>開催日</th>
              <td>'.$event_date.'</td>
            </tr>
            <tr>
              <th>締め切り日</th>
              <td>'.$deadline.'</td>
            </tr>
          </tbody>
        </table>'.$features_html
      .'</div>
    </div>
    <div class="full-card-buttons">'
      .$button_html.'
      <a href = "'.esc_url($detai_url).'"><button class="button detail">詳細を見る</button></a>
    </div>
  </div>';

  return do_shortcode($card_html);
}
add_shortcode('view-fullwidth-intern-card','view_fullwidth_intern_card_func');

function view_intern_apply_num_func ( $atts ) {
  $args = array(
    'post_status' => array('publish','private'),
    'post_type' => array('internship'),
    'posts_per_page' => -1,
  );
  $html = '
  <table class="tbl02">
    <thead>
      <tr>
        <th>案件名</th>
        <th>職種</th>
        <th>応募数</th>
      </tr>
    </thead>
    <tbody>';
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
      $the_query->the_post();
      $post_id = get_the_ID();
      $post_title = get_the_title($post_id);
      $occupation = get_the_terms($post_id,"occupation")[0]->name;
      $formname = 'インターン応募';
      $post_views_count = do_shortcode(' [cfdb-count form="/'.$formname.'.*/" filter="job-id='.$post_id.'"]');
      $html .= '
      <tr>
        <td label="案件名">
          <p>'.$post_title.'</p>
        </td>
        <td label="職種">
          <p>'.$occupation.'</p>
        </td>
        <td label="応募数">
          <p>'.$post_views_count.'</p>
        </td>
      </tr>';
    endwhile;
  endif;
  $html .= '
    </tbody>
  </table>';
  wp_reset_postdata();
  return $html;
}
add_shortcode('view_intern_apply_num','view_intern_apply_num_func');

?>