<?php

namespace App\Http\Api\MagicOfNumbers;

use App\Http\Api\MagicOfNumbers\Integrations\MagicOfNumbersConnector;
use App\Http\Api\MagicOfNumbers\Models\Report;
use App\Http\Api\MagicOfNumbers\Repositories\ReportsRepository;
use App\Http\Api\MagicOfNumbers\Requests\GetExpandedReportRequest;
use App\Http\Api\MagicOfNumbers\Requests\GetReportsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use JsonException;
use Exception;

class MagicOfNumbersApi
{
    protected MagicOfNumbersConnector $connector;

    public function __construct()
    {
        $this->connector = new MagicOfNumbersConnector();
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     * @throws Exception
     */
    public function getReports(): ReportsRepository
    {
        $request = new GetReportsRequest();
        $response = $this->connector->send($request);
        $data = $response->json();
        return new ReportsRepository($data['grouped']['General']);
    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    public function getReportExpandedData(string|int $id): array
    {
        $request = new GetExpandedReportRequest($id);
        $response = $this->connector->send($request);
        return $response->json();
    }
}
