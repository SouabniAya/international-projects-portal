<?php

use Illuminate\Support\Facades\Route;

// ---- Public pages ----------------------------------------------------
Route::get('/', fn () => view('home'))->name('home');
Route::get('/projects', fn () => view('projects'))->name('projects');
Route::get('/calls/{id}', fn ($id) => view('call-details', ['id' => $id]))->name('call-details');

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

// ---- Admin pages added by teammate (kept flat as originally written) ----
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
/*Route::get('/admin/calls', function () {
    return view('admin.calls');
})->name('admin.calls');
Route::get('/admin/calls', function () {
    $calls = [];

    return view('admin.calls', compact('calls'));
})->name('admin.calls');*/
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
Route::get('/admin/notifications', function () {
    return view('admin.notifications');
})->name('admin.notifications');
Route::get('/admin/notifications/{id}', function ($id) {
    return view('admin.notification-details', ['id' => $id]);
})->name('admin.notification-details');
// Public mobility opportunities
// Public mobility opportunities
Route::get('/mobility', fn () => view('mobility.mobility'))->name('mobility.index');
Route::get('/mobility/{id}', fn ($id) => view('mobility.mobility-details', ['id' => $id]))->name('mobility.show');

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