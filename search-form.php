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
        $select_bt_2=str_replace("ion", "<li><label class='select-chkbox'><input type='checkbox' class='search_area' checked= 'checked' id='".$id.$cnt."' name='".$name."[]'", substr($select_bt, 0, 3));
        $select_bt_2 .= substr($select_bt, 4);
      }else{
        $select_bt_2=str_replace("ion", "<li><label class='select-chkbox'><input type='checkbox' class='search__area' id='".$id.$cnt."' name='".$name."[]'", substr($select_bt, 0, 3));
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

  $s_area = wp_dropdown_categories($args_area);
  $s_area = str_replace('<option class="level-0" value="%e3%82%aa%e3%83%b3%e3%83%a9%e3%82%a4%e3%83%b3">オンライン</option>','',$s_area);
  $select_area =convert_to_dropdown_checkboxes($s_area,"chk-ar-","area","エリア(14)",$area_names);
  $select_area = str_replace('&nbsp;&nbsp;&nbsp;', '┗', $select_area);
  $select_occupation=convert_to_dropdown_checkboxes(wp_dropdown_categories($args_occupation),"chk-op-","occupation","職種(12)",$occupation_tag);
  $select_business_type= convert_to_dropdown_checkboxes(wp_dropdown_categories($args_business_type),"chk-bt-","business_type","業種(17)",$business_type_tag);
  $home_url =esc_url( home_url( ));

  $select_area = str_replace('select-dropdown-container','select-dropdown-container_test z-area', $select_area);
  $select_area = str_replace('<label><input','<label><input name="selective" onclick="clickBtn1()"',$select_area);
  $select_area_sp = explode("<ul>",$select_area)[1];
  $select_area_sp = explode("</ul>",$select_area_sp)[0];
  $select_occupation = str_replace('select-dropdown-container','select-dropdown-container_test z-occupation', $select_occupation);
  $select_occupation = str_replace('<label><input','<label><input name="selective" onclick="clickBtn2()"',$select_occupation);
  $select_occupation_sp = explode("<ul>",$select_occupation)[1];
  $select_occupation_sp = explode("</ul>",$select_occupation_sp)[0];
  $select_business_type = str_replace('select-dropdown-container','select-dropdown-container_test z-business', $select_business_type);
  $select_business_type = str_replace('<label><input','<label><input name="selective" onclick="clickBtn3()"',$select_business_type);
  $select_business_type_sp = explode("<ul>",$select_business_type)[1];
  $select_business_type_sp = explode("</ul>",$select_business_type_sp)[0];

      //検索条件のvalueから、情報を抜き出す
      if (isset($featuring_tag)) {
        $feature_conditions = '<span>特徴・条件：</span>';
        foreach($featuring_tag as $feature){
          $feature_conditions .= '<div class="card-category" style="background-color:#f9b539;" id="'.$feature.'">'.$feature.'</div>';
        }
        $feature_conditions .= '<br>';
      }
    
      if (isset($area_tag)){
        $area_conditions = '<span>エリア　　：</span>';
        foreach($area_names as $area_name) {
          $frend = explode($area_name,$select_area);
          $area_text = '">';
          $frend2 = explode($area_text,$frend[1]);
          $frend3 = explode("</span>",$frend2[1]);
          $area_condition = str_replace('┗', '', $frend3[0]);
          $area_slug = get_term_by( 'name', $area_condition, 'area')->slug;
          $area_conditions .= '<div class="card-category" id = "'.$area_slug.'">'.$area_condition.'</div>';
        }
        $area_conditions .= '<br>';
      }
    
      if (isset($occupation_tag)){
        $occupation_conditions = '<span>職種　　　：</span>';
        foreach($occupation_tag as $occupation) {
          $frend = explode($occupation,$select_occupation);
          $delete_text = '">';
          $frend2 = explode($delete_text,$frend[1]);
          $frend3 = explode("</span>",$frend2[1]);
          $occupation_condition = str_replace('┗', '', $frend3[0]);
          $occupation_slug = get_term_by( 'name', $occupation_condition, 'occupation')->slug;
          $occupation_conditions .= '<div class="card-category" id = "'.$occupation_slug.'">'.$occupation_condition.'</div>';
        }
        $occupation_conditions .= '<br>';
      }
    
      if (isset($business_type_tag)){
        $business_type_conditions = '<span>業種　　　：</span>';
        foreach($business_type_tag as $business) {
          $frend = explode('value="'.$business,$select_business_type);
          $delete_text = '">';
          $frend2 = explode($delete_text,$frend[1]);
          $frend3 = explode("</span>",$frend2[1]);
          $business_type_condition = str_replace('┗', '', $frend3[0]);
          $business_type_slug = get_term_by( 'name', $business_type_condition, 'business_type')->slug;
          $business_type_conditions .= '<div class="card-category" id = "'.$business_type_slug.'">'.$business_type_condition.'</div>';
        }
        $business_type_conditions .= '<br>';
      }
    
      if (isset($area_tag) || isset($occupation_tag) || isset($business_type_tag) || (isset($featuring_tag))) {
        $search_conditions =   '
        <table class="condition_table">
          <tbody>
            <tr>
              <th>検索条件</th>
              <td>'.$area_conditions.$occupation_conditions.$business_type_conditions.$feature_conditions.'</td>
            </tr>
          </tbody>
        </table>';
        $search_form_html .= $search_conditions;
      }else {
        $search_form_html .= '<table class="condition_table"></table>';
      }

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
        $search_form_html .= '<form role="search" method="get" class="search-form" action="'.$home_url.'/'.$item_type.'" autocomplete="off"  name="form3">'.$search_form_html3;
      }else {
        $search_form_html .= '<form role="search" method="get" class="search-form" action="'.$home_url.'/'.$item_type.'" autocomplete="off"  name="form3">'.$search_form_html3;
      }
  $search_form_html.='
    <div class="form-selects-row search-row only-pc" id="br_tag">
      <div class="form-selects-container_test form-group_test select">';

  if($area_flag===true && $item_type != 'company'){
    $search_form_html.=$select_area;
  }
  if($occupation_flag===true && $item_type != 'company'){
    $search_form_html.=$select_occupation;
  }
  if($business_type_flag===true){
    $search_form_html.=$select_business_type;
  }

  if(!isset($sw_tag)) {
    $sw_tag = "";
  }
  $features = array("時給1000円以上","時給1200円以上","時給1500円以上","時給2000円以上","週1日ok","週2日ok","週3日以下でもok","1ヶ月からok","3ヶ月以下歓迎","未経験歓迎","1,2年歓迎","新規事業立ち上げ","理系学生おすすめ","外資系","ベンチャー","エリート社員","社長直下","起業ノウハウが身につく","インセンティブあり","英語力が活かせる","英語力が身につく","留学生歓迎","土日のみでも可能","リモートワーク可能","テスト期間考慮","短期間の留学考慮","女性おすすめ","少数精鋭","交通費支給","曜日/時間が選べる","夕方から勤務でも可能","服装自由","髪色自由","ネイル可能","有名企業への内定者多数","プログラミングが未経験から学べる");
  if($item_type == "internship" || $item_type == 'summer_internship' || $item_type == 'autumn_internship'){
    $search_form_html2 = '
    <div class="select-dropdown-container_test z-feature">
      <label><input class="select-dropdown-check" onclick="clickBtn4()" name="selective" type="checkbox">
        <div class="select-dropdown-text">特徴 (36)</div>
          <ul>';
    $acf_args = array(
      'post_type' => array($item_type),
      'post_status' => array('publish'),
      'showposts' => 1,
    );
    //$acf_post = get_posts($acf_args)[0];
    //$features = get_field_object('特徴', $acf_post->ID )["choices"];
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
    $search_form_html2 .= '
    <button type="submit" class="search-submit button">
      <i class="fas fa-search"></i>
    </button>
    <input type="submit" class="search-submit_test button" value="探す">
      <input type="hidden" name="itype" class="search-field" value="'.$item_type.'">
      </div>
    </div>';
    $search_form_html2 .= '
    <div class="freeword-search-container">
      <div class="select-dropdown-container_test">
        <label>
          <div class="select-dropdown-text2">
            <input type="search" class="search-field_test" placeholder="フリーワードから探す" value="'.$sw_tag.'" name="sw" id="sw">
          </div>
        </label>
      </div>
      <button type="submit" class="search-submit button"><i class="fas fa-search"></i></button>
      <input type="submit" class="search-submit_test button" value="探す">
    </div>';
  }else{
    $search_form_html2 = '
        <button type="submit" class="search-submit button">
          <i class="fas fa-search"></i>
        </button>
        <input type="submit" class="search-submit_test button" value="探す">
        <input type="hidden" name="itype" class="search-field" value="'.$item_type.'">
      </div>
    </div>
    <div class="freeword-search-container">
      <div class="select-dropdown-container_test z-feature">
        <input type="search"  class="search-field_test " placeholder="フリーワード検索" value="'.$sw_tag.'" name="sw" id="sw">
      </div>
      <button type="submit" class="search-submit button">
        <i class="fas fa-search"></i>
      </button>
      <input type="submit" class="search-submit_test button" value="探す">
    </div>';
  }
  if($item_type == 'internship'){
    $item_type_name = 'インターン';
  }else if($item_type == 'company'){
    $item_type_name = '企業';
  }
  $search_form_html .= $search_form_html2;
  $search_form_html_sp = '
  <div onclick="openSelectModal()" class="select-modal-open only-sp">
    <div>'.$item_type_name.'を絞り込む</div>
  </div>
  <div class="select-modal-container">
    <div class="select-modal-header">
      <span class="select-modal-title">'.$item_type_name.'を絞り込む</span>
      <span onclick="closeSelectModal()" class="select-modal-close"></span>
    </div>
    <div class="select-modal-body">
      <div class="select-modal-kind">
        <div class="select-modal-kind-title">
          <h4>エリア</h4>
        </div>
        <div class="select-modal-kind-ele">
          <ul>'.$select_area_sp.'</ul>
        </div>
      </div>
      <div class="select-modal-kind">
        <div class="select-modal-kind-title">
          <h4>職種</h4>
        </div>
        <div class="select-modal-kind-ele">
          <ul>'.$select_occupation_sp.'</ul>
        </div>
      </div>
      <div class="select-modal-kind">
        <div class="select-modal-kind-title">
          <h4>業種</h4>
        </div>
        <div class="select-modal-kind-ele">
          <ul>'.$select_business_type_sp.'</ul>
        </div>
      </div>
  ';
  if($item_type == "internship" || $item_type == 'summer_internship' || $item_type == 'autumn_internship'){
    $search_form_html_sp .= '
    <div class="select-modal-kind">
      <div class="select-modal-kind-title">
        <h4>特徴</h4>
      </div>
      <div class="select-modal-kind-ele">
        <ul>
    ';
    foreach($features as $feature_each){
      $search_form_html_sp .= '
          <li>
            <label class="select-chkbox">
              <input type="checkbox" name="feature[]" id="" value="'.$feature_each.'">
              <span class="select-chkbox-item"> '.$feature_each.'</span>
            </label>
          </li>';
    }
    $search_form_html_sp .= '
      </ul></div></div>
    ';
    foreach($featuring_tag as $feature){
      if(strpos($search_form_html_sp,$feature) !== false){
        $search_form_html_sp = str_replace( '<input type="checkbox" name="feature[]" id="" value="'.$feature.'">','<input type="checkbox" checked="checked" name="feature[]" id="" value="'.$feature.'">',$search_form_html_sp);
      }
    }
  }
  else {
    $search_form_html_sp = '
    <div onclick="openSelectModal()" class="select-modal-open only-sp">
      <div>'.$item_type_name.'を絞り込む</div>
    </div>
    <div class="select-modal-container">
      <div class="select-modal-header">
        <span class="select-modal-title">'.$item_type_name.'を絞り込む</span>
        <span onclick="closeSelectModal()" class="select-modal-close"></span>
      </div>
      <div class="select-modal-body">
        <div class="select-modal-kind">
          <div class="select-modal-kind-title">
            <h4>業種</h4>
          </div>
          <div class="select-modal-kind-ele">
            <ul>'.$select_business_type_sp.'</ul>
          </div>
        </div>
    ';
  }

  $search_form_html_sp .='
  </div>
  <div class="select-modal-footer">
      <span class="num__search-sp elect-modal-title"></span>
      <button type="submit" class="search-submit button select-modal-btn"><i class="fas fa-search"></i>選択した条件で絞り込む</button>
      <input type="submit" class="search-submit_test button" value="探す">
  </div>
