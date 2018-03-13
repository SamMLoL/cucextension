    $(document).ready(function() {
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }

        var cedula = getParameterByName('cedula');
        $.ajax({

            type: "GET",
            url: "../controlador/participante-control.php?x=3&cedula="+cedula,
            dataType: 'json',
            data:{id:$('#cambiar').val()}

        }).done(function(respuesta){

            $('#cedula').val(respuesta.cedula);
            $('#nombre').val(respuesta.nombre);
            $('#apellido').val(respuesta.apellido);
            $('#edad').val(respuesta.edad);
            $('#sexo').val(respuesta.sexo);
            $('#correo').val(respuesta.correo);
            $('#carrera').val(respuesta.carrera);
            $('#telefono').val(respuesta.telefono);
            $('#descripcion_part').val(respuesta.descripcion_part);
        });
    });
