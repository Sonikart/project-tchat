$('#registerForm').on('submit', function(e){
        e.preventDefault();
        
        $.ajax({
        	url: 'ajax/register.php',
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
                window.location.href='login.php';
            }

            setTimeout(function() {
                $('#alert').fadeOut(500);
            }, 3000);
        })
    })