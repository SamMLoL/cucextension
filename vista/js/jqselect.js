                $(document).ready(function() {
                    
                var disci = function(){

                    $.ajax({
                            type: "POST",
                            url: "../controlador/funciones.php?x=1",
                            success: function(response)
                            {
                                $('#selector-disciplina select').html(response).fadeIn();
                            }
                    });
                
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
 
                });

    $(document).on('click', '#agregarDis', function() {
        $('#ModalAgregarDisciplina').modal('show');
    });

    $(document).on('click', '#eliminarDis', function() {
        $('#ModalEliminarDisciplina').modal('show');
    });