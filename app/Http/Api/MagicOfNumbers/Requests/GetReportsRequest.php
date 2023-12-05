<?php

namespace App\Http\Api\MagicOfNumbers\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetReportsRequest extends Request
{

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/reports';
    }
}
