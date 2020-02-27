<?php

add_filter('widget_text', 'do_shortcode' );
// 記事の自動整形を無効化
remove_filter('the_content', 'wpautop');
// 抜粋の自動整形を無効化
remove_filter('the_excerpt', 'wpautop');

function convert_to_dropdown_checkboxes($html,$id,$name,$text,$tags){
  $html= str_replace( "\xc2\xa0", "", $html );
  $cnt=0;
  $selects_arr=explode("<opt",$html);
  array_splice($selects_arr, 0, 2);
  $html="<div class='select-dropdown-container'><label><input class='select-dropdown-check' type='checkbox'><div class='select-dropdown-text'>".$text."</div><ul>";
  foreach ($selects_arr as $select_bt) {
    if(strncmp($select_bt,"ion ",4)==0){
      $select_bt=str_replace("\r", '', $select_bt);
      $select_bt=str_replace("\n", '', $select_bt);
      $select_bt=str_replace("</option>", '', $select_bt);
      $select_bt=str_replace("</select>", '', $select_bt);
      $cnt++;
      $select_bt=str_replace( ">","><span class='select-chkbox-item'>",$select_bt);
      //検索条件の保存（リンクにある条件のチェックボックスをcheckedにする）
      $tag_cnt=0;
      foreach($tags as $tag){
        $tag = 'value="'.$tag;
        if(strpos($select_bt,$tag) !== false){
          $tag_cnt += 1;
        }
      }
      if($tag_cnt>0){
        $select_bt_2=str_replace("ion", "<li><label class='select-chkbox'><input type='checkbox' checked= 'checked' id='".$id.$cnt."' name='".$name."[]'", substr($select_bt, 0, 3));
        $select_bt_2 .= substr($select_bt, 4);
      }else{
        $select_bt_2=str_replace("ion", "<li><label class='select-chkbox'><input type='checkbox' id='".$id.$cnt."' name='".$name."[]'", substr($select_bt, 0, 3));
        $select_bt_2 .= substr($select_bt, 4);
      }
      $select_bt_2=rtrim($select_bt_2);
      $select_bt_2=$select_bt_2."</span></label></li>";
    }
    $html.=$select_bt_2;
  }
  $html.="</ul></label><div class='select-dropdown-shadow'></div></div>";
  return $html;
}

//文章のマルチ分割
function multiexplode ($delimiters,$string) {
  $ready = str_replace($delimiters, $delimiters[0], $string);
  $launch = explode($delimiters[0], $ready);
  return  $launch;
}

