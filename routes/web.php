<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ManagePolls;
use App\Livewire\Polls\VotePoll;


Route::view('/', 'welcome');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/polls', ManagePolls::class)->name('admin.polls');
});
Route::get('/poll/{pollId}', VotePoll::class)->name('poll.vote');


require __DIR__ . '/auth.php';
