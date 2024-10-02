<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionListController;
use App\Http\Controllers\WatchedController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

require __DIR__ . '/auth.php';

// Normal logged routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('courses', CourseController::class)->only(['index']);
    Route::resource('questions', QuestionController::class);
    Route::resource('reviews', QuestionListController::class)->parameter('reviews', 'questionList');
    Route::post('reviews/by-lesson/{lesson}', [QuestionListController::class, 'reviewByLesson'])->name('reviews.by-lesson');
    Route::get('/reviews/{questionList}/first-question', [QuestionListController::class, 'showFirstQuestion'])->name('reviews.first-question');
    // lista de questões
    Route::get('/reviews/{questionList}/question/{question}', [QuestionListController::class, 'answerQuestions'])->name('reviews.answer-questions');
    Route::post('/reviews/check-answer/{questionListItem}', [QuestionListController::class, 'checkAnswer'])->name('reviews.check-answer');
    Route::post('/reviews/check-all-answers/{questionList}', [QuestionListController::class, 'checkAllAnswers'])->name('reviews.check-all-answers');
    Route::get('/lessons/last-watched/{course}', [LessonController::class, 'showLastWatched'])->name('lessons.last-watched');
    Route::resource('lessons', LessonController::class)->only(['show']);
    Route::get('/markWatched/{lesson}', [WatchedController::class, 'markWatched'])->name('markWatched');
    Route::get('/markUnWatched/{lesson}', [WatchedController::class, 'markUnWatched'])->name('markUnWatched');
    Route::resource('profiles', ProfileController::class);
});

// Admin routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {
        // Logs
        Route::get('logs', [LogViewerController::class, 'index'])->middleware(['can:visualizar_logs']);
        // Users
        Route::get('users/{user}/roles/edit', [AdminUserController::class, 'editRoles'])->name('users.edit_roles');
        Route::put('users/{user}/roles', [AdminUserController::class, 'updateRoles'])->name('users.update_roles');
        Route::resource('users', AdminUserController::class);
        // Roles
        Route::get('roles/{role}/permissions/edit', [AdminRoleController::class, 'editPermissions'])->name('roles.edit_permissions');
        Route::put('roles/{role}/permissions', [AdminRoleController::class, 'updatePermissions'])->name('roles.update_permissions');
        Route::resource('roles', AdminRoleController::class);
        // Courses, Modules and Lessons
        Route::resource('courses', AdminCourseController::class);
        Route::get('json/modules/{course}', [AdminModuleController::class, 'indexJson'])->name('json.modules.index_json');
        Route::get('json/lessons/{module}', [AdminLessonController::class, 'indexJson'])->name('json.lessons.index_json');
        Route::resource('modules', AdminModuleController::class);
        Route::resource('lessons', AdminLessonController::class);

        Route::get('/rota-de-fuga', function () {
            Illuminate\Support\Facades\Schema::table('question_user', function ($table) {
                $table->float('score');
            });
        });
    });
