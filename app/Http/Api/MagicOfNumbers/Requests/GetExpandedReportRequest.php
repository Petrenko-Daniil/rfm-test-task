<?php

namespace App\Http\Api\MagicOfNumbers\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetExpandedReportRequest extends Request
{

    protected Method $method = Method::GET;
    protected string|int $id;

    public function __construct(string|int $id)
    {
        $this->id = $id;
    }

    public function resolveEndpoint(): string
    {
        return '/report/' . $this->id . '/run';
    }
}
