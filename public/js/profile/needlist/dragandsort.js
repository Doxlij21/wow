$( function() {
    var $charinv = $('#charinveq');

    $("#raiditems span").draggable({
        revert: "invalid",
        containment: "document",
        helper: "clone",
        cursor: "move",
        start: function (event, ui) {
            var dragid = $(this)[0].id;
            var snapid = $('#charinveq').find("#" + dragid);
            snapid.css('background','green');
        },
        stop: function (event, ui) {
            var dragid = $(this)[0].id;
            var snapid = $('#charinveq').find("#" + dragid);
            snapid.css('background','');
        }
    });
    $charinv.droppable({
        accept: "#raiditems span",
        drop: function (event, ui) {
            var $dragid = ui.draggable,
                $snapid = $charinv.find("#" + $dragid[0].id),
                $raid = $("#selectraid option:selected" ).text().replace(/ /g,"%20"),
                $char = $("#selectCharacter")[0].value.replace(/ /g,"%20");
            window.cloned = ui.draggable.clone();
            cloned.addClass('selectedItem').insertAfter($snapid);
            $snapid.css('display','none');
            var $itemid = $dragid[0].dataset.tooltipHref.split('http://www.wowdb.com/items/')[1];
            var $jsonString = new Array();
            $jsonString[0] = $itemid;
            $jsonString[1] = $char;
            $jsonString[2] = decodeURIComponent($raid);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                type: 'POST',
                url: '//local.wowraid/profile/needlist/simcitem',
                data: {item_id: $jsonString}
            });
        }
    });
});