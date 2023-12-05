<?php

namespace App\Http\Api\MagicOfNumbers\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBearerTokenRequest extends Request
{

    private string $username;
    private string $password;

    protected Method $method = Method::GET;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function resolveEndpoint(): string
    {
        return '/user/token';
    }

    protected function defaultQuery(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
