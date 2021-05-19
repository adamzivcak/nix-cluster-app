<?php

use App\Http\Controllers;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DeploymentsController;
use App\Http\Controllers\ConfigfilesController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// Users management

Route::get('/users', [UsersController::class, 'index'])->middleware('auth');                // show list of users
Route::get('/users/create', [UsersController::class, 'create'])->middleware('auth');        // show form for creating new user
Route::post('/users', [UsersController::class, 'store'])->middleware('auth');               // submit creating new user
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->middleware('auth');     // show form for editing user
Route::put('/users/{user}', [UsersController::class, 'update'])->middleware('auth');        // submit editing user info
Route::delete('/users/{user}', [UsersController::class, 'destroy'])->middleware('auth');    // deleting user

// Deployments management

Route::get('/deployments', [DeploymentsController::class, 'index'])->middleware('auth');            // show list of deployments
Route::get('/deployments/create', [DeploymentsController::class, 'create'])->middleware('auth');    // show form for creating new deployment
Route::post('/deployments', [DeploymentsController::class, 'store'])->middleware('auth');           // submit creating new deployment
Route::get('/deployments/{deployment}/info', [DeploymentsController::class, 'info'])->middleware('auth');      // get info about an existing deployment
Route::get('/deployments/{deployment}/check', [DeploymentsController::class, 'check'])->middleware('auth');  // deploy an existing deployment
Route::post('/deployments/{deployment}/deploy', [DeploymentsController::class, 'deploy'])->middleware('auth');  // deploy an existing deployment
Route::post('/deployments/{deployment}/delete', [DeploymentsController::class, 'delete'])->middleware('auth');  // deploy an existing deployment
Route::post('/deployments/{deployment}/destroy', [DeploymentsController::class, 'destroy'])->middleware('auth');  // deploy an existing deployment

// Configuration files management

Route::get('/configfiles', [ConfigfilesController::class, 'index'])->middleware('auth');            // show list of configuration files
Route::get('/configfiles/create', [ConfigfilesController::class, 'create'])->middleware('auth');    // show form for creating new configuration file
Route::post('/configfiles', [ConfigfilesController::class, 'store'])->middleware('auth');               // submit creating new user
Route::get('/configfiles/{configfile}/show', [ConfigfilesController::class, 'show'])->middleware('auth');               // submit creating new user
Route::get('/configfiles/{configfile}/edit', [ConfigfilesController::class, 'edit'])->middleware('auth');               // submit creating new user
Route::put('/configfiles/{configfile}', [ConfigfilesController::class, 'update'])->middleware('auth');               // submit creating new user
Route::delete('/configfiles/{configfile}', [ConfigfilesController::class, 'destroy'])->middleware('auth');               // submit creating new user

// GET /users        - reading stuff
// GET /users/:id    - reading stuff
// GET /users/:id/edit    - edit stuff
// POST /users       - creating new stuff
// PUT /users/:id    - update
// DELETE /users/:id - delete


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
