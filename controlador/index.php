<?php

session_start();

if(!isset($_SESSION['id'])) {
	header('Location: ../vista/inicio.html');
} else {
	$estado = $_SESSION['id'];
}

include ('../vista/nav.html');

$x=0;
if(array_key_exists('x', $_GET)){
	$x = $_GET['x'];
}

switch ($x){
//fuinciones de PARTICIPANTES 
	case 1:  
		$html = file_get_contents('../vista/v2.html');
		echo $html; 
	break;
	case 2: 
		$html = file_get_contents('../vista/agregarPar.html');
		echo $html; 
	break;
	case 3: 
	$html = file_get_contents('../vista/ConsultarPar.html');
	echo $html; 
	break;
// Funciones de Profesores
	case 4: 
	$html = file_get_contents('../vista/v3.html');
	echo $html; 
	break;
	case 5: 
	$html = file_get_contents('../vista/agregarPro.html');
	echo $html; 
	break;
	case 6: 
	$html = file_get_contents('../vista/ConsultarPro.html');
	echo $html; 
	break;
	case 7: 
			session_start();

			unset($_SESSION);

			session_destroy();

			header("Location: index.php");
			die();
	break;

	default: 
		$html = file_get_contents('../vista/v1.html');
		echo $html; 
	
	}
	
?>
