<?php

namespace App\Http\Controllers;

use App\Http\Api\MagicOfNumbers\Integrations\MagicOfNumbersConnector;
use App\Http\Api\MagicOfNumbers\MagicOfNumbersApi;
use App\Http\Api\MagicOfNumbers\Models\Report;
use App\Http\Api\MagicOfNumbers\Requests\GetBearerTokenRequest;
use Inertia\Inertia;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use JsonException;
use Exception;

class IndexController extends Controller
{
    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     * @throws Exception
     */
    public function index()
    {
        $api = new MagicOfNumbersApi();

        //get reports
        $reportsRepository = $api->getReports();

        //find report and fetch additional data
        /** @var Report $rfmReport */
        $rfmReport = $reportsRepository->getReports()->where('name', 'get_segment_rfm')->first();
        if (!$rfmReport) {
            return response('Remote endpoint has no get_segment_rfm report', 404);
        }
        $rfmReport->setExpandedResults(
            $api->getReportExpandedData($rfmReport->id)
        );

        $rfmReport->prepareForView();

        //return view
        return Inertia::render('Index', [
            'report' => $rfmReport
        ]);
    }
}
