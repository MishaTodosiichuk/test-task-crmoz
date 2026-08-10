<?php

namespace App\Enums;

enum CacheEnum: string {
    case CACHE_KEY = 'zoho_access_token';
    public const int TOKEN_BUFFER = 60;
}
