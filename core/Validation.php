<?php
/*
 * Clase para hacer validaciones de formularios
 **********************/

class Validation {
	/** ERRORS **/

	//function que te devuelve un status con el numero de error y el mensaje
	function error($mng, $status)
	{
		header('Content-type: application/json');
	    http_response_code($status);
	    echo json_encode(array("status"=>"KO", "error"=> $status,"message" => $mng));
	    die();
	}

	/* checkAll checkea de un array que existan los campos , esten vacíos y sean del tipo concreto
	 * @params con formato como el de ejemplo
	 * @return true o corta la ejecucion creando un error con mensaje
	 */
	function checkAll($post, $checksArray)
	{
		$ejemplo = [
            "nombre" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
            "apellidos" 			=>	['isset'=>true,	], 									// valida que exista
            "edad" 					=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float
            "boolean"				=>	['isset'=>true,	'empty'=>true,'type'=>'boolean'],	// valida que es un 0-1
            "email" 				=>	['isset'=>true,	'empty'=>true,'type'=>'email'], 	// valida que es un email
            "date" 					=>	['isset'=>true,	'empty'=>true,'type'=>'date'], 		// valida que es un timestamp ej."2018-01-31",
            "timestamp"				=>	['isset'=>true,	'empty'=>true,'type'=>'timestamp'], // valida que es un timestamp ej."2018-01-31 14:11:41",
            "telefono"				=> 	['isset'=>true,	'empty'=>true,'type'=>'exp','regular'=>'/^([0-9]{9})/' ], //valida la expresion regular dada
		];

		//validaciones
		foreach ($checksArray as $campo => $checks)
		{
			if(isset($checks['isset']) && !isset($post[$campo]))
			{
				$this->error(array('key'=>$campo ,'message'=>'No existe: '.$campo),400);
			}
			if(isset($checks['empty']) && empty($post[$campo]) && $post[$campo] != '0')
			{
				$this->error(array('key'=>$campo ,'message'=>'Campo vacío: '.$campo),400);
			}

			if(isset($checks['type'])){
				if(!empty($post[$campo]) || $post[$campo] == '0'){
					switch ($checks['type']) {
						case 'email':
							if(!$this->checkEmail($post[$campo])){
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' tiene que ser un email"), 400);
							}
							break;
						case 'boolean':
							if( $post[$campo] != '0' && $post[$campo] != '1' )
							{
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' tiene que ser 0-1"), 400);
							}
						case 'int':
							if(!is_numeric($post[$campo])){
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' tiene que ser un número"), 400);
							}
							break;
						case 'date':
							if(!$this->checkDate($post[$campo]))
							{
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' tiene que ser una fecha YYYY-MM-DD"), 400);
							}
							break;
						case 'timestamp':
							if(!$this->checkTimeStamp($post[$campo]))
							{
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' es '$post[$campo]'y tiene que ser un timestamp YYYY-MM-DD HH:MM:SS"), 400);
								$this->error(array('key'=>$campo ,'message'=>"Campo '$campo' tiene que ser un timestamp YYYY-MM-DD HH:MM:SS"), 400);
							}
							break;
						case 'array':

							if(!in_array($post[$campo], $checks['data']))
							{
								$array = implode('-', $checks['data']);
								$this->error(array('key'=>$campo ,'message'=>"El campo '$campo' debe ser tipo $array"), 400);
							}
							break;
						case 'exp':
							$expresion_regular = $checks['regular'];
							if(!$this->checkExpr($post[$campo],$expresion_regular))
							{
								$this->error(array('key'=>$campo ,'message'=>"El campo '$campo' no es válido"), 400);
							}
							break;
						default:
							$this->error('Error servidor de tipo: '.$campo, 500);
							break;
						case 'passwd':
							if(!$this->checkPasswd($post[$campo])){
								$this->error(array('key' => $campo, 'message' => "El campo '$campo' no es válido"),500);
							}
							break;
					}
				}
				
			}
		}
		return true;	
	}

	private function checkEmail($email)
	{
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
		{
		  return true;
		}
		return false;
	}
	private function checkTimeStamp($timeStamp)
	{
		if(preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})\s([0-9]{2}):([0-9]{2}):([0-9]{2})/',$timeStamp))
		{
		  return true;
		}
		return false;
	}
	private function checkDate($date){
		if(preg_match('/^([0-9]{4})-([0-9]{2})-([0-9]{2})/',$date))
		{
		  return true;
		}
		return false;
	}
	private function checkExpr($variable,$expresionRegular)
	{
		if(preg_match($expresionRegular,$variable))
		{
		  return true;
		}
		return false;

	}
	private function checkPasswd($passwd){
		if(preg_match('/^\S*(?=\S{8,})(?=\S*[a-z])(\S?=*[A-Z])(?=\S*[\d])\S*$/',$passwd)){
			return true;
		}
		return false;
	}
}