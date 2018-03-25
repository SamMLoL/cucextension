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
            url: "controlador/participante-control.php?x=3",
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
                        url:"controlador/participante-control.php?x=4",
                        data: $("#formuModificar").serialize(),
                        beforeSend:function(){
                            $('#guardar').val('Conectando...');
                        },
                        success: function(data){
                          $('#guardar').val('Guardar');

                            if (data == "error") {

                                $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se lograron guardar los datos del participante, verifique los datos ingresados.</div>");
                            }
                            else {                         
                               $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Registrado!</strong> Los nuevos datos de participante han sido guardado con exito.</div>");
                           }
                        }
                    });

                    return false
                }
            });



    })


//FUNCIONES LISTA
$(document).ready( function () {
    lista();
});
var status_simple = function ( data ) {
    if (data=='t') {
    return 'Activo';
    }
    else{
        return 'Inactivo'
    }
}
var lista = function(){
    var table = $("#todosParticipantes").DataTable({
        "destroy":true,
        "ajax":{
            "method": "POST",
            "url": "controlador/participante-control.php?x=5"
        },
        "columns":[
            {"data":"id"},
            {"data":"cedula"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"edad"},
            {"data":"sexo"},
            {"data":"carrera"},
            {"data":"correo"},
            {"data":"telefono"},
            {"data":"descripcion_part"},
            {"data":"descripcion"},
            {"data":"status", "render": status_simple},
            {"defaultContent": "<button type='button' title='Editar participante' class='editar btn btn-primary'><i class='glyphicon glyphicon-edit'></i></button>  <button type='button' title='eliminar participante'  class='eliminar btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button>"},
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
        ],

        "language": cambiarcontenido

    });
    data_editar("#todosParticipantes tbody", table);
    data_eliminar("#todosParticipantes tbody", table);
}
    var data_editar = function(tbody, table){
        $(tbody).on("click", "button.editar", function(){
            var data = table.row( $(this).parents("tr") ).data();
            var cedula = data.cedula;
            var nombre = data.nombre;
            var apellido = data.apellido;
             var bool=confirm("Seguro quieres editar el participante: "+nombre+" "+apellido+"?");
            if(bool){
                ModicarParti(cedula);
            }
            
        
        });
    }
        var data_eliminar = function(tbody, table){
            $(tbody).on("click", "button.eliminar", function(){
                var data = table.row( $(this).parents("tr") ).data();
                var id = data.id;
                var nombre = data.nombre;
                var apellido = data.apellido;
                 var bool=confirm("Seguro quieres eliminar el participante: "+nombre+" "+apellido+"?");
                if(bool){
                    eliminarParti(id);
                    lista();

                }
            
            });
        }

    var cambiarcontenido = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar: _MENU_ participantes",
        "sZeroRecords":    "No se encontraron participantes registrados",
        "sEmptyTable":     "Ningún participante disponible",
        "sInfo":           "Participantes del _START_ al _END_ de un total de _TOTAL_ participantes",
        "sInfoEmpty":      "Participantes del 0 al 0 de un total de 0 participantes",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ participante)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }

    var eliminarParti = function(id){
                var parametros = {
                "id" : id,
        };
        $.ajax({
            data: parametros,
            type: "POST",
            url: "controlador/participante-control.php?x=6",
            
            success: function(response){

                if (response=="error") {
                    alert("No se pudo eliminar el participante");
                }
                else{
                    alert("El participante ha sido eliminado con exito");
                }
            }
        });

    };
