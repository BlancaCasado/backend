<?php

require_once __DIR__.'/../../core/Validation.php';

class GenreValidation extends Validation
{
	public function validationRegisterGenre($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
	}
	public function validationUpdateGenre($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
  	}
  
	public function validationDeleteGenre($request)
	{
		$checks = [
			"id" 				=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float,
		];
		$this->checkAll($request, $checks);
	}
}