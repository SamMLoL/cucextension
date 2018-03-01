    $(document).ready(function() {
        $("#ok").hide();

        $("#formuRegistro").validate({
            rules: {
                usuario: { required: true, minlength: 5, maxlength: 25},
                correo: { required:true, email: true},
                clave: { required:true},
                confirclave: { required:true},
                claveadmin:{ required:true}
            },
            messages: {
                usuario: {required: 'El campo es requerido', minlength: 'El mínimo permitido son 5 caracteres', maxlength: 'El máximo permitido son 25 caracteres'},
                correo : "Debe introducir un email válido.",
                clave: "Debe introducir su contraseña.",
                confirclave: "Debes confirmar la contraseña.",
                claveadmin: "Debes introducir la contraseña de Administrador",

            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"../controlador/usuario-control.php?x=2",
                    data: $("#formuRegistro").serialize(),
                    success: function(data){
                      $("#respuesta").html(data);
                    }
                });
                    borrar();
                    function borrar(){
                       $( "form input:password" ).val('') ;
                    };

                return false

            }
         });
    });