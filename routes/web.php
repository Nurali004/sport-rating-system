<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\ProfileController;
use App\Models\Athlete;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('users', UserController::class)->names('users');
    Route::resource('sports', SportController::class)->names('sports');
    Route::resource('achievements', AchievementController::class)->names('achievements');
    Route::resource('athletes', \App\Http\Controllers\Admin\AthleteController::class)->names('athletes');
    Route::resource('competitions', CompetitionController::class)->names('competitions');
    Route::resource('ratings', RatingController::class)->names('ratings');
    Route::resource('regions', RegionController::class)->names('regions');
    Route::resource('seasons', SeasonController::class)->names('seasons');
    Route::resource('site-settings', SiteSettingController::class)->names('site-settings');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('frontend')->name('frontend.')->group(function () {
    Route::get('/athletes/list', [AthleteController::class, 'list'])->name('athletes.list');
    Route::get('/ratings/list', [\App\Http\Controllers\RatingController::class, 'list'])->name('ratings.list');
    Route::get('/competitions/list', [\App\Http\Controllers\CompetitionController::class, 'list'])->name('competitions.list');
    Route::get('/athletes/{athlete}', [AthleteController::class, 'show'])->name('athletes.show');
    Route::get('/competitions/{competition}', [\App\Http\Controllers\CompetitionController::class, 'show'])->name('competitions.show');
});

Route::get('/lang/{lang}', function ($lang){
    session()->put('locale', $lang);
    return redirect()->back();
});

Route::get('/test', function (){
    dispatch( new \App\Jobs\ProccessDataJob());
    return 'test';
});

Route::get('/test-broadcast', function (){
    broadcast(new \App\Events\MessageEvent('Sport Reytingi Yangilandi'));
    return "Xabar Navbatga jo'natildi";
});

Route::get('/test-athlete', function (){
    $athlete = Athlete::first();
    $msg = "Sportchi {$athlete->first_name} reytingi yangilandi";
    broadcast(new \App\Events\MessageEvent($msg));
    return "Xabar Navbatga jo'natildi";
});

require __DIR__.'/auth.php';
