<?php

Illuminate\Support\Facades\Route::post(config('filament-unlayer.upload.url'), config('filament-unlayer.upload.class'))->middleware(config('filament-unlayer.upload.middlewares'))->name(config('filament-unlayer.upload.url_name'));