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
	$cedula=$_POST['cedula1'];

	$obj_buscar = new participante();
	$buscarParticipante = $obj_buscar->verificarParticipante($cedula);
	$validar = pg_fetch_array($buscarParticipante);
	if ($validar) {
		

			session_start();
			$_SESSION['cedula']= $cedula;

			echo $cedula;
	
	}	

	break;

	case 3: 
		$datos = new stdClass();
		session_start();
		$cedula= $_SESSION['cedula'];

		$obj_mostrar = new participante();
		$mostrarParticipante = $obj_mostrar->MostrarParticipante($cedula);
		$datos = pg_fetch_object($mostrarParticipante);
	  echo json_encode($datos);

	break;
	case 4: 


		$id= $_POST["id"];
		$cedula = $_POST["cedula"];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$select2 = $_POST['select2'];
		$edad = $_POST['edad'];
		$sexo = $_POST['sexo'];
		$carrera = $_POST['carrera'];
		$id_disciplina = $_POST['id_disciplina2'];
		$correo = $_POST['correo'];
		$telefono = $_POST['telefono'];
		$descripcion_part = $_POST['descripcion_part'];
		$status = $_POST['status'];


		$obj_modificar = new participante();
		$modificar= $obj_modificar->ModificarParticipante($id, $cedula,$nombre,$apellido,$edad,$sexo,$carrera,$correo,$telefono,$descripcion_part,$id_disciplina,$status);


		if ($modificar) {
			session_start();
			$_SESSION['cedula']=$cedula;
			echo "ok";
		}
		else{
			echo "error";
		}
		

	break;

	case 5: 
	$obj_participantes = new participante();
	$todos = $obj_participantes->MostrarTodos();
	if (!$todos) {
		die("error");
	}
	else{
		while ($data = pg_fetch_assoc($todos)) {
			$array["data"][]= $data;
		};
		echo json_encode($array);
	}


	break;
	case 6:
	$id=$_POST['id'];
	$obj_eliminar = new participante();
	$eliminar = $obj_eliminar->EliminarParticipante($id);

	if ($eliminar) {
		echo "ok";
	}
	else{
		echo "error";
	}

	break;

	case 7:
		session_start();
		$id_disciplina = $_SESSION['id_disciplina'];

		$obj_participantes = new participante();
		$todos = $obj_participantes->ParticipanteDisciplina($id_disciplina);
		if (!$todos) {
			die("error");
		}
		else{

			while ($data = pg_fetch_assoc($todos)) {
				echo "<tr><td>" . $data['cedula'].  "</td><td>" . $data['nombre']. "</td><td>" . $data['apellido']."</td><td>" . $data['carrera']. "</td></tr>";
			};
			
		}

		

	break;
	

	}

?>