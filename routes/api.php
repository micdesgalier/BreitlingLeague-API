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
use App\Http\Controllers\API\QuizAttemptController;
use App\Http\Controllers\API\QuizMatchController;
use App\Http\Controllers\API\QuizMatchParticipantController;
use App\Http\Controllers\API\QuizMatchQuestionController;
use App\Http\Controllers\API\QuizMatchAnswerController;

// On définit un paramètre plus court pour éviter >32 caractères
Route::apiResource(
    'user-activity-group-activity-results',
    UserActivityGroupActivityResultController::class
)->parameters([
    'user-activity-group-activity-results' => 'user-activity-group-r'
]);

Route::post('quizzes/start-quiz', [QuizAttemptController::class, 'startRandom'])
     ->name('quizzes.start_random');
Route::post(
    'quizzes/{quiz}/questions/{question}/answer',
    [QuizAttemptQuestionController::class, 'storeOrStart']
)->name('quizzes.attempts.questions.answer');
Route::post('/quizzes/{quiz}/end-quiz', [QuizAttemptController::class, 'endQuiz']);

Route::post('/quiz-matches/start-match', [QuizMatchController::class, 'startMatch']);
Route::get('/quiz-matches/{quizMatch}/details', [QuizMatchController::class, 'detailedShow']);
Route::get('/quiz-matches/{quizMatch}/next-turn', [QuizMatchController::class, 'getNextTurn']);
Route::post('/quiz-matches/{quizMatch}/questions/{question}/answer', [QuizMatchController::class, 'answerQuestion']);
Route::get('/quiz-matches/{quizMatch}/end-quiz-match', [QuizMatchController::class, 'endQuizMatch']);

Route::apiResource('activity-results',                     ActivityResultController::class);
Route::apiResource('quiz-activity-results',                QuizActivityResultController::class);

Route::get('users/ranking', [UserController::class, 'ranking']);
Route::get('users/{user}/quiz-match-list', [UserController::class, 'quizMatch']);

Route::apiResource('users', UserController::class)
     ->where(['user' => '[0-9]+']);
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

Route::apiResource('quiz-matches',                         QuizMatchController::class);
Route::apiResource('quiz-match-participants',              QuizMatchParticipantController::class);
Route::apiResource('quiz-match-questions',                 QuizMatchQuestionController::class);
Route::apiResource('quiz-match-answers',                   QuizMatchAnswerController::class);