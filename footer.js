function cleanQuery(query) {
	var arr = [];
	$.each(query.split('&'), function(i, param) {
	  if (param.split('=')[1] && param.split('=')[1] != 0 && param.split('=')[0] != 'tab_item') { arr.push(param); }
	});
	return arr.join('&');
  }
  
  jQuery(function($){
	  $('#form__scout').on('submit', function(event) {
	event.preventDefault(); // サブミットをキャンセルする。
	var query = $(this).serialize(); // フォームデータ集合をクエリー文字列で取得する。
	query = cleanQuery(query) // クエリー文字列から値が空のパラメータを取り除く。
	location.href = this.action + '?' + query; // 画面を遷移させる。
  });
  });
  jQuery(function($){
	  $("#post-14004 .wpcf7-submit").attr(
		  "onclick", "gtag('event', 'click', {'event_category': 'link', 'event_label': 'tech-build'});"
	  );
  });
  
  jQuery(function($){
	  $(".post-1601 #um-submit-btn").attr(
		  "onclick", "gtag('event', 'click', {'event_category': 'link', 'event_label': 'register'});"
	  );
  });
  
  jQuery(function($){
	  $("#wpcf7-f324-p918-o1 .wpcf7-submit").attr(
		  "onclick", "gtag('event', 'click', {'event_category': 'link', 'event_label': 'intern'});"
	  );
  });
  
  jQuery(function($){
	  $("#wpcf7-f897-p918-o1 .wpcf7-submit").attr(
		  "onclick", "gtag('event', 'click', {'event_category': 'link', 'event_label': 'event'});"
	  );
  });
  
  
  // トップページロゴクリック位置修正
  jQuery(".branding .logo a").empty();
  // ハンバーガーアイコン修正
  jQuery(".menu-toggle").empty();
  
  var $form = document.querySelector('form');// jQueryの $("form")相当
  //jQueryの$(function() { 相当(ただし厳密には違う)
  document.addEventListener('DOMContentLoaded', function() {
	  //画像ファイルプレビュー表示
	  //  jQueryの $('input[type="file"]')相当
	  // addEventListenerは on("change", function(e){}) 相当
	  document.querySelector('input[name="picture"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
				 reader = new FileReader(),
				 $preview =  document.querySelector(".preview-img"), // jQueryの $(".preview")相当
				 t = this;
  
		  // 画像ファイル以外の場合は何もしない
		  if(file.type.indexOf("image") < 0){
			return false;
		  }
  
		  reader.onload = (function(file) {
			return function(e) {
			   //jQueryの$preview.empty(); 相当
			   while ($preview.firstChild) $preview.removeChild($preview.firstChild);
  
			  // imgタグを作成
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '150px');
			  img.setAttribute('title',  file.name);
			  // imgタグを$previeの中に追加
			  $preview.appendChild(img);
			};
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  document.addEventListener('DOMContentLoaded', function() {
	  //画像ファイルプレビュー表示
	  //  jQueryの $('input[type="file"]')相当
	  // addEventListenerは on("change", function(e){}) 相当
	  document.querySelector('input[name="picture2"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
				  reader = new FileReader(),
				  $preview =  document.querySelector(".preview-img2"), // jQueryの $(".preview")相当
				  t = this;
  
		  // 画像ファイル以外の場合は何もしない
		  if(file.type.indexOf("image") < 0){
			  return false;
		  }
  
		  reader.onload = (function(file) {
			  return function(e) {
				  //jQueryの$preview.empty(); 相当
				  while ($preview.firstChild) $preview.removeChild($preview.firstChild);
  
			  // imgタグを作成
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '150px');
			  img.setAttribute('title',  file.name);
			  // imgタグを$previeの中に追加
			  $preview.appendChild(img);
			  };
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  document.addEventListener('DOMContentLoaded', function() {
	  //画像ファイルプレビュー表示
	  //  jQueryの $('input[type="file"]')相当
	  // addEventListenerは on("change", function(e){}) 相当
	  document.querySelector('input[name="picture3"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
				 reader = new FileReader(),
				 $preview =  document.querySelector(".preview-img3"), // jQueryの $(".preview")相当
				 t = this;
  
		  // 画像ファイル以外の場合は何もしない
		  if(file.type.indexOf("image") < 0){
			return false;
		  }
  
		  reader.onload = (function(file) {
			return function(e) {
			   //jQueryの$preview.empty(); 相当
			   while ($preview.firstChild) $preview.removeChild($preview.firstChild);
  
			  // imgタグを作成
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '150px');
			  img.setAttribute('title',  file.name);
			  // imgタグを$previeの中に追加
			  $preview.appendChild(img);
			};
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
	  //画像ファイルプレビュー表示
	  //  jQueryの $('input[type="file"]')相当
	  // addEventListenerは on("change", function(e){}) 相当
	  document.querySelector('input[name="picture4"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
				 reader = new FileReader(),
				 $preview =  document.querySelector(".preview-img4"), // jQueryの $(".preview")相当
				 t = this;
  
		  // 画像ファイル以外の場合は何もしない
		  if(file.type.indexOf("image") < 0){
			return false;
		  }
  
		  reader.onload = (function(file) {
			return function(e) {
			   //jQueryの$preview.empty(); 相当
			   while ($preview.firstChild) $preview.removeChild($preview.firstChild);
  
			  // imgタグを作成
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '150px');
			  img.setAttribute('title',  file.name);
			  // imgタグを$previeの中に追加
			  $preview.appendChild(img);
			};
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  if (window.matchMedia( "(max-width: 680px)" ).matches) {
	  var startPos = 0,winScrollTop = 0;
	  jQuery(window).on("scroll",function($){
		  winScrollTop = $(this).scrollTop();
		  if (Math.abs(winScrollTop-startPos) > 10) {
			  if (winScrollTop >= startPos) {
				  $(".navi-container").fadeIn("fast");
			  } else {
				  $(".navi-container").fadeOut("fast");
			  }
			  startPos = winScrollTop;
			} else {
			  startPos = winScrollTop;
			}
	  });
  } else {
  }
  
  var a = function() {
	  jQuery(".um-cover").hover(function() {
		  jQuery(".um-cover-overlay").fadeIn();
		}, function() {
		  jQuery(".um-cover-overlay").fadeOut();
		});
  };
  var b = function () {
	  jQuery(".um-cover-overlay-t").hover(function() {
		  jQuery(".um-cover-overlay-t").css("color","#b5acac");
		}, function() {
		  jQuery(".um-cover-overlay-t").css("color","#fff");
		});
  };
  var c = function () {
	  jQuery(".um-manual-trigger .um-faicon-picture-o").hover(function() {
		  jQuery(".um-manual-trigger .um-faicon-picture-o").css("color","#b5acac");
		}, function() {
		  jQuery(".um-manual-trigger .um-faicon-picture-o").css("color","#fff");
	  });
  };
  // トプ画オーバーレイ
  var d = function () {
	  jQuery(".um-profile-photo-img").hover(function() {
		  jQuery(".um-profile-photo-overlay").fadeIn();
		}, function() {
		  jQuery(".um-profile-photo-overlay").fadeOut();
		});
  };
  var e = function () {
	  jQuery(".um-profile-photo-overlay-s .um-faicon-camera").hover(function() {
		  jQuery(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#b5acac");
		}, function() {
		  jQuery(".um-profile-photo-overlay-s .um-faicon-camera").css("color","#fff");
		});
  };
  jQuery(function(){
	  var w = jQuery(window).width();
		var x = 560;
		if (w <= x) {
		} else if(w > x) {
		a();
		b();
		c();
		d();
		e();
		}
  });
  jQuery(window).resize(function(){
	  var w = jQuery(window).width();
	  var x = 560;
	  if (w <= x) {
	  } else if(w > x) {
		  a();
		  b();
		  c();
		  d();
		  e();
	  }
  });
  function cancel() {
	  jQuery(".um-editor").removeClass("active");
	  jQuery(".um-edit-btn").removeClass("active");
	  jQuery(".um-field-area").removeClass("inactive");
  }
  function edit_base() {
	  if (jQuery(".um-edit-btn-base").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-base").addClass("active");
		  jQuery(".um-edit-btn-base").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-base").addClass("inactive");
	  }
  }
  function edit_univ() {
	  if (jQuery(".um-edit-btn-univ").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-univ").addClass("active");
		  jQuery(".um-edit-btn-univ").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-univ").addClass("inactive");
	  }
  }
  function edit_abroad() {
	  if (jQuery(".um-edit-btn-abroad").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-abroad").addClass("active");
		  jQuery(".um-edit-btn-abroad").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-abroad").addClass("inactive");
	  }
  }
  function edit_programming() {
	  if (jQuery(".um-edit-btn-programming").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-programming").addClass("active");
		  jQuery(".um-edit-btn-programming").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-programming").addClass("inactive");
	  }
  }
  function edit_skill() {
	  if (jQuery(".um-edit-btn-skill").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-skill").addClass("active");
		  jQuery(".um-edit-btn-skill").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-skill").addClass("inactive");
	  }
  }
  function edit_community() {
	  if (jQuery(".um-edit-btn-community").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-community").addClass("active");
		  jQuery(".um-edit-btn-community").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-community").addClass("inactive");
	  }
  }
  function edit_internship() {
	  if (jQuery(".um-edit-btn-internship").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-internship").addClass("active");
		  jQuery(".um-edit-btn-internship").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-internship").addClass("inactive");
	  }
  }
  function edit_interest() {
	  if (jQuery(".um-edit-btn-interest").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-interest").addClass("active");
		  jQuery(".um-edit-btn-interest").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-interest").addClass("inactive");
	  }
  }
  function edit_experience() {
	  if (jQuery(".um-edit-btn-experience").hasClass("active")) {
		  cancel();
	  }else {
		  jQuery(".um-editor").removeClass("active");
		  jQuery(".um-editor-experience").addClass("active");
		  jQuery(".um-edit-btn-experience").addClass("active");
		  jQuery(".um-field-area").removeClass("inactive");
		  jQuery(".um-field-area-experience").addClass("inactive");
	  }
  }
  
  jQuery(function(){
	  jQuery(".um-finish-upload.image").removeClass("disabled");
	  jQuery(".um-finish-upload.image").remove();
	  jQuery(".um-modal-btn.alt").remove();
	  jQuery(".um-modal-right").remove();
  });
  jQuery(function(){
  jQuery(".um-profile-photo").addClass("um-trigger-menu-on-click");
  jQuery(".um-cover.has-cover ").addClass("um-trigger-menu-on-click");
  });
  
  jQuery(function() {
	  var z = screen.width;
	  var t = 560;
	  if (z <= t) {
		  jQuery(".um-modal.no-photo").removeClass("normal");
		  jQuery(".um-modal.no-photo").addClass("large");
	  }
  
  });
  jQuery('.um-form').on('click', function() {
		  var ProgSelect = jQuery("#programming_languages");
		  var prog = ProgSelect.children("option:selected").text();
		  if (prog.indexOf('C言語') !== -1) {
		  jQuery('#C言語').css('display','block');
		  }
		  if (prog.indexOf('C++') !== -1) {
		  jQuery('.um-is-conditional.um-field-programming_lang_lv_cpp').css('display','block');
		  }
		  if (prog.indexOf('C#') !== -1) {
		  jQuery('.um-is-conditional.um-field-programming_lang_lv_cs').css('display','block');
		  }
		  if (prog.indexOf('Objective-C') !== -1) {
		  jQuery('#Objective-C').css('display','block');
		  }
		  if (prog.indexOf('Java') !== -1) {
		  jQuery('#Java').css('display','block');
		  }
		  if (prog.indexOf('JavaScript') !== -1) {
		  jQuery('#JavaScript').css('display','block');
		  }
		  if (prog.indexOf('Python') !== -1) {
		  jQuery('#Python').css('display','block');
		  }
		  if (prog.indexOf('PHP') !== -1) {
		  jQuery('#PHP').css('display','block');
		  }
		  if (prog.indexOf('Perl') !== -1) {
		  jQuery('#Perl').css('display','block');
		  }
		  if (prog.indexOf('Ruby') !== -1) {
		  jQuery('#Ruby').css('display','block');
		  }
		  if (prog.indexOf('Go') !== -1) {
		  jQuery('#Go').css('display','block');
		  }
		  if (prog.indexOf('Swift') !== -1) {
		  jQuery('#Swift').css('display','block');
		  }
		  if (prog.indexOf('Visual Basic') !== -1) {
		  jQuery('#Basic').css('display','block');
		  }
	  });
  
  jQuery(function(){
  var wrp = ".um-edit-wrapper",
	  btnOpen = ".menu-edit-icon",
	  btnClose = ".edit-slide-close",
	  sld = ".edit-slide",
	  ovrly = ".edit-overlay",
	  current_scrollY;
  
  jQuery(btnOpen).on("click",function(e){
	  if(jQuery(sld).css("display") == "none"){
		  current_scrollY = jQuery( window ).scrollTop();
		  jQuery(wrp).css({
			  position: "fixed",
			  width: "100%",
			  top: -1 * current_scrollY
		  });
		  jQuery(sld).slideDown();
		  jQuery(ovrly).css("display","block");
	  }
  });
  
  jQuery(btnClose).on("click",function(){
	  if(jQuery(sld).css("display") == "block"){
		  jQuery(wrp).attr({style:""});
		  jQuery("html, body").prop({scrollTop: current_scrollY});
		  jQuery(sld).slideUp();
		  jQuery(ovrly).fadeOut();
	  }
  });
  
  jQuery(document).on("click",function(e) {
	  if(jQuery(sld).css("display") == "block"){
		  if ((!jQuery(e.target).closest(sld).length)&&(!jQuery(e.target).closest(btnOpen).length)) {
			  jQuery(wrp).attr({style:""});
			  jQuery("html, body").prop({scrollTop: current_scrollY});
			  jQuery(sld).slideUp();
			  jQuery(ovrly).fadeOut();
		  }
	  }
  });
  
  });
  
  jQuery(function(){
  var wrp = ".um-img-edit-wrapper",
		  btnOpen = ".img-edit-icon",
		  btnClose = ".edit-slide-close",
		  sld = ".img-edit-slide",
		  ovrly = ".img-edit-overlay",
		  current_scrollY;
  
  jQuery(btnOpen).on("click",function(e){
		  if(jQuery(sld).css("display") == "none"){
				  current_scrollY = jQuery( window ).scrollTop();
				  jQuery(wrp).css({
						  position: "fixed",
						  width: "100%",
						  top: -1 * current_scrollY
				  });
				  jQuery(sld).slideDown();
				  jQuery(ovrly).css("display","block");
		  }
  });
  
  jQuery(btnClose).on("click",function(){
		  if(jQuery(sld).css("display") == "block"){
				  jQuery(wrp).attr({style:""});
				  jQuery("html, body").prop({scrollTop: current_scrollY});
				  jQuery(sld).slideUp();
				  jQuery(ovrly).fadeOut();
		  }
  });
  
  jQuery(document).on("click",function(e) {
		  if(jQuery(sld).css("display") == "block"){
				  if ((!jQuery(e.target).closest(sld).length)&&(!jQuery(e.target).closest(btnOpen).length)) {
						  jQuery(wrp).attr({style:""});
						  jQuery("html, body").prop({scrollTop: current_scrollY});
						  jQuery(sld).slideUp();
						  jQuery(ovrly).fadeOut();
				  }
		  }
  });
  
  });
  function sort_by_new(){
	  var insert = '<input type="hidden" name="sort" class="search-field" value="new">';
	  jQuery(".sort-field").html(insert);
  }
  function sort_by_recommend(){
	  var insert = '<input type="hidden" name="sort" class="search-field" value="recommend">';
	  jQuery(".sort-field").html(insert);
  }
  function sort_by_popular(){
	  var insert = '<input type="hidden" name="sort" class="search-field" value="popular">';
	  jQuery(".sort-field").html(insert);
  }
  
  jQuery('#ajax_btn').on('click', function() {
		  jQuery("#edit_company_ajax").removeClass("hidden");
		  jQuery("#info_company_ajax").addClass("hidden");
		  jQuery("#ajax_btn").addClass("hidden");
  });
  jQuery('#ajax_btn2').on('click', function() {
		  jQuery("#edit_company_ajax").addClass("hidden");
		  jQuery("#info_company_ajax").removeClass("hidden");
		  jQuery("#ajax_btn").removeClass("hidden");
  });
  jQuery(".selection_flows").on("click", ".add", function() {
	  jQuery('.selection_flows').append('<td><div class="arrow"></div><div class="company-capital"><input class="input-width" type="text" min="0" name="selection_flow[]" placeholder="(例)グループワーク" id="" value=""></div></td>');
  });
  jQuery(".selection_flows").on("click", ".del", function() {
	  var target = jQuery(".selection_flows td");
	  if (jQuery(".selection_flows td").length > 1) {
		  jQuery(".selection_flows td:last").remove();
	  }
  });
  jQuery(".intern_days").on("click", ".add", function() {
	  jQuery('.intern_days').append('<td><div class="arrow"></div><div class="company-capital"><p>開始時間</p><input type="time" name="start[]" list="data1"><p>終了時間</p><input type="time" name="end[]" list="data1"><p>作業内容</p><input class="input-width" type="text" min="0" placeholder="(例)新規事業部立ち上げに関する打ち合わせ" id="" value="" name="oneday_flow[]"></div></td>');
  });
  jQuery(".intern_days").on("click", ".del", function() {
	  var target = jQuery(".intern_days td");
	  if (jQuery(".intern_days td").length > 1) {
		  jQuery(".intern_days td:last").remove();
	  }
  });
  
  jQuery(function(){
	  if(jQuery(".um-cover").length>1){
		  var profiletab = "";
		  jQuery(".um-cover")[0].remove();
		  jQuery(".um-profile-photo")[0].remove();
		  jQuery(".um-profile-meta")[0].remove();
		  if(jQuery(".um-profile-nav").length){
			  var profiletab = jQuery(".um-profile-nav")[0];
			  jQuery(".um-profile-nav")[0].remove();
		  }
		  jQuery(".um-header")[0].remove();
		  jQuery('.um-header').after(profiletab);
	 }
  });
  
  jQuery('.um-cover').click(function() {
	  jQuery(".upload-coverphoto").css('display','block');
	  if(jQuery(".um-cover .um-dropdown").length){
				  jQuery(".um-cover .um-dropdown")[0].remove();
	 }
  });
  
  jQuery('.um-profile-photo').click(function() {
	  jQuery(".upload-photo").css('display','block');
  });
  
  jQuery('.upload-coverphoto .button').click(function() {
	  jQuery(".upload-coverphoto").css('display','none');
  });
  
  jQuery('.upload-photo .button').click(function() {
	  jQuery(".upload-photo").css('display','none');
  });
  jQuery(function(){
	  if(jQuery(".um-cover .um-dropdown").length){
				  jQuery(".um-cover .um-dropdown")[0].remove();
	 }
  });
  
  jQuery(function(){
	  if(jQuery(".favorites-default").length){
						  jQuery(".um-cover")[0].remove();
						  jQuery(".um-profile-photo")[0].remove();
						  jQuery(".um-profile-meta")[0].remove();
						  jQuery(".um-header")[0].remove();
	}
  });
  jQuery(function() {
	  jQuery("#button1").click(function() {
		  var str1 = jQuery('#past-self-pr-1').text();
		  jQuery('textarea[name="your-message"]').val(str1);
		  jQuery('.modal_options').iziModal('close');
	  });
	  jQuery("#button2").click(function() {
		  var str2 = jQuery('#past-self-pr-2').text();
		  jQuery('textarea[name="your-message"]').val(str2);
		  jQuery('.modal_options').iziModal('close');
	  });
	  jQuery("#button3").click(function() {
		  var str3 = jQuery('#past-self-pr-3').text();
		  jQuery('textarea[name="your-message"]').val(str3);
		  jQuery('.modal_options').iziModal('close');
	  });
	  jQuery("#button4").click(function() {
		  var str4 = jQuery('#past-self-pr-4').text();
		  jQuery('textarea[name="your-message"]').val(str4);
		  jQuery('.modal_options').iziModal('close');
	  });
	  jQuery("#button5").click(function() {
		  var str5 = jQuery('#past-self-pr-5').text();
		  jQuery('textarea[name="your-message"]').val(str5);
		  jQuery('.modal_options').iziModal('close');
	  });
  });
  jQuery(function () {
	  jQuery(".column-section").click(function () {
		jQuery(".column-section").not(this).removeClass("open");
		jQuery(".column-section").not(this).find("ul").slideUp(300);
		jQuery(this).toggleClass("open");
		jQuery(this).find("ul").slideToggle(300);
	});
  });
  jQuery(function(){
	  var w = jQuery(window).width();
	  var x = 480;
	  if (w <= x) {
		  jQuery(".column-navi h2").html("カテゴリーから探す");
	  } else if(w > x) {
	  }
  });
  
  jQuery(function($){
	  if(document.URL.match("https://jobshot.jp/apply")) {
		  if($('#esmenjo').length){
			  $("#es").remove();
			  $("#esmenjo").remove();
			  $(".entry-seat").remove();
			  $(".es-example").remove();
  　		}
	  }
  });
  
  jQuery(function(){
	  if(jQuery('#canworktime').length){
		 jQuery("#canworktime br")[0].remove();
		 jQuery("#canworktime br")[0].remove();
	  }
  });
  // プロフィール画像
  jQuery(function(){
	  var w = jQuery(window).width();
	  var x = 480;
	  if (w <= x) {
		  jQuery(".um-profile-photo-img").on('click',function(){
			  jQuery(".upload-photo").slideDown("fast");
		  });
		  jQuery(".um-cover-overlay").on('click',function(){
			  jQuery(".upload-coverphoto").slideDown("fast");
		  });
		  jQuery(".upload-photo .photo-cancel button.favorite.innactive").on('click',function(){
			  console.log(unnko);
			  jQuery(".upload-photo").slideUp();
			  console.log(unnko2);
		  });
		  jQuery(".upload-coverphoto .photo-cancel button.favorite.innactive").on('click',function(){
			  jQuery(".upload-coverphoto").slideUp();
		  });
	  } else if(w > x) {
		  jQuery(".um-profile-photo-img").on('click',function(){
			  jQuery(".upload-photo").fadeIn("fast");
		  });
		  jQuery(".um-cover-overlay").on('click',function(){
			  jQuery(".upload-coverphoto").fadeIn("fast");
		  });
		  jQuery(".upload-photo .photo-cancel button.favorite.innactive").on('click',function(){
			  console.log(unnko);
			  jQuery(".upload-photo").fadeOut();
			  console.log(unnko2);
		  });
		  jQuery(".upload-coverphoto .photo-cancel button.favorite.innactive").on('click',function(){
			  jQuery(".upload-coverphoto").fadeOut();
		  });
	  }
  });
  document.addEventListener('DOMContentLoaded', function() {
	  document.querySelector('input[name="upfilename"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
			  reader = new FileReader(),
			  $preview =  document.querySelector(".photo-img-preview"),
			  t = this;
		  if(file.type.indexOf("image") < 0){
		  return false;
		  }
  
		  reader.onload = (function(file) {
		  return function(e) {
			  while ($preview.firstChild) $preview.removeChild($preview.firstChild);
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '200px');
			  img.setAttribute('title',  file.name);
			  $preview.appendChild(img);
		  };
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  document.addEventListener('DOMContentLoaded', function() {
	  document.querySelector('input[name="upcovername"]').addEventListener('change', function(e) {
		  var file = e.target.files[0],
			  reader = new FileReader(),
			  $preview =  document.querySelector(".coverphoto-img-preview"),
			  t = this;
		  if(file.type.indexOf("image") < 0){
		  return false;
		  }
  
		  reader.onload = (function(file) {
		  return function(e) {
			  while ($preview.firstChild) $preview.removeChild($preview.firstChild);
			  var img = document.createElement( 'img' );
			  img.setAttribute('src',  e.target.result);
			  img.setAttribute('width', '200px');
			  img.setAttribute('title',  file.name);
			  $preview.appendChild(img);
		  };
		  })(file);
  
		  reader.readAsDataURL(file);
	  });
  });
  
  //favボタンのajax更新
  jQuery(function($){
	  $( '.favorite-button' ).click( function (){
		  // フォームデータから、サーバへ送信するデータを作成
		  var fd = new FormData();
		  //post_id取得
		  var post_id = $(this).val();
		  //カウントを示すhtmlのid
		  var count_id = "#fav_count_"+post_id;
		  //favのカウント
		  var count = (Number($(count_id).html()));
		  if($(this).hasClass("es-like-active")){
			  $(this).removeClass("es-like-active");
			  $(count_id).html(count-1);
		  }else{
			  $(this).addClass("es-like-active");
			  $(count_id).html(count+1);
		  }
		  fd.append("post_id",post_id);
		  // サーバー側で何の処理をするかを指定。
		  fd.append('action' ,'update_favorite_count' );
		  // ajaxの通信（fav数を更新）
		  $.ajax({
			  type: 'POST',
			  url: ajaxurl,
			  data: fd,
			  processData: false,
			  contentType: false,
			  success: function( response ){
			  },
			  error: function( response ){
				  console.log('miss');
			  }
		  });
		  return false;
	  });
  });
  
  jQuery(function($){
	  $('.es-text__body').hover(
		  function() {
			  //マウスカーソルが重なった時の処理
			  $(this).parents('.es-timeline__card').addClass('es-text__body_hover');
						  $(this).parents('.es-timeline__card').find('button').addClass('es-text__body_hover');
		  },
		  function() {
			  //マウスカーソルが離れた時の処理
			  $(this).parents('.es-timeline__card').removeClass('es-text__body_hover');
						  $(this).parents('.es-timeline__card').find('button').removeClass('es-text__body_hover');
		  }
	  );
  });
  
  jQuery(function($) {
	  if($('.col-sidebar').length){
		  $('.col-sidebar').addClass('fix-sidebar');
		  $('.hfeed').children('.main').addClass('fix-main');
	  }
  });
  
  
  
  jQuery(function($){
	$(".main").css('display', '');
  });
  
  jQuery(function($){
	  $( '.favorite-button_sub' ).click( function (){
		  
		  // フォームデータから、サーバへ送信するデータを作成
		  var fd = new FormData();
		  //post_id取得
		  var post_id = $(this).val();
		  //カウントを示すhtmlのid
		  var count_id = "#fav_count_"+post_id;
		  var button_id = "#fav_button_"+post_id;
		  //favのカウント
		  var count = (Number($(count_id).html()));
		  if($(button_id).hasClass("es-like-active")){
			  $(button_id).removeClass("es-like-active");
			  $(count_id).html(count-1);
		  }else{
			  $(button_id).addClass("es-like-active");
			  $(count_id).html(count+1);
		  }
		  fd.append("post_id",post_id);
		  // サーバー側で何の処理をするかを指定。
		  fd.append('action' ,'update_favorite_count' );
		  // ajaxの通信（fav数を更新）
		  $.ajax({
			  type: 'POST',
			  url: ajaxurl,
			  data: fd,
			  processData: false,
			  contentType: false,
			  success: function( response ){
			  },
			  error: function( response ){
				  console.log('miss');
			  }
		  });
		  return false;
	  });
  });
  
  
  
  jQuery(function($){
	  $('form[name=form3]').change(function(){
		  var str = location.href;
		  var w = screen.width;
		  if ( str.match(/internship/)) {
		  // チェックされている値を配列に格納
		  var area = $('input[name="area[]"]:checked').map(function(){
			  // 値を返す
			  return $(this).next().text();
		  }).get();   // オブジェクトを配列に変換するメソッド
		  var occupation = $('input[name="occupation[]"]:checked').map(function(){
			  // 値を返す
			  return $(this).next().text();
		  }).get();   // オブジェクトを配列に変換するメソッド
		  var business = $('input[name="business_type[]"]:checked').map(function(){
			  // 値を返す
			  return $(this).next().text();
		  }).get();   // オブジェクトを配列に変換するメソッド
		  var feature = $('input[name="feature[]"]:checked').map(function(){
			  // 値を返す
			  return $(this).next().text();
		  }).get();   // オブジェクトを配列に変換するメソッド
		  var sw = $('input[name="sw"]').map(function(){
			  // 値を返す
			  return $(this).val();
		  }).get();
		  $.ajax({
			  type: 'POST',
			  url: ajaxurl,
			  data: {
				  "action":"ajax_search",
				  "area":area,
				  "occupation":occupation,
				  "business":business,
				  "feature":feature,
				  "sw":sw,
				  "window_size":w,
			  },
			  success: function( response ){
				  $(".condition_table").html(response);
				  if(w <681){
					  var res = response.split('<span class="num__search">')[1];
					  var res = res.split('</span>')[0];
					  $(".num__search-sp").text(res);
				  }
			  },
			  error: function( response ){
				 console.log("失敗!");
			  }
		  });
		  return false;
		  }
	  });
  });

jQuery(function($){
	$('form[name=form__scout]').change(function(){
		// チェックされている値を配列に格納
		var mail = $('input[name="mail_can_send"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var gender = $('[name=gender]').val();  // オブジェクトを配列に変換するメソッド
		var login = $('[name=last_login]').val();  // オブジェクトを配列に変換するメソッド
		var degree_of_internship_interest = $('[name=degree_of_internship_interest]').val();
		var will_venture = $('[name=will_venture]').val(); 
		var profile_score = $('[name=profile_score]').val();
		var scouted_or = $('[name=scouted_or]').val();
		var university = $('input[name="university[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var faculty_lineage = $('input[name="faculty_lineage[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var graduate_year = $('input[name="graduate_year[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var occupation = $('input[name="occupation[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var studied_abroad = $('input[name="studied_abroad[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド

		var student_experience = $('input[name="student_experience[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var univ_community = $('input[name="univ_community[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド

		var internship_experiences = $('input[name="internship_experiences[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var bussiness_type = $('input[name="bussiness_type[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var programming = $('input[type="range"]').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		var sw = $('input[name="freeword"]').map(function(){
			// 値を返す
			return $(this).val();
		}).get();
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				"action":"ajax_search_student",
				"mail":mail,
				"gender":gender,
				"login":login,
				"degree_of_internship_interest":degree_of_internship_interest,
				"will_venture":will_venture,
				"profile_score":profile_score,
				"university":university,
				"faculty_lineage":faculty_lineage,
				"graduate_year":graduate_year,
				"occupation":occupation,
				"studied_abroad":studied_abroad,
				"student_experience":student_experience,
				"univ_community":univ_community,
				"internship_experiences":internship_experiences,
				"bussiness_type":bussiness_type,
				"programming":programming,
				"sw":sw,
				"scouted_or":scouted_or,
			},
			success: function( response ){
				var text = 'この条件で検索する'+response;
				var text2 = '検索'+response;
				$('.scout_search').val(text);
				$('.scout_freeword_search').val(text2);
			},
			error: function( response ){
			   console.log("失敗!");
			}
		});
		return false;
	});
});
jQuery(function($){
	$('input[name="user_ids[]"]').change(function(){
		var user_ids = $('input[name="user_ids[]"]:checked').map(function(){
			// 値を返す
			return $(this).val();
		}).get();   // オブジェクトを配列に変換するメソッド
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				"action":"ajax_scout_students_link",
				"user_ids":user_ids,
			},
			success: function( response ){
				if(response == 'safe'){
					if($(".fixed-buttom").hasClass("hidden")) {
						$('.fixed-buttom').removeClass("hidden");
					}
				}else if(response == 'miss'){
					if($(".fixed-buttom").not("hidden")) {
						$('.fixed-buttom').addClass("hidden");
					}
					alert('１ヶ月に送ることができる上限を超えています');
				}else{
					if($(".fixed-buttom").not("hidden")) {
						$('.fixed-buttom').addClass("hidden");
					}
				}
			},
			error: function( response ){
			   console.log("失敗!");
			}
		});
		return false;
	});
});

jQuery(function($){
	$("#scout_test0 .scout_test").addClass("hidden");
	$("#scout_test0 .scout_test").before('');
});
// トップバナー
function removebanner() {
    jQuery('.top-banner').remove();
}
