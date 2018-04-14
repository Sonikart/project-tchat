$(document).ready(function(){

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'ajax/connexion.php',
            type: 'POST',
            data: $(this).serialize(),
        })
        .done(function(data) {
            var json = $.parseJSON(data);

            $('#alert').fadeIn(500);
            $('#alert').removeAttr('class').attr('class', json.status);
            $('#alert > #status').html(json.status+ ' !');
            $('#alert > #message').html(json.message);

            if(json.status == 'success'){
                window.location.href='index.php';
            }

            setTimeout(function() {
                $('#alert').fadeOut(500);
            }, 3000);

        });
    });

});