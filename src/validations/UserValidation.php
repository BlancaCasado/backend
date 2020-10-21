<?php

require_once __DIR__.'/../../core/Validation.php';

/*
 *	Class: TesterValidation
 *	Description: sirve validar los parámetros de post-get etc
 *
 ******************************************/


class UserValidation extends Validation
{

	/*PARÁMETROS*/

	/*MÉTODOS*/
	public function testValidation($request)
	{
		$checks = [
			"nombre" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
			"apellidos" 			=>	['isset'=>true,	], 									// valida que exista
			"edad" 					=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float
			"boolean"				=>	['isset'=>true,	'empty'=>true,'type'=>'boolean'],	// valida que es un 0-1
			"email" 				=>	['isset'=>true,	'empty'=>true,'type'=>'email'], 	// valida que es un email
			"date" 					=>	['isset'=>true,	'empty'=>true,'type'=>'date'], 		// valida que es un timestamp ej."2018-01-31",
			"timestamp"				=>	['isset'=>true,	'empty'=>true,'type'=>'timestamp'], // valida que es un timestamp ej."2018-01-31 14:11:41",
			"telefono"				=> 	['isset'=>true,	'empty'=>true,'type'=>'exp','regular'=>'/^([0-9]{9})/' ], //valida la expresion regular dada
		];
		$this->checkAll($request, $checks);
    }
    
	/*MÉTODOS*/
	/*
	 * Function: validationRegister
	 * @params: array request con el usuario
	 * @return: void (Si esta mal corta la ejecución)
	 */
	public function validationRegister($request)
	{
		$checks = [
			"password" 	=>	['isset'=>true,	'empty'=>true], // valida que exista
			"email" 	=>	['isset'=>true,	'empty'=>true,'type'=>'email'], // valida que es un email
		];
		$this->checkAll($request, $checks);
	}


	public function validationLogin($request)
	{
		$checks = [
			"email" =>	['isset'	=>true,	'empty'=>true,'type'=>'email'],
			"password" => ['isset' 	=> true, 'empty'=>true],
		];
		$this->checkAll($request, $checks);
	}

	public function validationRecover($request)
	{
		$checks = [
			"email" =>	['isset'	=>true,	'empty'=>true,'type'=>'email'],
		];
		$this->checkAll($request, $checks);

	}
}