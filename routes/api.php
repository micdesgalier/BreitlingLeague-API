<?php
// routes/api.php

use App\Http\Controllers\API\ChallengeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('challenges', ChallengeController::class);