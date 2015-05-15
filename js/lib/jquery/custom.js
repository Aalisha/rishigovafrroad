/*Custom Javascript*/
$(document).ready(function ()
{
    var removeClass = true;
    $(".m-trig, .m-box ul li a").on("click", function ()
    {
        $(".m-box").toggleClass('open');
        removeClass = false;
    });

    // console.log(window.base_url);
    // alert(document.location.host);			

    // Popup Box
    $('a.popup').click(function ()
    {
        var popupid = $(this).attr('rel');
        $('#' + popupid).fadeIn();
        $('body').append('<div id="fade"></div>');
        $('#fade').css({ 'filter': 'alpha(opacity=80)' }).fadeIn();
        var popuptopmargin = ($('#' + popupid).height() + 10) / 2;
        var popupleftmargin = ($('#' + popupid).width() + 10) / 2;
        $('#' + popupid).css({
            'margin-top': -popuptopmargin,
            'margin-left': -popupleftmargin
        });
    });
    $('#fade, #close, #start_survey, #vote_indi').click(function ()
    {
        $('#fade, .popupbox').fadeOut()
        return false;
    });

    // function setHeight() {
    // 	var top = $('.main-header ').outerHeight();
    // 	var nav = $('.breadcrum-nav').outerHeight();
    // 	var action = $('.continue').outerHeight();
    // 	var bottom = $('.footer').outerHeight();
    // 	var totHeight = $(window).height();
    // 	var newHeight = ( totHeight - top - nav - action - bottom - 20 );
    // 	$('.inner-middle-database , .inner-middle-database .left-part,  .inner-middle-database .right-part').css({ 
    // 		'height': newHeight + 'px'
    // 	});
    // }
    // setHeight();
    // $(window).on('resize', function() { setHeight(); });


    function setHeight()
    {
        var top = $('.main-header ').outerHeight();
        var nav = $('.breadcrum-nav').outerHeight();
        var action = $('.continue').outerHeight();
        var bottom = $('.footer').outerHeight();
        var totHeight = $(window).height();
        var newHeight = (totHeight - top - nav - action - bottom);
        var mainHeight = (totHeight -top -bottom);
        var dalalistHeight = (newHeight - 280);
        $('.inner-middle-workspace .target-indicator-stp2').css({
            'height': newHeight + 'px'
        });
        $('.inner-middle-workspace .target-indicator-stp2 .data-listing').css({
            'height': dalalistHeight + 'px'
        });
        $('.main-middle').css({
            'height': mainHeight + 'px'
        });
    }
    $(window).on('resize', function () { setHeight(); });
    setHeight();
});    