var tspand = $('.third span.done');
var tspanp = $('.third span.pending');
var tspane = $('.third span.error');
var count = 0;
if (!$.session.get("Names"))
{
    var sessionNames = ['null'];
} else {
    var sessionNames = $.session.get("Names").split(',');
}
var arrayOfNamesPlused = $.merge(arrayOfNames[0],sessionNames);

$.each(arrayOfNamesPlused ,function (index , value) {
    for (i=0; i < $('#selectCharacters').children().find('input').length ; i++)
    {
        if ($('#selectCharacters').children().find('input')[i].value == value)
        {
            $('#selectCharacters').children().find('input').eq(i).prop( "checked", true );
        }
    }
});
$('#selectCharacters').find('input').on('click',function () {
    var classes = $(this)[0];
    var intId = count++;
    var tspandiv = $("<div id=\"selectedcharacters" + intId + "\" style=\"display: inline;margin-right: 5px;\"></div>");
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
    if($( this ).prop( "checked" ) == false)
    {
        if (tspand.children().length == '1')
        {
            tspand.hide();
            tspanp.show();
            tspane.hide();
        }
        for (i = 0; i < arrayOfNamesPlused.length; ++i)
        {
            if (arrayOfNamesPlused[i] == $(this)[0].value)
            {
                arrayOfNamesPlused = jQuery.grep(arrayOfNamesPlused, function(value) {
                    return value != arrayOfNamesPlused[i];
                });
                $.session.remove("Names");
                $.session.set("Names",arrayOfNamesPlused);
            }
        }
        for (var i = 0; i < $('.third span.done div').length; ++i)
        {
            if($(this)[0].value == $('.third span.done div')[i].outerText)
            {
                $('.third span.done div')[i].remove();
                return;
            }
        }
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