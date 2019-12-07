$(function () {

    $('form').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'ajax-track-response.php',
            data: $('form').serialize(),
            beforeSend: function() { $('#response').html("Loading..."); },
            success: function (data) {
                $('#response').html(data);
            }
        });

    });

});