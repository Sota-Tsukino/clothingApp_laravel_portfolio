<?php

use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BodyMeasurementController;
use App\Http\Controllers\BodyCorrectionController;
use App\Http\Controllers\FittingToleranceController;
use App\Http\Controllers\SizeCheckerController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// user用ルート
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('/measurement', BodyMeasurementController::class);

    Route::get('/correction/{correction}/edit', [BodyCorrectionController::class, 'edit'])->name('correction.edit');
    Route::put('/correction/{correction}', [BodyCorrectionController::class, 'update'])->name('correction.update');

    Route::get('/tolerance', [FittingToleranceController::class, 'index'])->name('tolerance.index');
    Route::get('/tolerance/edit', [FittingToleranceController::class, 'edit'])->name('tolerance.edit');
    Route::put('/tolerance/update', [FittingToleranceController::class, 'update'])->name('tolerance.update');


});

// admin用ルート
Route::middleware(['auth', 'verified', 'role:admin']) // ← 管理者のみ通す　
    ->prefix('admin') // URLの先頭にadminをつける
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('/measurement', BodyMeasurementController::class);

        // Route::get('/correction', [BodyCorrectionController::class, 'show'])->name('correction.show');
        Route::get('/correction/{correction}/edit', [BodyCorrectionController::class, 'edit'])->name('correction.edit');
        Route::put('/correction/{correction}', [BodyCorrectionController::class, 'update'])->name('correction.update');

        // Route::resource('/tolerance', FittingToleranceController::class)->except('destroy', 'show');
        Route::get('/tolerance', [FittingToleranceController::class, 'index'])->name('tolerance.index');
        Route::get('/tolerance/edit', [FittingToleranceController::class, 'edit'])->name('tolerance.edit');
        Route::put('/tolerance/update', [FittingToleranceController::class, 'update'])->name('tolerance.update');

        Route::get('/size-checker', [SizeCheckerController::class, 'index'])->name('sizechecker.index');

        Route::resource('/clothing-item', ItemController::class);

        //adminのみユーザー管理権原
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    });

    Route::get('/phpinfo', function() {
        phpinfo();
    });

// Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
// Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
// Route::get('/servicecontainertest', [LifeCycleTestController::class, 'showServiceContainerTest']);
// Route::get('/serviceprovidertest', [LifeCycleTestController::class, 'showServiceProviderTest']);


require __DIR__.'/auth.php';
