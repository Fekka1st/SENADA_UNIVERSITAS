<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Services\PermissionService;

class CheckModuleAccess
{
    /**
     * Handle an incoming request.
     * Check if user can access specific module based on any permission from that module
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!PermissionService::canAccessModule($user, $module)) {
            abort(403, 'Anda tidak memiliki akses untuk mengakses modul ini.');
        }

        return $next($request);
    }
}
