<?php 

require_once('conexion.php');
	
	class objetos{

	private $id_disciplina;
	private $disciplina;
	private $titulo;
	private $contenido;
	private $clase;
	private $inicio;
	private $final;
	private $inicio_normal;
	private $final_normal;
	private $url;
	private $id_unidad;
 
	    
	public  function objetos()
	{
		$this->id_disciplina="";
		$this->disciplina="";
		$this->titulo="";
		$this->contenido="";
		$this->clase="";
		$this->inicio="";
		$this->final="";
		$this->inicio_normal="";
		$this->final_normal="";
		$this->url="";
		$this->id_unidad="";

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

		public function AgregarEvento($titulo,$contenido,$clase,$inicio,$final,$id_disciplina,$inicio_normal,$final_normal)
	{
		$conex = new Conexion();
		$conex->conectar();

		$sql="INSERT INTO public.evento(title, body, class, start, \"end\", inicio_normal, id_disciplina, final_normal)
                VALUES ('$titulo','$contenido','$clase','$inicio','$final','$inicio_normal','$id_disciplina','$final_normal');";

		$query = pg_query($sql);

		if ($query)
		{	
			$im=$obj_conex=pg_query("SELECT MAX(id) AS id FROM evento");
            $row = pg_fetch_row($im);  
            $id = trim($row[0]);
            $link = "../controlador/funciones.php?x=5&id=$id";
            $query="UPDATE evento SET url = '$link' WHERE id = $id";
            $obj_conex=pg_query($query);
			return true;
		}
		else
		{
			return false;
		}

	}


}
?>