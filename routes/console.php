<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('worktrack:about', function () {
    $this->comment('WorkTrack Employee Daily Work & Performance System');
})->purpose('Display WorkTrack project information');
