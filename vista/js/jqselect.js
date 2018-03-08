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
                nombre: {required: 'Debe introducir un nombre.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 25 caracteres.'},
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
 
                });

    $(document).on('click', '#agregarDis', function() {
        $('#ModalAgregarDisciplina').modal('show');
    });