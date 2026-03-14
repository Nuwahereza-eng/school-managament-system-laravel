<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
    if (Auth::check()){
        return Redirect::to('/dashboard');
    }
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::prefix('classroom')->middleware(['auth'])->group(function () {
    Route::get('', [ClassroomController::class, 'index'])->name('classroom.index');
    Route::get('create', [ClassroomController::class, 'create'])->name('classroom.create');
    Route::post('store', [ClassroomController::class, 'store'])->name('classroom.store');
    Route::get('show/{id}', [ClassroomController::class, 'show'])->name('classroom.show');
    Route::get('edit/{id}', [ClassroomController::class, 'edit'])->name('classroom.edit');
    Route::post('update/{id}', [ClassroomController::class, 'update'])->name('classroom.update');
    Route::delete('delete/{id}', [ClassroomController::class, 'destroy'])->name('classroom.destroy');
});

Route::prefix('teacher')->middleware(['auth'])->group(function () {
    Route::get('', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('show/{id}', [TeacherController::class, 'show'])->name('teacher.show');
    Route::get('edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit');
    Route::post('update/{id}', [TeacherController::class, 'update'])->name('teacher.update');
    Route::delete('delete/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy');
    Route::get('ajax/fetchSubjects/{id}', [TeacherController::class, 'getSubjects'])->name('teacher.getSubjects');
});

Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::get('', [StudentController::class, 'index'])->name('student.index');
    Route::get('create', [StudentController::class, 'create'])->name('student.create');
    Route::post('store', [StudentController::class, 'store'])->name('student.store');
    Route::get('show/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('delete/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
});

Route::prefix('subject')->middleware(['auth'])->group(function () {
    Route::get('', [SubjectController::class, 'index'])->name('subject.index');
    Route::get('create', [SubjectController::class, 'create'])->name('subject.create');
    Route::post('store', [SubjectController::class, 'store'])->name('subject.store');
    Route::get('show/{id}', [SubjectController::class, 'show'])->name('subject.show');
    Route::get('edit/{id}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('update/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('delete/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy');
});

Route::prefix('manager')->middleware(['auth'])->group(function () {
    Route::get('', [UserController::class, 'index'])->name('manager.index');
    Route::get('create', [UserController::class, 'create'])->name('manager.create');
    Route::post('store', [UserController::class, 'store'])->name('manager.store');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('manager.edit');
    Route::post('update/{id}', [UserController::class, 'update'])->name('manager.update');
    Route::delete('delete/{id}', [UserController::class, 'destroy'])->name('manager.destroy');
});

require __DIR__.'/auth.php';
