<?php
require_once('../modelo/model-funciones.php');


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

	
	}

?>

