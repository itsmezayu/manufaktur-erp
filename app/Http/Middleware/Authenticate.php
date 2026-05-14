<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) return null;
        
        // Jika akses route accounting, redirect ke accounting login
        if (str_starts_with($request->path(), 'accounting')) {
            return route('accounting.login');
        }

        return route('accounting.login');
    }
}