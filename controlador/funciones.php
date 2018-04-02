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
    $unidad=htmlspecialchars(urldecode(($_GET['unidad'])));

    $obj_buscar = new objetos();
	    $all= $obj_buscar->selectdis($unidad);
	    echo '<option disabled value="0" selected>Seleccionar</option>';
	    while ( $row = pg_fetch_assoc($all) )    
	        {

	            echo '<option value="'.$row['id_disciplina'].'">'.$row['descripcion'].'</option>';

	        }

	break;

//FUNCION AGREGAR DISCIPLINA
	case 2: 

			$descripcion = $_POST["nombre"];
            $unidad = $_POST["unidad"];
			$obj_registrar = new objetos();
            $validarDisciplina = $obj_registrar->verificarDisciplina($descripcion);
            $validar = pg_fetch_array($validarDisciplina);

                if($validar==0){

                	$crear = $obj_registrar->RegistrarDisciplina($descripcion, $unidad);

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
			$id_disciplina = $_POST["id_disciplina2"];
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
            $Datein = date('d/m/Y H:i:s', strtotime($_POST['from']));
            $Datefi = date('d/m/Y H:i:s', strtotime($_POST['to']));
            $inicio = _formatear($Datein);

            $final  = _formatear($Datefi);


            $orderDate = date('d/m/Y H:i:s', strtotime($_POST['from']));
            $inicio_normal = $orderDate;


            $orderDate2 = date('d/m/Y H:i:s', strtotime($_POST['to']));
            $final_normal  = $orderDate2;

            $titulo = evaluar($_POST['title']);

            $contenido  = evaluar($_POST['event']);
            $id_disciplina  = evaluar($_POST['id_disciplina3']);
            $clase  = evaluar($_POST['class']);

            $obj_evento = new objetos();
            $evento = $obj_evento->AgregarEvento($titulo,$contenido,$clase,$inicio,$final,$id_disciplina,$inicio_normal,$final_normal);


            if ($evento) {
                echo "1";
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
            
    $id  = evaluar($_GET['id']);

    $obj_evento = new objetos();
    $evento = $obj_evento->ConsultaEventos($id);

    $row = pg_fetch_assoc($evento);

    $id=$row['id'];
    $titulo=$row['title'];
    $evento=$row['body'];
    $inicio=$row['inicio_normal'];
    $final=$row['final_normal'];
    $disciplina=$row['descripcion'];
    $id_disciplina=$row['id_disciplina'];

    $class=$row['class'];

        switch ($class) {
        case "event-info":
            $tipo="Informativo";
        break;
        case "event-success":
            $tipo="Deportivo";
        break;
        case "event-important":
            $tipo="Artistico";
        break;
        case "event-warning":
            $tipo="Cultural";
        break;
        case "event-special":
            $tipo="Especial";
        break;

    }

    echo "
         <h3>".$titulo."</h3>
         <hr>
         <b>Fecha inicio:</b> ".$inicio."
         <b>Fecha termino:</b> ".$final."
         <b>Descripcion: </b><p>".$evento."</p>
        <b>tipo de evento:</b> ".$tipo."
        <br><b>Disciplina:</b> ".$disciplina;

        session_start();
        $_SESSION['id_disciplina']= $id_disciplina;

    break;
	
    case 6:
    
        $sql="SELECT * FROM evento"; 

        $conexion = new Conexion();
        $conexion->conectar();
        if ($conexion=pg_query($sql))
        { 

            $datos = array(); 

            $i=0; 

            $e = $conexion=pg_query($sql); 

            while($row=pg_fetch_array($e))
            {
                $datos[$i] = $row; 
                $i++;
            }

                echo json_encode(
                        array(
                            "success" => 1,
                            "result" => $datos
                        )
                    );

            }
            else
            {
                echo "No hay datos"; 
            }

    break;

    case 7:

        $id_disciplina= htmlspecialchars(urldecode(($_GET['id_disciplina'])));

        $obj_evento = new objetos();
        $resultado = $obj_evento->AutocompeteEventos($id_disciplina);

        echo '<option disabled value="0" selected>Seleccionar</option>';

        while ( $row = pg_fetch_assoc($resultado) )    
            {

                echo '<option value="'.$row['id'].'">'.$row['title'].'</option>';

            }



    break;

    case 8:
        
        $id = $_POST['nombreevento'];

        $obj_evento = new objetos();
        $EliminarEvento = $obj_evento->EliminarEvento($id);


        if ($EliminarEvento) {
            echo "1";
        }
        else {
            echo "error";
        }
     


    break;
    case 8:


	}





function evaluar($valor) 
{
    $nopermitido = array("'",'\\','<','>',"\"");
    $valor = str_replace($nopermitido, "", $valor);
    return $valor;
}

function _formatear($fecha)
{
    return strtotime(substr($fecha, 6, 4)."-".substr($fecha, 3, 2)."-".substr($fecha, 0, 2)." " .substr($fecha, 10, 6)) * 1000;
}



?>

