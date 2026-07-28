<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddlewarev
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(!$request->user()){
            return redirect()->route('login')
            ->witherror('Anda harus login terlebih dahulu.');
        }

        $userRole = $request->user()->role->name;

        if(!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
        return $next($request);
    }
}
