<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Debugging: Log the current user and requested roles
        Log::info('Current User:', [
            'authenticated'   => Auth::check(),
            'user'            => Auth::user(),
            'requested_roles' => $roles,
        ]);

        if (! Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Debugging: Log the user's role
        Log::info('User Role Check:', [
            'user_role'     => $user->role,
            'allowed_roles' => $roles,
            'role_match'    => in_array($user->role, $roles),
        ]);

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on user's role if unauthorized
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard')
                    ->with('error', 'You do not have permission to access this page.');
            case 'organizer':
                return redirect()->route('organizer.dashboard')
                    ->with('error', 'You do not have permission to access this page.');
            case 'user':
            default:
                return redirect()->route('dashboard')
                    ->with('error', 'You do not have permission to access this page.');
        }
    }
}
