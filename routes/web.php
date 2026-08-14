<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Admin routes — dashboard.blade.php from the zip already expects these
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Add the rest of your admin sections (cooperation, projects, calls,
// mobility, users, reports, settings) the same way once those views exist —
// x-admin-sidebar already links to /admin/{these}, so it'll 404 until you do.