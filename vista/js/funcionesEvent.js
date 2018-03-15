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
                        events_source: '<?=$base_url?>modelo/obtener_eventos.php', 

                        // mostramos el calendario en el mes
                        view: 'month',             

                        // y dia actual
                        day: yyyy+"-"+mm+"-"+dd,   


                        // definimos el idioma por defecto
                        language: 'es-ES', 

                        //Template de nuestro calendario
                        tmpl_path: '<?=$base_url?>vista/tmpls/', 
                        tmpl_cache: false,


                        // Hora de inicio
                        time_start: '08:00', 

                        // y Hora final de cada dia
                        time_end: '22:00',   

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
                                                .html('<a href="' + val.url + '">' + val.class + '</a>')
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
                language: 'es',
                minDate: new Date()
            });
            $('#to').datetimepicker({
                language: 'es',
                minDate: new Date()
            });

        });