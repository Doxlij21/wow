var a=$("#classFilter");
var b=$("#selectCharacters");
var selected = $("#selectedStaticCharacter");
$('#classFilterWrap').find(a).on("click","li",function(){
    var c=$(this);
    if (c[0].dataset.catClass == 'All')
    {
        b.children().addClass("active");
    }else {
        b.find(".active").removeClass("active");
        b.find('[dataclass="'+c.data("cat-class")+'"]').addClass("active");
    }
    a.find(".active").removeClass("active");c.addClass("active");

    var guildserver = selected.find('#guildserverinput')[0].value.replace(/ /g,"%20");
    var guildname = selected.find("#guildnameinput")[0].value.replace(/ /g,"%20");
    var className = c[0].outerText.replace(/ /g,"%20");;

    $("#selectCharacters").load('?guildserver=' + guildserver  + '&guildname=' + guildname + '&class=' + className + ' #selectCharacters');
});