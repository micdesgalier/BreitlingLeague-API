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
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\UserAttemptController;
use App\Http\Controllers\API\UserAttemptQuestionController;
use App\Http\Controllers\API\UserAttemptChoiceController;
use App\Http\Controllers\API\UserActivityGroupActivityController;
use App\Http\Controllers\API\UserActivityGroupActivityResultController;
use App\Http\Controllers\API\ActivityResultController;
use App\Http\Controllers\API\QuizActivityResultController;
use App\Http\Controllers\API\QuizAttemptQuestionController;

Route::apiResource('users',                                UserController::class);
Route::apiResource('challenges',                           ChallengeController::class);
Route::apiResource('quizzes',                              QuizController::class);
Route::apiResource('stages',                               StageController::class);
Route::apiResource('pools',                                PoolController::class);
Route::apiResource('pool-questions',                       PoolQuestionController::class);
Route::apiResource('questions',                            QuestionController::class);
Route::apiResource('choices',                              ChoiceController::class);
Route::apiResource('user-attempts',                        UserAttemptController::class);
Route::apiResource('user-attempt-questions',               UserAttemptQuestionController::class);
Route::apiResource('user-attempt-choices',                 UserAttemptChoiceController::class);

Route::apiResource('user-activity-group-activities',       UserActivityGroupActivityController::class);

// On définit un paramètre plus court pour éviter >32 caractères
Route::apiResource(
    'user-activity-group-activity-results',
    UserActivityGroupActivityResultController::class
)->parameters([
    'user-activity-group-activity-results' => 'user-activity-group-r'
]);

Route::post(
    'quizzes/{quiz}/questions/{question}/answer',
    [QuizAttemptQuestionController::class, 'storeOrStart']
)->name('quizzes.attempts.questions.answer');

Route::apiResource('activity-results',                     ActivityResultController::class);
Route::apiResource('quiz-activity-results',                QuizActivityResultController::class);