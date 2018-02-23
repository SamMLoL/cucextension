<?PHP

class conexion {

	public $conex;

	public function conectar()
	{
			if(!isset($this->conex))
		{
			$this->conex = pg_connect("host=localhost dbname=extension user=postgres password='123456'")or die("No se ha podido conectar: ".pg_last_error());
			
		}
		return true;
	}
	
}


?>