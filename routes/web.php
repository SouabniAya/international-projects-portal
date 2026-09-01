<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RequestsDocumentsController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
// ---- Public pages ----------------------------------------------------
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/projects', fn () => view('projects'))->name('projects');


// Add these two lines to routes/web.php (alongside your other admin routes).
// Don't forget: use App\Http\Controllers\CallController;


Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
Route::get('/calls/{call}', [CallController::class, 'show'])->name('calls.show');

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



Route::get('/international-presentation', [PresentationController::class, 'index'])->name('presentation');

Route::get('/funding-programmes/{slug}', fn ($slug) => view('funding-programmes.show'))->name('funding-programmes.show');

Route::get('/news', fn () => view('news.index'))->name('news.index');
Route::get('/news/{slug}', fn ($slug) => view('news.show'))->name('news.show');

Route::get('/events', fn () => view('events.index'))->name('events.index');
Route::get('/events/{slug}', fn ($slug) => view('events.show'))->name('events.show');

Route::get('/testimonials', fn () => view('testimonials'))->name('testimonials');

Route::get('/faq', [App\Http\Controllers\FaqController::class, 'index'])->name('faq');

Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

Route::get('/become-a-partner', fn () => view('become-a-partner'))->name('become-a-partner');
Route::post('/become-a-partner', fn () => back())->name('become-a-partner.store');

