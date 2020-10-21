<?php

/*
 * Este archivo se encarga de cargar todos los archivos de rutas incluidos en la carpeta
 */

$directorio = __DIR__;

$ficheros  = scandir($directorio);
foreach ($ficheros as $fichero) {

	//echo $fichero.'=>'.strpos($fichero, '.php').PHP_EOL;
	//strpos($fichero, '.php');
	if( 
		$fichero != '.' && $fichero != '..' && 
		$fichero != 'utils_autoload.php' &&
		strpos($fichero, '.php') > 0
	  )
	{
		require_once __DIR__.'/'.$fichero;
	}
}