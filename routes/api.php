<?php

use App\Di\DependencyContainer;
use App\Http\Controllers\User\UserController;
use App\Services\Test\Abstract\ITestService;
use App\Services\Test\TestService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $dispatcher = new \App\Queue\Dispatcher(new \App\Queue\Queue);

    $dispatcher->dispatch(new \App\Queue\TestJobes\TestJob('Имя', 'Фамилия'));
    $dispatcher->dispatch(new \App\Queue\TestJobes\CoolTestJob);
    $dispatcher->dispatch(new \App\Queue\TestJobes\TestJob('Имя', 'Фамилия'));

//    $di = new DependencyContainer;
//
//    $di->bind(ITestService::class, fn () => TestService::class);
//
//    dd(
//        $di->get(UserController::class)->show(1),
//        $di->get(UserController::class)->test()
//    );
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
