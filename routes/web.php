<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RequestsDocumentsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// ============================================================================
// PUBLIC PAGES
// ============================================================================

Route::get('/', [
    App\Http\Controllers\HomeController::class,
    'index'
])->name('home');

Route::get('/projects', [
    App\Http\Controllers\ProjectController::class,
    'index'
])->name('projects');

Route::get('/projects/{id}', [
    App\Http\Controllers\ProjectController::class,
    'show'
])->name('projects.show');


// ============================================================================
// PUBLIC CALLS
// ============================================================================

Route::get('/calls', [
    CallController::class,
    'index'
])->name('calls.index');

Route::get('/calls/{call}', [
    CallController::class,
    'show'
])->name('calls.show');


// ============================================================================
// AUTHENTICATION
// ============================================================================

Route::get('/login', fn () => view('auth.login'))
    ->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.store');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');

Route::get('/forgot-password', [
    ForgotPasswordController::class,
    'showLinkRequestForm'
])->name('password.request');

Route::post('/forgot-password', [
    ForgotPasswordController::class,
    'sendResetLink'
])->name('password.email');

Route::get('/reset-password/{token}', [
    ForgotPasswordController::class,
    'showResetForm'
])->name('password.reset');

Route::post('/reset-password', [
    ForgotPasswordController::class,
    'reset'
])->name('password.update');


// ============================================================================
// LOCALE
// ============================================================================

Route::get('/lang/{locale}', function (string $locale) {

    if (in_array($locale, ['en', 'fr', 'ar'], true)) {
        session(['locale' => $locale]);
    }

    return back();

})->name('lang.switch');


// ============================================================================
// PUBLIC PARTNERSHIPS
// ============================================================================

Route::get('/partnerships', [
    App\Http\Controllers\PartnerController::class,
    'index'
])->name('partnerships.index');

Route::get('/partnerships/{slug}', [
    App\Http\Controllers\PartnerController::class,
    'show'
])->name('partnerships.show');


// ============================================================================
// PUBLIC PRESENTATION
// ============================================================================

Route::get('/international-presentation', [
    PresentationController::class,
    'index'
])->name('presentation');


// ============================================================================
// PUBLIC FUNDING PROGRAMMES / FUNDING OPPORTUNITIES
// ============================================================================

Route::get('/funding-opportunities', [
    App\Http\Controllers\FundingProgrammeController::class,
    'index'
])->name('funding-programmes.index');

Route::get('/funding-programmes/{id}', [
    App\Http\Controllers\FundingProgrammeController::class,
    'show'
])->name('funding-programmes.show');


// ============================================================================
// PUBLIC NEWS
// ============================================================================

Route::get('/news', [
    App\Http\Controllers\NewsController::class,
    'index'
])->name('news.index');

Route::get('/news/{id}', [
    App\Http\Controllers\NewsController::class,
    'show'
])->name('news.show');


// ============================================================================
// PUBLIC EVENTS
// ============================================================================

Route::get('/events', [
    App\Http\Controllers\EventController::class,
    'index'
])->name('events.index');

Route::get('/events/{id}', [
    App\Http\Controllers\EventController::class,
    'show'
])->name('events.show');

Route::get('/events/{id}/register', [
    App\Http\Controllers\EventController::class,
    'register'
])->name('events.register');

Route::post('/events/{id}/register', [
    App\Http\Controllers\EventController::class,
    'registerStore'
])->name('events.register.store');


// ============================================================================
// PUBLIC TESTIMONIALS
// ============================================================================

Route::get('/testimonials', [
    TestimonialController::class,
    'index'
])->name('testimonials.index');

Route::get('/testimonials/submit', [
    TestimonialController::class,
    'create'
])->name('testimonials.create');

Route::post('/testimonials', [
    TestimonialController::class,
    'store'
])->name('testimonials.store');


// ============================================================================
// FAQ / CONTACT
// ============================================================================

Route::get('/faq', [
    App\Http\Controllers\FaqController::class,
    'index'
])->name('faq');

Route::get('/help', fn () => view('help'))->name('help');

Route::get('/contact', [
    App\Http\Controllers\ContactController::class,
    'index'
])->name('contact');

Route::post('/contact', [
    App\Http\Controllers\ContactController::class,
    'store'
])->name('contact.store');