</div>
  ';
  $search_form_html .= $search_form_html_sp;
  $search_form_html .= '</form>';

  return $search_form_html;
}
add_shortcode('search_form','search_form_func');

function Ajax_Search(){
  $url = $_SERVER['REQUEST_URI'];
  $area = [];
  $window_size = $_POST["window_size"];
  if(isset($_POST['area'])) {
    $area = $_POST['area'];
	 $area = $a = str_replace('┗', '', $area);
    $area_conditions = '<span>エリア　　：</span>';
    foreach($area as $a) {
      if($window_size > 1022){
        $area_slug = get_term_by( 'name', $a, 'area')->slug;
        $area_conditions .= '<div class="card-category" id = "'.$area_slug.'"><span class="select-chkbox-item">'.$a.'</span><span class="card-category_delete" ></span></div>';
      }else{
        $area_conditions .= '<div class="card-category"><span class="select-chkbox-item">'.$a.'</span></div>';
      }
    }
    $area_conditions .= '<br>';
  }
  $occupation = [];
  if(isset($_POST['occupation'])) {
    $occupation = $_POST['occupation'];
    $occupation_conditions = '<span>職種　　　：</span>';
    foreach($occupation as $o) {
      if($window_size > 1022){
        $occupation_slug = get_term_by( 'name', $o, 'occupation')->slug;

        $occupation_conditions .= '<div class="card-category" id = "'.$occupation_slug.'"><span class="select-chkbox-item">'.$o.'</span><span class="card-category_delete" ></span></div>';
      }else{
        $occupation_conditions .= '<div class="card-category"><span class="select-chkbox-item">'.$o.'</span></div>';
      }
    }
    $occupation_conditions .= '<br>';
  }
  $business = [];
  if(isset($_POST['business'])) {
    $business = $_POST['business'];
    $business_type_conditions = '<span>業種　　　：</span>';
    foreach($business as $b) {
      if($window_size > 1022){
        $business_type_slug = get_term_by( 'name', $b, 'business_type')->slug;
        $business_type_conditions .= '<div class="card-category" id = "'.$business_type_slug.'"><span class="select-chkbox-item">'.$b.'</span><span class="card-category_delete" ></span></div>';
      }else{
        $business_type_conditions .= '<div class="card-category"><span class="select-chkbox-item">'.$b.'</span></div>';
      }
    }
    $business_type_conditions .= '<br>';
  }
  $feature = [];
  if(isset($_POST['feature'])){
    $feature = $_POST['feature'];
    $feature_conditions = '<span>特徴・条件：</span>';
    foreach($feature as $f) {
      if($window_size > 1022){
        $feature_conditions .= '<div class="card-category" style="background-color:#f9b539;" id="'.trim($f).'"><span class="select-chkbox-item">'.$f.'</span><span class="card-category_delete"></span></div>';
      }else{
        $feature_conditions .= '<div class="card-category" style="background-color:#f9b539;"><span class="select-chkbox-item">'.$f.'</span></div>';
      }
    }
    $feature_conditions .= '<br>';
  }
  $sw = [];
  if(isset($_POST['sw'])){
    $sw = $_POST["sw"];
  }
  $count = Ajax_SearchNum('internship',$area,$occupation,$business,$feature,$sw);
  $html = '
  <tbody>
    <tr>
      <th>検索予定条件</th>
      <td>'.$area_conditions.$occupation_conditions.$business_type_conditions.$feature_conditions.'<span class="num__search">検索で'.$count.'件ヒット</span></td>
    </tr>
  </tbody>
  ';

  echo $html;
  die();
}
add_action( 'wp_ajax_ajax_search', 'Ajax_Search' );
add_action( 'wp_ajax_nopriv_ajax_search', 'Ajax_Search' );

