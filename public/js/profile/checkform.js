var fspand = $('.first span.done');
var fspanp = $('.first span.pending');
var fspane = $('.first span.error');
var tspane = $('.third span.error');
var tspand = $('.third span.done');
var tspanp = $('.third span.pending');
$("input[name='static_name']").on('input', function() {
    var fspandc = $('<i />').addClass('fa fa-check-square');
    var fspandp = $('<i />').addClass('fa fa-hand-pointer-o').css('color','#cecece');
    var fspadpa = $('<a href="#static_name"></a>');

    fspadpa.append(fspandp);
    if (!$("input[name='static_name']")[0].value)
    {
        fspanp.show();
        fspand.hide();
        fspane.hide();
    } else {
        fspane.hide();
        fspanp.hide();
        fspand.text($("input[name='static_name']")[0].value);
        fspand.append(fspandc);
        fspand.append(fspadpa);
        fspand.show();
    }
});

function check() {
    var fspanem = $('<i />').addClass('fa fa-minus-square');
    var tspanem = $('<i />').addClass('fa fa-minus-square');
    var fspanep = $('<i />').addClass('fa fa-hand-pointer-o').css('color','#cecece');
    if (!$("input[name='static_name']")[0].value) {
        fspand.hide();
        fspanp.hide();
        fspane.show();
        fspane.text('Please enter static name');
        fspane.append(fspanem);
        fspane.append(fspanep);
        return false;
    }
    if ($('#selectCharacters').find('input:checked').length == 0) {
        tspand.hide();
        tspanp.hide();
        tspane.text('Please select atleast one static member');
        tspane.append(tspanem);
        tspane.show();
        return false;
    }
}