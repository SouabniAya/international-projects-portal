<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Display the users management page.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $roleId = $request->query('role');
        $status = $request->query('status');

        $query = User::query()
            ->with([
                'roles',
                'loginHistory' => function ($query) {
                    $query->latest('loginTime');
                },
            ]);

        /*
         * Search users
         */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('userName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
         * Filter by role
         */
        if ($roleId !== null && $roleId !== '') {
            $query->whereHas('roles', function ($q) use ($roleId) {
                $q->where('Role.roleID', $roleId);
            });
        }

        /*
         * Filter by account status
         */
        if (in_array($status, ['active', 'disabled'], true)) {
            $query->where('accountStatus', $status);
        }

        /*
         * Paginated users
         */
        $users = $query
            ->orderByDesc('userID')
            ->paginate(10)
            ->withQueryString();

        /*
         * Statistics
         */
        $totalUsers = User::count();

        $activeUsers = User::where(
            'accountStatus',
            'active'
        )->count();

        $inactiveUsers = User::where(
            'accountStatus',
            'disabled'
        )->count();

        $rolesCount = Role::count();

        /*
         * Roles for the filter dropdown
         */
        $roles = Role::orderBy('roleName')->get();

        /*
         * IMPORTANT:
         * The Blade file is:
         *
         * resources/views/admin/users/index.blade.php
         */
        return view('admin.users.index', compact(
            'users',
            'roles',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'rolesCount',
            'search',
            'roleId',
            'status'
        ));
    }

    /**
     * Show the create user form.
     */
    public function create(): View
    {
        $roles = Role::orderBy('roleName')->get();

        return view(
            'admin.users.create',
            compact('roles')
        );
    }

    /**
     * Store a new user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'firstName' => [
                'required',
                'string',
                'max:100',
            ],

            'lastName' => [
                'required',
                'string',
                'max:100',
            ],

            'userName' => [
                'required',
                'string',
                'max:100',
                'unique:User,userName',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:User,email',
            ],

            'phoneNumber' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'accountStatus' => [
                'required',
                'in:active,disabled',
            ],

            'roleID' => [
                'nullable',
                'integer',
                'exists:Role,roleID',
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'integer',
                'exists:Role,roleID',
            ],
        ]);

        $roleIds = $request->input('roles', []);
        if ($request->filled('roleID') && empty($roleIds)) {
            $roleIds = [(int) $request->input('roleID')];
        }

        DB::transaction(function () use ($validated, $roleIds) {

            $user = User::create([
                'firstName' => $validated['firstName'],
                'lastName' => $validated['lastName'],
                'userName' => $validated['userName'],
                'email' => $validated['email'],
                'phoneNumber' => $validated['phoneNumber'] ?? null,
                'password' => Hash::make($validated['password']),
                'accountStatus' => $validated['accountStatus'],
            ]);

            if (!empty($roleIds)) {
                $user->roles()->sync(array_map('intval', array_values($roleIds)));
            }
        });

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User created successfully.'
            );
    }

    /**
     * Display one user.
     */
    public function show(User $user): View
    {
        $user->load([
            'roles',
            'loginHistory' => function ($query) {
                $query->latest('loginTime');
            },
        ]);

        return view(
            'admin.users.show',
            compact('user')
        );
    }

    /**
     * Show edit user form.
     */
    public function edit(User $user): View
    {
        $roles = Role::orderBy('roleName')->get();

        $user->load('roles');

        return view(
            'admin.users.edit',
            compact(
                'user',
                'roles'
            )
        );
    }

    /**
     * Update user.
     */
    public function update(
        Request $request,
        User $user
    ): RedirectResponse {
        $validated = $request->validate([
            'firstName' => [
                'required',
                'string',
                'max:100',
            ],

            'lastName' => [
                'required',
                'string',
                'max:100',
            ],

            'userName' => [
                'required',
                'string',
                'max:100',
                'unique:User,userName,' . $user->userID . ',userID',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:User,email,' . $user->userID . ',userID',
            ],

            'phoneNumber' => [
                'nullable',
                'string',
                'max:20',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'accountStatus' => [
                'required',
                'in:active,disabled',
            ],

            'roleID' => [
                'nullable',
                'integer',
                'exists:Role,roleID',
            ],

            'roles' => [
                'nullable',
                'array',
            ],

            'roles.*' => [
                'integer',
                'exists:Role,roleID',
            ],
        ]);

        $roleIds = $request->input('roles', []);
        if ($request->filled('roleID') && empty($roleIds)) {
            $roleIds = [(int) $request->input('roleID')];
        }

        DB::transaction(function () use (
            $validated,
            $user,
            $roleIds
        ) {

            $user->firstName = $validated['firstName'];
            $user->lastName = $validated['lastName'];
            $user->userName = $validated['userName'];
            $user->email = $validated['email'];
            $user->phoneNumber =
                $validated['phoneNumber'] ?? null;
            $user->accountStatus =
                $validated['accountStatus'];

            /*
             * Only change the password when a new
             * password was provided.
             */
            if (!empty($validated['password'])) {
                $user->password = Hash::make(
                    $validated['password']
                );
            }

            $user->save();

            /*
             * Sync roles.
             */
            $user->roles()->sync(
                array_map('intval', array_values($roleIds))
            );
        });

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User updated successfully.'
            );
    }

    /**
     * Enable / disable a user.
     */
    public function toggleStatus(
        User $user
    ): RedirectResponse {
        /*
         * Do not allow the currently authenticated
         * administrator to disable their own account.
         */
        if (
            auth('admin')->check() &&
            (int) auth('admin')->id() === (int) $user->userID
        ) {
            return back()->with(
                'error',
                'You cannot disable your own account.'
            );
        }

        $user->accountStatus =
            $user->accountStatus === 'active'
                ? 'disabled'
                : 'active';

        $user->save();

        return back()->with(
            'success',
            $user->accountStatus === 'active'
                ? 'User activated successfully.'
                : 'User disabled successfully.'
        );
    }

    /**
     * Delete a user.
     */
    public function destroy(
        User $user
    ): RedirectResponse {
        /*
         * Do not allow the currently authenticated
         * administrator to delete their own account.
         */
        if (
            auth('admin')->check() &&
            (int) auth('admin')->id() === (int) $user->userID
        ) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        DB::transaction(function () use ($user) {

            /*
             * Remove role assignments first.
             */
            $user->roles()->detach();

            /*
             * Delete login history if there is
             * no database cascade configured.
             */
            $user->loginHistory()->delete();

            /*
             * Delete the user.
             */
            $user->delete();
        });

        return redirect()
            ->route('admin.users.index')
            ->with(
                'success',
                'User deleted successfully.'
            );
    }

    /**
     * Users permissions page.
     */
    public function permissions(): View
    {
        $roles = Role::with('users')
            ->orderBy('roleName')
            ->get();

        return view(
            'admin.users.permissions',
            compact('roles')
        );
    }

    /**
     * Login history page.
     */
