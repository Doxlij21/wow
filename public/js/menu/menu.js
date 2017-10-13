$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.menuMenu').fadeIn();
        $('.menuHover').fadeOut();
        $('.scrollup').fadeIn();
    } else {
        $('.scrollup').fadeOut();
    }
});

var colors = ['rgb(240, 100, 53)', 'rgb(113, 173, 37)', 'rgb(60, 119, 188)','rgb(88, 62, 160)','rgb(48, 168, 141)','rgb(210, 60, 67)','rgb(82, 165, 182)','rgb(196, 16, 90)','rgb(255, 161, 0)'];
var random_color = colors[Math.floor(Math.random() * colors.length)];

$('.menuMenu').css('background', random_color).on("click",function(){
    $('.menuHover').show();
    $('.menuMenu').hide();
});

$(window).on('load', function() {
    $("body").show();
});