// ============================================================================
// BECOME A PARTNER
// ============================================================================

Route::get('/become-a-partner', function () {

    $countries = \App\Models\Country::with([
        'translations' => fn ($q) => $q->whereIn(
            'languageCode',
            [app()->getLocale(), 'en']
        )
    ])
        ->get()
        ->sortBy(
            fn ($country) =>
                $country->translation()?->countryName
                ?? $country->countryCode
        )
        ->values();

    return view('become-a-partner', compact('countries'));

})->name('become-a-partner');

Route::post('/become-a-partner', [
    App\Http\Controllers\BecomeAPartnerController::class,
    'store'
])->name('become-a-partner.store');


// ============================================================================
// PUBLIC DOCUMENTS
// ============================================================================

Route::get('/documents', [
    DocumentController::class,
    'index'
])->name('documents.index');

Route::get('/documents/{documentID}/download', [
    DocumentController::class,
    'download'
])->name('documents.download');


// ============================================================================
// PUBLIC MOBILITY
// ============================================================================

Route::get('/mobility', [
    App\Http\Controllers\MobilityController::class,
    'index'
])->name('mobility.index');

Route::get('/mobility/{id}', [
    App\Http\Controllers\MobilityController::class,
    'show'
])->name('mobility.show');


// ============================================================================
// ADMIN
// ALL NORMAL ADMIN ROUTES ARE PROTECTED BY auth:admin
// ============================================================================

