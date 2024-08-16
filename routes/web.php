<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->middleware('auth');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/examples/blade', [ExampleController::class, 'blade'])->name('examples.blade');
    Route::get('/examples/vue', [ExampleController::class, 'vue'])->name('examples.vue');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('users/{user}/roles/edit', [UserController::class, 'editRoles'])->name('users.edit_roles');
    Route::put('users/{user}/roles', [UserController::class, 'updateRoles'])->name('users.update_roles');
    Route::resource('users', UserController::class);
    Route::get('roles/{role}/permissions/edit', [RoleController::class, 'editPermissions'])->name('roles.edit_permissions');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update_permissions');
    Route::resource('roles', RoleController::class);

    Route::resource('courses', CourseController::class);
    Route::get('api/modules/{course}', [ModuleController::class, 'indexJson'])->name('api.modules.index_json');
    Route::resource('modules', ModuleController::class);
    Route::resource('lessons', LessonController::class);
});

require __DIR__ . '/auth.php';
