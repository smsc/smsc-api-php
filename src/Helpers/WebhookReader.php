<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of Smsc. Smsc can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace Smsc\Helpers;

class WebhookReader
{
    /**
     * @param array<mixed> $values
     */
    public static function read($values): bool
    {
        return true;
    }

    public static function readFromGet(): bool
    {
        return self::read($_GET);
    }
}
