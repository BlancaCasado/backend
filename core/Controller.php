<?php
use \Firebase\JWT\JWT;

class Controller {
	public $request = [];
	public $token = null;
	function __construct()
	{
		// los globales
		$this->setRequest();
	}

	/* RESPONDER */
	function getToken($payload)
	{
	    return JWT::encode($payload, KEY_TOKEN);
	}
	function checkToken()
	{
		$headers = apache_request_headers();
		// $this->error($headers,401);
		if(!isset($headers["Token"])){
			$this->error('ERR_AUTH_03', 401);
		}
		$token = $headers['Token'];
	    try
	    {
	        $decoded = JWT::decode($token, KEY_TOKEN , array('HS256'));
	        $this->token = $decoded;
	    }
	    catch(Firebase\JWT\SignatureInvalidException $e)
	    {
			// TOKEN NO VALIDO 1
	        $this->error('ERR_AUTH_01',401);
	    }catch(Exception $ex){
			// TOKEN NO VALIDO 2
	    	$this->error('ERR_AUTH_02',401);
	    }
	}

	function responseJson($data)
	{
		header('Content-type: application/json;charset=utf-8');
		// echo json_encode(array('status' =>'OK' , 'data'=> $data));
		
		echo json_encode(array('status' =>'OK' , 'data'=> $this->utf8_converter($data)));
		exit();
	}

	function utf8_converter($array)
	{
		if (is_array( $array )){
			array_walk_recursive($array, function(&$item, $key){
				if(!mb_detect_encoding($item, 'utf-8', true)){
					$item = utf8_encode($item);
				}
			});
		} else {
			if(!mb_detect_encoding($array, 'utf-8', true)){
					$array = utf8_encode($array);
				}
		}
		return $array;
	}

	/** ERRORS **/

	//function que te devuelve un status con el numero de error y el mensaje
	function error($mng, $status = 400)
	{
		header('Content-type: application/json');
	    http_response_code($status);
	    echo json_encode(array("status"=>"KO", "error"=> $status,"message" => $mng));
	    die();
	}
	function setRequest ()
	{
		//obterner variables de $_POST
		foreach ($_POST as $key => $value) {
			$this->request[$key] = trim($value) ;
		}
		//Obtener variables del body
		$json_str = file_get_contents('php://input');
		$json_array = json_decode($json_str,true);
		if($json_array)
		{
			$this->request = array_merge ($this->request, $json_array);
		}
	}

	//Devuelve la fecha actual en formato Y-m-d H:i:s
	function getNow()
	{
		return date("Y-m-d H:i:s");
	}

	//Devuelve la fecha actual en formato Y-m-d H:i:s
	function middleWare($middlewares = null)
	{
		if(count($middlewares) > 0){
			// 1º partimos por "|" los diferentes middlewares
			foreach ($middlewares as $middleware) {
				$m = explode(':', $middleware);
				$params = isset($m[1]) ? explode(',', $m[1]) : null;
				$this->executeMiddleware($m[0], $params );
			}
		}
	}
	private function executeMiddleware($middleware, $params = null) {
		try {
			$this->$middleware($params);
		} catch (\Throwable $th) {
			// echo 'No existe middleware:'.$middleware;
			$this->error('No existe middleware:'.$middleware, 400);
		}
	}
	private function Auth($roles = null){
		// 1º checkeamos si tiene token
		$this->checkToken();
		// si es un string (un rol) q sea un array
		$roles = (gettype($roles) == 'string') ? array($roles) : $roles;
		// 2º checkeamos si tiene el rol especificado
		if($roles !== NULL && !$this->hasRole($roles)) {
			$this->error('No tienes acceso', 401);
		}
		// echo 'Im in Auth';
		// var_dump($roles);
	}
	private function hasRole($roles){
		// 1º checkeamos si tiene token
		$rolUser = $this->token->user->rol;
		foreach ($roles as $role) {
			if ($role == $rolUser) {
				return true;
			}
		}
		return false;
	}
	
}