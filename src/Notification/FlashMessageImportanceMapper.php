<?php

namespace App\Notification;

use Symfony\Component\Notifier\FlashMessage\AbstractFlashMessageImportanceMapper;
use Symfony\Component\Notifier\FlashMessage\FlashMessageImportanceMapperInterface;

class FlashMessageImportanceMapper extends AbstractFlashMessageImportanceMapper implements FlashMessageImportanceMapperInterface
{
    protected const IMPORTANCE_MAP = [
        'urgent' => 'error',
        'high' => 'error',
        'medium' => 'primary',
        'low' => 'success',
    ];
}
