<?php

use App\Http\Controllers\StudentController;
use App\Models\Student;
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

Route::get('/', [StudentController:: class, 'index']);
Route::post('/add-student', [StudentController::class, 'addStudent'])->name('add_student');
Route::get('/show-student', [StudentController::class, 'showStudent'])->name('show_student');
Route::get('/get-student-data', [StudentController::class, 'getStudentData'])->name('get_student_data');
Route::post('/update-student', [StudentController::class, 'updateStudent'])->name('update_student');
Route::post('/delete-student', [StudentController::class, 'deleteStudent'])->name('delete_student');
