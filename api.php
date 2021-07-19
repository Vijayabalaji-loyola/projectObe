<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('auth')->group(function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('/me', [\App\Http\Controllers\AuthController::class, 'me']);
    Route::post('/role', [\App\Http\Controllers\AuthController::class, 'role']);
    Route::post('/isLogin', [\App\Http\Controllers\AuthController::class, 'isLogin']);
});

Route::middleware(['superadmin', 'auth'])->group(function () {
    Route::post('/add-course', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'addCourse']);
    Route::get('/get-courseList', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'getCourse']);
    Route::post('/add-vission-mission', [\App\Http\Controllers\VissionMissionController::class, 'addVissionMission']);
    Route::post('/add-school', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'addSchool']);
    Route::get('/get-school', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'getSchool']);
    Route::put('/edit-school/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'editSchool']);
    Route::delete('/delete-school/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'deleteSchool']);
    Route::post('/add-departmentNprogram', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'addDepartmentAndProgram']);
    Route::get('/get-departmentNprogram', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'getDepartmentAndProgram']);
    Route::put('/edit-department/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'editDepartment']);
    Route::delete('/delete-department/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'deleteDepartment']);
    Route::put('/edit-program/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'editProgram']);
    Route::delete('/delete-program/{id}', [\App\Http\Controllers\SuperAdmin\CourseController::class, 'deleteProgram']);

});

Route::middleware(['hod', 'auth'])->group(function () {
    Route::get('/get-course-code', [\App\Http\Controllers\Hod\CourseController::class, 'getCourse']);
    Route::get('/get-syllabus-course', [\App\Http\Controllers\Hod\CourseController::class, 'getSyllabusCourse']);

    Route::get('/get-assigned-courses', [\App\Http\Controllers\Hod\CourseController::class, 'syllabusAssigned']);

    Route::post('/add-syllabus-course', [\App\Http\Controllers\Hod\CourseController::class, 'addCourse']);
    Route::post('assign-staff-syllabus', [\App\Http\Controllers\Hod\CourseController::class, 'assignSyllabus']);
});

Route::middleware('auth')->group(function () {
    Route::get('/getStaffDetails', [\App\Http\Controllers\Controller::class, 'getStaffDetails']);
    Route::get('/assigned-syllabus', [\App\Http\Controllers\Controller::class, 'getSyllabusAssigned']);
});

Route::get('/getDepartments', [\App\Http\Controllers\Controller::class, 'getDepartments']);
Route::get('/getRoles', [\App\Http\Controllers\Controller::class, 'getRoles']);

// Route::group(function(){
//     Route::post('/add-mark',[\App\Http\Controllers\CourseOutcomeController::class,'addMark']);
// });
