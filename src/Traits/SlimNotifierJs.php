<?php

namespace AsayDev\LaraTickets\Traits;

trait SlimNotifierJs
{

    public  static $success = 'success';
    public  static $warning = 'warning';
    public  static $error = 'error';
    public  static $envelope = 'envelope';

    public static function prepereNotifyData($type, $title, $message, $duration = '3000')
    {
        return array(
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'duration' => $duration
        );
    }
}
