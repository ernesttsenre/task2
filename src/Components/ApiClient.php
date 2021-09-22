<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Components;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(string $path): array
    {
        $response = $this->client->request('GET', $path);

        return $this->convertResponseJsonToArray($response);
    }

    public function post(string $path, array $body): array
    {
        $response = $this->client->post($path, [
            'form_params' => $body
        ]);

        return $this->convertResponseJsonToArray($response);
    }

    public function put(string $path, array $body): array
    {
        $response = $this->client->put($path, [
            'form_params' => $body
        ]);

        return $this->convertResponseJsonToArray($response);
    }

    private function convertResponseJsonToArray(ResponseInterface $response): array
    {
        return json_decode((string) $response->getBody(), true);
    }
}
