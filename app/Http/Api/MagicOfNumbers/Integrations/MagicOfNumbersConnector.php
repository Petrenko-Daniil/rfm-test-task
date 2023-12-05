<?php

namespace App\Http\Api\MagicOfNumbers\Integrations;

use App\Http\Api\MagicOfNumbers\Requests\GetBearerTokenRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Exception;
use JsonException;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class MagicOfNumbersConnector extends Connector
{
    use AlwaysThrowOnErrors;

    //Позволяет нам при устаревании токена обновить его и повторить запрос
    public ?int $tries = 2;

    protected string $token = '';

    /**
     * @throws Exception
     */
    public function __construct($token = null)
    {
        if ($token === null) {
            $this->token = \Cache::remember('magicOfNumbersBearerToken', 60 * 60, function () {
                return $this->getBearerToken();
            });
        }
        $this->withTokenAuth($this->token, 'Bearer');
    }

    public function hasRequestFailed(Response $response): ?bool
    {
        //обновляем Bearer токен
        if ($response->status() === 400) {
            \Cache::forget('magicOfNumbersBearerToken');
            $this->token = \Cache::remember('magicOfNumbersBearerToken', 60 * 60, function () {
                return $this->getBearerToken();
            });
            $this->withTokenAuth($this->token, 'Bearer');
        }
        return str_contains($response->body(), 'Server Error');
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Exception
     * @throws JsonException
     */
    protected function getBearerToken(): string
    {
        $username = (string)config('apidata.magicofnumbers.username');
        $password = (string)config('apidata.magicofnumbers.password');
        $getBearerTokenRequest = new GetBearerTokenRequest($username, $password);
        $response = $this->send($getBearerTokenRequest);
        if (isset($response->json()['access_token']))
            return $response->json()['access_token'];
        throw new Exception('Response of remote API does not contain access_token', 500);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://app.magic-of-numbers.ru/api';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
