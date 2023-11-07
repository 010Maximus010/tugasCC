<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\tb_entry_progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IRS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $countSemsester = tb_entry_progress::where('nim', Auth::user()->nim_nip)->count();
        if (tb_entry_progress::where('nim', Auth::user()->nim_nip)
            ->where('semester_aktif', $countSemsester)
            ->where('is_irs', 1)->exists()
        ) {
            return redirect()->route('khs.index');
        } else if (tb_entry_progress::where('nim', Auth::user()->nim_nip)->count() == 0) {
            return redirect('mahasiswa/entry');
        } else {
            return $next($request);
        }
    }
}
