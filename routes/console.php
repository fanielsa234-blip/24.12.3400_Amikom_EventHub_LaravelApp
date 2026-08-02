<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Pendaftaran Scheduler Otomatis Pelepasan Reservasi Expired (Bagian 3)
Schedule::command('app:release-expired-reservations')->everyFiveMinutes();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
