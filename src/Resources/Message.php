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

namespace Smsc\Resources;

abstract class Message
{
    /** @var \DateTime */
    private $date;
    /** @var string */
    private $priority;
    /** @var string */
    private $method = 'whatsapp';
    /** @var string */
    private $content = '';

    /**
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
