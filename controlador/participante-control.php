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
		$crear = $obj_registrar->RegistrarParticipante($cedula,$nombre,$apellido,$edad,$sexo,$carrera,$correo,$telefono,$descripcion_part,$id_disciplina,$status);


		if ($crear) {

			echo "el usuario ha sido registrado";
			
		}else {
			echo "Error al cargar";
		}

	break;

//FUNCION 
	case 2: 
			

	break;

	
	}

?>