<?php

@$id = $_POST['usuario'];
@$clave = $_POST['clave'];


if ($id == 'usuario' & $clave == '123456'){

	header("Location:../controlador/index.php");
	session_start();
	$_SESSION['id']= $id;

}else{

	echo "<div class='col-sm-7'><center><font color='red' size='4'><strong>Contraseña o Usuario Incorrecto</strong></font></center></div>";

	require_once("../vista/login.html");
 }
?>