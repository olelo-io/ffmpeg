<?php

namespace Olelo\FFmpeg;

use Illuminate\Support\Str;
use Olelo\FFmpeg\Exceptions\FFmpegException;

use GuzzleHttp\Client;

class FFmpeg
{
    protected $uri;
    protected $token;

    protected $defaultUri = 'https://ffmpeg.olelo.io/api/v1/';

    public function __construct($token = null, $uri = null)
    {
        if(is_null($uri)) {
            $uri = $this->defaultUri;
        }

        if(!$this->isValidUrl($uri)) {
            throw new FFmpegException('"' . $uri . '" is not a valid URL.');
        }

        if(!($token)) {
            throw new FFmpegException('You need to configure a token.');
        }

        $this->uri = $uri;
        $this->token = $token;
    }

    /**
     * Convert a given file.
     *
     * @param $uri
     * @param $commands
     * @param null $targetFormat
     * @return string
     */
    public function convert($uri, $commands, $targetFormat = null)
    {
        $commands = is_array($commands) ? $commands : [$commands];

        $data = [
            'file' => $uri,
            'commands' => $commands,
        ];

        if($targetFormat) {
            $data['targetFormat'] = $targetFormat;
        }

        return $this->getResult('conversions', $data);
    }

    /**
     * Concatenate given files
     *
     * @param $files
     * @param $pause
     * @return mixed
     */
    public function concatenate($files, $pause = 0)
    {
        return $this->getResult('concatenations', [
            'files' => $files,
            'pause' => $pause
        ]);
    }

    /**
     * Determine if the given path is a valid URL.
     *
     * @param  string  $path
     * @return bool
     */
    public function isValidUrl($path)
    {
        if (! preg_match('~^(#|//|https?://|mailto:|tel:)~', $path)) {
            return filter_var($path, FILTER_VALIDATE_URL) !== false;
        }

        return true;
    }

    protected function getResult($endpoint, $data)
    {
        $client = new Client([
            'base_uri' => $this->uri,
        ]);

        $requestData['headers'] = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ];

        $requestData['json'] = $data;

        $response = $client->post($endpoint, $requestData)->getBody()->getContents();

        return $this->isApiVersionV1() ? $response : json_decode($response, true);
    }

    protected function isApiVersionV1()
    {
        return Str::contains($this->uri, '/v1/');
    }
}