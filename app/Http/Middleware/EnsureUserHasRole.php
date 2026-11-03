<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        $userRole = strtolower($user->roleModel?->name ?? $user->role ?? '');

        $allowedRoles = array_map('strtolower', $roles);

        if (in_array('administrator', $allowedRoles, true) && ! in_array('admin', $allowedRoles, true)) {
            $allowedRoles[] = 'admin';
        }
        if (in_array('admin', $allowedRoles, true) && ! in_array('administrator', $allowedRoles, true)) {
            $allowedRoles[] = 'administrator';
        }

        if (! in_array($userRole, $allowedRoles, true) && ! in_array(strtolower((string) $user->role), $allowedRoles, true)) {
            abort(403, 'Unauthorized access to this portal.');
        }

        return $next($request);
    }
}
