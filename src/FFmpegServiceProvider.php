<?php

namespace Olelo\FFmpeg;

use Illuminate\Support\ServiceProvider;

class FFmpegServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ffmpeg.php' => base_path('config/ffmpeg.php')
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ffmpeg.php', 'ffmpeg');

        $this->app->bind('ffmpeg', function(){
            return new FFmpeg(config('ffmpeg.api.token'), config('ffmpeg.api.uri'));
        });
    }
}