Route::middleware('auth:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // --------------------------------------------------------------------
        // Dashboard
        // --------------------------------------------------------------------

        Route::get('/dashboard', [
            App\Http\Controllers\Admin\DashboardController::class,
            'index'
        ])->name('dashboard');

        Route::get('/help', fn () => view('admin.help'))->name('help');

        Route::get('/reports', [
            App\Http\Controllers\Admin\ReportsController::class,
            'index'
        ])->name('reports');


        // --------------------------------------------------------------------
        // Profile
        // --------------------------------------------------------------------

        Route::get('/profile', [
            App\Http\Controllers\Admin\ProfileController::class,
            'index'
        ])->name('profile');


        // --------------------------------------------------------------------
        // Content Management
        // --------------------------------------------------------------------

        Route::get('/cooperation', [
            App\Http\Controllers\Admin\ContentManagementController::class,
            'index'
        ])->name('content-management');

        Route::post('/content', fn () => back())
            ->name('content.store');

        Route::get('/content/create', fn () =>
            view('admin.content.create')
        )->name('content.create');

        Route::post('/partnerships', fn () => back())
            ->name('partnerships.store');

        Route::get('/school-presentation', [
            App\Http\Controllers\Admin\SchoolPresentationController::class,
            'index'
        ])->name('school-presentation');

        Route::get('/school-presentation/edit', [
            App\Http\Controllers\Admin\SchoolPresentationController::class,
            'edit'
        ])->name('school-presentation.edit');

        Route::put('/school-presentation', [
            App\Http\Controllers\Admin\SchoolPresentationController::class,
            'update'
        ])->name('school-presentation.update');

        Route::get('/faqs', [
            App\Http\Controllers\Admin\FaqController::class,
            'index'
        ])->name('faqs');

        Route::get('/faqs/create', [
            App\Http\Controllers\Admin\FaqController::class,
            'create'
        ])->name('faqs.create');

        Route::post('/faqs', [
            App\Http\Controllers\Admin\FaqController::class,
            'store'
        ])->name('faqs.store');

        Route::get('/faqs/{id}/edit', [
            App\Http\Controllers\Admin\FaqController::class,
            'edit'
        ])->name('faqs.edit');

        Route::put('/faqs/{id}', [
            App\Http\Controllers\Admin\FaqController::class,
            'update'
        ])->name('faqs.update');

        Route::delete('/faqs/{id}', [
            App\Http\Controllers\Admin\FaqController::class,
            'destroy'
        ])->name('faqs.destroy');

        Route::get('/testimonials', [
            App\Http\Controllers\Admin\TestimonialController::class,
            'index'
        ])->name('testimonials');

        Route::post('/testimonials/{id}/status', [
            App\Http\Controllers\Admin\TestimonialController::class,
            'updateStatus'
        ])->name('testimonials.status');


        // --------------------------------------------------------------------
        // Users
        // --------------------------------------------------------------------

        Route::get('/users', [
            UserController::class,
            'index'
        ])->name('users.index');

        Route::get('/users/create', [
            UserController::class,
            'create'
        ])->name('users.create');

        Route::post('/users', [
            UserController::class,
            'store'
        ])->name('users.store');

        Route::get('/users/permissions', [
            UserController::class,
            'permissions'
        ])->name('users.permissions');

        Route::get('/users/permissions/{role}', [
            UserController::class,
            'managePermissions'
        ])->name('users.permissions.manage');

        Route::get('/users/login-history', [
            UserController::class,
            'loginHistory'
        ])->name('users.login-history');

        Route::get('/users/export', [
            UserController::class,
            'export'
        ])->name('users.export');

        Route::get('/users/{user}/edit', [
            UserController::class,
            'edit'
        ])->name('users.edit');

        Route::get('/users/{user}', [
            UserController::class,
            'show'
        ])->name('users.show');

        Route::put('/users/{user}', [
            UserController::class,
            'update'
        ])->name('users.update');

        Route::delete('/users/{user}', [
            UserController::class,
            'destroy'
        ])->name('users.destroy');


        // --------------------------------------------------------------------
        // Settings
        // --------------------------------------------------------------------

        Route::get('/settings', [
            App\Http\Controllers\Admin\SettingsController::class,
            'index'
        ])->name('settings');

        Route::put('/settings/profile', [
            App\Http\Controllers\Admin\SettingsController::class,
            'updateProfile'
        ])->name('settings.profile');

        Route::put('/settings/password', [
            App\Http\Controllers\Admin\SettingsController::class,
            'updatePassword'
        ])->name('settings.password');

        Route::put('/settings/two-factor', [
            App\Http\Controllers\Admin\SettingsController::class,
            'toggleTwoFactor'
        ])->name('settings.two-factor');

        Route::patch('/settings', fn () => back())
            ->name('settings.update');


        // --------------------------------------------------------------------
        // Opportunities
        // --------------------------------------------------------------------

        Route::get('/opportunities', [
            CallController::class,
            'opportunitiesIndex'
        ])->name('opportunities');


        // --------------------------------------------------------------------
        // PROJECTS
        // --------------------------------------------------------------------

        Route::get('/projects', [
            ProjectController::class,
            'index'
        ])->name('projects');

        Route::get('/projects/create', [
            ProjectController::class,
            'create'
        ])->name('projects.create');

        Route::get('/projects/export', [
            ProjectController::class,
            'export'
        ])->name('projects.export');

        Route::post('/projects', [
            ProjectController::class,
            'store'
        ])->name('projects.store');

        /*
         * IMPORTANT:
         * /projects/create MUST remain above /projects/{id}.
         */
        Route::get('/projects/{id}', [
            ProjectController::class,
            'show'
        ])->name('project-details');

        Route::put('/projects/{id}', [
            ProjectController::class,
            'update'
        ])->name('projects.update');

        Route::delete('/projects/{id}', [
            ProjectController::class,
            'destroy'
        ])->name('projects.destroy');


        // --------------------------------------------------------------------
        // EVENTS
        // --------------------------------------------------------------------

        Route::get('/events', [
            App\Http\Controllers\Admin\EventController::class,
            'index'
        ])->name('events');

        Route::get('/events/create', [
            App\Http\Controllers\Admin\EventController::class,
            'create'
        ])->name('events.create');

        Route::post('/events', [
            App\Http\Controllers\Admin\EventController::class,
            'store'
        ])->name('events.store');

        Route::get('/events/{id}', [
            App\Http\Controllers\Admin\EventController::class,
            'show'
        ])->name('events.show');

        Route::get('/events/{id}/edit', [
            App\Http\Controllers\Admin\EventController::class,
            'edit'
        ])->name('events.edit');

        Route::put('/events/{id}', [
            App\Http\Controllers\Admin\EventController::class,
            'update'
        ])->name('events.update');

        Route::delete('/events/{id}', [
            App\Http\Controllers\Admin\EventController::class,
            'destroy'
        ])->name('events.destroy');

        Route::get('/news', [
            App\Http\Controllers\Admin\NewsController::class,
            'index'
        ])->name('news');

        Route::get('/news/create', [
            App\Http\Controllers\Admin\NewsController::class,
            'create'
        ])->name('news.create');

        Route::post('/news', [
            App\Http\Controllers\Admin\NewsController::class,
            'store'
        ])->name('news.store');

        Route::get('/news/{id}', [
            App\Http\Controllers\Admin\NewsController::class,
            'show'
        ])->name('news.show');

        Route::get('/news/{id}/edit', [
            App\Http\Controllers\Admin\NewsController::class,
            'edit'
        ])->name('news.edit');

        Route::put('/news/{id}', [
            App\Http\Controllers\Admin\NewsController::class,
            'update'
        ])->name('news.update');

        Route::delete('/news/{id}', [
            App\Http\Controllers\Admin\NewsController::class,
            'destroy'
        ])->name('news.destroy');


        // --------------------------------------------------------------------
        // PARTNERS
        // --------------------------------------------------------------------

        // --------------------------------------------------------------------
        // PARTNER MANAGEMENT
        // --------------------------------------------------------------------

        Route::get('/partner-management', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'index'
        ])->name('partner-management');

        Route::get('/partner-management/create', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'create'
        ])->name('partner-management.create');

        Route::post('/partner-management', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'store'
        ])->name('partner-management.store');

        Route::get('/partners/{partnerID}', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'show'
        ])->name('partner-management.show');

        Route::delete('/partners/{partnerID}', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'destroy'
        ])->name('partner-management.destroy');

        Route::get('/partners/{partnerID}/edit', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'edit'
        ])->name('partner-management.edit');

        Route::put('/partners/{partnerID}', [
            App\Http\Controllers\Admin\PartnerManagementController::class,
            'update'
        ])->name('partner-management.update');


        // --------------------------------------------------------------------
        // ADMIN DOCUMENTS
        // --------------------------------------------------------------------

        Route::get('/documents', [
            App\Http\Controllers\Admin\DocumentController::class,
            'index'
        ])->name('documents');

        Route::post('/documents', [
            App\Http\Controllers\Admin\DocumentController::class,
            'store'
        ])->name('documents.store');

        Route::get('/documents/create-options', [
            App\Http\Controllers\Admin\DocumentController::class,
            'create'
        ])->name('documents.create-options');

        Route::delete('/documents/{documentID}', [
            App\Http\Controllers\Admin\DocumentController::class,
            'destroy'
        ])->name('documents.destroy');


        // --------------------------------------------------------------------
        // CALLS
        // --------------------------------------------------------------------

        Route::get('/calls', [
            CallController::class,
            'adminIndex'
        ])->name('calls');

        Route::get('/calls/create', [
            CallController::class,
            'adminCreate'
        ])->name('calls.create');

        Route::get('/calls/export', [
            CallController::class,
            'adminExport'
        ])->name('calls.export');

        Route::post('/calls', [
            CallController::class,
            'adminStore'
        ])->name('calls.store');

        Route::put('/calls/{call}', [
            CallController::class,
            'adminUpdate'
        ])->name('calls.update');

        Route::delete('/calls/{call}', [
            CallController::class,
            'adminDestroy'
        ])->name('calls.destroy');


        // --------------------------------------------------------------------
        // AGREEMENTS
        // --------------------------------------------------------------------

        Route::get('/agreements', [
            App\Http\Controllers\Admin\AgreementController::class,
            'index'
        ])->name('agreements');

        Route::post('/agreements', [
            App\Http\Controllers\Admin\AgreementController::class,
            'store'
        ])->name('agreements.store');

        Route::get('/agreements/create', [
            App\Http\Controllers\Admin\AgreementController::class,
            'create'
        ])->name('agreements.create');

        Route::get('/agreements/export', [
            App\Http\Controllers\Admin\AgreementController::class,
            'export'
        ])->name('agreements.export');

        Route::get('/agreements/{id}/edit', [
            App\Http\Controllers\Admin\AgreementController::class,
            'edit'
        ])->name('agreements.edit');

        Route::put('/agreements/{id}', [
            App\Http\Controllers\Admin\AgreementController::class,
            'update'
        ])->name('agreements.update');

        Route::delete('/agreements/{id}', [
            App\Http\Controllers\Admin\AgreementController::class,
            'destroy'
        ])->name('agreements.destroy');

        Route::get('/agreements/{id}', [
            App\Http\Controllers\Admin\AgreementController::class,
            'show'
        ])->name('agreement-details');


        // --------------------------------------------------------------------
        // FUNDING PROGRAMMES
        // --------------------------------------------------------------------

        Route::get('/funding-programmes', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'index'
        ])->name('funding-programmes');

        Route::get('/funding-programmes/create', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'create'
        ])->name('funding-programmes.create');

        Route::get('/funding-programmes/{id}/edit', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'edit'
        ])->name('funding-programmes.edit');

        Route::post('/funding-programmes', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'store'
        ])->name('funding-programmes.store');

        Route::put('/funding-programmes/{id}', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'update'
        ])->name('funding-programmes.update');

        Route::delete('/funding-programmes/{id}', [
            App\Http\Controllers\Admin\FundingProgrammeController::class,
            'destroy'
        ])->name('funding-programmes.destroy');


        // --------------------------------------------------------------------
        // MOBILITY
        // --------------------------------------------------------------------

        Route::get('/mobility', [
            App\Http\Controllers\MobilityController::class,
            'adminIndex'
        ])->name('mobility');

        Route::get('/mobility/create', [
            App\Http\Controllers\MobilityController::class,
            'adminCreate'
        ])->name('mobility.create');

        Route::get('/mobility/export', [
            App\Http\Controllers\MobilityController::class,
            'adminExport'
        ])->name('mobility.export');

        Route::post('/mobility', [
            App\Http\Controllers\MobilityController::class,
            'adminStore'
        ])->name('mobility.store');

        Route::put('/mobility/{mobility}', [
            App\Http\Controllers\MobilityController::class,
            'adminUpdate'
        ])->name('mobility.update');

        Route::delete('/mobility/{mobility}', [
            App\Http\Controllers\MobilityController::class,
            'adminDestroy'
        ])->name('mobility.destroy');

        Route::get('/mobility/{id}', [
            App\Http\Controllers\MobilityController::class,
            'adminShow'
        ])->name('mobility-details');


        // --------------------------------------------------------------------
        // NOTIFICATIONS
        // --------------------------------------------------------------------

        Route::get('/notifications', [
            App\Http\Controllers\Admin\NotificationController::class,
            'index'
        ])->name('notifications');

        Route::get('/notifications/{id}', [
            App\Http\Controllers\Admin\NotificationController::class,
            'show'
        ])->name('notification-details');


        // --------------------------------------------------------------------
        // CALL DETAILS
        // --------------------------------------------------------------------

        Route::get('/calls/{id}', [
            CallController::class,
            'adminShow'
        ])->name('call-details');

});


