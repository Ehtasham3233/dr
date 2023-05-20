$('.mask').click(function () {
  $('.mask').fadeOut();
});

$(".btn-btt").click(function() {
  $("html, body").animate({ scrollTop: 0 }, "slow");
});

$("#btn_report_cancel").click(function (e) {
  $(".mask").fadeOut();
  $('.report-popup').fadeOut();
});

$(".btn-comment").click(function () {
  $("div.btn-comment").hide();
  $('.comment').show();
  $("html, body").animate({
      scrollTop: $('.comment').offset().top
  }, 500);
});

$(".tab li").click(function() {
  $(this).parent().find('li').removeClass('selected');
  $('.anime_muti_link li').removeClass('selected');
  $(this).addClass('selected');

  var tab_class = $(this).attr('data-tab');
  $('.' + tab_class).parent().find('.tab-content').removeClass('selected');
  $('.' + tab_class).addClass('selected');

  $(window).trigger('scroll');
});

$('.anime_muti_link li').click(function (e) {
    e.preventDefault();
    $("#tab-video li").removeClass('selected');
    $('.anime_muti_link li').removeClass('selected');
    
    if ($(this).hasClass("selected")) {
        return false;
    }else{
        var link = $(this).attr('data-video');
        $(".tab-content-video iframe").attr('src', link);
        $('html,body').animate({
                scrollTop: $("#block-tab-video").offset().top
            }, 1000);
    }
    $(this).addClass('selected');
});

$(".switch-view li").click(function(){
  $(".switch-view li").removeClass('selected');
  $(this).addClass('selected');

  $(".switch-block").attr('class','switch-block ' + $(this).attr('data-view'));
});

$(".lazy").lazyload({
  effect: "fadeIn",
  failure_limit: 10,
  skip_invisible: true
});

$(".show-all").click(function(){
  $(this).remove();
  $(".all-episode li").fadeIn().css("display","inline-block");
});

$('a.menu_mobile').click(function(){ 
        slideMenu = $('nav.menu_top');
        if (slideMenu.is(':hidden')) {
            $('#off_light').removeClass('hide');
            $('#off_light').addClass('show');
            $(slideMenu).removeClass('hide');
            $(slideMenu).addClass('show');
            $('html').css({"height":"100%","width":"100%", "overflow-x":"hidden"});
            $('body').css({"height":"100%","overflow-y":"hidden", "width":"100%", "overflow-x":"hidden"});
        }else{
            $('#off_light').removeClass('show');
            $('#off_light').addClass('hide');
            $(slideMenu).removeClass('show');
            $(slideMenu).addClass('hide');
            $('html').css({"height":"","width":"", "overflow-x":""});
            $('body').css({"height":"","overflow-y":"","width":"", "overflow-x":""});
        }
    }); 
    $('#off_light').click(function(){ 
            $('#off_light').removeClass('show');
            $('#off_light').addClass('hide');
            $(slideMenu).removeClass('show');
            $(slideMenu).addClass('hide');
            $('html').css({"height":"","width":"", "overflow-x":""});
            $('body').css({"height":"","overflow-y":"","width":"", "overflow-x":""});
    }); 

//navbar
var current_url = window.location.protocol + '//' + window.location.hostname + window.location.pathname;

$(".navbar li>a").each(function(){
  if(this.href === current_url){
    $(this).parent().addClass('selected');
  }
});

// if (document.getElementById('load-anclytic')){
// 		loadTopViews('.tab_icon.one1', 1)
// }
    function loadTopViews(obj,id){ 
    if(id>1){$("#laoding").show();}if ($.trim($("#load_topivews.views"+id).html()).length > 0 ){$("#laoding").hide();}$(".tab_icon").removeClass("active");$(".movies_show #load_topivews").hide();$(".tab_icon.one"+id).addClass('active');$("#load_topivews.views"+id).show();if(id>0){$("#load_topivews.views"+id).is(":empty")&&$.ajax({url:api_anclytic+'?id='+id,type:'GET',async:true,crossDomain:true,success:function(data){if(data!='0'){var dataString=JSON.stringify(data);$("#load_topivews.views"+id).html(data);$("#laoding").hide()}}})}
}
function ajaxBookmark(id, url, callback) {
    $.ajax({
        dataType: 'json',
        type: 'post',
        async: false,
        data: {
            id: id,
            _csrf: $("meta[name=csrf-token]").attr('content')
        },
        url: url,
        success: function (response) {
            callback(response);
        }
    });
}
