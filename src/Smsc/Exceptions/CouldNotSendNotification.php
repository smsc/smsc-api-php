<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of Saldo.com.ar. Saldo.com.ar can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

namespace Smsc\Exceptions;

use Smsc\Resources\SmsMessage;
use Smsc\Resources\WhatsappMessage;

class CouldNotSendNotification extends SmscException
{
    /**
     * @param mixed $message
     *
     * @return static
     */
    public static function invalidMessageObject($message): self
    {
        $className = get_class($message) ?: 'Unknown';

        return new static(
            "Notification was not sent. Message object class `{$className}` is invalid. It should
            be either `" . SmsMessage::class . '` or `' . WhatsappMessage::class . '`');
    }

    /**
     * @return static
     */
    public static function invalidReceiver(): self
    {
        return new static(
            'The notifiable did not have a receiving phone number. Add a routeNotificationForSmsc
            method or a phone_number attribute to your notifiable.'
        );
    }
}
