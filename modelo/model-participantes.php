<?php

require_once('conexion.php');

class participante{

	private $cedula;
	private $nombre;
	private $apellido;
	private $edad;
	private $sexo;
	private $carrera;
	private $correo;
	private $telefono;
	private $descripcion_part;
	private $id_disciplina;
	private $status;
	private $unidad;
	    
	public  function participante()
	{
		$this->cedula="";
		$this->nombre="";
		$this->apellido="";
		$this->edad="";
		$this->sexo="";
		$this->carrera="";
		$this->correo="";
		$this->telefono="";
		$this->descripcion_part="";
		$this->id_disciplina="";
		$this->status="";
		$this->unidad="";

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

		public function verificarParticipante($cedula)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT participantes.cedula
							FROM public.participantes
							WHERE participantes.cedula='$cedula';");

		if($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	
	}

	public function ConsultarID($cedula)
	{
		$obj_conex = new conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT 
	 	participantes.id
	FROM 
  		public.participantes 
	WHERE 

  			participantes.cedula='$cedula';  ");		
	
		if(pg_num_rows($query)>0){
			return $query;
		}
		else
		{

			return false;
		}

	}

	public function MostrarParticipante($cedula)
	{
		$obj_conex = new conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT
		  disciplina.descripcion, 
		  disciplina.unidad,
		  disciplina.id_disciplina, 
		  participantes.nombre, 
		  participantes.edad, 
		  participantes.sexo, 
		  participantes.descripcion_part, 
		  participantes.telefono, 
		  participantes.correo, 
		  participantes.id_disciplina, 
		  participantes.status, 
		  participantes.cedula, 
		  participantes.apellido, 
		  participantes.carrera, 
		  participantes.id
		FROM 
  			public.participantes,
  			public.disciplina
 		WHERE
			disciplina.id_disciplina=participantes.id_disciplina
		AND
  			participantes.cedula='$cedula';");		
	
		if(pg_num_rows($query)>0){
			return $query;
		}
		else
		{

			return false;
		}

	}

	public function ModificarParticipante($id, $cedula,$nombre,$apellido,$edad,$sexo,$carrera,$correo,$telefono,$descripcion_part,$id_disciplina,$status)
	{

		$obj_conex = new conexion();
		$obj_conex->conectar();

		$sql = "UPDATE participantes
  		SET nombre='$nombre', cedula='$cedula', 
      	apellido='$apellido', edad='$edad', carrera='$carrera',
      	correo='$correo', telefono='$telefono', 
      	descripcion_part='$descripcion_part', id_disciplina='$id_disciplina', 
      	status='$status'
		WHERE id='$id';";

		$query = @pg_query($sql);

		if ($query) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function MostrarTodos()
	{
		$conex = new Conexion();
		$conex->conectar();

		$query = pg_query("SELECT 
		  participantes.nombre, 
		  participantes.edad, 
		  participantes.sexo, 
		  participantes.telefono, 
		  participantes.descripcion_part, 
		  participantes.correo, 
		  participantes.status, 
		  participantes.cedula, 
		  participantes.apellido, 
		  participantes.carrera, 
		  participantes.id, 
		  disciplina.descripcion
		FROM 
		  public.participantes, 
		  public.disciplina
  		WHERE 
  		  participantes.id_disciplina = disciplina.id_disciplina
 		ORDER BY
  		  participantes.cedula ASC;");

		if ($query) 
		{
			return $query;			
		}
		else
		{
			return false;
		}
	}
		public function ParticipanteDisciplina($id_disciplina)
	{
		$conex = new Conexion();
		$conex->conectar();

		$query = pg_query("SELECT 
		  participantes.nombre, 
		  participantes.apellido, 
		  participantes.carrera, 
		  participantes.cedula, 
		  participantes.id_disciplina 
		FROM 
		  public.participantes 
		WHERE

		 participantes.id_disciplina = '$id_disciplina'
		AND
		 participantes.status=TRUE
 		ORDER BY
  		  participantes.cedula ASC;");

		if ($query) 
		{
			return $query;			
		}
		else
		{
			return false;
		}
	}

	public function EliminarParticipante($id)
	{
		$conex = new Conexion();
		$conex->conectar();

		$sql = "DELETE FROM public.participantes WHERE id='$id'";

		$query = pg_query($sql);

		if ($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}


}
?>