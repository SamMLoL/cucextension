<?php
require_once('../modelo/funciones-usuario.php');


$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
//fuincion SESION
	case 1:  
		@$id = $_POST['usuario'];
		@$clave = $_POST['clave'];

		$obj_usuario = new usuario();

		$login =  $obj_usuario->iniciarSession($id,$clave);

		if ($login){

			$obj_conex = new conexion();
			$obj_conex->conectar();

			$query = pg_query("SELECT * FROM usuario WHERE id='$id'");

			$row = pg_fetch_assoc($query);

			session_start();
			$_SESSION['id']= $row['id'];
			$_SESSION['estado'] = 'Autentificado';
			header("Location:index.php");
		}else{

			echo "<div class='col-sm-12'><center><font color='red' size='4'><strong>Contraseña o Usuario Incorrecto</strong></font></center></div>";

			require_once("../vista/inicio.html");
		 }

	break;
//funcion Registrar
	case 2: 
			@$id = $_POST["usuario"];
			@$correo = $_POST['correo'];
			@$clave = $_POST['clave'];
			@$clave_admin = $_POST['clave-admin'];
			@$clave_ver = $_POST['confir-clave'];

			if ($clave_admin=="extension123") {

				if ($clave_ver==$clave) {

					$obj_registrar= new usuario();
					$crear = $obj_registrar->RegistrarUsuario($id, $correo, $clave);

					if ($crear) {

						echo "<div class='col-sm-12'><center><font color='limegreen' size='4'><strong>Usuario Registrado</strong></font></center></div>";

								require_once("../vista/inicio.html");

						}
						else {
								echo "<div class='col-sm-12'><center><font color='red' size='4'><strong>No se logro registrar el usuario</strong></font></center></div>";

								require_once("../vista/inicio.html");
				 		}
					}
					else
						{
							echo "<div class='col-sm-12'><center><font color='red' size='4'><strong>Las contraseñas no coinciden</strong></font></center></div>";

								require_once("../vista/inicio.html");
						}
				}
					
					else{

						echo "<div class='col-sm-12'><center><font color='red' size='4'><strong>No se logro registrar el usuario <br> verique la contraseña de administrador</strong></font></center></div>";

						require_once("../vista/inicio.html");
						}

	break;

	default: 
		$html = file_get_contents('../vista/inicio.html');
		echo $html; 
	
	}

?>