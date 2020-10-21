<?php
class CustomCurl
{
	/*
	 * Function: get
	 * Params: String / url de destino
	 * Return: Si es un json la respuesta, un array clave valor -> sino el string
	 * Description: 
	 ********************/
	public function get($url)
	{
		$res = $this->curl($url);
		$result = json_decode($res, true);
		return $result ? $result : $res;
	}

	/*
	 * Function: post
	 * Params: String / url de destino , $params -> array clave valor de los parametros del post
	 * Return: Si es un json la respuesta, un array clave valor -> sino el string 
	 * Description: 
	 ********************/
	public function post($url, $params)
	{
		$exampleParams = [
			'parametro1' => 'Valor1',
			'parametro2'=> 'Valor2'
		];
		$defaults = array(
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $params
		);
		$res = $this->curl($url, $defaults);
		$result = json_decode($res, true);
		return $result ? $result : $res;
	}

	private function curl($url, $setopt = NULL)
	{
		try {
		    $ch = curl_init();

		    // Check if initialization had gone wrong*    
		    if ($ch === false) {
		        throw new Exception('failed to initialize');
		    }

		    //curl_setopt($ch, CURLOPT_URL, 'http://jsonplaceholder.typicode.com/todos/1');
		    curl_setopt($ch, CURLOPT_URL, 'localhost/premiumguest/API/test/');

		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		    if($setopt){
		    	foreach ($setopt as $key => $value) {
		    		curl_setopt($ch, $key, $value);
		    	}
		    }

		    $content = curl_exec($ch);

		    // Check the return value of curl_exec(), too
		    if ($content === false) {
		    	if (MOD_DESARROLLO) {
		        	throw new Exception(curl_error($ch), curl_errno($ch));
		    	} else {
		    		header('Content-type: application/json');
		    		echo json_encode(array("status"=>"KO", "error"=> '500',"message" => 'CURL Err'));
		    		http_response_code(500);
		    		die();
		    	}
		    }
		    /* Process $content here */
		    // Close curl handle
		    curl_close($ch);
		    return $content;
		} catch(Exception $e) {
		    trigger_error(sprintf(
		        'Curl failed with error #%d: %s',
		        $e->getCode(), $e->getMessage()),
		        E_USER_ERROR);
		}
	}
}