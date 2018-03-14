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
                        
                        if (data=="ok") {
                            $(location).attr('href','../controlador/index.php');
                        } else {
                            $("#respuestalogin").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Usuario o contraseña incorrectas.</div>");
                            $('#login').val('ingresar');
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


            $("#formuParticipante").validate({
                rules: {
                    cedula: { required: true, digits: true, minlength: 7, maxlength: 9},
                    nombre:  { required: true, minlength: 4, maxlength: 25},
                    apellido: { required: true, minlength: 4, maxlength: 25},
                    edad: { required: true, digits: true},
                    sexo: { required: true},
                    carrera: { required: true},
                    id_disciplina: { required: true},
                    correo: { required:true, email: true, minlength: 13, maxlength: 50},
                    telefono: { required: true, digits:true, minlength: 4, maxlength: 25},
                    descripcion_part: { required: true, minlength: 4, maxlength: 40},
                    status: { required: true}

                },
                messages: {
                    cedula: "Debe instroducir una cedula valida",
                    nombre: {required: 'Debe introducir un nombre.' , minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    apellido: {required: 'Debe introducir el apellido.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    edad: "Debe instroducir una edad valida",
                    sexo: "Debe seleccionar un sexo",
                    carrera: "Debe seleccionar una carrera",
                    id_disciplina: "Debe seleccionar una disciplina.",
                    correo : "Debe introducir un email válido.",
                    telefono: "Debe introducir un telefono valido.",
                    descripcion_part: {required: 'Debe introducir una descripcion.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 40 caracteres.'},
                    status: "Debe seleccionar un estatus",

                },
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"../controlador/participante-control.php?x=1",
                        data: $("#formuParticipante").serialize(),
                        beforeSend:function(){
                            $('#registrar').val('Conectando...');
                        },
                        success: function(data){
                          $('#registrar').val('Registrar');

                            if (data == "error") {

                                $("#respRegistro").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se logro registrar el participante, la cedula puede estar ya registrada</div>");
                            }
                            else {                         
                                alert("El participante ha sido registrado con exito");
                                $(location).attr('href','../controlador/index.php?x=4&cedula='+data);
                           }
                        }
                    });

                    return false
                }
            });

    });




 $(document).ready(function() {
        
        var disci = function(){

            $.ajax({
                    type: "POST",
                    url: "../controlador/funciones.php?x=1",
                    success: function(response)
                    {
                        $('#selector-disciplina select').html(response).fadeIn();
                        mostrar();
                    }
            });
            return false
        };
        disci();


            
            $("#formdisciplina").validate({
                rules: {
                    nombre: { required: true, minlength: 4, maxlength: 25},
                },
                messages: {
                    nombre: {required: 'Debe introducir una disciplina.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                },
            
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"../controlador/funciones.php?x=2",
                        data: $("#formdisciplina").serialize(),
                        beforeSend:function(){
                            $('#GuardarNombre').val('Guardando...');
                        },
                        success: function(data){
                          $("#resp").html(data);
                          $('#GuardarNombre').val('Guardar');
                          disci();
                        }
                    });
                return false

                }
            });

            $("#formEliminar").validate({
                rules: {
                    id_disciplina: { required: true},
                },
                messages: {
                    id_disciplina: {required: 'Debe seleccionar una disciplina'},
                },

                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"../controlador/funciones.php?x=3",
                        data: $("#formEliminar").serialize(),
                        beforeSend:function(){
                            $('#EliminarNombre').val('Cargando...');
                        },
                        success: function(data){
                          $("#respEliminar").html(data);
                          $('#GuardarNombre').val('Eliminar');
                          disci();
                        }
                    });
                return false

                }
            });

        $("#formubuscar").validate({
            rules: {
                cedula1: { required: true, digits: true, minlength: 7, maxlength: 9}
            },
            messages: {
               
               cedula1: 'Debe instroducir una cedula valida.',
            },
            submitHandler: function(form){
                $.ajax({
                    type: "GET",
                    url:"../controlador/participante-control.php?x=2",
                    data: $("#formubuscar").serialize(),
                    beforeSend:function(){
                        $('#buscarPart').val('Buscando...');
                    },
                    success: function(data){
                        if (data!=0) {
                            $(location).attr('href','../controlador/index.php?x=4&cedula='+data);
                        } else {
                            $("#respbuscar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Cedula incorrecta.</div>");
                            $('#buscarPart').val('Buscar Participante');
                        }

                    }
                });

                return false

            },
         });

 
    });


    $(document).on('click', '#agregarDis', function() {
        $('#ModalAgregarDisciplina').modal('show');
    });

    $(document).on('click', '#eliminarDis', function() {
        $('#ModalEliminarDisciplina').modal('show');
    });



