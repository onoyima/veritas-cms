<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Models\User;

class EnsureStaffHasCmsAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('staff')->check()) {
            return redirect()->route('staff.login');
        }

        $staff = Auth::guard('staff')->user();

        /** @var \App\Models\Staff $staff */
        if (!$staff) {
             return redirect()->route('staff.login');
        }

        // Check for Management Role (5) or if user has any website role
        // We check 'role' or 'user_type' attribute on Staff model
        // If not found, we check the related User model's user_type

        $role = $staff->role ?? $staff->user_type ?? null;

        if ($role === null && $staff->user) {
            $role = $staff->user->user_type;
        }

        // Allow access if role is Management (5), Admin (1), or has any website role
        // Admin role might come from User model (1)
        if ($role == Staff::ROLE_MGT || $role == 1 || $staff->websiteRoles()->exists()) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to CMS.');
    }
}
