<?php

if (isset($_REQUEST['Inicio'])){
	$x = 1;
}

if (isset($_REQUEST['participantes'])){
	$x = 2;
}

if (isset($_REQUEST['profesores'])){
	$x = 3;
}

if (isset($_REQUEST['agregarpart'])){
	$x = 4;
}

if (isset($_REQUEST['consultarpart'])){
	$x = 5;
}

if (isset($_REQUEST['registrar.prof'])){
	$x = 6;
}

if (isset($_REQUEST['consultar.prof'])){
	$x =7;
}


?>