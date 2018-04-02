<?php

require_once('conexion.php');

class profesor{

	private $cedula;
	private $nombre;
	private $apellido;
	private $edad;
	private $sexo;
	private $telefono;
	private $id_disciplina;
	private $status;
	private $unidad;
	    
	public  function profesor()
	{
		$this->cedula="";
		$this->nombre="";
		$this->apellido="";
		$this->edad="";
		$this->sexo="";
		$this->telefono="";
		$this->id_disciplina="";
		$this->status="";
		$this->unidad="";

	}
	public function RegistrarProfesor($cedula,$nombre,$apellido,$edad,$sexo,$telefono,$id_disciplina,$status)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("INSERT INTO public.profesor(nombre, cedula, apellido, edad, sexo, telefono, id_disciplina, status)
    					   VALUES ('$nombre','$cedula','$apellido','$edad','$sexo','$telefono','$id_disciplina','$status');");

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

		public function verificarProfesor($cedula)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT profesor.cedula
							FROM public.profesor
							WHERE profesor.cedula='$cedula';");

		if($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	
	}

	public function MostrarProfesor($cedula)
	{
		$obj_conex = new conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT
		  disciplina.descripcion, 
		  disciplina.unidad,
		  disciplina.id_disciplina, 
		  profesor.nombre, 
		  profesor.edad, 
		  profesor.sexo,  
		  profesor.telefono, 
		  profesor.id_disciplina, 
		  profesor.status, 
		  profesor.cedula, 
		  profesor.apellido, 
		  profesor.id
		FROM 
  			public.profesor,
  			public.disciplina
 		WHERE
			disciplina.id_disciplina=profesor.id_disciplina
		AND
  			profesor.cedula='$cedula';");		
	
		if(pg_num_rows($query)>0){
			return $query;
		}
		else
		{

			return false;
		}

	}
	public function ModificarProfesor($id, $cedula,$nombre,$apellido,$edad,$sexo,$telefono,$id_disciplina,$status)
	{

		$obj_conex = new conexion();
		$obj_conex->conectar();

		$sql = "UPDATE profesor
  		SET nombre='$nombre', cedula='$cedula', 
      	apellido='$apellido', edad='$edad',
      	telefono='$telefono',  id_disciplina='$id_disciplina', status='$status'
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
		  profesor.nombre, 
		  profesor.edad, 
		  profesor.sexo, 
		  profesor.telefono,
		  profesor.status, 
		  profesor.cedula, 
		  profesor.apellido, 
		  profesor.id, 
		  disciplina.descripcion
		FROM 
		  public.profesor, 
		  public.disciplina
  		WHERE 
  		  profesor.id_disciplina = disciplina.id_disciplina
 		ORDER BY
  		  profesor.cedula ASC;");

		if ($query) 
		{
			return $query;			
		}
		else
		{
			return false;
		}
	}
	public function EliminarProfesor($id)
	{
		$conex = new Conexion();
		$conex->conectar();

		$sql = "DELETE FROM public.profesor WHERE id='$id'";

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