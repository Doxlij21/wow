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
    var tspandiva = $("<a href=\"#" + $(this)[0].value + "\"></a>").text($(this)[0].value);
    tspandiv.append(tspandiva);
    var tspandc = $('<i />').addClass('fa fa-check-square');
    tspand.show();
    tspanp.hide();
    tspane.hide();
    tspand.append(tspandiv);
    $(".selectedcharacters" + intId).find('a').html($(this)[0].value);
    tspandiv.append(tspandc);
});