<?php

/*********************************
 *		  MODO DESARROLLO
 *         true / false
 *********************************/
define('MOD_DESARROLLO' , true );

define('LOCAL' , true );

//define('MOD_DES' , false );

/*********************************
 *		  BASE DE DATOS
 *********************************/
if(LOCAL){
	define('BASE_URL', 'http://localhost/mng/');
	//Host de la base de datos
	define('DB_HOST','localhost');
	//Nombre de la BD
	define('DB_NAME','plantilla_web');
	//Usuario BD
	define('DB_USER','root');
	//Password BD
	define('DB_PASS','');
	//Nombre del puerto
	define('DB_PORT','3306');
	define('DB_DSN','mysql:host='.DB_HOST.';dbname='.DB_NAME);
}
	else
{
	define('BASE_URL', '');
	//Host de la base de datos
	define('DB_HOST','localhost');
	//Nombre de la BD
	define('DB_NAME','');
	//Usuario BD
	define('DB_USER','');
	//Password BD
	define('DB_PASS','');
	//Nombre del puerto
	define('DB_PORT','3306');
	define('DB_DSN','mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME);
}


/*********************************
 *		  CORREO SMTP
 *********************************/
//Host del mail
define('SMTP_EMAIL','');
//Nombre mail
define('USERNAME_EMAIL','');
//Password mail
define('PASSWORD_EMAIL','');
//Puerto
define('PORT_EMAIL',587); // 25);
//Email base de los correos
define('FROM_EMAIL','');
//From 
define('FROM_NAME_EMAIL', '');


/*********************************
 *		      CORS
 *********************************/

//Habilitar conexion crossdomain origin
define('MOD_CORS', true );


/*********************************
 *		      TOKEN
 *********************************/

//clave secreta para los tokens
define('KEY_TOKEN', '' );

//tiempo para la expiracion del token
define('TIME_TOKEN', '21 days' );



/*Cabeceras CORS*/
if(MOD_CORS)
{
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
}
if(MOD_DESARROLLO)
{
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}



/*********************************
 *		  FIREBASE API KEY
 *********************************/
//Define a new constant for firebase api key

//define('FIREBASE_API_KEY', '');

header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, token, timezone');