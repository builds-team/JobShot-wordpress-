// 新規登録ボタンエラー修正
window.addEventListener('load', function () {
    var str = document.getElementsByClassName("um-right um-half");
    for (i = 0; i < str.length; i++) {
        str[i].innerHTML = '<a href="https://jobshot.jp/regist" class="um-button um-alt">新規登録</a>';
      }
});

/* top_accordion_script */
const accs = document.getElementsByClassName('select-dropdown-check');
const shadows = document.getElementsByClassName('select-dropdown-shadow');

function closeOthers(i) {
  for (let j = 0; j < accs.length; j++) {
    if (i !== j) {
      accs[j].checked = false;
    }
  }
}

function closeAll() {
  for (let j = 0; j < accs.length; j++) {
    accs[j].checked = false;
  }
}

for (let i = 0; i < accs.length; i++) {
  accs[i].addEventListener('click', () => {
    closeOthers(i);
  });
}

for (let i = 0; i < accs.length; i++) {
  shadows[i].addEventListener('click', () => {
    closeAll();
  });
}

/* card_aline_fix */
const containers = document.getElementsByClassName('cards-container');

for (let j = 0; j < containers.length; j ++) {
    const container = containers[j];
    const num = container.childNodes.length;

    for (let i = 0; i < num; i++) {
        const emptyElm = document.createElement('div');
        emptyElm.classList.add('card', 'empty');
        container.appendChild(emptyElm);
    }
}



/* top-page */
function slide() {
    if(jQuery('.searched-icon').hasClass('searched-icon-change')) {
        jQuery('.searched-icon').removeClass('searched-icon-change');
        jQuery('searched').css('color','#03c4b0','background-color','#fff');
    }else {
        jQuery('.searched-icon').addClass('searched-icon-change');
        jQuery('searched').css('color','#fff','background-color','#03c4b0');
    }

    jQuery('.search-container').slideToggle('fast');
}
jQuery(function() {
    jQuery('.searched').attr('onclick', 'slide()');
});

jQuery(function() {
    jQuery('#footer #text-9 .textwidget p a br').remove();
    jQuery('#post-1600 .um-misc-ul li a br').remove();
});


/* search-form-test, code:searach-form.php */
function clickBtn1() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[0].checked == true) {
            for (let i = 1; i < color3.length; i++){
                color3[i].checked = false;
            }
        }
    }
}

function clickBtn2() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[1].checked == true) {
            for (let i = 0; i < color3.length; i++){
                if (i != 1){
                    color3[i].checked = false;
                }
            }
        }
        }
}

function clickBtn3() {
    var w = screen.width;
    var x = 1023;
    if (w <= x) {
        const color3 = document.form3.selective;
        if (color3[2].checked == true) {
            for (let i = 0; i < color3.length-1; i++){
                color3[i].checked = false;
            }
        }
    }
}

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_base' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#base").html(response[0]);
                $("#resultarea").html("基本情報を更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea").css('display','block');
                $(".um-editor-base").removeClass("active");
                $(".um-edit-btn-base").removeClass("active");
                $(".um-field-area-base").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#base").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform2' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_univ' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#univ").html(response[0]);
                $("#resultarea2").html("学歴を更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea2").css('display','block');
                $(".um-editor-univ").removeClass("active");
                $(".um-edit-btn-univ").removeClass("active");
                $(".um-field-area-univ").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea2").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#univ").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform3' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_abroad' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#abroad").html(response[0]);
                $("#resultarea3").html("留学を更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea3").css('display','block');
                $(".um-editor-abroad").removeClass("active");
                $(".um-edit-btn-abroad").removeClass("active");
                $(".um-field-area-abroad").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea3").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#aborad").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform4' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_programming' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#programming").html(response[0]);
                $("#resultarea4").html("プログラミングを更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea4").css('display','block');
                $(".um-editor-programming").removeClass("active");
                $(".um-edit-btn-programming").removeClass("active");
                $(".um-field-area-programming").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea4").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#programming").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform5' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_skill' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#skills").html(response[0]);
                $("#resultarea5").html("資格・その他スキルを更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea5").css('display','block');
                $(".um-editor-skill").removeClass("active");
                $(".um-edit-btn-skill").removeClass("active");
                $(".um-field-area-skill").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea5").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#skills").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform6' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_community' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#community").html(response[0]);
                $("#resultarea6").html("コミュニティを更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea6").css('display','block');
                $(".um-editor-community").removeClass("active");
                $(".um-edit-btn-community").removeClass("active");
                $(".um-field-area-community").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea6").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#community").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform7' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_intern' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#intern").html(response[0]);
                $("#resultarea7").html("長期インターンを更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea7").css('display','block');
                $(".um-editor-internship").removeClass("active");
                $(".um-edit-btn-internship").removeClass("active");
                $(".um-field-area-internship").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea7").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#intern").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform8' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_interest' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#interest").html(response[0]);
                $("#resultarea8").html("興味・関心を更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea8").css('display','block');
                $(".um-editor-interest").removeClass("active");
                $(".um-edit-btn-interest").removeClass("active");
                $(".um-field-area-interest").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea8").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#interest").html( "error" );
            }
        });
        return false;
    });
});

jQuery(function($){
    // formの送信ボタンが押されたときの処理
    $( '#testform9' ).submit( function(event){
        // クリックイベントをこれ以上伝播させない
        event.preventDefault();
        // フォームデータから、サーバへ送信するデータを作成
        var fd = new FormData( this );
        // サーバー側で何の処理をするかを指定。後ほどphp側で実装する
        fd.append('action'  , 'ajax_experience' );
        // ajaxの通信
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: fd,
            processData: false,
            contentType: false,
            success: function( response ){
                $("#experience").html(response[0]);
                $("#resultarea9").html("学生時代の経験を更新しました");
                $(".user_profile_score_value").html(response[1]);
                $(".score-area p").html(response[1]);
                $("#resultarea9").css('display','block');
                $(".um-editor-experience").removeClass("active");
                $(".um-edit-btn-experience").removeClass("active");
                $(".um-field-area-experience").removeClass("inactive");
                setTimeout(function(){
                    jQuery("#resultarea9").fadeOut();
                 }, 5000);
            },
            error: function( response ){
                $("#experience").html( "error" );
            }
        });
        return false;
    });
});
