$(document).ready(function(){

    $('#search').on('keyup', function() {
        var term = $(this).val();
        serarch(term);
    });

    $('#results').on('click', '.selectable', function () {
        console.log($(this));
        var name = $(this).text();
        var id = $(this).data('id');
        $('#selected').append('<p class="columns medium-6">' + name + ' ' + id + '</p>');
        $('#selected-form').append('<input type="hidden" name="interests[_ids][]" value="' + id + '">');
    });


});

function serarch(term) {
    $.get({
        url: 'http://mycake3.app/interests/search',
        data: {term: term},
        success: function (data) {
            $('#results').html(data);
        }
    })
}