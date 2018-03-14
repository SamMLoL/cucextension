        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        var cedula = getParameterByName('cedula');
        
        function mostrar(){


        $.ajax({

            type: "POST",
            url: "../controlador/participante-control.php?x=3&cedula="+cedula,
            dataType: 'json',
            data:{id:$('#cambiar').val()}

        }).done(function(respuesta){

            $('#id').val(respuesta.id);
            $('#cedula').val(respuesta.cedula);
            $('#nombre').val(respuesta.nombre);
            $('#apellido').val(respuesta.apellido);
            $('#edad').val(respuesta.edad);
            $('#sexo').val(respuesta.sexo);
            $('#correo').val(respuesta.correo);
            $('#carrera').val(respuesta.carrera);
            $('#telefono').val(respuesta.telefono);
            $('#descripcion_part').val(respuesta.descripcion_part);
            $('#id_disciplina').val(respuesta.id_disciplina);
            $('#status').val(respuesta.status);

        }); 
    }

    $(document).ready(function(){

        $("#formuModificar").validate({
                rules: {
                    cedula: { required: true, digits: true, minlength: 7, maxlength: 9},
                    nombre:  { required: true, minlength: 4, maxlength: 25},
                    apellido: { required: true, minlength: 4, maxlength: 25},
                    edad: { required: true, digits: true, maxlength:2},
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
                        url:"../controlador/participante-control.php?x=4",
                        data: $("#formuModificar").serialize(),
                        beforeSend:function(){
                            $('#guardar').val('Conectando...');
                        },
                        success: function(data){
                          $('#guardar').val('Guardar');

                            if (data == "error") {

                                $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se logro registrar el participante, la cedula puede estar ya registrada</div>");
                            }
                            else {                         
                               $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Registrado!</strong> la nueva disciplina ha sido ha registrada exitosamente.</div>");
                           }
                        }
                    });

                    return false
                }
            });




    })


