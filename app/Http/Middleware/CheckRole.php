<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$positions): Response
    {
        if (!$request->user()) {
            return redirect('login');
        }

        // Convert positions string to array (e.g., 'admin|project-manager' => ['admin', 'project-manager'])
        $allowedPositions = [];
        foreach ($positions as $position) {
            $allowedPositions = array_merge($allowedPositions, explode('|', $position));
        }

        // Check if user position is in the allowed positions array
        // We'll do a case-insensitive check to be more flexible
        $userPosition = strtolower($request->user()->position);
        $isAllowed = collect($allowedPositions)->contains(function ($position) use ($userPosition) {
            return strtolower($position) === $userPosition;
        });

        if ($isAllowed) {
            return $next($request);
        }

        // Return a proper response object instead of using abort
        return response('Unauthorized action.', 403);
    }
}
