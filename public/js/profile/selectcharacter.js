var sspanp = $('.second span.pending');
var sspand = $('.second span.done');
$('#staticCharacterOpt').find('li').on('click',function () {
    if ($.session.get("Names"))
    {
        $.session.remove("Names");
    } else {}
    var transfer = $(this)[0].nextElementSibling;
    var selected = $("#selectedStaticCharacter");
    var sspandc = $('<i />').addClass('fa fa-check-square');
    var sspandp = $('<i />').addClass('fa fa-hand-pointer-o').css('color','#cecece');
    var sspandpa = $('<a href="#staticCharacterOpt"></a>');
    sspandpa.append(sspandp);
    selected.html(transfer.outerHTML);
    selected.children().eq(0).show();

    $.ajaxSetup ({
        cache: false,
        complete: function() {

            setTimeout(2000);
        }
    });
    guildserver = selected.find('#guildserverinput')[0].value.replace(/ /g,"%20");
    guildname = selected.find("#guildnameinput")[0].value.replace(/ /g,"%20");
    sspanp.hide();
    sspand.show();
    sspand.text($(this)[0].textContent);
    sspand.append(sspandc);
    sspand.append(sspandpa);
    $('.third span.done div').remove();
    $('.third span.done').hide();
    $('.third span.error').hide();
    $('.third span.pending').show();

    $("#staticUsers").load('?guildserver=' + guildserver  + '&guildname=' + guildname + ' #staticUsers', function () {
        $.getScript('/js/profile/classfilter.js');
        $.getScript('/js/profile/checkselectedcharacters.js');
    });

});