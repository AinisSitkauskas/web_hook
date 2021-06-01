<?php

namespace App\Service;

use App\Http\Requests\PostDataTransfer;
use App\Models\Subscription;
use App\Models\Transaction;

class SubscriptionService
{
    const SUBSCRIPTION = '30 days';

    public function create(PostDataTransfer $requestObject): Subscription
    {
        $subscription = Subscription::create([
            'provider_id' => $requestObject->provider_id,
            'provider_user_id' => $requestObject->provider_user_id,
            'active' => true,
            'valid_until' => date('Y-m-d H:i:s', strtotime('+ ' . self::SUBSCRIPTION)),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        Transaction::create([
            'subscription_id' => $subscription->id,
            'provider_id' => $requestObject->provider_id,
            'provider_user_id' => $requestObject->provider_user_id,
            'provider_transaction_id' => $requestObject->transaction_id,
            'payed' => true,
            'payment_amount' => $requestObject->payment_amount,
            'payment_time' => date('Y-m-d H:i:s'),
        ]);

        return $subscription;
    }

    public function update(PostDataTransfer $requestObject): Subscription
    {
        $subscription = Subscription::where(['provider_id' => $requestObject->provider_id, 'provider_user_id' => $requestObject->provider_user_id])->first();

        if (is_null($subscription)) {
            throw new \Exception('SubscriptionStatus not found');
        }

        $subscriptionId = $subscription->id;
        $subscription->active = true;
        $subscription->valid_until = date('Y-m-d H:i:s', strtotime('+ ' . self::SUBSCRIPTION));
        $subscription->updated_at = date('Y-m-d H:i:s');
        $subscription->save();

        Transaction::create([
            'subscription_id' => $subscriptionId,
            'provider_id' => $requestObject->provider_id,
            'provider_user_id' => $requestObject->provider_user_id,
            'provider_transaction_id' => $requestObject->transaction_id,
            'payed' => true,
            'payment_amount' => $requestObject->payment_amount,
            'payment_time' => date('Y-m-d H:i:s'),
        ]);

        return $subscription;
    }

    public function cancel(PostDataTransfer $requestObject): Subscription
    {
        $subscription = Subscription::where(['provider_id' => $requestObject->provider_id, 'provider_user_id' => $requestObject->provider_user_id])->first();

        if (is_null($subscription)) {
            throw new \Exception('SubscriptionStatus not found');
        }

        $subscription->active = false;
        $subscription->updated_at = date('Y-m-d H:i:s');
        $subscription->save();

        return $subscription;
    }
}
