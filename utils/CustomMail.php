<?php
/*Funciones útiles*/

function emailsmtp($asunto,$mensaje,$to_email,$from_email=FROM_EMAIL,$from_name=FROM_NAME_EMAIL)
{    
	include_once(__DIR__."/mail/class.phpmailer.php");   
    include_once(__DIR__."/mail/class.smtp.php"); 
    //FIJOS SI NO CAMBIAMOS DE SERVIDOR
    $mail = new PHPMailer();
    $mail->IsSMTP();
    // $mail->SMTPDebug = 2;
	$mail->SMTPAuth = true;
    // $smtp->SMTPSecure = "tls";
    $mail->Host = SMTP_EMAIL; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = USERNAME_EMAIL; // Correo completo a utilizar
    $mail->Password = PASSWORD_EMAIL;  // Contraseña
    $mail->Port = PORT_EMAIL; // Puerto a utilizar
    $mail->From = $from_email; // Desde donde enviamos (Para mostrar)
    $mail->FromName = $from_name;
    //$mail->AddAddress("correo"); // Esta es la dirección a donde enviamos
    //$mail->AddCC("cuenta@dominio.com"); // Copia
    //$mail->AddBCC("cuenta@dominio.com"); // Copia oculta
    $mail->IsHTML(true); // El correo se envía como HTML
    //$mail->Subject = "Titulo"; // Este es el titulo del email.
    $mail->CharSet = 'UTF-8';
    $mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
    //$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
    //$exito = $mail->Send(); // Envía el correo.
    $mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
			)
		);             
		
	//PARA QUIEN
	//$mail->AddAddress("jescorial@nwc10.com");
	$mail->AddAddress($to_email);
	
    //CUERPO DEL MENSAJE
    $mail->Subject = $asunto; // Este es el titulo del email.
	$mail->Body = $mensaje; // Mensaje a enviar 
    if($mail->Send()){
        return true;
    }else{
		echo 'mal';
        echo $mail->ErrorInfo;
        return false;
    }


    
    //return $mail->Send();
}	

function emailsmtpFiles($asunto,$mensaje,$to_email,$arrayFiles,$from_email=FROM_EMAIL,$from_name=FROM_NAME_EMAIL)
{    
	include_once(__DIR__."/mail/class.phpmailer.php");   
	include_once(__DIR__."/mail/class.smtp.php"); 
	
	//FIJOS SI NO CAMBIAMOS DE SERVIDOR
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$smtp->SMTPSecure = "tls";
	$mail->Host = SMTP_EMAIL; // SMTP a utilizar. Por ej. smtp.elserver.com
	$mail->Username = USERNAME_EMAIL; // Correo completo a utilizar
	$mail->Password = PASSWORD_EMAIL;  // Contraseña
	$mail->Port = PORT_EMAIL; // Puerto a utilizar
	$mail->From = $from_email; // Desde donde enviamos (Para mostrar)
	$mail->FromName = $from_name;

	//$mail->AddAddress("correo"); // Esta es la dirección a donde enviamos
	//$mail->AddCC("cuenta@dominio.com"); // Copia
	//$mail->AddBCC("cuenta@dominio.com"); // Copia oculta
	$mail->IsHTML(true); // El correo se envía como HTML
	//$mail->Subject = "Titulo"; // Este es el titulo del email.
	$mail->CharSet = 'UTF-8';
	
	$mail->AltBody = "Hola mundo. Esta es la primer línean Acá continuo el mensaje"; // Texto sin html
	//$exito = $mail->Send(); // Envía el correo.
	$mail->SMTPOptions = array(
	                        'ssl' => array(
	                        'verify_peer' => false,
	                        'verify_peer_name' => false,
	                        'allow_self_signed' => true
	                        )
	        );             

	//PARA QUIEN
	//$mail->AddAddress("jescorial@nwc10.com");
	$mail->AddAddress($to_email);

	//CUERPO DEL MENSAJE
	$mail->Subject = $asunto; // Este es el titulo del email.
	$mail->Body = $mensaje; // Mensaje a enviar 
	foreach ($arrayFiles as $archivo) {
		$mail->AddAttachment($archivo['tmp_name'], $archivo['name']);
	}
	if($mail->Send()){
	    return true;
	}else{
	    echo $mail->ErrorInfo;
	    return false;
	}
	//return $mail->Send();
}	

function dd($dato)
{
	print_r($dato);
	die();
}
