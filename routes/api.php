<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChallengeController;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\StageController;
use App\Http\Controllers\API\PoolController;
use App\Http\Controllers\API\PoolQuestionController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ChoiceController;
use App\Http\Controllers\API\UserAttemptController;
use App\Http\Controllers\API\UserAttemptQuestionController;
use App\Http\Controllers\API\UserAttemptChoiceController;

Route::apiResource('challenges',                  ChallengeController::class);
Route::apiResource('quizzes',                     QuizController::class);
Route::apiResource('stages',                      StageController::class);
Route::apiResource('pools',                       PoolController::class);
Route::apiResource('pool-questions',              PoolQuestionController::class);
Route::apiResource('questions',                   QuestionController::class);
Route::apiResource('choices',                     ChoiceController::class);
Route::apiResource('user-attempts',               UserAttemptController::class);
Route::apiResource('user-attempt-questions',      UserAttemptQuestionController::class);
Route::apiResource('user-attempt-choices',        UserAttemptChoiceController::class);