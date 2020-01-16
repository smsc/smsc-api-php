<?php
/**
 * SMSC Api
 *
 * @author Pablo Gabriel Reyes
 * @link https://smsc.com.ar/ Smsc
 * @link https://github.com/smsc/smsc-api-php Smsc on GitHub
 * @version 1.0.1
 */
namespace Smsc\Resources;

abstract class Message
{
    private $date;
    private $priority;
    private $method = 'whatsapp';

    /**
     * @var string
     */
    private $content = '';

    /**
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return self
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }
}