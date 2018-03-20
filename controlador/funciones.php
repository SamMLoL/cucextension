<?php
require_once('../modelo/model-funciones.php');
date_default_timezone_set("America/Caracas");

$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
//funcion SELECT DE DISCIPLINA
	case 1:  
    $obj_buscar = new objetos();
	    $all= $obj_buscar->selectdis();
	    echo '<option disabled value="0" selected>Seleccionar</option>';
	    while ( $row = pg_fetch_assoc($all) )    
	        {

	            echo '<option value="'.$row['id_disciplina'].'">'.$row['descripcion'].'</option>';

	        }

	break;

//FUNCION AGREGAR DISCIPLINA
	case 2: 

			$descripcion = $_POST["nombre"];
			$obj_registrar = new objetos();
            $validarDisciplina = $obj_registrar->verificarDisciplina($descripcion);
            $validar = pg_fetch_array($validarDisciplina);

                if($validar==0){

                	$crear = $obj_registrar->RegistrarDisciplina($descripcion);

					if ($crear) {
						echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Registrado!</strong> la nueva disciplina ha sido ha registrada exitosamente.</div>";
					}
					else {
						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se pudo registrar la disciplina, verifique que no este ya registrada.</div>";
					}
			}
			else{
				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se pudo registrar la disciplina, verifique que no este ya registrada.</div>";

			}
			
	break;

//FUNCION Eliminar DISCIPLINA
	case 3:
			$id_disciplina = $_POST["id_disciplina"];
			$obj_eliminar = new objetos();
        	$eliminar = $obj_eliminar->EliminarDisciplina($id_disciplina);

			if ($eliminar) {
				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Eliminado!</strong> la disciplina ha sido ha eliminada exitosamente.</div>";
			}
			else {
				echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se pudo eliminar la disciplina, la disciplina puede tener registros que no se pueden borrar</div>";
			}


	break;
	//FUNCIONES EVENTOS
	case 4:

        if ($_POST['from']!="" AND $_POST['to']!="") 
        {
$Datein                    = date('d/m/Y H:i:s', strtotime($_POST['from']));
$Datefi                    = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $inicio = _formatear($Datein);
        // y la formateamos con la funcion _formatear

        $final  = _formatear($Datefi);

        // Recibimos el fecha de inicio y la fecha final desde el form
        $orderDate                      = date('d/m/Y H:i:s', strtotime($_POST['from']));
        $inicio_normal = $orderDate;

        // y la formateamos con la funcion _formatear
        $orderDate2                      = date('d/m/Y H:i:s', strtotime($_POST['to']));
        $final_normal  = $orderDate2;

            $titulo = evaluar($_POST['title']);

            $contenido  = evaluar($_POST['event']);
            $id_disciplina  = evaluar($_POST['id_disciplina']);
            $clase  = evaluar($_POST['class']);




            $obj_evento = new objetos();
            $evento = $obj_evento->AgregarEvento($titulo,$contenido,$clase,$inicio,$final,$id_disciplina,$inicio_normal,$final_normal);


            if ($evento) {
                echo "ok";

            }
            else {
                echo "error";
            }
        }
        else{
            echo "error";
        }

	break;
    case 5:
            
    // Obtenemos el id del evento
    $id  = evaluar($_GET['id']);

    // y lo buscamos en la base de dato
        $obj_conex = new conexion();
        $obj_conex->conectar();
    $bd  = pg_query("SELECT * FROM evento WHERE id=$id");

    // Obtenemos los datos
    $row = pg_fetch_assoc($bd);

    // titulo 
    $titulo=$row['title'];

    // cuerpo
    $evento=$row['body'];

    // Fecha inicio
    $inicio=$row['inicio_normal'];

    // Fecha Termino
    $final=$row['final_normal'];

    $class=$row['class'];

        switch ($class) {
        case "event-info     ":
            $tipo="Informativo";
        break;
        case "event-success  ":
            $tipo="Deportivo";
        break;
        case "event-important":
            $tipo="Artistico";
        break;
        case "event-warning  ":
            $tipo="Cultural";
        break;
        case "event-special  ":
            $tipo="Especial";
        break;

}

    echo "
         <h3>".$titulo."</h3>
         <hr>
         <b>Fecha inicio:</b> ".$inicio."
         <b>Fecha termino:</b> ".$final."
        <p>".$evento."</p>
        <b>tipo de evento:</b> ".$tipo;  

    break;
	
    case 6:
    
        $sql="SELECT * FROM evento"; 

        $conexion = new Conexion();
        $conexion->conectar();
        // Verificamos si existe un dato
        if ($conexion=pg_query($sql))
        { 

            // creamos un array
            $datos = array(); 

            //guardamos en un array multidimensional todos los datos de la consulta
            $i=0; 

            // Ejecutamos nuestra sentencia sql
            $e = $conexion=pg_query($sql); 

            while($row=pg_fetch_array($e)) // realizamos un ciclo while para traer los agenda encontrados en la base de dato
            {
                $datos[$i] = $row; 
                $i++;
            }

            // Transformamos los datos encontrado en la BD al formato JSON
                echo json_encode(
                        array(
                            "success" => 1,
                            "result" => $datos
                        )
                    );

            }
            else
            {
                // Si no existen agenda mostramos este mensaje.
                echo "No hay datos"; 
            }

    break;
	}


function evaluar($valor) 
{
    $nopermitido = array("'",'\\','<','>',"\"");
    $valor = str_replace($nopermitido, "", $valor);
    return $valor;
}

// Formatear una fecha a microtime para añadir al evento, tipo 1401517498985.
function _formatear($fecha)
{
    return strtotime(substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2)." " .substr($fecha, 10, 6)) * 1000;
}



?>

