$(document).ready(function () {

    bindFunc();

    $('#search').on('keyup', function () {
        var term = $(this).val();
        search(term);
    });

    $('#results').on('click', '.selectable', function () {
        var name = $(this).text();
        var id = $(this).data('id');
        $('#selected').append('<div>' +
            '<p class="columns medium-6">' + name + '</p>' +
            '<button class="remove" id="' + id + '">Remove</button>' +
            '</div>' +
            '');
        $('#selected-form').append('<input type="hidden" id="' + id + '" name="interests[_ids][]" value="' + id + '">');
        bindFunc()
    });

    $("#message-form").submit(function(event) {
        event.preventDefault();
        var $form = $( this ),
            url = $form.attr( 'action' );

        /* Send the data using post with element id name and name2*/
        var posting = $.post( url, { body: $('#body').val() } );

        /* Alerts the results */
        posting.done(function( data ) {
            $("#message-form")[0].reset();
        });
    });

    // var messageId = $('#messages-id').val();
    refreshMessages(messageId);


});

function search(term) {
    $.get({
        url: 'http://mycake3.app/interests/search',
        data: {term: term},
        success: function (data) {
            $('#results').html(data);
        }
    })
}

var interval = 1000;
function refreshMessages(messageId) {

    $.get({
        url: 'http://mycake3.app/messages/instant-messages/' + messageId,
        success: function (data) {
            $('#messages').html(data);
        },
        complete: function () {
            // Schedule the next
            setTimeout(refreshMessages(messageId), interval);
        }
    })
}

function bindFunc() {
    $('.remove').click(function () {
        var id = $(this).attr('id');
        $(this).parent().remove();
        $('#' + id).remove();
    });
}