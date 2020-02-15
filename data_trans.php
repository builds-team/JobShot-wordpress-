<?php

function database_show ( $atts ) {


  //ユーザー用

  /*
  $args = array(
  );
    $array=new WP_User_Query( $args );
  $array=json_encode($array, JSON_UNESCAPED_UNICODE);
  print_r($array);
  */

  //企業用

    
    $args = array(
      'posts_per_page'   => -1,
      'post_status' => array('publish','private'),
      'post_type' => array('company'),
    );
    $the_query = new WP_Query($args);
    $array=array();
    while ($the_query->have_posts()): $the_query->the_post();
      $post_id = get_the_ID();
      $post=get_post($post_id);
      $dict=array();
      $company = get_userdata($post->post_author);
      $dict['name'] = $company->data->display_name;
      $dict['business_description'] = get_field("事業内容",$post_id);
      $dict['establishment'] = get_field("設立年",$post_id);
      $dict['capital'] = get_field("資本金",$post_id);
      $dict['employee_numbers'] = get_field("従業員数",$post_id);
      $dict['representative_name'] = get_field("代表者",$post_id);
      $dict['representative_email'] = $company->data->user_email;
      $dict['postcode'] = get_field("郵便番号",$post_id);
      $dict['address'] = get_field("住所",$post_id);
      $array[]=$dict;
    endwhile;
    $array=json_encode($array, JSON_UNESCAPED_UNICODE);
    print_r($array);
    

    //学生用

    /*
    $args = array(
          'role'         => 'student',
    );
      $students=new WP_User_Query( $args );
    $array=array();
    foreach($students->get_results() as $s){
      $array[]=get_user_meta( $s->data->ID, '');
    }
    $array=json_encode($array, JSON_UNESCAPED_UNICODE);
    print_r($array);
    */
  }
  add_shortcode('database_show','database_show');

?>