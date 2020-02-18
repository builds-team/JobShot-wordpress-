<?php

function _log($debug){
    $company_name = wp_get_current_user()->data->display_name;
    if(current_user_can( 'administrator' ) || $company_name == "株式会社Builds"){
        print_r("<pre>");
        print_r($debug);
        print_r("</pre>");
        exit;
    }else{
        return;
    }
}

?>