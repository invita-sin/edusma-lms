<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $roleList = [];

        foreach ($roles as $role) {
            $roleList = array_merge($roleList, explode(',', $role));
        }
        $roleList = array_map('trim', $roleList);

        foreach ($roleList as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        if ($request->is('admin*') && ($user->hasRole('teacher') || $user->hasRole('student'))) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini. Silakan login melalui portal yang sesuai.');

            if ($user->hasRole('teacher')) {
                return redirect('/teacher/login');
            }

            return redirect('/student/login');
        }

        if ($request->is('teacher*') && $user->hasRole('student')) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini.');
            return redirect('/student/login');
        }

        if ($request->is('student*') && $user->hasRole('teacher')) {
            session()->flash('error', 'Anda tidak memiliki akses ke halaman ini.');
            return redirect('/teacher/login');
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
