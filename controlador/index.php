<?php

$x=0;

session_start();

if(!isset($_SESSION['id'])) {

	$x=100;

} else {
	$estado = $_SESSION['id'];
	$nav = file_get_contents('../vista/nav.html');
	echo $nav; 

	if(array_key_exists('x', $_GET)){
		$x = $_GET['x'];
	} 
}





switch ($x){

	case 100:

	$html = file_get_contents('../vista/inicio.html');
	echo $html; 
	$eventos = file_get_contents('../vista/evento.html');
		echo $eventos; 

//funciones de PARTICIPANTES 
	break;
	case 1:  
		$html = file_get_contents('../vista/v2.html');
		echo $html; 
	break;
	case 2: 
		$html = file_get_contents('../vista/agregar-part.html');
		echo $html; 
	break;
	case 3: 
		$html = file_get_contents('../vista/consultar-part.html');
		echo $html; 
	break;
	case 4: 
		$html = file_get_contents('../vista/mostrar-part.html');
		echo $html; 
	break;
	case 5:
		$html = file_get_contents('../vista/listaparticipantes.html');
		echo $html; 
	break;

	
// Funciones de Eventos
	case 6: 

		$html = file_get_contents('../vista/evento.html');
		echo $html; 

	break;

	case 10: 
		$html = file_get_contents('../vista/agregarPro.html');
		echo $html; 
	break;
	case 11: 
		$html = file_get_contents('../vista/ConsultarPro.html');
		echo $html; 
	break;

	default: 
		$html = file_get_contents('../vista/v1.html');
		echo $html; 

	}
	
?>
