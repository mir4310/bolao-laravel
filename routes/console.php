<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Bloqueia partidas que iniciam em até 60 minutos — roda a cada 15 minutos
Schedule::command('games:lock-starting')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->runInBackground();
