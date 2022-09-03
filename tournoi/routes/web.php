<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\CaptainController;
use App\Http\Controllers\PromptController;
use App\Http\Controllers\PromptGestionController;

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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/register', [RegistrationController::class, 'create'])->name('registration');
Route::post('/register', [RegistrationController::class, 'store']);


Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'LoginController@authenticate');
Route::get('/lougout', 'LoginController@logout')->name('logout');

Route::get('/prompt/{id}', 'PromptController@show')->name('prompt');

Route::get('/loi', [HomeController::class,'loi'])->name('loi');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', 'LoginController@dashboard')->name('dashboard');

    Route::middleware(['role:2'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('dashboard-admin');
        Route::post('/create', [AdminController::class, 'Creation_Tournoi']);
        Route::post('/admin',[AdminController::class, 'change_perm']);
    });

    Route::middleware(['role:1'])->group(function () {
        Route::get('/gestion', [GestionController::class, 'index'])->name('dashboard-gestion');
        Route::get('/gestion/register_matches',[GestionController::class,'registration_index'])->name('registration_index');
        Route::get('/gestion/register_matches/{id}',[GestionController::class,'register_matches'])->name('register_matches');
        Route::get('/gestion/register_score',[GestionController::class,'register_score_index'])->name('register_score_index');
        Route::get('gestion/register_score/{id}',[GestionController::class,'register_score'])->name('register_score');
        Route::post('gestion/register_score/{id}/score/{numMatch}/tour/{currentTour}',[GestionController::class,'score'])->name('score');
        Route::post('/gestion/register_matches/{id}/registration/{nb_matches}',[GestionController::class,'creation_matche'])->name('creation_matche');
        Route::post('/gestion/register_matches/{id}/fix',[GestionController::class,'fix_date'])->name('fix_date');
        Route::post('/gestion/register_matches/{id}/start',[GestionController::class,'start_tournament'])->name('start_tournament');
        Route::get('/prompt_gestio/{label_tournament}', [PromptGestionController::class,'show_gestio'])->name('prompt_gestio');
        Route::get('/prompt_gestio/{label_tournament}/info_teams/{nom_team}/delete', [PromptGestionController::class,'delete_team'])->name('delete_team');
        Route::get('/prompt_gestio/{label_tournament}/info_teams/{nom_team}', [PromptGestionController::class, 'info_teams'])->name('info_teams');
        Route::post('/prompt_gestio/{label_tournament}/info_teams/{nom_team}/inscription',[PromptGestionController::class, 'inscription'])->name('inscription');
    });

    Route::middleware(['role:0'])->group(function () {
        Route::get('/captain', [CaptainController::class, 'index'])->name('dashboard-captain');
        Route::post('/captain', [CaptainController::class, 'team_creation'])->name('team.creation');
        Route::get('/pre-inscription-tournoi', [CaptainController::class, 'registration_tournament'])->name('registration.tournament');
        Route::post('/captain/gestion/request', [CaptainController::class, 'gestion_request'])->name('gestion.request');
        Route::post('/captain/update', [CaptainController::class, 'captain_update'])->name('captain.update');
        Route::get('captain/player/delete/{id}', [CaptainController::class, 'player_delete'])->name('player.delete');
        Route::post('captain/player/add/{count}', [CaptainController::class, 'player_add'])->name('player.add');
        Route::post('/sub', 'PromptController@sub');
        Route::post('/unsub', 'PromptController@unsub');
    });

});
