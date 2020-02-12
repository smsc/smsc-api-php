<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of LaravelJsonApi. LaravelJsonApi can not be copied and/or
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

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
