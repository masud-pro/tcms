<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptionController;


Route::get("options/reset-frontpage-image",[OptionController::class,'reset_frontpage_image'])->name("options.reset-frontpage-image");









