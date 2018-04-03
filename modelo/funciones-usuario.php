<?php 
require_once('conexion.php');

class usuario{
 private $id; 
 private $correo;
 private $clave;
 
    
	public  function usuario()
	{
		$this->id="";
		$this->correo="";
		$this->clave="";
		

	}

	public function iniciarSession($id,$clave)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = pg_query("SELECT id,clave FROM public.usuario	WHERE id = '$id' AND clave = '$clave'; ");

		if (pg_num_rows($query)>0){
			return true;
		}else{
			return  false;
		}
	}

	
	public function RegistrarUsuario($id,$correo,$clave)
	{
		$obj_conex = new Conexion();
		$obj_conex->conectar();
		$query = @pg_query("INSERT INTO usuario
			(id, correo, clave) 
			VALUES ('$id','$correo','$clave');");

		if($query){

			return true;
		}else{

			return false;
			}
	}

	public function consultarUsuario($id)
	{
		$obj_conex = new Conexion();
		$obj_conex -> conectar();
		$query = @pg_query(" SELECT * FROM
			public.usuario WHERE id='$id';");
		if (pg_num_rows($query)>0) {
			return $query;
		}
		else
		{
			return false;
		}


	}

	public function Recuperar($id, $correo)
	{
		$obj_conex = new Conexion();
		$obj_conex -> conectar();
		$query = @pg_query(" SELECT * 
			FROM public.usuario 
			WHERE id='$id'
			AND correo= '$correo';");
		if (pg_num_rows($query)>0) {
			return $query;
		}
		else
		{
			return false;
		}


	}
}
 ?>