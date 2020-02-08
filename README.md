# olelo FFmpeg - Helper
This is a little helper to easily call [olelo FFmpeg](https://www.olelo.io/ffmpeg) in your PHP projects. 

## Prerequisites
You need an olelo account and the FFmpeg module enabled. 

## Installation
You can install the package via composer:
```
composer require olelo/ffmpeg
```

If you use Laravel, add your olelo-FFmpeg token to .env as `FFMPEG_API_TOKEN`.

## Usage
```
$ffmpeg = new \Olelo\FFmpeg\FFmpeg('yourApiToken');
$convertedFile = $ffmpeg->convert('https://your-url.com/something', 'remove-silence'); 
```

#### Laravel
A Laravel service provider with a facade is contained in this package. It is automatically detected. You can use it like:
```
use Olelo\FFmpeg\Facades\FFmpeg;

$convertedFile = FFmpeg::convert('https://your-url.com/something', 'remove-silence');
```
