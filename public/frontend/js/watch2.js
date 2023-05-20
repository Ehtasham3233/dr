$("#tab-video li").click(function () {
    $(this).parent().find('li').removeClass('selected');
    $(this).addClass('selected');

    $(".tab-content-video iframe").attr('src', '');

    $(".tab-content-video.selected iframe").attr('src', $(".tab-content-video.selected iframe").attr("data-src"));
});

$(document).ready(function () {

    $('.offlight').click(function (e) {
        e.preventDefault();
        $('#off_light').fadeToggle();
    });
    $('#off_light').click(function () {
        $(this).hide();
    });

    $(".btn-report").click(function (e) {
        $(".mask").fadeIn();
        $('.report-popup').fadeIn();

        e.stopPropagation();
    });

    $(".btn-dismiss").click(function (e) {
        $(".popover-favorites").fadeOut();
        e.stopPropagation();
    });

    $(".report2").click(function (e) {
        $(".mask").fadeIn();
        $('.report-popup').fadeIn();

        e.stopPropagation();
    });

    $(window).click(function (e) {
        var container = $(".login-popup, .report-popup");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });
});