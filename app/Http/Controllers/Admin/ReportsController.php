<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use App\Models\LoginHistory;
use App\Models\PartnershipRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * "Reports" was a static, unexplained page in the original design (docx
 * remark: "reports: is empty should we remove it or what is this page
 * supposed to represent?"). There's no report-generation engine anywhere
 * in the schema/specs, so rather than build a fictional feature, this page
 * reports on the one kind of data the portal actually accumulates over
 * time and that isn't shown anywhere else: incoming requests (contact +
 * partnership) and admin login activity. If this isn't the intended
 * purpose, easy to repoint — the route/view are isolated from everything
 * else.
 */
class ReportsController extends Controller
{
    public function index()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(5)->startOfMonth();

        // ---- Requests received per month (last 6 months) ----------------
        $months = collect(range(0, 5))
            ->map(fn ($i) => Carbon::now()->subMonths(5 - $i)->startOfMonth())
            ->values();

        $contactByMonth = ContactRequest::query()
            ->where('submissionDate', '>=', $sixMonthsAgo)
            ->selectRaw('DATE_FORMAT(submissionDate, "%Y-%m") as ym, COUNT(*) as total')
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $partnerByMonth = PartnershipRequest::query()
            ->where('submissionDate', '>=', $sixMonthsAgo)
            ->selectRaw('DATE_FORMAT(submissionDate, "%Y-%m") as ym, COUNT(*) as total')
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $maxMonthly = 1;
        $monthBars = $months->map(function ($m) use ($contactByMonth, $partnerByMonth, &$maxMonthly) {
            $key = $m->format('Y-m');
            $contact = (int) ($contactByMonth[$key] ?? 0);
            $partner = (int) ($partnerByMonth[$key] ?? 0);
            $maxMonthly = max($maxMonthly, $contact + $partner);

            return [
                'label' => $m->format('M'),
                'contact' => $contact,
                'partner' => $partner,
                'total' => $contact + $partner,
            ];
        })->map(function ($bar) use (&$maxMonthly) {
            $bar['heightPct'] = $maxMonthly > 0 ? round(($bar['total'] / $maxMonthly) * 100) : 0;
            return $bar;
        });

        // ---- Status breakdown ---------------------------------------------
        $contactStatus = ContactRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $partnerStatus = PartnershipRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // ---- Login activity (last 30 days) ---------------------------------
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $loginSuccess = LoginHistory::where('loginTime', '>=', $thirtyDaysAgo)
            ->where('successful', true)
            ->count();

        $loginFailed = LoginHistory::where('loginTime', '>=', $thirtyDaysAgo)
            ->where('successful', false)
            ->count();

        $recentLogins = LoginHistory::with('user')
            ->orderByDesc('loginTime')
            ->take(8)
            ->get()
            ->map(fn ($l) => [
                'user' => $l->user?->fullName ?? __('Unknown user'),
                'time' => $l->loginTime,
                'successful' => (bool) $l->successful,
                'ip' => $l->ipAddress,
                'reason' => $l->failureReason,
            ]);

        // ---- Totals for KPI cards -------------------------------------------
        $kpis = [
            [
                'label' => 'Contact requests',
                'value' => ContactRequest::count(),
                'sub' => __(':count new', ['count' => $contactStatus['new'] ?? 0]),
            ],
            [
                'label' => 'Partnership requests',
                'value' => PartnershipRequest::count(),
                'sub' => __(':count new', ['count' => $partnerStatus['new'] ?? 0]),
            ],
            [
                'label' => 'Logins (30 days)',
                'value' => $loginSuccess + $loginFailed,
                'sub' => __(':count failed', ['count' => $loginFailed]),
            ],
        ];

        return view('admin.reports', [
            'kpis' => $kpis,
            'monthBars' => $monthBars,
            'contactStatus' => $contactStatus,
            'partnerStatus' => $partnerStatus,
            'recentLogins' => $recentLogins,
            'loginSuccess' => $loginSuccess,
            'loginFailed' => $loginFailed,
        ]);
    }
}
