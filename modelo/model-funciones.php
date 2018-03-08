<?php 

require_once('conexion.php');
	
	class participantes{

	private $id_disciplina;
	private $disciplina;
	    
	public  function participantes()
	{
		$this->id_disciplina="";
		$this->disciplina="";

	}

	public function selectdis()

	{	
		$conex = new Conexion();
		$conex->conectar();
		 $query = pg_query("SELECT 
 		 disciplina.id_disciplina, disciplina.descripcion
		FROM 
  			public.disciplina
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

	public function RegistrarDisciplina($descripcion)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("INSERT INTO public.disciplina(descripcion)
    					   VALUES ('$descripcion');");

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
}
?>