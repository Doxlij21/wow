
var a=$("#classFilter");
var b=$("#selectCharacters");
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
});
