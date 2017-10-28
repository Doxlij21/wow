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
    var classes = $(this)[0];
    var arrayOfClasses = [
        ['Paladin' ,'#F58CBA'],['Warrior' , '#C79C6E'],['Warlock' ,'#9482CA'],['Hunter' , '#ABD473'],['Rogue', '#FFF569'],['Priest' , '#FFFFFF'],['Death Knight','#C41F3B'],['Shaman','#2459FF'],
        ['Mage','#69CCF0'],['Monk','#008467'],['Druid','#FF7D0A'],['Demon Hunter','#A330C9']
    ];
    $.each(arrayOfClasses, function(index , value){
        if(classes.parentElement.id == value[0])
        {
            tspandiva = $("<a href=\"#" + classes.value + "\"></a>").css('color',value[1]).text(classes.value);
        }
    });

    tspandiv.append(tspandiva);
    var tspandc = $('<i />').addClass('fa fa-check-square');
    tspand.show();
    tspanp.hide();
    tspane.hide();
    tspand.append(tspandiv);
    $(".selectedcharacters" + intId).find('a').html($(this)[0].value);
    tspandiv.append(tspandc);
});