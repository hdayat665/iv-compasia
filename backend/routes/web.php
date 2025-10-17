<?php

use App\Jobs\UploadQueueJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-job', function () {
    UploadQueueJob::dispatch();
    return 'job dispatch';
});
