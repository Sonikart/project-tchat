jQuery(document).ready(function($) {

    $.get('config.json', function(config){
        // Ont charge le fichier de configuration JSON pour en retourner les parametres

        $('.menu__logo').click(function(e){
            e.preventDefault;
            $('.menu').toggle(400);
        });
    
        $("#scroll").scrollTop($("#scroll")[0].scrollHeight);

        $('#loginForm').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                url: 'ajax/message.php',
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data) {
                $('input[name=content]').val('');
                var json = $.parseJSON(data);
                console.log(json.color);
                if(json.status == 'success')
                {
                    $('#scroll').append('<li style="color:'+ json.color +'" class="right">'+
                        '<p><b>'+ json.pseudo +' </b> '+ json.message +'</p>'+
                        // '<p class="date">'+ json.date +'</p>'+
                        '</li>');
                }
                $("#scroll").scrollTop($("#scroll")[0].scrollHeight);

            });
        });

        $('input').keypress(function(e) { 
            if($(this).val() != '')
            {
                $.get('ajax/check_writing.php');
            }
        });

        $('#execut_clear').click(function(e){
            e.preventDefault();
            $.get('ajax/clear.php', function(data){
            });
            // var element = $(this);
            // var elementID = event.target.id;
            // var oggVar = ("http://s1download-universal-soundbank.com/wav/2042.wav");
            // var audioElement = $('#myAudio')[0];
            // audioElement.setAttribute('src', oggVar); 
            // audioElement.play();
        });

        setInterval(function(){
            $.get('ajax/check_notificate.php', function(data){
                var json = $.parseJSON(data);
                if(json.type  == 'success'){
                    var modal_notificate = $('#alerte_notificate');
                    modal_notificate.show();
                    modal_notificate.html(json.error);
                    setTimeout(function(){           
                        modal_notificate.fadeOut(400);
                        $.get('ajax/delete_notificate.php');
                    }, config.show_notificate );
                }
            });
        }, config.check_notificate);

        setInterval(function(){
            $.get('ajax/check_clear.php', function(data) {
                var json = $.parseJSON(data);

                if(json.status == 'success'){
                    $('#scroll').html('');
                }
            });

            if($('input[name=content]').val() == ''){
                $.get('ajax/check_writing.php?no');
            } 

            $.get('ajax/actus.php');

            $.get('ajax/check_online.php', function(data) {
                var json = $.parseJSON(data);

                $('#listing').html('');

                for (var i = json.length - 1; i >= 0; i--){
                    if(json[i]['writing'] == 0){
                        $('#listing').append('<li class="list_user_connected"><img class="avatar_list" src="'+ json[i]['avatar'] +'">' + json[i]['username'] + '<img style="position: absolute; height:15px; width:15px; margin-left:2.5px; margin-top:2.5px;" src="'+ json[i]['icon_rank'] +'"><font style="margin-top:7px; float: right;color: #76FF03;">◕</font></li><i style="position: absolute; margin-left:45px; margin-top:-15px; font-size:12px;">#'+ json[i]['position'] +'</i>');
                    } else {
                        $('#listing').append('<li class="list_user_connected"><img class="avatar_list" src="'+ json[i]['avatar'] +'">' + json[i]['username'] + '<img style="position: absolute; height:15px; width:15px; margin-left:2.5px; margin-top:2.5px;" src="'+ json[i]['icon_rank'] +'"><font style="margin-top:7px; float: right;color: #76FF03;">◕</font></li><i font-size:13px; style="position: absolute; right:0; float: right; margin-top:-22.5px; margin-right: 35px;" class="far fa-comment"></i><i style="position: absolute; margin-left:45px; margin-top:-15px; font-size:12px;">#'+ json[i]['position'] +'</i>');
                    }
                }
            });

            $.get('ajax/check_message.php', function(data) {
                var json = $.parseJSON(data);

                for (var i = json.length - 1; i >= 0; i--) {
                    if($('li[id_msg="'+ json[i]['id'] +'"]').length == 0){
                        $('#scroll').append('<li id_msg="' + json[i]['id'] + '" class="left">'+
                            '<p style="color:'+ json[i]['color'] +'"><b>'+ json[i]['username'] +' :</b> '+ json[i]['message'] +'</p>'+
                            // '<p class="date">'+ json[i]['date'] +'</p>'+
                            '</li>');
                        $("#scroll").scrollTop($("#scroll")[0].scrollHeight);
                    }
                }  

            });
        }, 500);

        $('#check_token').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: 'ajax/check_token.php',
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                var json = $.parseJSON(data);
                console.log(json.error + json.type);
            })
        });

        $('#open_check').click(function(){
            $('#window_vip').fadeIn(400);
            $('#close_window_vip').click(function(){
                $('#window_vip').fadeOut(500);
            })
        });
    }); 
});
