$(document).ready(function(){


    $('.jsSendFeed').on('click', function(e){
        e.preventDefault();
        $('.jsCommentForm').fadeIn();
    });

    $('.jsSendMessage').on('click', function(e){
        e.preventDefault();


        var $message = $('#text').val();

        $.ajax({
            type: "POST",
            url: "/api/feedadd/",
            data: {
                'message': $message,
            },
            success: function(data)
            {
                console.log(data);
                if (data) {
                    window.location = '/';
                }
                else {
                    alert('error');
                }
            }
        });
    })

    $('.close').on('click', function(e){
        e.preventDefault();
            var $id = $(this).attr('data-id');
            $('.message[data-id='+ $id + ']').remove();

            $.ajax({
                type: "POST",
                url: "/api/feedremove/",
                data: {
                    'id': $id,
                },
            });


    })
});
