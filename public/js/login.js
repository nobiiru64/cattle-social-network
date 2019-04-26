$(document).ready(function(){


    $('.jsSubmit').on('click', function(e){
       e.preventDefault();
       var $name = $('#inputLogin').val();
       var $pass = $('#inputPassword').val();


        $.ajax({
            type: "POST",
            url: '/login',
            data: {
                'user': $name,
                'pass': $pass
            },
            success: function(data)
            {
                console.log(data);
                if (data) {
                    window.location = '/';
                }
                else {
                    alert('Invalid Credentials');
                }
            }
        });



    });
});