Route::get('/documents', fn () => view('documents'))->name('documents');

    Route::get('/cooperation', fn () => view('admin.content-management'))->name('admin.content-management');
   
    

    // Referenced by <form action="{{ route(...) }}"> on the admin pages.
    // JS currently intercepts these submits for the demo (see resources/js/admin.js),
    // so these can stay as simple redirect-back stubs until real controllers exist —
    // just swap the closure for a Controller@method and the frontend needs no changes.
    Route::post('/content', fn () => back())->name('admin.content.store');
    Route::get('/content/create', fn () => view('admin.content.create'))->name('admin.content.create');
    Route::post('/partnerships', fn () => back())->name('admin.partnerships.store');
    Route::patch('/settings', fn () => back())->name('admin.settings.update');
    Route::patch('/settings/password', fn () => back())->name('admin.settings.password');


Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
Route::put('/settings/profile', [App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('settings.profile');
Route::put('/settings/password', [App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('settings.password');
Route::put('/settings/two-factor', [App\Http\Controllers\Admin\SettingsController::class, 'toggleTwoFactor'])->name('settings.two-factor');
    Route::get('/users/create', [UserController::class, 'create'])
        ->name('users.create');

    Route::post('/users', [UserController::class, 'store'])
        ->name('users.store');

    Route::get('/users/permissions', [UserController::class, 'permissions'])
        ->name('users.permissions');

    Route::get('/users/login-history', [UserController::class, 'loginHistory'])
        ->name('users.login-history');

    Route::get('/users/export', [UserController::class, 'export'])
        ->name('users.export');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    Route::put('/users/{user}', [UserController::class, 'update'])
        ->name('users.update');

    Route::delete('/users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});
Route::get('/admin/users/permissions/{role}', 
    [UserController::class, 'managePermissions']
)->name('admin.users.permissions.manage');


Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');




// ---- Admin pages added by teammate (kept flat as originally written) ----
Route::get('/admin/opportunities', function () {
    return view('admin.opportunities');
})->name('admin.opportunities');


Route::get('/admin/projects/{id}', function ($id) {
    return view('admin.project-details', ['id' => $id]);
})->name('admin.project-details');
Route::get('/admin/partners', function () {
    $projectId = request()->query('project');
    return view('admin.partners', ['projectId' => $projectId]);
})->name('admin.partners');
Route::get('/admin/documents', [App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('admin.documents');
Route::post('/admin/documents', [App\Http\Controllers\Admin\DocumentController::class, 'store'])->name('admin.documents.store');
Route::get('/admin/projects', function () {
    return view('admin.projects');
})->name('admin.projects');
Route::get('/admin/documents/create-options', [App\Http\Controllers\Admin\DocumentController::class, 'create'])->name('admin.documents.create-options');
Route::get('/admin/calls', function () {
    $calls = [
        [
            'id' => 1,
            'title' => 'Erasmus+ KA220 – Cooperation Partnerships in Higher Education',
            'ref' => 'ERASMUS-EDU-2025-CP-HE',
            'flag' => 'images/flags/eu.png',
            'programme' => 'Erasmus+',
            'type' => 'Partnership',
            'status' => 'Open',
            'opening' => 'Apr 15, 2025',
            'deadline' => 'Jun 30, 2025',
        ],
        [
            'id' => 2,
            'title' => 'Horizon Europe – Research and Innovation Actions (RIA)',
            'ref' => 'HORIZON-CL4-2025-01-RIA',
            'flag' => 'images/flags/horizon.png',
            'programme' => 'Horizon Europe',
            'type' => 'Research & Innovation',
            'status' => 'Open Soon',
            'opening' => 'May 22, 2025',
            'deadline' => 'Sep 18, 2025',
        ],
        [
            'id' => 3,
            'title' => 'MSCA Doctoral Networks 2025',
            'ref' => 'HORIZON-MSCA-2025-DN-01',
            'flag' => 'images/flags/msca.png',
            'programme' => 'MSCA',
            'type' => 'Research Training',
            'status' => 'Open',
            'opening' => 'Apr 8, 2025',
            'deadline' => 'May 28, 2025',
        ],
        [
            'id' => 4,
            'title' => 'PRIMA Section 2 – Multi-topic 2025',
            'ref' => 'PRIMA-S2-2025',
            'flag' => 'images/flags/prima.png',
            'programme' => 'PRIMA',
            'type' => 'Research & Innovation',
            'status' => 'Upcoming',
            'opening' => 'Jun 1, 2025',
            'deadline' => 'Aug 28, 2025',
        ],
        [
            'id' => 5,
            'title' => 'ERC Starting Grants 2025',
            'ref' => 'ERC-2025-StG',
            'flag' => 'images/flags/eu.png',
            'programme' => 'European Commission',
            'type' => 'Research',
            'status' => 'Closed',
            'opening' => 'Jul 11, 2024',
            'deadline' => 'Oct 17, 2024',
        ],
        [
            'id' => 6,
            'title' => 'World Bank – Research Grants Program',
            'ref' => 'WBG-RGP-2025',
            'flag' => 'images/flags/worldbank.png',
            'programme' => 'World Bank',
            'type' => 'Grant',
            'status' => 'Closed',
            'opening' => 'Jan 10, 2025',
            'deadline' => 'Mar 10, 2025',
        ],
    ];

    return view('admin.calls', compact('calls'));
})->name('admin.calls');
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {

Route::get('/partner-management', [App\Http\Controllers\Admin\PartnerManagementController::class, 'index'])->name('partner-management');
    // Create Partner
    Route::get('/partner-management/create', [App\Http\Controllers\Admin\PartnerManagementController::class, 'create'])
        ->name('partner-management.create');
Route::get('/partners/{partnerID}', [App\Http\Controllers\Admin\PartnerManagementController::class, 'show'])->name('partner-management.show');
Route::delete('/partners/{partnerID}', [App\Http\Controllers\Admin\PartnerManagementController::class, 'destroy'])->name('partner-management.destroy');
    Route::post('/partner-management', [App\Http\Controllers\Admin\PartnerManagementController::class, 'store'])
        ->name('partner-management.store');

});
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
Route::get('/admin/notifications', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications');

Route::get('/admin/notifications/{id}', function ($id) {
    return view('admin.notification-details', ['id' => $id]);
})->name('admin.notification-details');
// Public mobility opportunities
// Public mobility opportunities
Route::get('/mobility', [App\Http\Controllers\MobilityController::class, 'index'])->name('mobility.index');
Route::get('/mobility/{id}', [App\Http\Controllers\MobilityController::class, 'show'])->name('mobility.show');

Route::get('/admin/mobility', function () {

    $opportunities = [
        [
            'id' => 1,
            'title' => 'Erasmus+ Student Mobility',
            'ref' => 'ERASMUS-SM-2025-01',
            'programme' => 'Erasmus+',
            'direction' => 'Outgoing',
            'status' => 'Open',
            'opening' => 'Mar 15, 2025',
            'deadline' => 'May 31, 2025',
        ],
        [
            'id' => 2,
            'title' => 'Staff Training Mobility',
            'ref' => 'ERASMUS-ST-2025-02',
            'programme' => 'Erasmus+',
            'direction' => 'Outgoing',
            'status' => 'Open',
            'opening' => 'Feb 20, 2025',
            'deadline' => 'Apr 20, 2025',
        ],
        [
            'id' => 3,
            'title' => 'Incoming Research Mobility',
            'ref' => 'HORIZON-RM-2025-01',
            'programme' => 'Horizon Europe',
            'direction' => 'Incoming',
            'status' => 'Open Soon',
            'opening' => 'May 1, 2025',
            'deadline' => 'Jun 15, 2025',
        ],
        [
            'id' => 4,
            'title' => 'PhD Exchange Programme',
            'ref' => 'MSCA-PHD-2025-01',
            'programme' => 'MSCA',
            'direction' => 'Outgoing',
            'status' => 'Closed',
            'opening' => 'Jan 5, 2025',
            'deadline' => 'Mar 10, 2025',
        ],
        [
            'id' => 5,
            'title' => 'Short-Term Student Mobility',
            'ref' => 'ACAD-SS-2025-01',
            'programme' => 'Academic Mobility',
            'direction' => 'Outgoing',
            'status' => 'Open',
            'opening' => 'Mar 1, 2025',
            'deadline' => 'May 5, 2025',
        ],
        [
            'id' => 6,
            'title' => 'Faculty Exchange Programme',
            'ref' => 'ERASMUS-FE-2025-03',
            'programme' => 'Erasmus+',
            'direction' => 'Incoming',
            'status' => 'Upcoming',
            'opening' => 'Jun 1, 2025',
            'deadline' => 'Jun 30, 2025',
        ],
    ];

    return view('admin.mobility', compact('opportunities'));

})->name('admin.mobility');
Route::get('/partnerships/projects/{project}', function ($project) {

    $projects = [

        [
            'programme' => 'Erasmus+',
            'status' => 'Ongoing',
            'title' => 'SmartEdu – Smart Education for the Digital Era',
            'desc' => 'Enhancing digital education through innovative learning solutions.',
            'tag' => 'Erasmus+',
            'thematic_area' => 'Digital Education',
            'duration' => '2025 – 2027',
            'coordinator' => 'International University Consortium',
            'countries' => 'Algeria, France, Spain, Italy',
            'partners' => '8 partner institutions',
            'budget' => '€850,000',
            'overview' => 'SmartEdu is an international cooperation project focused on improving digital education through innovative technologies, modern teaching methodologies and collaborative learning environments.',
            'objectives' => [
                'Improve digital learning environments for students and teachers.',
                'Develop innovative educational tools and resources.',
                'Strengthen cooperation between European and international universities.',
                'Promote digital skills and inclusive education.'
            ]
        ],

        [
            'programme' => 'Horizon Europe',
            'status' => 'Proposed',
            'title' => 'GreenCampus – Sustainable Universities',
            'desc' => 'Promoting sustainable and eco-friendly university campuses.',
            'tag' => 'Horizon Europe',
            'thematic_area' => 'Environment & Sustainability',
            'duration' => '2026 – 2029',
            'coordinator' => 'European Sustainable Universities Network',
            'countries' => 'Algeria, Germany, France, Belgium',
            'partners' => '12 partner institutions',
            'budget' => '€1,200,000',
            'overview' => 'GreenCampus aims to support universities in their transition towards more sustainable, energy-efficient and environmentally responsible campuses.',
            'objectives' => [
                'Reduce energy consumption across university campuses.',
                'Develop sustainable campus management strategies.',
                'Promote renewable energy and green technologies.',
                'Encourage environmental awareness among students and staff.'
            ]
        ],

        [
            'programme' => 'Erasmus+',
            'status' => 'Completed',
            'title' => 'ResearchConnect – Global Research Networks',
            'desc' => 'Strengthening international research and academic collaboration.',
            'tag' => 'Erasmus+',
            'thematic_area' => 'Research & Innovation',
            'duration' => '2023 – 2025',
            'coordinator' => 'Global Research Alliance',
            'countries' => 'Algeria, France, Germany, Portugal',
            'partners' => '10 partner institutions',
            'budget' => '€640,000',
            'overview' => 'ResearchConnect strengthened international academic cooperation by creating new research networks, mobility opportunities and collaborative research initiatives.',
            'objectives' => [
                'Create international research networks.',
                'Facilitate academic mobility.',
                'Support collaborative research projects.',
                'Increase knowledge exchange between partner institutions.'
            ]
        ],

        [
            'programme' => 'PRIMA',
            'status' => 'Ongoing',
            'title' => 'AgriTech – Smart Agriculture Solutions',
            'desc' => 'Supporting smart and sustainable agricultural innovation.',
            'tag' => 'PRIMA',
            'thematic_area' => 'Agriculture & Technology',
            'duration' => '2025 – 2028',
            'coordinator' => 'Mediterranean Agricultural Research Network',
            'countries' => 'Algeria, Tunisia, Italy, Spain',
            'partners' => '9 partner institutions',
            'budget' => '€920,000',
            'overview' => 'AgriTech promotes the use of digital technologies and smart agricultural solutions to improve productivity and sustainability in Mediterranean agriculture.',
            'objectives' => [
                'Develop smart agriculture technologies.',
                'Improve water and resource management.',
                'Support sustainable agricultural production.',
                'Promote technology transfer between research institutions and farmers.'
            ]
        ],

        [
            'programme' => 'Erasmus+',
            'status' => 'Ongoing',
            'title' => 'DigitalHealth – Innovation in Healthcare',
            'desc' => 'Developing digital solutions for modern healthcare.',
            'tag' => 'Erasmus+',
            'thematic_area' => 'Digital Health',
            'duration' => '2025 – 2027',
            'coordinator' => 'European Digital Health Consortium',
            'countries' => 'Algeria, France, Belgium, Netherlands',
            'partners' => '7 partner institutions',
            'budget' => '€780,000',
            'overview' => 'DigitalHealth focuses on the development of innovative digital solutions that can improve healthcare education, research and services.',
            'objectives' => [
                'Develop digital healthcare solutions.',
                'Improve digital health education.',
                'Support collaboration between universities and healthcare institutions.',
                'Promote innovation in healthcare services.'
            ]
        ],

    ];

    $selectedProject = collect($projects)->first(function ($item) use ($project) {
        return Str::slug($item['title']) === $project;
    });

    abort_unless($selectedProject, 404);

    return view('partnerships.project-details', [
        'project' => $selectedProject
    ]);

})->name('partnerships.project.show');