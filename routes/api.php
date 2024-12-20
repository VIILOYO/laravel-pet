<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $dispatcher = new \App\Queue\Dispatcher(new \App\Queue\Queue);

    $dispatcher->dispatch(new \App\Queue\TestJobes\TestJob('Имя', 'Фамилия'));
    $dispatcher->dispatch(new \App\Queue\TestJobes\CoolTestJob);
    $dispatcher->dispatch(new \App\Queue\TestJobes\TestJob('Имя', 'Фамилия'));
});

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::post('/', [UserController::class, 'create'])->name('create');
    Route::get('/', [UserController::class, 'list'])->name('list');

    Route::group(['prefix' => '{user_id}'], function () {
        Route::get('/', [UserController::class, 'show'])->name('show');
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::delete('/', [UserController::class, 'delete'])->name('delete');
    });
});
