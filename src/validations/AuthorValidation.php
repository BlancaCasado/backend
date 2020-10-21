<?php

require_once __DIR__.'/../../core/Validation.php';

class AuthorValidation extends Validation
{
	public function validationRegisterAuthor($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
	}
	public function validationUpdateAuthor($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
  	}
  
	public function validationDeleteAuthor($request)
	{
		$checks = [
			"id" 				=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float,
		];
		$this->checkAll($request, $checks);
	}
}