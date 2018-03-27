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
            
    $id  = evaluar($_GET['id']);

    $obj_evento = new objetos();
    $evento = $obj_evento->ConsultaEventos($id);

    $row = pg_fetch_assoc($evento);


    $titulo=$row['title'];
    $evento=$row['body'];
    $inicio=$row['inicio_normal'];
    $final=$row['final_normal'];
    $disciplina=$row['descripcion'];

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
        <link rel=\"stylesheet\" type=\"text/css\" href=\"../vista/css/bootstrap.min.css\">
        <script src=\"../vista/js/bootstrap.min.js\"></script>
         <h3>".$titulo."</h3>
         <hr>
         <b>Fecha inicio:</b> ".$inicio."
         <b>Fecha termino:</b> ".$final."
         <b>Descripcion: </b><p>".$evento."</p>
        <b>tipo de evento:</b> ".$tipo."
        <br><b>Disciplina:</b> ".$disciplina;  

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

        $evento= $_POST['keyword'];

        $obj_evento = new objetos();
        $resultado = $obj_evento->AutocompeteEventos($evento);


        while ($row=pg_fetch_assoc($resultado)) {
            
            $datos[] = $row;

        }
        if(!empty($datos)) {
        ?>
        <ul id="country-list">
        <?php
        foreach($datos as $country) {
        ?>
        <li onClick="selectCountry('<?php echo $country["title"]; ?>');"><?php echo $country["title"]; ?></li>
        <?php } ?>
        </ul>
        <?php } 

    break;

    case 8:
        
        $title = $_POST['nombre-evento'];

        $sql = "DELETE FROM evento WHERE title = '$title';";
        $conexion = new Conexion();
        $conexion->conectar();
        if ($obj_conex=pg_query($sql)) 
        {
            echo "Evento eliminado";
        }
        else
        {
            echo "El evento no se pudo eliminar";
        }
         


    break;


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