function Ajax_SearchNum($item_type,$area,$occupation,$business_type,$features,$sw){
    $args = array(
        'posts_per_page' => 1000,
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
    );
    if (!empty($sw)) {
    $args += array('s' => $sw[0]);
    }
    if (!empty($features)) {
    foreach($features as $feature){
        $metaquerysp[] = array('key'=>'特徴','value'=> $feature,'compare'=>'LIKE');
    }
    $args += array('meta_query' => $metaquerysp);
  }
  if (!empty($business_type)) {
    if($item_type!="company"){
        $args2=array('post_type' => array('company'),'posts_per_page' => -1);
        $tax_obj2=get_taxonomy('business_type');
        $terms2= $business_type;
        $taxq2 = array('relation' => 'AND',);
        array_push($taxq2, array(
            'taxonomy' => 'business_type',
            'field' => 'name',
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
  if(!empty($occupation)){
      array_push($tax_query, array(
          'taxonomy' => 'occupation',
          'field' => 'name',
          'terms' => $occupation,
          'include_children' => true,
          'operator' => 'IN',
      ));
  }
  if(!empty($area)){
    array_push($tax_query, array(
        'taxonomy' => 'area',
        'field' => 'slug',
        'terms' => $area,
        'include_children' => true,
        'operator' => 'IN',
    ));
}
  $args += array('tax_query' => $tax_query);
  $posts = get_posts($args);
  return count($posts);
}

function week_view_num() {
	$args = array(
        'post_status' => array('publish'),
        'post_type' => array('internship','column'),
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $custom_key = 'week_views_count';
    $custom_key1 = 'week_views_count1';
    $custom_key2 = 'week_views_count2';
    $custom_key3 = 'week_views_count3';
    $posts = get_posts( $args );
    $weekly_column_view = 0;
    $weekly_internship_view = 0;
    foreach($posts as $post){
        $post_id=$post->ID;
        if(get_post_type($post_id)=='internship'){
            $view_count = get_post_meta($post_id, 'week_views_count', true);
            if ($view_count != ''){
                $weekly_internship_view += (int)$view_count;
            }
        }else {
            $view_count = get_post_meta($post_id, 'week_views_count', true);
            if ($view_count != ''){
                $weekly_column_view += (int)$view_count;
            }
        }
    }
    return array($weekly_internship_view,$weekly_column_view);
}

?>

function Ajax_Search(){
  $area = [];
  if(isset($_POST['area'])) {
    $area = $_POST['area'];
	  $area = $a = str_replace('┗', '', $area);
    $area_conditions = '　エリア：';
    foreach($area as $a) {
      $area_conditions .= '<div class="card-category">'.$a.'</div>';
    }
  }
  $occupation = [];
  if(isset($_POST['occupation'])) {
    $occupation = $_POST['occupation'];
    $occupation_conditions = '　職種：';
    foreach($occupation as $o) {
      $occupation_condition = str_replace('┗', '', $o);
      $occupation_conditions .= '<div class="card-category">'.$occupation_condition.'</div>';
    }
  }
  $business = [];
  if(isset($_POST['business'])) {
    $business = $_POST['business'];
    $business_type_conditions = '　業種：';
    foreach($business as $b) {
      $business_type_condition = str_replace('┗', '', $b);
      $business_type_conditions .= '<div class="card-category">'.$business_type_condition.'</div>';
    }
  }
  $feature = [];
  if(isset($_POST['feature'])){
    $feature = $_POST['feature'];
    $feature_conditions = '　特徴・条件：';
    foreach($feature as $f) {
      $feature_conditions .= '<div class="card-category" style="background-color:#f9b539;">'.$f.'</div>';
    }
  }
  $sw = [];
  if(isset($_POST['sw'])){
    $sw = $_POST["sw"];
  }
  $ajax_array = Ajax_SearchNum('internship',$area,$occupation,$business,$feature,$sw);
  $count = $ajax_array[1];
  $card_html = $ajax_array[0];
  $feature_html = '
  <tbody>
    <tr>
      <th width="20%">検索予定条件</th>
      <td>'.$area_conditions.$occupation_conditions.$business_type_conditions.$feature_conditions.'　　　検索で'.$count.'件ヒット</td>
    </tr>
  </tbody>
  ';
  $list = array($feature_html,$card_html);
  header("Content-Type: application/json; charset=UTF-8"); //ヘッダー情報の明記。必須。
  echo json_encode($list);
  die();
}
add_action( 'wp_ajax_ajax_search', 'Ajax_Search' );
add_action( 'wp_ajax_nopriv_ajax_search', 'Ajax_Search' );

function Ajax_SearchNum($item_type,$area,$occupation,$business_type,$features,$sw){
  global $post;
    $page_no = 1;
    $args = array(
        'posts_per_page' => 10,
        'paged' => $page_no,
        'post_type' => array($item_type),
        'post_status' => array( 'publish' ),
    );
    if (!empty($sw)) {
    $args += array('s' => $sw[0]);
    }
    if (!empty($features)) {
    foreach($features as $feature){
        $metaquerysp[] = array('key'=>'特徴','value'=> $feature,'compare'=>'LIKE');
    }
    $args += array('meta_query' => $metaquerysp);
  }
  if (!empty($business_type)) {
    if($item_type!="company"){
        $args2=array('post_type' => array('company'),'posts_per_page' => -1);
        $tax_obj2=get_taxonomy('business_type');
        $terms2= $business_type;
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
  if(!empty($occupation)){
      array_push($tax_query, array(
          'taxonomy' => 'occupation',
          'field' => 'slug',
          'terms' => $occupation,
          'include_children' => true,
          'operator' => 'IN',
      ));
  }
  if(!empty($area)){
    array_push($tax_query, array(
        'taxonomy' => 'area',
        'field' => 'slug',
        'terms' => $area,
        'include_children' => true,
        'operator' => 'IN',
    ));
 }
  $args += array('tax_query' => $tax_query);
  $posts = get_posts($args);
  $cat_query = new WP_Query($args);
  $post_num = $cat_query->found_posts;
  $post_count = 0;
  $html = '<div class="siteorigin-widget-tinymce textwidget">';
  $html .= paginate($cat_query->max_num_pages, 1, $cat_query->found_posts, 10);
    $tech_build_url = "https://jobshot.jp/jobshot_tech-build";
    $tech_build_img_url = wp_get_attachment_image_src(14216, array(400, 400))[0];
    $html .= '
    <div class="card full-card">
        <div class="full-card-main">
            <div class="full-card-img">
                <img src="'.$tech_build_img_url.'" alt="">
            </div>
            <div class="full-card-text">
                <div class="full-card-text-title"><a href="'.esc_url($tech_build_url).'">【エンジニア未経験者必見！】たった二ヶ月で未経験からエンジニアに</a></div>
                <div><p class="tech-build-detail" style="margin:15px 0;">【広告】プログラミング学習は独学者の9割が挫折すると言われています。TECH-BUILDはプログラミング学習者がつまずきやすいポイントを押さえた有名IT企業所属の優秀な現役エンジニアコーチと伴走して実力を身につけていくプログラミングスクールです。</p></div>
                <div class="card-category" style="background-color:#f9b539;">プログラミング初心者</div>
            </div>
        </div>
        <div class="full-card-buttons">
        <a href = "'.esc_url($tech_build_url).'"><button class="button detail">詳細を見る</button></a>
        </div>
    </div>';
  while ($cat_query->have_posts()): $cat_query->the_post();
    $post_id = $post->ID;
    $html .= view_card_func($post_id);
    $post_count += 1;
    if($item_type == 'internship' && $post_count == 3){
      $chiyoda = wp_get_attachment_image_src(14204, array(250,150))[0];
      $marketing = wp_get_attachment_image_src(14196, array(250,150))[0];
      $retail = wp_get_attachment_image_src(14199, array(250,150))[0];
      $zimu = wp_get_attachment_image_src(14206, array(250,150))[0];
      $sonota = wp_get_attachment_image_src(14202, array(250,150))[0];
      $it = wp_get_attachment_image_src(14194, array(250,150))[0];
      $house = wp_get_attachment_image_src(14193, array(250,150))[0];
      $media = wp_get_attachment_image_src(14197, array(250,150))[0];
      $html .= '    <div class="top__search__container top__feature__search__container">
      <div class="top__search__wrap">
          <h4 class="top__search__wrap__title">自分にあった募集を「特徴」から探そう</h4>
          <ul class="top__search__contents">
              <li class="top__search__ele">
                <span>リモートワーク可能</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E3%83%AA%E3%83%A2%E3%83%BC%E3%83%88%E3%83%AF%E3%83%BC%E3%82%AF%E5%8F%AF%E8%83%BD&itype=internship"><noscript><img src="'.$zimu.'" alt class="only-pc"></noscript><img src="'.$zimu.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$zimu.'"></a>
              </li>
              <li class="top__search__ele">
                <span>プログラミング未経験</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E3%83%97%E3%83%AD%E3%82%B0%E3%83%A9%E3%83%9F%E3%83%B3%E3%82%B0%E3%81%8C%E6%9C%AA%E7%B5%8C%E9%A8%93%E3%81%8B%E3%82%89%E5%AD%A6%E3%81%B9%E3%82%8B&itype=internship"><noscript><img src="'.$it.'" alt class="only-pc"></noscript><img src="'.$it.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$it.'"></a>
              </li>
              <li class="top__search__ele">
                <span>時給1200円以上</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E6%99%82%E7%B5%A61200%E5%86%86%E4%BB%A5%E4%B8%8A&itype=internship"><noscript><img src="'.$marketing.'" alt class="only-pc"></noscript><img src="'.$marketing.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$marketing.'"></a>
              </li>
              <li class="top__search__ele">
                <span>土日のみでも可</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E5%9C%9F%E6%97%A5%E3%81%AE%E3%81%BF%E3%81%A7%E3%82%82%E5%8F%AF%E8%83%BD&itype=internship"><noscript><img src="'.$house.'" alt class="only-pc"></noscript><img src="'.$house.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$house.'"></a>
              </li>
              <li class="top__search__ele">
                <span>週２日OK</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E9%80%B12%E6%97%A5ok&itype=internship"></noscript><img src="'.$chiyoda.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$chiyoda.'"></a>
              </li>
              <li class="top__search__ele">
                <span>社長直下</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E7%A4%BE%E9%95%B7%E7%9B%B4%E4%B8%8B&itype=internship"><noscript><img src="'.$retail.'" alt class="only-pc"></noscript><img src="'.$retail.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$retail.'"></a>
              </li>
              <li class="top__search__ele only-pc">
                <span>1.2年生歓迎</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=1%2C2%E5%B9%B4%E6%AD%93%E8%BF%8E&itype=internship"><noscript><img src="'.$sonota.'" alt class="only-pc"></noscript><img src="'.$sonota.'" alt="" class="only-pc ls-is-cached lazyloaded" data-src="'.$sonota.'"></a>
              </li>
              <li class="top__search__ele only-pc">
                <span>英語力が身に付く</span>
                <a href="https://jobshot.jp/internship?sw=&feature%5B%5D=%E8%8B%B1%E8%AA%9E%E5%8A%9B%E3%81%8C%E8%BA%AB%E3%81%AB%E3%81%A4%E3%81%8F&itype=internship"><noscript><img src="'.$media.'" alt class="only-pc"></noscript><img src="'.$media.'" alt="" class="only-pc lazyloaded" data-src="'.$media.'"></a>
              </li>
          </ul>
      </div>
    </div>';
  }
  endwhile;
  $html .= paginate($cat_query->max_num_pages, 1, $cat_query->found_posts, 10);
  $html .= '</div>';
  wp_reset_postdata();
  $list = array($html,$cat_query->found_posts);
  return $list;
}

