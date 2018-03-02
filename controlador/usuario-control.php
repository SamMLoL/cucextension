<?php
require_once('../modelo/funciones-usuario.php');


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
			$_SESSION['estado'] = 'Autentificado';
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

			if ($clave_admin=="extension123") {

				if ($clave_ver==$clave) {

					$obj_registrar= new usuario();
					$crear = $obj_registrar->RegistrarUsuario($id, $correo, $clave);

					if ($crear) {

						echo "<center><font color='green'>Usuario Registrado<font><center>";

						}
						else {
								echo "<center><font color='red'>No se logro registrar el usuario<font><center>";
				 		}
					}
					else
						{
							echo "<center><font color='red'>Las contraseñas no coinciden<font><center>";
						}
				}
					
					else{

						echo "<center><font color='red'>Contraseña de administrador incorrecta<font><center>";
						}

	break;

	default: 
		$html = file_get_contents('../vista/inicio.html');
		echo $html; 
	
	}

?>