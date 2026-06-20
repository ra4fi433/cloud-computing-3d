<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;
use App\Models\Document;
use App\Jobs\SendTelegramNotification;
use Illuminate\Support\Facades\Artisan;

// Perintah bawaan Laravel untuk inspirasi
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:test-job')->everySecond();

// Scheduler untuk mengirim pesan Telegram


