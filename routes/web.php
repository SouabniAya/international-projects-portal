<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Admin routes — dashboard.blade.php from the zip already expects these
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');
Route::get('/admin/opportunities', function () {
    return view('admin.opportunities');
})->name('admin.opportunities');
Route::get('/admin/users', function () {
    return view('admin.users');
})->name('admin.users');
Route::get('/admin/requests-documents', function () {
    return view('admin.requests-documents');
})->name('admin.requests-documents');
Route::get('/admin/projects/{id}', function ($id) {
    return view('admin.project-details', ['id' => $id]);
})->name('admin.project-details');
Route::get('/admin/partners', function () {
    $projectId = request()->query('project');
    return view('admin.partners', ['projectId' => $projectId]);
})->name('admin.partners');
Route::get('/admin/documents', function () {
    return view('admin.documents');
})->name('admin.documents');
Route::get('/admin/projects', function () {
    return view('admin.projects');
})->name('admin.projects');
Route::get('/admin/calls', function () {
    return view('admin.calls');
})->name('admin.calls');
Route::get('/admin/partner-management', function () {
    return view('admin.partner-management');
})->name('admin.partner-management');
Route::get('/admin/funding-programmes', function () {
    return view('admin.funding-programmes');
})->name('admin.funding-programmes');
Route::get('/admin/requests', function () {
    return view('admin.requests');
})->name('admin.requests');
Route::get('/admin/mobility/{id}', function ($id) {
    return view('admin.mobility-details', ['id' => $id]);
})->name('admin.mobility-details');
Route::get('/admin/agreements', function () {
    return view('admin.agreements');
})->name('admin.agreements');
Route::get('/admin/agreements/{id}', function ($id) {
    return view('admin.agreement-details', ['id' => $id]);
})->name('admin.agreement-details');
Route::get('/admin/calls/{id}', function ($id) {
    return view('admin.call-details', ['id' => $id]);
})->name('admin.call-details');
Route::get('/calls/{id}', function ($id) {
    return view('call-details', ['id' => $id]);
})->name('call-details');
Route::get('/admin/notifications', function () {
    return view('admin.notifications');
})->name('admin.notifications');
Route::get('/admin/notifications/{id}', function ($id) {
    return view('admin.notification-details', ['id' => $id]);
})->name('admin.notification-details');
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr', 'ar'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');
Route::get('/admin/agreements/{id}', function ($id) {
    return view('admin.agreement-details', ['id' => $id]);
})->name('admin.agreement-details');
Route::get('/admin/calls', function () {
    return view('admin.calls');
})->name('admin.calls');