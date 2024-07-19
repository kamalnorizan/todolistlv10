<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyFirstController;


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
// DB::listen(function ($event) {
//     dump($event->sql);
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mylaravel/{nama?}', function($nama='Amir'){
    $umur = 19;
    return view('mylaravel',compact('nama','umur'));
});

Route::get('aboutus/{namakementerian}', [MyFirstController::class,'aboutus']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/{id}/edit', [UserController::class, 'edit']);

Route::get('tasks',[TaskController::class,'index'])->name('tasks.index');
Route::post('tasks/ajaxloadtasks',[TaskController::class,'ajaxloadtasks'])->name('tasks.ajaxloadtasks');
Route::get('tasks/create', [TaskController::class,'create'])->name('tasks.create');
Route::post('tasks', [TaskController::class,'store'])->name('tasks.store');
Route::get('tasks/{task}',[TaskController::class,'show'])->name('tasks.show');
Route::post('tasks/ajaxloadtask', [TaskController::class,'ajaxloadtask'])->name('tasks.ajaxloadtask');
Route::post('tasks/update', [TaskController::class,'update'])->name('tasks.update');
Route::post('tasks/delete', [TaskController::class,'delete'])->name('tasks.delete');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
