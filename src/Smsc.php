<?php
/**
 * SMSC Api
 *
 * @author Pablo Gabriel Reyes
 * @link https://smsc.com.ar/ Smsc
 * @link https://github.com/smsc/smsc-api-php Smsc on GitHub
 * @version 1.0.1
 */

class Smsc
{
    /**
     * @var string ApiKey de SMSC
     */
    private $apikey = '';

    /**
     * @var string Alias de SMSC
     */
    private $alias = '';

    public $version = '0.3';
    public $protocol = 'https';
    
    private $priority = null;
    private $line = null;
    private $mensaje = '';
    private $return = '';

    public function  __construct($alias = null, $apikey = null) {
        if ($alias !== null)
            $this->setAlias ($alias);
        if ($apikey !== null)
            $this->setApikey ($apikey);

    }

    public function getApikey()
    {
     return $this->apikey;
    }
    public function setApikey($apikey)
    {
     $this->apikey = $apikey;
    }

    public function getAlias()
    {
     return $this->alias;
    }
    public function setAlias($alias)
    {
     $this->alias = $alias;
    }


    public function getData()
    {
        return $this->return['data'];
    }

    public function getStatusCode()
    {
        return $this->return['code'];
    }

    public function getStatusMessage()
    {
        return $this->return['message'];
    }

    public function exec($cmd = null, $extradata = null)
    {
        $this->return = null;

        // construyo la URL de consulta
        $url = $this->protocol.'://www.smsc.com.ar/api/'.$this->version.'/?alias='.$this->alias.'&apikey='.$this->apikey;
        $url2 = '';
        if ($cmd !== null)
            $url2 .= '&cmd='.$cmd;
        if ($extradata !== null)
            $url2 .= $extradata;

        // hago la consulta
        $data = @file_get_contents($url.$url2);
        if ($data === false)
        {
            throw new Exception('No se pudo conectar al servidor.', 1);
            return false;
        }
        $ret = json_decode($data, true);
        if (!is_array($ret))
        {
            throw new Exception('Datos recibidos, pero no han podido ser reconocidos ("'.$data.'") (url2='.$url2.').', 2);
            return false;
        }
        $this->return = $ret;
        return true;
    }


    /**
     * Estado del sistema SMSC.
     * @return bool Devuelve true si no hay demoras en la entrega.
     */
    public function getEstado()
    {
        $ret = $this->exec('estado');
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
             throw new Exception($this->getStatusMessage(), $this->getStatusCode());
             return false;
        } else {
            $ret = $this->getData();
            return $ret['estado'];
        }
    }


    /**
     * Validar número
     * @return bool Devuelve true si es un número válido.
     */
    public function evalNumero($prefijo, $fijo = null)
    {
        $ret = $this->exec('evalnumero', '&num='.$prefijo.($fijo === null?'':'-'.$fijo));
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
             throw new Exception($this->getStatusMessage(), $this->getStatusCode());
             return false;
        } else {
            $ret = $this->getData();
            return $ret['estado'];
        }
    }


    /**
     *
     * @return array
     */
    public function getSaldo()
    {
        $ret = $this->exec('saldo');
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
            return false;
        } else {
            $ret = $this->getData();
            return $ret['mensajes'];
        }
    }


    /**
     *
     * @param int $prioridad 0:todos 1:baja 2:media 3:alta
     * @return array
     */
    public function getEncolados($prioridad = 0)
    {
        $ret = $this->exec('encolados', '&prioridad='.intval($prioridad));
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
            throw new Exception($this->getStatusMessage(), $this->getStatusCode());
            return false;
        } else {
            $ret = $this->getData();
            return $ret['mensajes'];
        }
    }


    /**
     * *******************************************
     * *******   Metodos para enviar SMS   *******
     * *******************************************
     */

    /**
     * @param integer $prefijo    Prefijo del área, sin 0
     *                    Ej: 2627 ó 2627530000
     * @param integer $fijo Número luego del 15, sin 15
     *                    Si sólo especifica prefijo, se tomará como número completo (no recomendado).
     *                    Ej: 530000
     */
    public function addNumero($prefijo, $fijo = null)
    {
        if ($fijo === null)
            $this->numeros[] = $prefijo;
        else
            $this->numeros[] = $prefijo.'-'.$fijo;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

    public function getLinea()
    {
        return $this->line;
    }
    /**
     * @param int $line_id. Only for dedicated lines.
     */
    public function setLinea($line_id)
    {
        $this->line = $line_id;
    }

    public function getPrioridad()
    {
        return $this->line;
    }
    /**
     * @param int $priority 1 for low to 7 for high. null for default.
     */
    public function setPrioridad($priority)
    {
        $this->priority = $priority;
    }

    public function enviar()
    {
        $params[] = 'num='.implode(',', $this->numeros);
        $params[] = 'msj='.urlencode($this->mensaje);
        
        if ($this->getLinea() > 0)
            $params[] = 'line='.$this->getLinea();
        
        if ($this->getPrioridad() > 0)
            $params[] = 'priority='.$this->getPrioridad();
        
        $ret = $this->exec('enviar', '&'. implode('&', $params));
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
             throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        } else {
            return $this->getData();
        }
    }


    /**
     * ***********************************************
     * *******  Metodos para hacer consultas   *******
     * ***********************************************
     */

    /**
     * Devuelve los últimos 30 SMSC recibidos.
     * 
     * Lo óptimo es usar esta función cuando se recibe la notificación, que puede
     * especificar en https://www.smsc.com.ar/usuario/api/
     * 
     * @param int $ultimoid si se especifica, el sistema sólo devuelve los SMS
     * más nuevos al sms con id especificado (acelera la
     * consulta y permite un chequeo rápido de nuevos mensajes)
     */
    public function getRecibidos($ultimoid = 0)
    {
        $ret = $this->exec('recibidos', '&ultimoid='.(int)$ultimoid);
        if (!$ret)
            return false;
        if ($this->getStatusCode() != 200)
        {
             throw new Exception($this->getStatusMessage(), $this->getStatusCode());
        } else {
            return $this->getData();
        }
    }

}