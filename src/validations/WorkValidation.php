<?php

require_once __DIR__.'/../../core/Validation.php';

class WorkValidation extends Validation
{
	public function validationRegisterWork($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
			"theme" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
			"editor" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
	}
	public function validationUpdateWork($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
			"theme" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
			"editor" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
  	}
  
	public function validationDeleteWork($request)
	{
		$checks = [
			"id" 				=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float,
		];
		$this->checkAll($request, $checks);
	}
}