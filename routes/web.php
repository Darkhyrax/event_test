<?php

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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::match(['get','post'],'/home/register_participation', [App\Http\Controllers\HomeController::class, 'register_participation'])->name('home.new_participation')->middleware('auth');

Route::resource('participants', App\Http\Controllers\ParticipantsController::class)->middleware('auth');
Route::get('/participants/inactive/{participant}/{action}', [App\Http\Controllers\ParticipantsController::class, 'inactive'])->name('participants.inactive')->middleware('auth');

Route::resource('events', App\Http\Controllers\EventsController::class)->middleware('auth');
Route::get('/events/banner/{event}', [App\Http\Controllers\EventsController::class, 'see_banner'])->name('events.banner')->middleware('auth');
Route::get('/events/participants/{event}', [App\Http\Controllers\EventsController::class, 'see_participants'])->name('events.participants')->middleware('auth');

Route::match(['get','post'],'/events/report/participants', [App\Http\Controllers\EventsController::class, 'participants_report'])->name('events.report')->middleware('auth');