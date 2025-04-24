<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Get the user's position (which is their role)
            $position = $user->position;

            // Check if user is on the correct dashboard for their role
            $currentPath = $request->path();

            // If this is the main dashboard, redirect based on role
            if ($currentPath === '/admin_dashboard') {
                switch($position) {
                    case 'project-manager':
                        return redirect('/projects/registration');
                    case 'accountant':
                        return redirect('/billings');
                    case 'inventory-staff':
                        return redirect('/inventory');
                    case 'supplier':
                        return redirect('/projects');
                    default:
                        // Admin stays on dashboard
                        break;
                }
            }
        }

        return $next($request);
    }
}
