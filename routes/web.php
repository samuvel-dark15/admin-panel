<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\FieldController;
use App\Http\Controllers\SuperAdmin\BlogFieldController;
use App\Http\Controllers\SuperAdmin\BlogController;
use App\Http\Controllers\SuperAdmin\EmployeeController;
use App\Http\Controllers\Frontend\BlogController as FrontBlogController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED DASHBOARDS
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('superadmin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMINS
        |--------------------------------------------------------------------------
        */
        Route::resource('admins', AdminController::class);

        Route::put(
            'admins/{admin}/status',
            [AdminController::class, 'toggleStatus']
        )->name('admins.status');

        Route::post(
            'admins/{admin}/add-column',
            [AdminController::class, 'addColumn']
        )->name('admins.addColumn');

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE FIELD SYSTEM
        |--------------------------------------------------------------------------
        */
        Route::resource('fields', FieldController::class);

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEES (DYNAMIC DATA)
        |--------------------------------------------------------------------------
        */
        Route::resource('employees', EmployeeController::class)
            ->only(['index', 'create', 'store']);

        Route::get(
            'employees/view/{createdAt}',
            [EmployeeController::class, 'show']
        )->name('employees.show');

        Route::get('/superadmin/employees/{id}/edit', 
    [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'edit']
)->name('employees.edit');

Route::post('/superadmin/employees/{id}/update', 
    [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'update']
)->name('employees.update');


        /*
        |--------------------------------------------------------------------------
        | BLOG FIELD SYSTEM
        |--------------------------------------------------------------------------
        */
        Route::resource('blog-fields', BlogFieldController::class)
            ->only(['index', 'create', 'store']);

        /*
        |--------------------------------------------------------------------------
        | BLOGS
        |--------------------------------------------------------------------------
        */
        Route::resource('blogs', BlogController::class);
    });

/*
|--------------------------------------------------------------------------
| FRONTEND BLOG ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/blogs', [FrontBlogController::class, 'index'])
    ->name('frontend.blogs');

Route::get('/blogs/{blog}', [FrontBlogController::class, 'show'])
    ->name('frontend.blog.show');
