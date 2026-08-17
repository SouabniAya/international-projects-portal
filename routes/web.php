<?php

use Illuminate\Support\Facades\Route;

// ---- Public pages ----------------------------------------------------
Route::get('/', fn () => view('home'))->name('home');

// ---- Authentication (UC2) ----------------------------------------------
Route::get('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', fn () => back())->name('login.store');
Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');
Route::post('/forgot-password', fn () => back())->name('password.email');
Route::post('/logout', fn () => redirect('/'))->name('logout');

// ---- Locale switcher -----------------------------------------------------
// Requires App\Http\Middleware\SetLocale registered in bootstrap/app.php:
//   ->withMiddleware(function (Middleware $middleware) {
//       $middleware->web(append: [\App\Http\Middleware\SetLocale::class]);
//   })
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fr', 'ar'], true)) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

Route::get('/partnerships', fn () => view('partnerships.index'))->name('partnerships.index');
Route::get('/partnerships/{slug}', fn ($slug) => view('partnerships.show'))->name('partnerships.show');

Route::get('/international-presentation', fn () => view('presentation'))->name('presentation');

Route::get('/funding-programmes/{slug}', fn ($slug) => view('funding-programmes.show'))->name('funding-programmes.show');

Route::get('/news', fn () => view('news.index'))->name('news.index');
Route::get('/news/{slug}', fn ($slug) => view('news.show'))->name('news.show');

Route::get('/events', fn () => view('events.index'))->name('events.index');
Route::get('/events/{slug}', fn ($slug) => view('events.show'))->name('events.show');

Route::get('/testimonials', fn () => view('testimonials'))->name('testimonials');

Route::get('/faq', fn () => view('faq'))->name('faq');

Route::get('/contact', fn () => view('contact'))->name('contact');
Route::post('/contact', fn () => back())->name('contact.store');

Route::get('/become-a-partner', fn () => view('become-a-partner'))->name('become-a-partner');
Route::post('/become-a-partner', fn () => back())->name('become-a-partner.store');

Route::get('/documents', fn () => view('documents'))->name('documents');

// ---- Admin pages (add auth/role middleware once available) -----------
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $kpis = [
            ['label' => 'Countries', 'value' => 24, 'trend' => '+4%', 'direction' => 'up', 'icon' => 'globe'],
            ['label' => 'Partners', 'value' => 72, 'trend' => '+8%', 'direction' => 'up', 'icon' => 'building'],
            ['label' => 'Agreements', 'value' => 72, 'trend' => '0%', 'direction' => 'flat', 'icon' => 'document'],
            ['label' => 'Projects', 'value' => 100, 'trend' => '+12%', 'direction' => 'up', 'icon' => 'folder'],
            ['label' => 'Mobility', 'value' => 14, 'trend' => '-3%', 'direction' => 'down', 'icon' => 'plane'],
            ['label' => 'Funding Calls', 'value' => 8, 'trend' => '+1%', 'direction' => 'up', 'icon' => 'megaphone'],
        ];

        $icons = [
            'globe' => '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M3 12h18M12 3c2.5 2.5 2.5 15.5 0 18M12 3c-2.5 2.5-2.5 15.5 0 18" stroke="currentColor" stroke-width="1.6"/>',
            'building' => '<rect x="4" y="3" width="16" height="18" stroke="currentColor" stroke-width="1.6"/><path d="M8 8h2M8 12h2M8 16h2M14 8h2M14 12h2M14 16h2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
            'document' => '<path d="M6 3h9l3 3v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M9 16h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
            'folder' => '<path d="M3 7a1 1 0 0 1 1-1h5l2 2h9a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
            'plane' => '<path d="M2.5 19.5 21 12 2.5 4.5 5 12l-2.5 7.5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>',
            'megaphone' => '<path d="M3 10v4a1 1 0 0 0 1 1h2l9 4V5L6 9H4a1 1 0 0 0-1 1Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M19 9a4 4 0 0 1 0 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        ];

        $dirIcon = ['up' => '↑', 'down' => '↓', 'flat' => '→'];

        return view('admin.dashboard', compact('kpis', 'icons', 'dirIcon'));
    })->name('admin.dashboard');
    Route::get('/cooperation', fn () => view('admin.content-management'))->name('admin.content-management');
    Route::get('/settings', fn () => view('admin.settings'))->name('admin.settings');
    Route::get('/profile', fn () => view('admin.profile'))->name('admin.profile');

    // Referenced by <form action="{{ route(...) }}"> on the admin pages.
    // JS currently intercepts these submits for the demo (see resources/js/admin.js),
    // so these can stay as simple redirect-back stubs until real controllers exist —
    // just swap the closure for a Controller@method and the frontend needs no changes.
    Route::post('/content', fn () => back())->name('admin.content.store');
    Route::get('/content/create', fn () => view('admin.content.create'))->name('admin.content.create');
    Route::post('/partnerships', fn () => back())->name('admin.partnerships.store');
    Route::patch('/settings', fn () => back())->name('admin.settings.update');
    Route::patch('/settings/password', fn () => back())->name('admin.settings.password');
});
