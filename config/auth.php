<?php

// This project ships Laravel's minimal skeleton, which does not publish
// config/auth.php by default. It's added here because AuthController
// already authenticates against Auth::guard('admin') and routes/web.php
// already protects admin routes with the "auth:admin" middleware — both
// were previously pointing at a guard that didn't exist.

return [

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        // Used by every /admin route and by AuthController for staff login.
        // Backed by the same User table/model — there is no separate Admin
        // model; access to the back-office is controlled by RoleMiddleware
        // (roleName checks) on top of this guard, not by a distinct model.
        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    // Password reset in this project is fully custom (User.passwordResetToken
    // / User.tokenExpiresAt handled directly in ForgotPasswordController) and
    // does not use Laravel's password broker, so no 'passwords' table config
    // is required. Left empty to keep config/auth.php complete/valid.
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
