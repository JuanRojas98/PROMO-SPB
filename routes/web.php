<?php

use App\Exports\InvoicesExport;
use App\Http\Controllers\GameController;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Backoffice\Invoices\Index as BackofficeInvoicesIndex;
use App\Livewire\Participants\Invoices\Upload;
use App\Livewire\Participants\Ranking\Index as ParticipantRankingIndex;
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

Route::view('/', 'welcome')
    ->middleware('guest')
    ->name('welcome');

/**
 * PARTICIPANTS ROUTES
 */
Route::middleware(['auth', 'role:participant', 'invoice.played'])
    ->prefix('participants')
    ->name('participants.')
    ->group(function () {
    /**
     * HOME ROUTES
     */
    Route::view('/', 'Participants.home')
        ->name('home');

    /**
     * INVOICES ROUTES
     */
    Route::get('/invoices/upload', Upload::class)
        ->name('invoices.upload');

    /**
     * GAME ROUTES
     */
    Route::view('/game/{invoice_id}', 'Participants.game')
        ->middleware('game')
        ->name('game');

    Route::post('/game/score', [GameController::class, 'store'])
        ->name('game.score');

    /*
     * RANKING ROUTES
     */
    Route::get('/ranking', ParticipantRankingIndex::class)
        ->name('ranking');
});

/**
 * BACKOFFICES ROUTES
 */
Route::middleware(['auth', 'role:backoffice'])
    ->prefix('backoffice')
    ->name('backoffice.')
    ->group(function () {
    /**
     * INVOICES ROUTES
     */
    Route::get('/invoices', BackofficeInvoicesIndex::class)
        ->name('invoices');
    Route::get('/invoices/export/{status?}', [InvoiceController::class, 'export'])
        ->name('invoices.export');
});

/**
 * ADMIN ROUTES
 */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
    /**
     * USERS ROUTES
     */
    Route::view('/users', 'Admin.Users.index')
        ->name('users');
});

require __DIR__.'/auth.php';
