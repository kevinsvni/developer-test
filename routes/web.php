<?php

use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layout');
});

Route::get('/users/{user}/achievements', [AchievementsController::class, 'index'])->name('achievements');


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('post-login', [LoginController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [LoginController::class, 'registration'])->name('register');
Route::post('post-registration', [LoginController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [LoginController::class, 'dashboard']); 
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('lessons', [LessonController::class, 'index'])->name('lesson');
Route::get('complete-lesson/{lessonId}', [LessonController::class, 'completeLesson'])->name('complete.lesson');

Route::get('comments', [CommentController::class, 'index'])->name('comments');
Route::post('post-comment', [CommentController::class, 'postComment'])->name('comment.post'); 
