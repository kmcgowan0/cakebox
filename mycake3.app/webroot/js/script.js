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
    $('.reveal-link').on('click', function () {
        var liveMessageId = $(this).data('id');
        connectionMessages(liveMessageId);
    });

    $("#message-form").submit(function (event) {
        event.preventDefault();
        var $form = $(this),
            url = $form.attr('action');

        var posting = $.post(url, {body: $('#body').val()});

        posting.done(function (data) {
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
        url: '/messages/instant-messages/' + messageId,
        success: function (data) {
            $('#messages').html(data);
        },
        complete: function () {
            // Schedule the next
            setTimeout(refreshMessages(messageId), interval);
        }
    })
}

function connectionMessages(messageId) {
    $.get({
        url: 'http://mycake3.app/messages/instant-messages/' + messageId,
        success: function (data) {
            $('#messages'+messageId).html(data);
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