<?php  
require_once('../modelo/model-profesores.php');


$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
	case 1:
		$cedula = $_POST["cedula"];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$edad = $_POST['edad'];
		$sexo = $_POST['sexo'];
		$id_disciplina = $_POST['id_disciplina'];
		$telefono = $_POST['telefono'];
		$status = $_POST['status'];

		$obj_registrar = new profesor();
		$validarProfesor = $obj_registrar->verificarProfesor($cedula);
		$validar = pg_fetch_array($validarProfesor);

		if ($validar==0) {

			$crear = $obj_registrar->RegistrarProfesor($cedula,$nombre,$apellido,$edad,$sexo,$telefono,$id_disciplina,$status);


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
	case 2:

	$cedula=$_POST['cedula1'];

	$obj_buscar = new profesor();
	$buscarProfesor = $obj_buscar->verificarProfesor($cedula);
	$validar = pg_fetch_array($buscarProfesor);
	if ($validar) {
		

			session_start();
			$_SESSION['cedula1']= $cedula;

			echo $cedula;
	
	}
	break;

	case 3: 
		$datos = new stdClass();
		session_start();
		$cedula= $_SESSION['cedula1'];

		$obj_mostrar = new profesor();
		$mostrarProfesor = $obj_mostrar->MostrarProfesor($cedula);
		$datos = pg_fetch_object($mostrarProfesor);
	  echo json_encode($datos);

	break;
	case 4: 


		$id= $_POST["id"];
		$cedula = $_POST["cedula"];
		$nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$edad = $_POST['edad'];
		$sexo = $_POST['sexo'];
		$id_disciplina = $_POST['id_disciplina2'];
		$telefono = $_POST['telefono'];
		$status = $_POST['status'];


		$obj_modificar = new profesor();
		$modificar= $obj_modificar->ModificarProfesor($id, $cedula,$nombre,$apellido,$edad,$sexo,$telefono,$id_disciplina,$status);


		if ($modificar) {
			session_start();
			$_SESSION['cedula1']=$cedula;
			echo "ok";
		}
		else{
			echo "error";
		}
		

	break;

	case 5: 
	$obj_profesores = new profesor();
	$todos = $obj_profesores->MostrarTodos();
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
	$obj_eliminar = new profesor();
	$eliminar = $obj_eliminar->EliminarProfesor($id);

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

		$obj_profesores = new profesor();
		$todos = $obj_profesores->ProfesoresDisciplina($id_disciplina);
		if (!$todos) {
			die("error");
		}
		else{

			while ($data = pg_fetch_assoc($todos)) {
				echo "<tr><td>" . $data['cedula'].  "</td><td>" . $data['nombre']. "</td><td>" . $data['apellido']."</td></tr>";
			};
			
		}

		

	break;
}
?>