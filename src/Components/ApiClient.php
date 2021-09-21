<?php declare(strict_types=1);

namespace Ernesttsenre\CommentService\Components;

use GuzzleHttp\Client;

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

        return json_decode((string) $response->getBody(), true);
    }

    public function post(string $path, array $body): array
    {
        $response = $this->client->post($path, [
            'form_params' => $body
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function put(string $path, array $body): array
    {
        $response = $this->client->put($path, [
            'form_params' => $body
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
