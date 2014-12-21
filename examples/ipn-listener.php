<?php
	/**
	 * Script de ejemplo que, al recibir la notificación de un nuevo SMS,
	 * envía un correo electrónico con el número y el mensaje recibido.
	 * 
	 * Debes cargar la URL de este script en
	 * https://www.smsc.com.ar/usuario/api/
	 * para que la consultemos cada vez que tu cuenta reciba un SMS
	 */
	
	try {
		$mensaje = 'De (numero): '.$_GET['num']."\n";
		$mensaje .= 'Mensaje: '.$_GET['msj']."\n";
		
		mail('tucorreo@dominio.com', 'IPN recibido en SMSC', $mensaje);
	} catch (Exception $e) {
		
	}
