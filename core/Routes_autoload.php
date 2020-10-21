<?php

/*
 * Este archivo se encarga de cargar todos los archivos de rutas incluidos en la carpeta
 */

$directorio = __DIR__.'/../src/routes';

$ficheros  = scandir($directorio);
foreach ($ficheros as $fichero) {
	if($fichero != '.' && $fichero != '..' ){
		require_once($directorio.'/'.$fichero);
	}
}