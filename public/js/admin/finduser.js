jQuery(document).ready(function($) {
    var engine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace('username'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote:{
            url: '/admin/search/querysearchuser?search_user=%QUERY',
            wildcard: '%QUERY'
        }
    });
    var engineid = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace('id'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote:{
            url: '/admin/search/querysearchuser?id=%QUERY',
            wildcard: '%QUERY'
        }
    });

    engine.initialize();
    engineid.initialize();

    $("#search_user_id").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        source: engineid.ttAdapter(),
        name: 'search_user_id_list',
        displayKey: 'id',
        templates: {
            empty: [
                '<div class="empty-message">unable to find any</div>'
            ].join('\n'),

            suggestion: function (data) {
                return '<div class="user-search-result"><h3>'+ data.username +'</h3></div>'
            }
        }
    });

    $("#search_user").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
    }, {
        source: engine.ttAdapter(),
        name: 'search_user_list',
        displayKey: 'username',
        templates: {
            empty: [
                '<div class="empty-message">unable to find any</div>'
            ].join('\n'),

            suggestion: function (data) {
                if($("#search_user").get(0).value.length == data.username.length && $("#search_user").get(0).value.toLowerCase() == data.username.toLowerCase())
                {
                    $.ajaxSetup ({
                        cache: false,
                        complete: function() {

                            setTimeout(2000);
                        }
                    });

                    $("#selectedUser").load(this.href + '?name=' + data.id  + ' #selectedUser');
                    $("#roleoptrevoke").load(this.href + '?name=' + data.id  + ' #roleoptrevoke');
                    $("#roleoptassign").load(this.href + '?name=' + data.id + ' #roleoptassign');
                    $("#permissionoptrevoke").load(this.href + '?name=' + data.id  + ' #permissionoptrevoke');

                    $("#search_user_id").val(data.id);
                }
                return '<div class="user-search-result"><h3>'+ data.username +'</h3></div>';
            }
        }
    });

    var employeeNameTypeahead = $('#search_user');
    var employeeIdTypeahead = $('#search_user_id');

    var employeeNameItemSelectedHandler = function (eventObject, suggestionObject, suggestionDataset) {
        employeeIdTypeahead.val(suggestionObject.id);
    };

    var employeeIdItemSelectedHandler = function (eventObject, suggestionObject, suggestionDataset) {
        employeeNameTypeahead.val(suggestionObject.name);
    };

    employeeNameTypeahead.on('typeahead:selected', employeeNameItemSelectedHandler);
    employeeIdTypeahead.on('typeahead:selected', employeeIdItemSelectedHandler);

});