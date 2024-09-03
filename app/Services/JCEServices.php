<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JCEServices
{
    private $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(env('BASE_URL_JCE'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ]);
    }

    public function getPerson($identification)
    {
        try {
            $response = $this->client->get('/jce/api/citizen/'.$identification);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException|\Exception $e) {
            Log::error($e->getMessage());
            return ['msg' => $e->getMessage()];
        }
    }

}
