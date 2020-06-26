<?php
    function company_logo_func(){
    $home_url =esc_url( home_url());
    $dentu = wp_get_attachment_image_src(6659, array(100,100))[0];
    $keizai = wp_get_attachment_image_src(4703, array(100,100))[0];
    $gaimu = wp_get_attachment_image_src(4535, array(100,100))[0];
    $sinpu = wp_get_attachment_image_src(6658, array(100,100))[0];
    $rans = wp_get_attachment_image_src(6651, array(100,100))[0];
    $wiz = wp_get_attachment_image_src(6657, array(100,100))[0];
    $pr_table = wp_get_attachment_image_src(4543, array(100,100))[0];
    $leaner = wp_get_attachment_image_src(4546, array(100,100))[0];
    $parts_one = wp_get_attachment_image_src(4547, array(100,100))[0];
    $warantee = wp_get_attachment_image_src(6759, array(100,100))[0];
    $logo_html ='
    <div class="company-logo only-pc">
    <div class="company-logo-image-box">
    <div class="company-logo-image">
        <!-- 電通 -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E9%9B%BB%E9%80%9A%E3%82%A4%E3%83%BC%E3%82%B8%E3%82%B9%E3%83%BB%E3%82%B8%E3%83%A3%E3%83%91%E3%83%B3%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE"><img class="company-logo-logo" src="'.$dentu.'"/></a>
        <!-- 経済産業省 -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E7%B5%8C%E6%B8%88%E7%94%A3%E6%A5%AD%E7%9C%81"><img class="company-logo-logo" src="'.$keizai.'" /></a>
        <!-- 外務省 -->
        <a class="company-logo-link" href=""><img class="company-logo-logo" src="'.$gaimu.'"/></a>
        <!-- シンプレックス -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%e3%82%b7%e3%83%b3%e3%83%97%e3%83%ac%e3%82%af%e3%82%b9%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%be"><img class="company-logo-logo" src="'.$sinpu.'"/></a>
        <!-- ランサーズ -->
        <a class="company-logo-link" href="'.$home_url.'/%3Fcompany%3D%E3%83%A9%E3%83%B3%E3%82%B5%E3%83%BC%E3%82%BA%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE"><img class="company-logo-logo" src="'.$rans.'"/></a>
        <!-- Wiz -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%bewiz"><img class="company-logo-logo" src="'.$wiz.'"/></a>
        <!-- PR-TABLE -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEpr-table"><img class="company-logo-logo" src="'.$pr_table.'" /></a>
        <!-- リーナー -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BEleaner-technologies"><img class="company-logo-logo" src="'.$leaner.'" /></a>
        <!--  パーツワン　-->
        <a class="company-logo-link" href="'.$home_url.'/?company=%E6%A0%AA%E5%BC%8F%E4%BC%9A%E7%A4%BE%E3%83%91%E3%83%BC%E3%83%84%E3%83%AF%E3%83%B3"><img class="company-logo-logo" src="'.$parts_one.'" /></a>
        <!-- Warrantee -->
        <a class="company-logo-link" href="'.$home_url.'/?company=%e6%a0%aa%e5%bc%8f%e4%bc%9a%e7%a4%bewarrantee"><img class="company-logo-logo" src="'.$warantee.'"/></a>
    </div>
    </div>
    </div>
    ';
    return $logo_html;
    }
    add_shortcode("company_logo","company_logo_func");

    function toppage_button(){
        $home_url = esc_url(home_url());
        if (is_user_logged_in()){
            $html = '
            <div class="hero__guide">
                <div class="hero__guide__each">
                    <p class="hero__guide__each__text">企業選びから内定まで無料でプロがサポート</p>
                    <a href="'.$home_url.'/interview"><button class="button detail button-white hero__guide__each__btn">個別相談会に参加する</button></a>
                </div>
            </div>';
        }else{
            $html = '
            <div class="hero__guide">
                <div class="hero__guide__each">
                    <p class="hero__guide__each__text">無料登録して会員限定コンテンツを受け取る</p>
                    <a href="'.$home_url.'/regist"><button class="button detail hero__guide__each__btn">新規登録をする</button></a>
                </div>
                <div class="hero__guide__each">
                    <p class="hero__guide__each__text">企業選びから内定まで無料でプロがサポート</p>
                    <a href="'.$home_url.'/interview"><button class="button detail button-white hero__guide__each__btn">個別相談会に参加する</button></a>
                </div>
            </div>';
        }
        return $html;
    }
    add_shortcode("toppage_button","toppage_button");

    function toppage_button_mobile(){
        $home_url = esc_url(home_url());
        if (is_user_logged_in()){
            $html = '
            <div class="hero__guide">
                <div class="hero__guide__each">
                    <p class="hero__guide__each__text">企業選びから内定まで無料でプロがサポート</p>
                    <a href="'.$home_url.'/interview"><button class="button detail button-white hero__guide__each__btn">個別相談会に参加する</button></a>
                </div>
            </div>';
        }else{
            $html = '
            <div class="hero__guide">
                <div class="hero__guide__each">
                    <p class="hero__guide__each__text">無料登録して会員限定コンテンツを受け取る</p>
                    <a href="'.$home_url.'/regist"><button class="button detail hero__guide__each__btn">新規登録をする</button></a>
                </div>
            </div>';
        }
        return $html;
    }
    add_shortcode("toppage_button_mobile","toppage_button_mobile");

?>