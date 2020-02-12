<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of Smsc. Smsc can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

/**
 * SMSC Api.
 *
 * @author Pablo Gabriel Reyes
 *
 * @see https://smsc.com.ar/ Smsc
 * @see https://github.com/smsc/smsc-api-php Smsc on GitHub
 *
 * @version 1.0.1
 */

namespace Smsc;

use Exception;

class SmscClient
{
    /**
     * @var string ApiKey de SMSC
     */
    private $apikey = '';

    /**
     * @var string Alias de SMSC
     */
    private $alias = '';

    /** @var string */
    public $version = '0.3';
    /** @var string */
    public $protocol = 'https';

    /** @var mixed */
    private $priority;
    /** @var int */
    private $line;
    /** @var string */
    private $mensaje = '';
    /** @var array<mixed> */
    private $return;
    /** @var string */
    private $method;
    /** @var array<string> */
    private $numeros;

    public function __construct(string $alias = null, string $apikey = null)
    {
        if ($alias !== null) {
            $this->setAlias($alias);
        }
        if ($apikey !== null) {
            $this->setApikey($apikey);
        }
    }

    public function getApikey(): string
    {
        return $this->apikey;
    }

    public function setApikey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return array_key_exists('data', $this->return) ? $this->return['data'] : [];
    }

    public function getStatusCode(): int
    {
        return $this->return['code'];
    }

    public function getStatusMessage(): string
    {
        return $this->return['message'];
    }

    /**
     * @throws Exception
     */
    public function exec(string $cmd = null, string $extradata = null): bool
    {
        $this->return = [];

        // construyo la URL de consulta
        $url = $this->protocol . '://www.smsc.com.ar/api/' . $this->version . '/?alias=' . $this->alias . '&apikey=' . $this->apikey;
        $url2 = '';
        if ($cmd !== null) {
            $url2 .= '&cmd=' . $cmd;
        }
        if ($extradata !== null) {
            $url2 .= $extradata;
        }

        // hago la consulta
        $data = @file_get_contents($url . $url2);
        if ($data === false) {
            throw new Exception('No se pudo conectar al servidor.', 1);
        }
        $ret = json_decode($data, true);
        if (!is_array($ret)) {
            throw new Exception('Datos recibidos, pero no han podido ser reconocidos ("' . $data . '") (url2=' . $url2 . ').', 2);
        }
        $this->return = $ret;

        return true;
    }

    /**
     * Estado del sistema SMSC.
     *
     * @throws Exception
     *
     * @return bool devuelve true si no hay demoras en la entrega
     */
    public function getEstado(): bool
    {
        $ret = $this->exec('estado');
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }
        $ret = $this->getData();

        return $ret['estado'];
    }

    /**
     * Validar número.
     *
     * @throws Exception
     *
     * @return bool devuelve true si es un número válido
     */
    public function evalNumero(string $prefijo, string $fijo = null): bool
    {
        $ret = $this->exec('evalnumero', '&num=' . $prefijo . ($fijo === null ? '' : '-' . $fijo));
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }
        $ret = $this->getData();

        return $ret['estado'];
    }

    /**
     * @throws Exception
     *
     * @return bool|array<string>
     */
    public function getSaldo()
    {
        $ret = $this->exec('saldo');
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }
        $ret = $this->getData();

        return $ret['mensajes'];
    }

    /**
     * @param int $prioridad 0:todos 1:baja 2:media 3:alta
     *
     * @throws Exception
     *
     * @return bool|array<string>
     */
    public function getEncolados($prioridad = 0)
    {
        $ret = $this->exec('encolados', '&prioridad=' . (int) $prioridad);
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }
        $ret = $this->getData();

        return array_key_exists('mensajes', $ret) ? $ret['mensajes'] : [];
    }

    /**
     * *******************************************
     * *******   Metodos para enviar SMS   *******
     * *******************************************.
     */

    /**
     * @param int $prefijo Prefijo del área, sin 0
     *                     Ej: 2627 ó 2627530000
     * @param int $fijo Número luego del 15, sin 15
     *                  Si sólo especifica prefijo, se tomará como número completo (no recomendado).
     *                  Ej: 530000
     */
    public function addNumero($prefijo, $fijo = null): void
    {
        $this->numeros[] = $fijo === null ? (string) $prefijo : $prefijo . '-' . $fijo;
    }

    public function getMensaje(): string
    {
        return $this->mensaje;
    }

    /**
     * @param string $mensaje
     */
    public function setMensaje($mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getLinea()
    {
        return $this->line;
    }

    /**
     * @param int $line_id. Only for dedicated lines.
     */
    public function setLinea($line_id): void
    {
        $this->line = $line_id;
    }

    /**
     * @return mixed
     */
    public function getPrioridad()
    {
        return $this->priority;
    }

    /**
     * @param int $priority 1 for low to 7 for high. null for default.
     */
    public function setPrioridad($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @throws Exception
     *
     * @return bool|mixed
     */
    public function enviar()
    {
        $params[] = 'num=' . implode(',', $this->numeros);
        $params[] = 'msj=' . urlencode($this->mensaje);

        if ($this->getLinea() > 0) {
            $params[] = 'line=' . $this->getLinea();
        }

        if ($this->getPrioridad() > 0) {
            $params[] = 'priority=' . $this->getPrioridad();
        }
        if ($this->method) {
            $params[] = 'method=' . urlencode($this->method);
        }

        $ret = $this->exec('enviar', '&' . implode('&', $params));
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }

        return $this->getData();
    }

    /**
     * ***********************************************
     * *******  Metodos para hacer consultas   *******
     * ***********************************************.
     */

    /**
     * Devuelve los últimos 30 SMSC recibidos.
     *
     * Lo óptimo es usar esta función cuando se recibe la notificación, que puede
     * especificar en https://www.smsc.com.ar/usuario/api/
     *
     * @param int $ultimoid si se especifica, el sistema sólo devuelve los SMS
     *                      más nuevos al sms con id especificado (acelera la
     *                      consulta y permite un chequeo rápido de nuevos mensajes)
     *
     * @throws Exception
     *
     * @return bool|mixed
     */
    public function getRecibidos($ultimoid = 0)
    {
        $ret = $this->exec('recibidos', '&ultimoid=' . (int) $ultimoid);
        if (!$ret) {
            return false;
        }
        if ($this->getStatusCode() !== 200) {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        }

        return $this->getData();
    }
}
