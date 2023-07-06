<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\SubjectsController;



Route::prefix('user')->group(function(){

    Route::prefix('program')->middleware('auth:user') ->controller(ProgramController::class)->group(function(){

        Route::get('/ProgramOfTheYear','index');
        Route::get('/downloadProgram','download');
        Route::get('/years','getYears');
        Route::get('/subjectsByYear/{id}','programs');
    });
    Route::prefix('subjects')->middleware('auth:user')->controller(SubjectsController::class)->group(function(){
        Route::get('/','index');
        Route::post('add','store');
        Route::get('/toDayLectures','toDayLectures');
        Route::get('users-Attended','usersAttended');
        Route::post('Attendance-Registration','attendanceRegistration');
    });
    Route::prefix('auth')->controller(AuthUserController::class)->group(function(){

        Route::post('/sign-up','store');
        Route::post('/sign-in','login');

        Route::group(['middleware'=>'auth:user'],function(){
            Route::get('/profile','show');
            Route::put('/edit','update')->name('updateProfile');
        });

    });

});

Route::prefix('admin')->group(function(){

    Route::controller(AuthController::class)->group(function(){

        Route::post('/login','auth');

    });
    Route::prefix('program')->middleware('auth:admin')->controller(ProgramController::class)->group(function(){

        Route::get('subjects-registration','subjects_registration');

        Route::get('student-registration','student_registration');

        Route::post('create','store');

        Route::get('/years','getYears');

        Route::get('/ProgramOfTheYear','index');

        Route::get('toDayLecs','todayLectures');

        Route::post('/upload','uploadFile')->name('uploadProgram');

        Route::post('/delete','destroy');

        Route::post('/update','edit')->name('editProgram');

    });
});
