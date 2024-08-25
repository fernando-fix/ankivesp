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
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

require __DIR__ . '/auth.php';

// Normal logged routes
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('courses', CourseController::class)->only(['index']);
    Route::get('/lessons/last-watched', [LessonController::class, 'showLastWatched'])->name('lessons.last-watched');
    Route::resource('lessons', LessonController::class)->only(['show']);
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
        Route::get('api/modules/{course}', [AdminModuleController::class, 'indexJson'])->name('api.modules.index_json');
        Route::resource('modules', AdminModuleController::class);
        Route::resource('lessons', AdminLessonController::class);
    });
