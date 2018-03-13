<?php
require_once('../modelo/model-participantes.php');


$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
//FUNCION
	case 1:
		$cedula = $_POST["cedula"];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$edad = $_POST['edad'];
		$sexo = $_POST['sexo'];
		$carrera = $_POST['carrera'];
		$id_disciplina = $_POST['id_disciplina'];
		$correo = $_POST['correo'];
		$telefono = $_POST['telefono'];
		$descripcion_part = $_POST['descripcion_part'];
		$status = $_POST['status'];

		$obj_registrar = new participante();
		$validarParticipante = $obj_registrar->verificarParticipante($cedula);
		$validar = pg_fetch_array($validarParticipante);

		if ($validar==0) {

			$crear = $obj_registrar->RegistrarParticipante($cedula,$nombre,$apellido,$edad,$sexo,$carrera,$correo,$telefono,$descripcion_part,$id_disciplina,$status);


			if ($crear) {

				echo $cedula;

			
			}else {
				echo "error";				
			}
		}
		else {
			echo "error";
		}
		
	break;

//FUNCION MODIFICAR/ BUSCAR
	case 2: 
 	$cedula = $_GET['cedula1'];
	echo $cedula;

	break;

	case 3: 
		$datos = new stdClass();
		$cedula= $_GET['cedula'];

		$obj_mostrar = new participante();
		$mostrarParticipante = $obj_mostrar->MostrarParticipante($cedula);
		$datos = pg_fetch_object($mostrarParticipante);

	  echo json_encode($datos);
	break;

	
	}

?>