public function loginHistory()
{
    $loginHistory = \App\Models\LoginHistory::with('user')
        ->orderByDesc('loginTime')
        ->paginate(20);

    return view('admin.users.login-history', [
        'loginHistory' => $loginHistory,
    ]);
}

    /**
     * Export users as CSV.
     */
    public function export(): StreamedResponse
    {
        $users = User::with('roles')
            ->orderBy('userID')
            ->get();

        $filename =
            'users-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';

        return response()->streamDownload(
            function () use ($users) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                /*
                 * CSV header.
                 */
                fputcsv($handle, [
                    'ID',
                    'First Name',
                    'Last Name',
                    'Username',
                    'Email',
                    'Phone',
                    'Roles',
                    'Status',
                ]);

                /*
                 * CSV rows.
                 */
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->userID,
                        $user->firstName,
                        $user->lastName,
                        $user->userName,
                        $user->email,
                        $user->phoneNumber,
                        $user->roles
                            ->pluck('roleName')
                            ->implode(', '),
                        $user->accountStatus,
                    ]);
                }

                fclose($handle);
            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }
    public function managePermissions($role)
{
    $role = \App\Models\Role::with('permissions')->findOrFail($role);

    return view('admin.users.manage-permissions', [
        'role' => $role,
    ]);
}
}