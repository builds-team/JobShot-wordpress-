<?php
function google_analytics_add_wp_head (){
    echo "<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src='https://www.googletagmanager.com/gtag/js?id=UA-135934453-1'></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-135934453-1', {'optimize_id':'GTM-5J6DKXZ'});
    </script>";

}
add_action ('wp_head','google_analytics_add_wp_head',1);

function google_analytics_add_wp_head (){
  echo "<!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src='https://www.googletagmanager.com/gtag/js?id=UA-135934453-1'></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-135934453-1', {'optimize_id':'GTM-5J6DKXZ'});
  </script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WRXPBDJ');</script>
<!-- End Google Tag Manager -->
<!-- User Heat Tag -->
<script type='text/javascript'>
(function(add, cla){window['UserHeatTag']=cla;window[cla]=window[cla]||function(){(window[cla].q=window[cla].q||[]).push(arguments)},window[cla].l=1*new Date();var ul=document.createElement('script');var tag = document.getElementsByTagName('script')[0];ul.async=1;ul.src=add;tag.parentNode.insertBefore(ul,tag);})('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');_uhtracker({id:'uhAInVkJCv'});
</script>
<!-- End User Heat Tag -->";

}
add_action ('wp_head','google_analytics_add_wp_head',1);


function instagram_analytics_add_wp_head (){
    echo "
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '866794000437602');
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height='1' width='1'
    src='https://www.facebook.com/tr?id=866794000437602&ev=PageView
    &noscript=1'/>
    </noscript>
    <!-- End Facebook Pixel Code -->";

}
add_action ('wp_head','instagram_analytics_add_wp_head',1);

?>