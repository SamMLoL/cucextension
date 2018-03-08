<?php

require_once('conexion.php');

class participante{

	private $cedula;
	private $nombre;
	private $apellido;
	private $edad;
	private $sexo;
	private $correo;
	private $telefono;
	private $descripcion_part;
	private $id_disciplina;
	private $status;
	    
	public  function participante()
	{
		$this->cedula="";
		$this->nombre="";
		$this->apellido="";
		$this->edad="";
		$this->sexo="";
		$this->correo="";
		$this->telefono="";
		$this->descripcion_part="";
		$this->id_disciplina="";
		$this->status="";

	}
	public function RegistrarParticipante($cedula,$nombre,$apellido,$edad,$sexo,$carrera,$correo,$telefono,$descripcion_part,$id_disciplina,$status)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("INSERT INTO public.participantes(nombre, cedula, apellido, edad, sexo, carrera, correo, telefono, descripcion_part, id_disciplina, status)
    					   VALUES ('$nombre','$cedula','$apellido','$edad','$sexo','$carrera','$correo','$telefono','$descripcion_part','$id_disciplina','$status');");

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



}
?>