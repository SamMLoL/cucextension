    $(document).ready(function() {
        $("#ok").hide();

            $('#usuario').blur(function(){

                    $('#info').html('<img src="loader.gif" alt="" />').fadeOut(300);

                    var usuario = $(this).val();        
                    var dataString = 'usuario='+usuario;

                    $.ajax({
                        type: "POST",
                        url: "controlador/usuario-control.php?x=3",
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
                    url:"controlador/usuario-control.php?x=2",
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
                    url:"controlador/usuario-control.php?x=1",
                    data: $("#formulogin").serialize(),
                    beforeSend:function(){
                        $('#login').val('Conectando...');
                    },
                    success: function(data){
                        
                        if (data=="ok") {
                            $(location).attr('href','index');
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

        $("#formuRecuperar").validate({
            rules: {
                usuario: { required: true, minlength: 4, maxlength: 25},
                correo: { required:true, email: true, minlength: 13, maxlength: 50},
                claveadmin:{ required:true, minlength: 6, maxlength:25}
            },
            messages: {
                usuario: {required: 'Debe introducir un usuario.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                correo : "Debe introducir un email válido.",
                claveadmin: "Debes introducir la contraseña de Administrador",

            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"controlador/usuario-control.php?x=6",
                    data: $("#formuRecuperar").serialize(),
                    beforeSend:function(){
                        $('#registrar').val('Conectando...');
                    },
                    success: function(data){
                      $("#RespuestaRecuperar").html(data);
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


            $("#formuParticipante").validate({
                rules: {
                    cedula: { required: true, digits: true, minlength: 7, maxlength: 9},
                    nombre:  { required: true, minlength: 4, maxlength: 25},
                    apellido: { required: true, minlength: 4, maxlength: 25},
                    edad: { required: true, digits: true},
                    sexo: { required: true},
                    carrera: { required: true},
                    select1: {required: true},
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
                    select1: "Debe seleccionar una unidad luego una disciplina.",
                    id_disciplina: "Debe seleccionar una disciplina.",
                    correo : "Debe introducir un email válido.",
                    telefono: "Debe introducir un telefono valido.",
                    descripcion_part: {required: 'Debe introducir una descripcion.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 40 caracteres.'},
                    status: "Debe seleccionar un estatus",

                },
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/participante-control.php?x=1",
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
                                var cedula = data;
                                ModicarParti(cedula);
                           }
                        }
                    });

                    return false
                }
            });





            //FUNCIONES PROFESORES
            $("#formuProfesores").validate({
                rules: {
                    cedula: { required: true, digits: true, minlength: 7, maxlength: 9},
                    nombre:  { required: true, minlength: 4, maxlength: 25},
                    apellido: { required: true, minlength: 4, maxlength: 25},
                    edad: { required: true, digits: true},
                    sexo: { required: true},
                    select1: {required: true},
                    id_disciplina: { required: true},
                    telefono: { required: true, digits:true, minlength: 4, maxlength: 25},
                    status: { required: true}

                },
                messages: {
                    cedula: "Debe instroducir una cedula valida",
                    nombre: {required: 'Debe introducir un nombre.' , minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    apellido: {required: 'Debe introducir el apellido.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    edad: "Debe instroducir una edad valida",
                    sexo: "Debe seleccionar un sexo",
                    select1: "Debe seleccionar una unidad luego una disciplina.",
                    id_disciplina: "Debe seleccionar una disciplina.",
                    telefono: "Debe introducir un telefono valido.",
                    status: "Debe seleccionar un estatus",

                },
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/profesor-control.php?x=1",
                        data: $("#formuProfesores").serialize(),
                        beforeSend:function(){
                            $('#registrar').val('Conectando...');
                        },
                        success: function(data){
                          $('#registrar').val('Registrar');

                            if (data == "error") {

                                $("#respRegistro").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se logro registrar el profesor, la cedula puede estar ya registrada</div>");
                            }
                            else {                         
                                alert("El profesor ha sido registrado con exito");
                                var cedula = data;
                                ModicarProfesor(cedula);
                           }
                        }
                    });

                    return false
                }
            });







    });




 $(document).ready(function() {

        
        var SeleccionarDis = function(){


                $("#select1").change(function(event){
                    var unidad = $("#select1").find(':selected').val();
                    $("#id_disciplina").load('controlador/funciones.php?x=1&unidad='+unidad);
                });
        }

        

        $('#select1').on('change', function(){
         var valor = $("#select1").val();
        if (valor === 0 || valor === true){
            $("#id_disciplina").attr('disabled', true);

        }else{
            $("#id_disciplina").attr('disabled', false);
        
        }
        })
        SeleccionarDis();



            
            $("#formdisciplina").validate({
                rules: {
                    unidad: {required: true},
                    nombre: { required: true, minlength: 4, maxlength: 25},
                },
                messages: {
                    unidad: "Debe seleccionar una unidad antes de registrar una disciplina.",
                    nombre: {required: 'Debe introducir una disciplina.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                },
            
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/funciones.php?x=2",
                        data: $("#formdisciplina").serialize(),
                        beforeSend:function(){
                            $('#GuardarNombre').val('Guardando...');
                        },
                        success: function(data){
                          $("#resp").html(data);
                          $('#GuardarNombre').val('Guardar');

                            $('#select1 option').prop('selected', function() {
                                return this.defaultSelected;
                            });
                            $('#UnidadEvento option').prop('selected', function() {
                                return this.defaultSelected;
                            });
                        }
                    });
                    

                return false

                }
            });

            $("#formEliminar").validate({
                rules: {
                    id_disciplina: { required: true},
                    Selectunidad2: { required: true},
                },
                messages: {
                    Selectunidad: {required: 'Debe seleccionar la unidad y luego la disciplina'},
                    id_disciplina2: {required: 'Debe seleccionar una disciplina'},
                },

                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/funciones.php?x=3",
                        data: $("#formEliminar").serialize(),
                        beforeSend:function(){
                            $('#EliminarNombre').val('Cargando...');
                        },
                        success: function(data){
                            $("#respEliminar").html(data);
                            $('#GuardarNombre').val('Eliminar');

                            $('#select1 option').prop('selected', function() {
                                return this.defaultSelected;
                            });
                            $('#UnidadEvento option').prop('selected', function() {
                                return this.defaultSelected;
                            });
                          
                        }
                    });
                return false

                }
            });

    var SelecEliminar = function(){

                $("#Selectunidad").change(function(event){
                    var unidad = $("#Selectunidad").find(':selected').val();
                    $("#id_disciplina2").load('controlador/funciones.php?x=1&unidad='+unidad);
                });
        }

        
        $('#Selectunidad').on('change', function(){
         var valor = $("#Selectunidad").val();
        if (valor === 0 || valor === true){
            $("#id_disciplina2").attr('disabled', true);

        }else{
            $("#id_disciplina2").attr('disabled', false);
        
        }
        })
        SelecEliminar();





        $("#formubuscar").validate({
            rules: {
                cedula1: { required: true, digits: true, minlength: 7, maxlength: 9}
            },
            messages: {
               
               cedula1: 'Debe instroducir una cedula valida.',
            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"controlador/participante-control.php?x=2",
                    data: $("#formubuscar").serialize(),
                    beforeSend:function(){
                        $('#buscarPart').val('Buscando...');
                    },
                    success: function(data){
                        if (data!=0) {
                            
                           // cedula(data);
                            $(location).attr('href','mostrar-participante');
                        } else {
                            $("#respbuscar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Cedula incorrecta.</div>");
                            $('#buscarPart').val('Buscar Participante');
                        }

                    }
                });

                return false

            },
         });
        $("#buscarProfesor").validate({
            rules: {
                cedula1: { required: true, digits: true, minlength: 7, maxlength: 9}
            },
            messages: {
               
               cedula1: 'Debe instroducir una cedula valida.',
            },
            submitHandler: function(form){
                $.ajax({
                    type: "POST",
                    url:"controlador/profesor-control.php?x=2",
                    data: $("#buscarProfesor").serialize(),
                    beforeSend:function(){
                        $('#buscarPro').val('Buscando...');
                    },
                    success: function(data){
                        if (data!=0) {
                            $(location).attr('href','mostrar-profesor');
                        } else {
                            $("#respbuscar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Cedula no encontrada.</div>");
                            $('#buscarPro').val('Buscar Participante');
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




 var  ModicarParti = function(cedula){
    var parametros = {
                "cedula1" : cedula,
        };

        $.ajax({
                data: parametros,
                url:   'controlador/participante-control.php?x=2', 
                type:  'post', 
                success:  function (response) { 
                    console.log(response);
                        $(location).attr('href','mostrar-participante');
                }
        });

 };

 var ModicarProfesor = function(cedula){
    var parametros = {
                "cedula1" : cedula,
        };

        $.ajax({
                data: parametros,
                url:   'controlador/profesor-control.php?x=2', 
                type:  'post', 
                success:  function (response) { 
                    console.log(response);
                        $(location).attr('href','mostrar-profesor');
                }
        });

 }