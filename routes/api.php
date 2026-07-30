<?php

use App\Enums\Stage;
use App\Http\Controllers\ZohoController;

Route::post('/zoho/lead-deal', [ZohoController::class, 'store'])->middleware('throttle:10,1');

Route::get('/stages', function () {
    return response()->json(Stage::options());
});
