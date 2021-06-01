<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PostDataTransfer extends DataTransferObject
{
    public $type;

    public $provider_id;

    public $provider_user_id;

    public $transaction_id;

    public $payment_amount;

    private static $notification_methods = [
        'INITIAL_BUY' => 'create',
        'DID_RENEW' => 'update',
        'DID_FAIL_TO_RENEW' => 'cancel',
        'CANCEL' => 'cancel',
    ];

    public static function fromAppleRequest(Request $request, int $providerId): self
    {
        return new self([
            'type' => self::$notification_methods[$request->input('notification_type')],
            'provider_id' => $providerId,
            'provider_user_id' => $request->input('user_id'),
            'transaction_id' => $request->input('transaction_id'),
            'payment_amount' => $request->input('payment_amount'),
        ]);
    }
}
