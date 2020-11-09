<?php
    function template_internship2_func($content){
        global $post;
        $post_id=$post->ID;
        $now_id = get_current_user_id();
        $company_id = CFS()->get('company_id',$post_id);
        $student_id = CFS()->get('user_id',$post_id);
        if($now_id == $company_id || now_id == $student_id){
            $scout_mail = CFS()->get('scout_mail',$post_id);
            $html = '
                <div><p>'.$scout_mail.'</p></div>
            ';
        }else{
            return $html;
        }
        return $html;
    }
?>