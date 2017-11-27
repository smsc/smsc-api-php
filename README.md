Librería PHP para SMSC
================

Esta es una libería PHP para facilitar el uso de la API de SMSC (http://smsc.com.ar/).

## Instalación vía Composer

```bash
composer require smsc/smsc-api-php
```

## ¡Comienza!

### Utilizando los ejemplos

Una vez que tienes tu cuenta SMSC (puedes solicitar una forma gratuita con 20 SMSC gratis), debes
editar config.php con tus datos de acceso a la API (los obtienes aquí: http://www.smsc.com.ar/usuario/api/).
Una vez que lo hayas completado, podrás probar los ejemplos de la carpeta examples.

### Usándolo en tu proyecto

```php
try {
	$smsc = new Smsc($your_user, $your_apikey);

	// Estado del servicio
	echo 'El estado del servicio es '.($smsc->getEstado()?'OK':'CAIDO').'. ';

	// Saldo
	echo 'Quedan: '.$smsc->getSaldo().' sms. ';
	
	// Enviar SMS
	$smsc->addNumero(2627, 000000);
	$smsc->setMensaje('Hola Mundo!');
	if ($smsc->enviar())
		echo 'Mensaje enviado.';
} catch (Exception $e) {
	echo 'Error '.$e->getCode().': '.$e->getMessage();
}
```
