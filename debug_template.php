<?php

function _log($debug){
    if(current_user_can( 'administrator' )){
        print_r("<pre>");
        print_r($debug);
        print_r("</pre>");
        exit;
    }else{
        return;
    }
}

?>