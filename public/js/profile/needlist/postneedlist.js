$(document).ready(function() {
    $(function() {
        function callAjax(){
            var raid = $("#selectraid option:selected" ).text().replace(/ /g,"%20");
            var char = $("#selectCharacter")[0].value.replace(/ /g,"%20");
            $('#pending').load('?raid=' + raid + '&char=' + char + " #pending");
        }
        setInterval(callAjax, 20000 );
    });

    $('.reseteq').click(function () {
        var $char = $("#selectCharacter")[0].value.replace(/ /g,"%20");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax
        ({
            type: 'POST',
            url: '//local.wowraid/profile/needlist/switchitem',
            data: {switched: $char},
            success: function(){
                $('#charinveq').load('?char=' + $char + ' #charinveq', function () {
                    $.getScript('/js/profile/needlist/dragandsort.js')
                });
            }
        });
    });

    $('#selectCharacter').on('change', function() {
        $('#statsform').submit();
    });

    $('#selecttemplate').on('change',function () {
        var char = $("#selectCharacter")[0].value.replace(/ /g,"%20");
        var tempname = $(this)[0].value;
        $("#charinveq").load('?char=' + char + '&tempname=' + tempname  + ' #charinveq', function () {
            $.getScript('/js/profile/needlist/dragandsort.js')
        });
    });

    $('#selectraid').on('change', function() {
        var raid = $("#selectraid option:selected" ).text().replace(/ /g,"%20");
        var char = $("#selectCharacter")[0].value.replace(/ /g,"%20");
        $("#raiditems").load('?raid=' + raid + '&char=' + char + ' #raiditems', function () {
            $.getScript('/js/profile/needlist/dragandsort.js')
        });
    });

});