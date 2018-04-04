<?php 

require_once('conexion.php');
	
	class disciplina{

	private $id_disciplina;
	private $descripcion;
	private $unidad; 
 
	    
	public  function disciplina()
	{
		$this->id_disciplina="";
		$this->descripcion="";
		$this->unidad="";

	}

	public function selectdis($unidad)

	{	
		$conex = new Conexion();
		$conex->conectar();
		 $query = pg_query("SELECT 
 		 disciplina.id_disciplina, disciplina.descripcion
		FROM 
  			public.disciplina
  		WHERE unidad='$unidad'
  		ORDER BY
  			disciplina.id_disciplina;");

		 if ($query) 
		{
			return $query;			
		}
		else
		{
			return false;
		}

	}

	public function RegistrarDisciplina($descripcion, $unidad)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("INSERT INTO public.disciplina(descripcion, unidad)
    					   VALUES ('$descripcion','$unidad');");

		if($query)
		{
			return true;
		}
		else
		{
			return false;
		}
	
	}
	public function verificarDisciplina($descripcion)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT disciplina.descripcion
							FROM public.disciplina
							WHERE disciplina.descripcion='$descripcion';");

		if($query)
		{
			return $query;
		}
		else
		{
			return false;
		}
	
	}

	public function EliminarDisciplina($id_disciplina)
	{
		$conex = new Conexion();
		$conex->conectar();

		$sql = "DELETE FROM public.disciplina WHERE id_disciplina='$id_disciplina'";

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
}
?>