// ============================================================================
// REQUESTS / DOCUMENTS WORKFLOW
//
// Must use auth:admin: AuthController only ever authenticates against
// Auth::guard('admin') (see config/auth.php + AuthController::login()).
// The plain 'auth' guard defaults to 'web', which no admin session ever
// populates, so this group was unreachable by any admin account.
// ============================================================================

Route::middleware(['auth:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/requests-documents', [
            RequestsDocumentsController::class,
            'index'
        ])->name('admin.requests-documents');

        Route::post('/partnership-requests/{requestID}/approve', [
            RequestsDocumentsController::class,
            'approvePartnership'
        ])->name('admin.partnership.approve');

        Route::post('/partnership-requests/{requestID}/reject', [
            RequestsDocumentsController::class,
            'rejectPartnership'
        ])->name('admin.partnership.reject');

        Route::post('/documents/{documentID}/approve', [
            RequestsDocumentsController::class,
            'approveDocument'
        ])->name('admin.document.approve');

        Route::post('/documents/{documentID}/reject', [
            RequestsDocumentsController::class,
            'rejectDocument'
        ])->name('admin.document.reject');

        Route::get('/requests-documents/contact/{requestID}', [
    RequestsDocumentsController::class,
    'showContactRequest'
])->name('admin.requests.contact.show');

Route::get('/requests-documents/partnership/{requestID}', [
    RequestsDocumentsController::class,
    'showPartnershipRequest'
])->name('admin.requests.partnership.show');

});