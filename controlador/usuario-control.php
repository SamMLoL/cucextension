<?php
require_once('../modelo/funciones-usuario.php');

$claveadministrador="extension123";
$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
//fuincion SESION
	case 1:  
		@$id = $_POST['usuariologin'];
		@$clave = $_POST['clavelogin'];

		$obj_usuario = new usuario();

		$login =  $obj_usuario->iniciarSession($id,$clave);

		if ($login){

			$obj_conex = new conexion();
			$obj_conex->conectar();

			$query = pg_query("SELECT * FROM usuario WHERE id='$id'");

			$row = pg_fetch_assoc($query);

			session_start();
			$_SESSION['id']= $row['id'];
			$_SESSION['status'] = 'Autentificado';
			echo "ok";
		}else{

			echo "error";
		 }

	break;
//funcion Registrar
	case 2: 
			$id = $_POST["usuario"];
			$correo = $_POST['correo'];
			$clave = $_POST['clave'];
			$clave_admin = $_POST['claveadmin'];
			$clave_ver = $_POST['confirclave'];

			if ($clave_admin==$claveadministrador) {

				if ($clave_ver==$clave) {

					$obj_registrar= new usuario();
					$crear = $obj_registrar->RegistrarUsuario($id, $correo, $clave);

					if ($crear) {

						echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Registrado!</strong> El usuario ha sido ha registrado exitosamente.</div>";

						}
						else {
								echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> No se logro registrar el usuario.</div>";
				 		}
					}
					else
						{
							echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> las contraseñas no coinciden</div>";
						}
				}
					
					else{

						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Contraseña de administrador incorrecta</div>";
						}

	break;

	case 3: 

			$id = $_POST["usuario"];


			if (!empty($id)) {

					$obj_consulta= new usuario();
					$consultar = $obj_consulta->consultarUsuario($id);

			if($consultar == 0){
                  echo "<span style='font-weight:bold;color:green;'>Disponible</span>";
            }else{
                  echo "<span style='font-weight:bold;color:red;'>El nombre de usuario ya existe.</span>";
            }

				}
					

	break;
	case 4: 
			session_start();

			unset($_SESSION);

			session_destroy();

			header("Location: ../inicio");
			die();
					

	break;
	case 5:

		session_start();

		$status = $_SESSION['status'];

		echo $status;


	break;
	case 6:
		$id = $_POST["usuario"];
		$correo = $_POST['correo'];
		$clave_admin = $_POST['claveadmin'];

		if ($clave_admin==$claveadministrador) {

			$obj_recuperar= new usuario();
			$crear = $obj_recuperar->Recuperar($id, $correo);

			if ($crear) {
				$row = pg_fetch_assoc($crear);
				echo "<div class='alert alert-dismissible alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Se ha recuperado la contraseña con exito</strong> <div><br><p align='center'>La contraseña del usuario <b> ".$row['id']." </b>es<b> ".$row['clave']."</b></p></div></div>";

				}
			else {
						echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Usuario o correo incorrectos.</div>";
		 	}
		}
		else{

			echo "<div class='alert alert-dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Error!</strong> Contraseña de administrador incorrecta</div>";
		}

	break;

	default: 
	header("Location: ../inicio");
	
	}

?>