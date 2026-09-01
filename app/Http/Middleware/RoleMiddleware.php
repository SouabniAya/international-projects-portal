<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user('admin') ?? $request->user();

        if (!$user) {
            abort(401);
        }

        foreach ($roles as $role) {
            $allowed = match (strtolower($role)) {
                'super', 'super-admin', 'super_admin' => $user->isSuperAdmin(),
                'functional', 'functional-admin', 'functional_admin' => $user->isFunctionalAdmin(),
                'admin', 'administrator', 'content' => $user->canManageContent(),
                default => $user->roles()->where('roleName', $role)->exists(),
            };

            if ($allowed) {
                return $next($request);
            }
        }

        abort(403, 'You do not have permission to access this page.');
    }
}
