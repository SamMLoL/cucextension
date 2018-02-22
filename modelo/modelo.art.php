<?php 

require_once ('../controlador/index.php');
	
	class artista{

	private $cedula;
	private $nombre;
	private $apellido;
	private $edad;
	private $sexo;
	private $correo;
	private $telefono;
	private $descripcion_art;
	private $id_disciplina;
	private $disciplina;
	private $id;
	private $nombre_agru;
	private $id_agrupacion;
	private $status;
	    
	public  function artista()
	{
		$this->cedula="";
		$this->nombre="";
		$this->apellido="";
		$this->edad="";
		$this->sexo="";
		$this->correo="";
		$this->telefono="";
		$this->descripcion_art="";
		$this->id_disciplina="";
		$this->disciplina="";
		$this->id="";
		$this->nombre_agru="";
		$this->id_agrupacion="";
		$this->status="";

	}

}
?>