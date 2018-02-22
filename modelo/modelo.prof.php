<?php 

require_once('../controlador/index.php');

	class profesor{

	private $cedula;
	private $nombre;
	private $apellido;
	private $edad;
	private $sexo;
	private $telefono;
	private $id_disciplina;
	private $disciplina;
	private $id;
	private $status;
	    
	public  function profesor()
	{
		$this->cedula="";
		$this->nombre="";
		$this->apellido="";
		$this->edad="";
		$this->sexo="";
		$this->telefono="";
		$this->id_disciplina="";
		$this->disciplina="";
		$this->id="";
		$this->status="";

	}

}

?>