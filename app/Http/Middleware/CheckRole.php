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
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = $request->user();

        if (! $user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dinonaktifkan oleh administrator.',
            ]);
        }

        // Superadmin bypasses all role restrictions
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        if (! in_array($user->role, $roles, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Forbidden. Anda tidak memiliki hak akses ke modul ini.',
                    'required_roles' => $roles,
                    'your_role' => $user->role,
                ], 403);
            }

            abort(403, 'Anda tidak memiliki hak akses (role: ' . implode(', ', $roles) . ') untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}

