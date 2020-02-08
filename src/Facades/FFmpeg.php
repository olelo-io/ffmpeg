<?php

namespace Olelo\FFmpeg\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string ffmpeg(string $uri, string $token)
 *
 *  @see \Olelo\FFmpeg\FFmpeg
 */
class FFmpeg extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ffmpeg';
    }
}
