<?php

namespace App\Http\Controllers;

use App\Constants\SubscriptionStatus;
use App\Http\Requests\PostDataTransfer;
use App\Service\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebHookController extends Controller
{
    private $subscriptionService;

    private $subscriptionConstants;

    public function __construct(SubscriptionService $subscriptionService, SubscriptionStatus $subscriptionConstants)
    {
        $this->subscriptionService = $subscriptionService;
        $this->subscriptionConstants = $subscriptionConstants;
    }

    public function webHookSubscriber(Request $request, int $id): JsonResponse
    {
        $requestData = PostDataTransfer::fromAppleRequest($request, $id);

        switch ($requestData->type) {
            case  $this->subscriptionConstants::CREATE :
                $this->subscriptionService->create($requestData);
                break;
            case $this->subscriptionConstants::UPDATE :
                $this->subscriptionService->update($requestData);
                break;
            case $this->subscriptionConstants::CANCEL :
                $this->subscriptionService->cancel($requestData);
                break;
            default:
                return response()->json([], 500);
        }

        return response()->json([]);
    }
}
