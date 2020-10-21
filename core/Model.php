<?php

class Model
{
	private $db;
	public $table = null;
	function __construct()
	{
		$this->db= Database::shareConnection();
		$this->db = $this->db->getDB();
	}

	/*
	funcion que ejecuta una query (SELECT,INSERT,UPDATE,DELETE)
	INSERT 			-> devuelve el id generado
	SELECT 			-> devuelve un array de datos
	UPDATE,DELETE 	-> devuelve las filas actualizadas o borradas
	*/
	public function getDb()
	{
		return $this->db;
	}
	public function query($sql,$params=array())
	{

		try{
			$stmt = $this->db->prepare($sql);
			foreach ($params as $value) {
				if(isset($value[2])){
					$stmt->bindParam($value[0],$value[1],$value[2]);
				}else{
					$stmt->bindParam($value[0],$value[1],PDO::PARAM_STR);
				}
			}
			$stmt->execute();
			//Recuperamos la primera palabra de la sentencia sql, que sera INSERT,SELECT,DELETE,UPDATE
			$pos = strpos($sql, " ");//strpos: busca el primer string coincidente con el segundo parámetro.
			$type = substr($sql, 0, $pos);//substr: extrae una parte de la cadena dada desde el punto inicial (0) hasta el punto final ($pos).
			//Dependiendo de la palabra obtenida, devolvemos a la última id generada, la tabla resultante o el número de filas afectadas(delete,update).
			if( $type == "INSERT" ){
				return $this->db->lastInsertId();
			}else if( $type == "SELECT" ){

				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				/*for ($i=0; $i < count($result); $i++) { 
					$result[$i] = array_map('utf8_encode', $result[$i]);
				}*/
				return $result;
			}else{
				return $stmt->rowCount();
			}		
		}catch(Exception $e){
			if(MOD_DESARROLLO){
				//xa debuquear query
				 //$stmt->debugDumpParams();die();
				//para ver una sql montada
				//foreach ($params as $param) {
				//	$sql = str_replace($param[0], "'".$param[1]."'", $sql);
				//}
				//$this->error($stmt->ErrorInfo(),500) ;
				echo $e;die();
				$this->error($e,500) ;
			}else{
				$this->error('Error en la base de datos',500);
			}
		}

	}

	public function getOne($sql,$params){

		$res = $this->query($sql,$params);
		if(!isset($res[0])){
			$this->error('No existe',404);
		}
		return $res[0];
	}
	public function getLOB($sql,$params){
		$res = $this->query($sql,$params);
		if(!isset($res[0])){
			$this->error('No existe',404);
		}
		return $res[0];
	}

	public function getById($id)
	{
		if ($this->table) {
			$sql = "SELECT * FROM ".$this->table." WHERE id = :id";
			$params = [
				[':id',$id]
			];
			return $this->getOne($sql,$params);
		} else {
			$this->error('Not table defind', 500);
		}
	}

	public function getAll()
	{
		if ($this->table) {
			$sql = "SELECT * FROM ".$this->table;
			// $params = [
			// 	[':valor',$valor]
			// ];
			return $this->query($sql);
		} else {
			$this->error('Not table defind', 500);
		}
	}

	public function getBy($campo, $valor)
	{

		if ($this->table) {
			$sql = "SELECT * FROM ".$this->table." WHERE ".$campo." = :valor";
			$params = [
				[':valor',$valor]
			];
			return $this->query($sql,$params);
		} else {
			$this->error('Not table defind', 500);
		}
	}
	public function checkEmail($valor)
	{
		if($this->table){
			$sql = "SELECT email FROM ".$this->table." WHERE email = :valor";
			$params = [
				[':valor',$valor]
			];
				$res = $this->query($sql,$params);
				if(isset($res[0])){
					$this->error('Email ya registrado',404);
				}
		}
	}
	public function checkBy($campo,$valor)
	{
		if($this->table){
			$sql = "SELECT * FROM ".$this->table." WHERE ".$campo." = :valor";
			$params = [
				[':valor', $valor]
			];
			$res = $this->query($sql,$params);
			if(!isset($res[0])){
				$this->error('no existe', 404);
			}
			return $res[0];
		}
	}


	//Devuelve la fecha actual en formato Y-m-d H:i:s
	function getNow()
	{
    	return date("Y-m-d H:i:s");
	}

	//function que te devuelve un status con el numero de error y el mensaje
	function error($mng,$status) 
	{
		header('Content-type: application/json');
	    echo json_encode(array("status" => "KO" , "error"=> $status , "message" => $mng));
	    http_response_code($status);
	    die();
	}

}