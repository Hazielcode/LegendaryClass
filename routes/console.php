<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Registrar comandos de gamificación
Artisan::command('gamification:setup {--fresh} {--demo}', function () {
    $setupCommand = new \App\Console\Commands\SetupGamificationCommand();
    $setupCommand->setLaravel($this->laravel);
    return $setupCommand->handle();
})->purpose('Setup the gamification system with initial data');