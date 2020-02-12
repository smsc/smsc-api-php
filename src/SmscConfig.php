<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of Smsc. Smsc can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace Smsc;

class SmscConfig
{
    /**
     * @var array<string>
     */
    private $config;

    /**
     * @param array<string> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getAlias(): string
    {
        return $this->config['alias'] ?? '';
    }

    public function getApiKey(): string
    {
        return $this->config['apikey'] ?? '';
    }
}
