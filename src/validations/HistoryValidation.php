<?php

require_once __DIR__.'/../../core/Validation.php';

class HistoryValidation extends Validation
{
	public function validationRegisterHistory($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
	}
	public function validationUpdateHistory($request)
	{
		$checks = [
			"title" 				=>	['isset'=>true,	'empty'=>true], 					// valida que exista y que no está vacio
		];
		$this->checkAll($request, $checks);
  	}
  
	public function validationDeleteHistory($request)
	{
		$checks = [
			"id" 				=>	['isset'=>true,	'empty'=>true,'type'=>'int'],		// valida que es un int o float,
		];
		$this->checkAll($request, $checks);
	}
}