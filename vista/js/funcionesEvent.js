(function($){
                //creamos la fecha actual
                var date = new Date();
                var yyyy = date.getFullYear().toString();
                var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
                var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

                //establecemos los valores del calendario
                var options = {

                    // definimos que los eventos se mostraran en ventana modal
                        modal: '#events-modal', 

                        // dentro de un iframe
                        modal_type:'iframe',    

                        //obtenemos los eventos de la base de datos
                        events_source: 'controlador/funciones.php?x=6', 

                        // mostramos el calendario en el mes
                        view: 'month',             

                        // y dia actual
                        day: yyyy+"-"+mm+"-"+dd,   


                        // definimos el idioma por defecto
                        language: 'es-ES', 

                        //Template de nuestro calendario
                        tmpl_path: 'vista/tmpls/', 
                        tmpl_cache: false,


                        // Hora de inicio
                        time_start: '00:00', 

                        // y Hora final de cada dia
                        time_end: '23:00',   

                        // intervalo de tiempo entre las hora, en este caso son 30 minutos
                        time_split: '30',    

                        // Definimos un ancho del 100% a nuestro calendario
                        width: '100%', 

                        onAfterEventsLoad: function(events)
                        {
                                if(!events)
                                {
                                        return;
                                }
                                var list = $('#eventlist');
                                list.html('');

                                $.each(events, function(key, val)
                                {
                                        $(document.createElement('li'))
                                                .html('<a href="' + val.url + '">' + val.title + '</a>')
                                                .appendTo(list);
                                });
                        },
                        onAfterViewLoad: function(view)
                        {
                                $('.page-header h2').text(this.getTitle());
                                $('.btn-group button').removeClass('active');
                                $('button[data-calendar-view="' + view + '"]').addClass('active');
                        },
                        classes: {
                                months: {
                                        general: 'label'
                                }
                        }
                };


                // id del div donde se mostrara el calendario
                var calendar = $('#calendar').calendar(options); 

                $('.btn-group button[data-calendar-nav]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.navigate($this.data('calendar-nav'));
                        });
                });

                $('.btn-group button[data-calendar-view]').each(function()
                {
                        var $this = $(this);
                        $this.click(function()
                        {
                                calendar.view($this.data('calendar-view'));
                        });
                });

                $('#first_day').change(function()
                {
                        var value = $(this).val();
                        value = value.length ? parseInt(value) : null;
                        calendar.setOptions({first_day: value});
                        calendar.view();
                });
        }(jQuery));


        $(function () {

            $('#from').datetimepicker({
                format: 'MM/DD/YYYY HH:mm:ss',
                minDate: new Date()
            });
            $('#to').datetimepicker({
                format: 'MM/DD/YYYY HH:mm:ss',
                useCurrent: false 
            });
            $("#from").on("dp.change", function (e) {
                $('#to').data("DateTimePicker").minDate(e.date);
            });
            $("#to").on("dp.change", function (e) {
                $('#from').data("DateTimePicker").maxDate(e.date);
            });
        });

        

        var autenficar = function(){
            $.ajax({
                type: "POST",
                url: "controlador/usuario-control.php?x=5",
                
                success: function(response){

                    if (response=="Autentificado") {
                        mostrarboton();
                    }
                    else{
                        return false
                    }
                }
            });
        };


        
        function mostrarboton(){
    
                $("#boton").html("<div class='pull-right form-inline'><button class='btn btn-info' data-toggle='modal'style=\"width:150px; height:35px;\" data-target='#add_evento'>Añadir Evento</button><br><br><button class='btn btn-danger' style=\"width:150px; height:35px;\" data-toggle='modal' data-target='#EliminarEvento'>Eliminar Evento</button></div>");
         

        };

        


$(document).ready(function(){
    autenficar();

        $("#formuEventos").validate({
                rules: {
                    from: { required: true},
                    to:  { required: true},
                    class: { required: true},
                    title: { required: true, minlength: 4, maxlength: 100},
                    id_disciplina: {required: true},
                    event: { required: true, minlength: 4, maxlength: 100}

                },
                messages: {
                    from: "Debe instroducir una fecha valida",
                    to: "Debe instroducir una fecha valida",
                    class: "Debe selecciona un tipo de evento",
                    title: "Debe introducir un titulo valido.",
                    id_disciplina: "Debe seleccionar una disciplina",
                    event:{required: 'Debe introducir una descripcion.', minlength: 'El mínimo permitido son 4 caracteres.', maxlength: 'El máximo permitido son 100 caracteres.'},

                },
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url:"controlador/funciones.php?x=4",
                        data: $("#formuEventos").serialize(),
                        success: function(data){
                            console.log(data);
                            if (data = 'ok') {
                                alert("El evento ha sido agregado con exito");
                                $(location).attr('href','eventos');
                            } 
                            else {    
                                $("#resEvento").html("<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se logro registrar el evento, verifique los datos ingresados.</div>");
                                                 
                            }
                        }
                    });

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





    $("#nombre-evento").keyup(function(){
        $.ajax({
        type: "POST",
        url: "controlador/funciones.php?x=7",
        data:'keyword='+$(this).val(),
        beforeSend: function(){
            $("#nombre-evento").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
        },
        success: function(data){
            $("#suggesstion-box").show();
            $("#suggesstion-box").html(data);
            $("#nombre-evento").css("background","#FFF");
        }
        });
    });
});

function selectCountry(val) {
$("#nombre-evento").val(val);
$("#suggesstion-box").hide();
}

