         function mostrarProfesor(){
                
            $.ajax({
                async:false, 
                type: "POST",
                url: "controlador/profesor-control.php?x=3",
                dataType: 'json',
                data:{id:$('#cambiar').val()}

            }).done(function(respuesta){
               
                
                $('#id').val(respuesta.id);
                $('#cedula').val(respuesta.cedula);
                $('#nombre').val(respuesta.nombre);
                $('#apellido').val(respuesta.apellido);
                $('#edad').val(respuesta.edad);
                $('#sexo').val(respuesta.sexo);
                $('#telefono').val(respuesta.telefono);
                $('#select2').val(respuesta.unidad);
                $('#status').val(respuesta.status);
                $('#id_disciplina2').val(respuesta.id_disciplina); 


 
            }); 
            
        };

       
    var disciP = function(){

            $.ajax({
                async:false,
                type: "POST",
                url: "controlador/profesor-control.php?x=3",
                dataType: 'json',
                data:{id:$('#unidad').val()}

            }).done(function(respuesta){

                $("#id_disciplina2").load('controlador/funciones.php?x=1&unidad='+respuesta.unidad);

                });  
        };

    $(document).ready(function(){


        $("#select2").change(function(event){
            var unidad = $("#select2").find(':selected').val();
            $("#id_disciplina2").load('controlador/funciones.php?x=1&unidad='+unidad);
         }); 
       


        function haceAlgo(callbackdisciP, callbackmostrarProfesor){
            callbackdisciP();

            callbackmostrarProfesor();
        }

        haceAlgo(disciP, mostrarProfesor);


        mostrarProfesor();    


        $("#ModificarProfesor").validate({
                rules: {
                    cedula: { required: true, digits: true, minlength: 7, maxlength: 9},
                    nombre:  { required: true, minlength: 4, maxlength: 25},
                    apellido: { required: true, minlength: 4, maxlength: 25},
                    edad: { required: true, digits: true, maxlength:2},
                    sexo: { required: true},
                    select2: { required: true},
                    id_disciplina2: { required: true},
                    telefono: { required: true, digits:true, minlength: 4, maxlength: 25},
                    status: { required: true}

                },
                messages: {
                    cedula: "Debe instroducir una cedula valida",
                    nombre: {required: 'Debe introducir un nombre.' , minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    apellido: {required: 'Debe introducir el apellido.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
                    edad: "Debe instroducir una edad valida",
                    sexo: "Debe seleccionar un sexo",
                    select2: "Debe seleccionar una disciplina.",
                    id_disciplina2: "Debe seleccionar una disciplina.",
                    telefono: "Debe introducir un telefono valido.",
                    status: "Debe seleccionar un estatus",

                },
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/profesor-control.php?x=4",
                        data: $("#ModificarProfesor").serialize(),
                        beforeSend:function(){
                            $('#guardar').val('Conectando...');
                        },
                        success: function(data){
                          $('#guardar').val('Guardar');

                            if (data == "ok") {
                                $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Registrado!</strong> Los nuevos datos del profesor han sido guardado con exito.</div>");
        
                             }
                            else {                         
                              
                                $("#RespuestaMostrar").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se lograron guardar los datos del profesor, verifique los datos ingresados.</div>");
                           
                             }
                        }
                    });

                    return false
                }
            });
        lista();
    });

    var status_simple = function ( data ) {
    if (data=='t') {
    return 'Activo';
    }
    else{
        return 'Inactivo'
    };
    }



var lista = function(){
    var table = $("#todosProfesores").DataTable({
        "destroy":true,
        "ajax":{
            "method": "POST",
            "url": "controlador/profesor-control.php?x=5"
        },
        "columns":[
            {"data":"id"},
            {"data":"cedula"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"edad"},
            {"data":"sexo"},
            {"data":"telefono"},
            {"data":"descripcion"},
            {"data":"status", "render": status_simple},
            {"defaultContent": "<button type='button' title='Editar profesor' class='editar btn btn-primary'><i class='glyphicon glyphicon-edit'></i></button>  <button type='button' title='eliminar profesor'  class='eliminar btn btn-danger'><i class='glyphicon glyphicon-trash'></i></button>"},
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
    data_editar("#todosProfesores tbody", table);
    data_eliminar("#todosProfesores tbody", table);
}
    var data_editar = function(tbody, table){
        $(tbody).on("click", "button.editar", function(){
            var data = table.row( $(this).parents("tr") ).data();
            var cedula = data.cedula;
            var nombre = data.nombre;
            var apellido = data.apellido;
             var bool=confirm("Seguro quieres editar el el profesor: "+nombre+" "+apellido+"?");
            if(bool){
                ModicarProfesor(cedula);
            }
            
        
        });
    }
        var data_eliminar = function(tbody, table){
            $(tbody).on("click", "button.eliminar", function(){
                var data = table.row( $(this).parents("tr") ).data();
                var id = data.id;
                var nombre = data.nombre;
                var apellido = data.apellido;
                 var bool=confirm("Seguro quieres eliminar el profesor: "+nombre+" "+apellido+"?");
                if(bool){
                    eliminarProfe(id);
                    lista();

                }
            
            });
        }

    var cambiarcontenido = {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar: _MENU_ profesores",
        "sZeroRecords":    "No se encontraron profesores registrados",
        "sEmptyTable":     "Ningún profesor disponible",
        "sInfo":           "Profesores del _START_ al _END_ de un total de _TOTAL_ profesores",
        "sInfoEmpty":      "Profesores del 0 al 0 de un total de 0 profesores",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ profesores)",
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

    var eliminarProfe = function(id){
                var parametros = {
                "id" : id,
        };
        $.ajax({
            data: parametros,
            type: "POST",
            url: "controlador/profesor-control.php?x=6",
            
            success: function(response){

                if (response=="error") {
                    alert("No se pudo eliminar el profesor");
                }
                else{
                    alert("El profesor ha sido eliminado con exito");
                }
            }
        });

    };
