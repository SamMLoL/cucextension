    $(document).ready(function() {
        $("#ok").hide();

            $('#usuario').blur(function(){

                    $('#info').html('<img src="loader.gif" alt="" />').fadeOut(300);

                    var usuario = $(this).val();        
                    var dataString = 'usuario='+usuario;

                    $.ajax({
                        type: "POST",
                        url: "../controlador/usuario-control.php?x=3",
                        data: dataString,
                        success: function(data) {
                            $('#info').fadeIn(300).html(data);
                        }
                    });
                });              


        $("#formuRegistro").validate({
            rules: {
                usuario: { required: true, minlength: 4, maxlength: 25},
                correo: { required:true, email: true, minlength: 13, maxlength: 50},
                clave: { required:true, minlength: 6, maxlength:25},
                confirclave: { required:true, minlength: 6, maxlength:25},
                claveadmin:{ required:true, minlength: 6, maxlength:25}
            },
            messages: {
                usuario: {required: 'Debe introducir un usuario.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                correo : "Debe introducir un email válido.",
                clave: {required: 'Debe introducir una contraseña', minlength: 'El mínimo permitido son 6 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                confirclave: {required: 'Debe confirmar su contraseña', minlength: 'El mínimo permitido son 6 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                claveadmin: "Debes introducir la contraseña de Administrador",

            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"../controlador/usuario-control.php?x=2",
                    data: $("#formuRegistro").serialize(),
                    beforeSend:function(){
                        $('#registrar').val('Conectando...');
                    },
                    success: function(data){
                      $("#respuesta").html(data);
                      $('#registrar').val('Registrar');
                    }
                });
                    borrar();
                    function borrar(){
                       $( "form input:password" ).val('') ;
                    };

                return false

            }
         });
            $("#formulogin").validate({
            rules: {
                usuariologin: { required: true, minlength: 4, maxlength: 25},
                clavelogin: { required:true, minlength: 6, maxlength:25}
            },
            messages: {
                usuariologin: {required: 'Debe introducir un usuario.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                clavelogin: {required: 'Debe introducir una contraseña', minlength: 'El mínimo permitido son 6 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"../controlador/usuario-control.php?x=1",
                    data: $("#formulogin").serialize(),
                    beforeSend:function(){
                        $('#login').val('Conectando...');
                    },
                    success: function(data){
                        $('#login').val('ingresar');
                        if (data=="ok") {
                            $(location).attr('href','../controlador/index.php');
                        } else {
                            $("#respuestalogin").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Usuario o contraseña incorrectas.</div>");
                        }

                    }
                });
                    borrar();
                    function borrar(){
                       $( "form input:password" ).val('') ;
                    };

                return false

            },
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                  if (placement) {
                    $(placement).append(error)
                  } else {
                    var inputName = $(element).attr('name')
                    $('#error-'+inputName).append(error)
                  }
            }
         });
    });