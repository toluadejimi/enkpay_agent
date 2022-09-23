<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Reference
{
    public static function signature(string $reference = null): string
    {
        $secret = config('services.vulte.secret');
        $request_ref = $reference ?? self::transactionRef();

        return md5("{$request_ref};{$secret}");
    }

    public static function requestRef(): string
    {
        return self::reference('RQ');
    }

    public static function transactionRef(): string
    {
        return self::reference('TR');
    }

    public static function mode(): string
    {
        return config('services.vulte.mode');
    }

    public static function blindIndex(string $reference): string
    {
        return md5(Str::upper($reference));
    }

    public static function apiKey(): string
    {
        return config('services.vulte.api_key');
    }

    protected static function reference(string $alpha = 'ENKPAY'): string
    {
        return "{$alpha}|" . Carbon::now()->format('YmdHms') . '|' . mt_rand(10, 99) . substr(time(), 6);
    }
}
