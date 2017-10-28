var tspand = $('.third span.done');
var tspanp = $('.third span.pending');
var tspane = $('.third span.error');
var count = 0;
$('#selectCharacters').find('input').on('click',function () {
    if ($('#selectCharacters').children().find('input:checked').length == 0)
    {
        tspand.hide();
        tspanp.show();
        tspane.hide();
    }
    if($( this ).prop( "checked" ) == false)
    {
        for (var i = 0; i < $('.third span.done div').length; ++i)
        {
            if($(this)[0].value == $('.third span.done div')[i].outerText)
            {
                $('.third span.done div')[i].remove();
                return;
            }
        }
    }
    var intId = count++;
    var tspandiv = $("<div id=\"selectedcharacters" + intId + "\" style=\"display: inline;margin-right: 5px;\"></div>");
    if($(this)[0].parentElement.id == 'Warrior') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#C79C6E').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Paladin') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#F58CBA').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Hunter') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#ABD473').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Rogue') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#FFF569').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Priest') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#FFFFFF').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Death Knight') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#C41F3B').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Shaman') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#2459FF').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Mage') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#69CCF0').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Warlock') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#9482CA').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Monk') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#008467').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Druid') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#FF7D0A').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'Demon Hunter') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#A330C9').text($(this)[0].value);
    }
    else if($(this)[0].parentElement.id == 'ALL') {
        var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").css('color','#FFFFFF').text($(this)[0].value);
    }
    tspandiv.append(tspandiva);
    var tspandc = $('<i />').addClass('fa fa-check-square');
    tspand.show();
    tspanp.hide();
    tspane.hide();
    tspand.append(tspandiv);
    $(".selectedcharacters" + intId).find('a').html($(this)[0].value);
    tspandiv.append(tspandc);
});