function search_form_func($atts){
  extract( shortcode_atts( array(
    'item_type' => '',
    'area_flag'  => true,
    'occupation_flag'  => true,
    'business_type_flag'  => true,
  ), $atts ) );

  if ($item_type=='' && isset($_GET['itype'])) {
    $item_type = my_esc_sql($_GET['itype']);
  }
  //検索条件の保持（urlから情報を取得）
  if (isset($_GET['sw'])) {
    $sw_tag = esc_sql($_GET['sw']);
  }

  if (isset($_GET['area'])) {
    $area_tag = esc_sql($_GET['area']);
  }

  if (isset($_GET['occupation'])) {
    $occupation_tag = esc_sql($_GET['occupation']);
  }

  if (isset($_GET['business_type'])) {
    $business_type_tag = esc_sql($_GET['business_type']);
  }
  if (isset($_GET['feature'])) {
    $featuring_tag = esc_sql($_GET['feature']);
  }
  $area_names=[];
  foreach($area_tag as $area){
    $exploded = multiexplode(array("{","}"),$area);
    $area_name = "";
    foreach($exploded as $explo){
      if(strlen($explo)>2){
        $explo = "%";
      }
      $area_name .= $explo;
    }
    $area_names[] = $area_name;
  }

  $args_area = array(
    'show_option_all' => 'エリアで絞り込み',
    'taxonomy'    => 'area',
    'name'        => 'area',
    'value_field' => 'slug',
    'hide_empty'  => 1,
    'selected'    => get_query_var("area",0),
    'hierarchical'       => 1,
    'depth'              => 2,
    'id' => 'area_'.$item_type,
    'echo' => false
  );
  $args_occupation = array(
    'show_option_all' => '職種で絞り込み',
    'taxonomy'    => 'occupation',
    'name'        => 'occupation',
    'value_field' => 'slug',
    'hide_empty'  => 0,
    'selected'    =>  get_query_var("occupation",0),
    'id' => 'occupation_'.$item_type,
    'echo' => false
  );
  $args_business_type = array(
    'show_option_all' => '業種で絞り込み',
    'taxonomy'    => 'business_type',
    'name'        => 'business_type',
    'value_field' => 'slug',
    'hide_empty'  => 1,
    'selected'    =>  get_query_var("business_type",0),
    'id' => 'business_type_'.$item_type,
    'echo' => false
  );

  if($item_type == 'internship'){
    $search_form_html ='<h3 class="widget-title">長期有給インターンを探す</h3>';
  }
  if($item_type == 'company'){
    $search_form_html ='<h3 class="widget-title">企業を探す</h3>';
  }
  if($item_type == 'summer_internship'){
    $search_form_html ='<h3 class="widget-title">サマーインターンを探す</h3>';
  }
  if($item_type == 'autumn_internship'){
    $search_form_html ='<h3 class="widget-title">秋インターンを探す</h3>';
  }

  $select_area =convert_to_dropdown_checkboxes(wp_dropdown_categories( $args_area ),"chk-ar-","area","エリアを選択",$area_names);
  $select_area = str_replace('&nbsp;&nbsp;&nbsp;', '┗', $select_area);
  $select_occupation=convert_to_dropdown_checkboxes(wp_dropdown_categories($args_occupation),"chk-op-","occupation","職種を選択",$occupation_tag);
  $select_business_type= convert_to_dropdown_checkboxes(wp_dropdown_categories($args_business_type),"chk-bt-","business_type","業種を選択",$business_type_tag);
  $home_url =esc_url( home_url( ));
  $search_form_html.='
  <form role="search" method="get" class="search-form" action="'.$home_url.'/'.$item_type.'" autocomplete="off"  name="form3">
    <div class="form-selects-row search-row" id="br_tag">
      <div class="form-selects-container_test form-group_test select">';

  $select_area = str_replace('select-dropdown-container','select-dropdown-container_test z-area', $select_area);
  $select_area = str_replace('<label><input','<label><input name="selective" onclick="clickBtn1()"',$select_area);
  $select_occupation = str_replace('select-dropdown-container','select-dropdown-container_test z-occupation', $select_occupation);
  $select_occupation = str_replace('<label><input','<label><input name="selective" onclick="clickBtn2()"',$select_occupation);
  $select_business_type = str_replace('select-dropdown-container','select-dropdown-container_test z-business', $select_business_type);
  $select_business_type = str_replace('<label><input','<label><input name="selective" onclick="clickBtn3()"',$select_business_type);

  if($area_flag===true){
    $search_form_html.=$select_area;
  }
  if($occupation_flag===true){
    $search_form_html.=$select_occupation;
  }
  if($business_type_flag===true){
    $search_form_html.=$select_business_type;
  }

  if(!isset($sw_tag)) {
    $sw_tag = "";
  }
  if($item_type == "internship" || $item_type == 'summer_internship' || $item_type == 'autumn_internship'){
    $search_form_html2 = '
    <div class="select-dropdown-container_test z-feature">
      <label><input class="select-dropdown-check" type="checkbox">
        <div class="select-dropdown-text2">
          <input type="search"  class="search-field_test " placeholder="特徴・条件" value="'.$sw_tag.'" name="sw" id="sw">
        </div>
        <ul>';
    $acf_args = array(
      'post_type' => array($item_type),
      'post_status' => array('publish'),
      'showposts' => 1,
    );
    $acf_post = get_posts($acf_args)[0];
    $features = get_field_object('特徴', $acf_post->ID )["choices"];
    $features = array("時給1000円以上","時給1200円以上","時給1500円以上","時給2000円以上","週1日ok","週2日ok","週3日以下でもok","1ヶ月からok","3ヶ月以下歓迎","未経験歓迎","1,2年歓迎","新規事業立ち上げ","理系学生おすすめ","外資系","ベンチャー","エリート社員","社長直下","起業ノウハウが身につく","インセンティブあり","英語力が活かせる","英語力が身につく","留学生歓迎","土日のみでも可能","リモートワーク可能","テスト期間考慮","短期間の留学考慮","女性おすすめ","少数精鋭","交通費支給","曜日/時間が選べる","夕方から勤務でも可能","服装自由","髪色自由","ネイル可能","有名企業への内定者多数","プログラミングが未経験から学べる");
    foreach($features as $feature_each){
      $search_form_html2 .= '
          <li>
            <label class="select-chkbox">
              <input type="checkbox" name="feature[]" id="" value="'.$feature_each.'">
              <span class="select-chkbox-item"> '.$feature_each.'</span>
            </label>
          </li>';
    }
    $search_form_html2 .= '
        </ul>
      </label>
    </div>';
    //特徴から探すの検索条件の保持
    foreach($featuring_tag as $feature){
      if(strpos($search_form_html2,$feature) !== false){
        $search_form_html2 = str_replace( '<input type="checkbox" name="feature[]" id="" value="'.$feature.'">','<input type="checkbox" checked="checked" name="feature[]" id="" value="'.$feature.'">',$search_form_html2);
      }
    }
  }else{
    $search_form_html2 = '
    <div class="select-dropdown-container_test z-feature">
      <input type="search"  class="search-field_test " placeholder="特徴・条件" value="" name="sw" id="sw">
    </div>';
  }
  $search_form_html2 .= '
    <button type="submit" class="search-submit button"><i class="fas fa-search"></i></button>
    <input type="submit" class="search-submit_test button" value="探す">';
  $search_form_html .= $search_form_html2;

  $search_form_html .= '<input type="hidden" name="itype" class="search-field" value="'.$item_type.'">';
  $search_form_html .= '</div></div>';

  if($item_type == 'internship'){
    if (isset($_GET['sort'])) {
      $sort = my_esc_sql($_GET['sort']);
      switch($sort){
        case 'popular':
          $search_form_html3 = '
          <div class="sort-search">
            <button type="submit" name="sort" class="search-field" value="new" onclick="sort_by_new()">新着順</button>
            <button type="submit" name="sort" class="search-field disabled" value="popular" onclick="sort_by_popular()" disabled>人気順</button>
            <button type="submit" name="sort" class="search-field" value="recommend" onclick="sort_by_recommend()">おすすめ順</button>
          </div>';
          break;
        case 'new':
          $search_form_html3 = '
          <div class="sort-search">
            <button type="submit" name="sort" class="search-field disabled" value="new" onclick="sort_by_new()" disabled>新着順</button>
            <button type="submit" name="sort" class="search-field" value="popular" onclick="sort_by_popular()">人気順</button>
            <button type="submit" name="sort" class="search-field" value="recommend" onclick="sort_by_recommend()">おすすめ順</button>
          </div>';
          break;
        case 'recommend':
          $search_form_html3 = '
          <div class="sort-search">
            <button type="submit" name="sort" class="search-field" value="new" onclick="sort_by_new()">新着順</button>
            <button type="submit" name="sort" class="search-field" value="popular" onclick="sort_by_popular()">人気順</button>
            <button type="submit" name="sort" class="search-field disabled" value="recommend" onclick="sort_by_recommend()" disabled>おすすめ順</button>
          </div>';
          break;
      }
    }else{
      $search_form_html3 = '
      <div class="sort-search">
        <button type="submit" name="sort" class="search-field disabled" value="new" onclick="sort_by_new()">新着順</button>
        <button type="submit" name="sort" class="search-field" value="popular" onclick="sort_by_popular()">人気順</button>
        <button type="submit" name="sort" class="search-field" value="recommend" onclick="sort_by_recommend()">おすすめ順</button>
      </div>';
    }
    $search_form_html3 .= '<p class="sort-field"></p>';
    $search_form_html .= $search_form_html3;
  }
  $search_form_html .= '</form>';

  //検索条件のvalueから、情報を抜き出す
  if (isset($featuring_tag)) {
    $feature_conditions = '　特徴・条件：';
    foreach($featuring_tag as $feature){
      $feature_conditions .= '<div class="card-category" style="background-color:#f9b539;">'.$feature.'</div>';
    }
  }

  if (isset($area_tag)){
    $area_conditions = 'エリア：';
    foreach($area_names as $area_name) {
      $frend = explode($area_name,$select_area);
      $area_text = '">';
      $frend2 = explode($area_text,$frend[1]);
      $frend3 = explode("</span>",$frend2[1]);
      $area_condition = str_replace('┗', '', $frend3[0]);
      $area_conditions .= '<div class="card-category">'.$area_condition.'</div>';
    }
  }

  if (isset($occupation_tag)){
    $occupation_conditions = '　職種：';
    foreach($occupation_tag as $occupation) {
      $frend = explode($occupation,$select_occupation);
      $delete_text = '">';
      $frend2 = explode($delete_text,$frend[1]);
      $frend3 = explode("</span>",$frend2[1]);
      $occupation_condition = str_replace('┗', '', $frend3[0]);
      $occupation_conditions .= '<div class="card-category">'.$occupation_condition.'</div>';
    }
  }

  if (isset($business_type_tag)){
    $business_type_conditions = '　業種：';
    foreach($business_type_tag as $business) {
      $frend = explode('value="'.$business,$select_business_type);
      $delete_text = '">';
      $frend2 = explode($delete_text,$frend[1]);
      $frend3 = explode("</span>",$frend2[1]);
      $business_type_condition = str_replace('┗', '', $frend3[0]);
      $business_type_conditions .= '<div class="card-category">'.$business_type_condition.'</div>';
    }
  }

  if (isset($area_tag) || isset($occupation_tag) || isset($business_type_tag) || (isset($featuring_tag))) {
    $search_conditions =   '
    <table class="condition_table">
      <tbody>
        <tr>
          <th width="20%">検索条件</th>
          <td>'.$area_conditions.$occupation_conditions.$business_type_conditions.$feature_conditions.'</td>
        </tr>
      </tbody>
    </table>';
    $search_form_html .= $search_conditions;
  }

  return $search_form_html;
}
add_shortcode('search_form','search_form_func');

?>
