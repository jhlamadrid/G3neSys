
$(function() {
    $('#username').focus();
    $("#formLogin").validate({
        rules :{
            username: { required: true},
            email: { required: true},
            password: { required: true}
        },
        messages:{
            username: { required: 'Campo Requerido.'},
            email: { required: 'Campo Requerido.'},
            password: { required: 'Campo Requerido.'}
        },
        submitHandler: function( form ){   
            $("#username").val($("#username").val().toUpperCase())
            var datos = $(form).serialize();
            $.ajax({
                type: "POST",
                url: `${base_url}/${app}/ingresar?ajax=true`,
                data: datos,
                dataType: 'json',
                success: function(data) {
                    
                    if(data.res === true) {
                        localStorage.setItem('token', data.token);
                        window.location.href = `${base_url}/${app}/inicio`;
                    } else {
                        showAlert(data.message, `alert`)
                    }
                }
            });
            return false;
        },
        errorClass: "help-inline",
        errorElement: "small",
        highlight:function(element, errorClass, validClass){
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass){
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });
});
