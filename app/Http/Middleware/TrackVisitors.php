<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $response = $next($request);

        // Hanya mencatat request GET
        if (!$request->isMethod('GET')) {
            return $response;
        }

        // Jangan mencatat halaman admin
        if ($request->is('admin/*')) {
            return $response;
        }

        // Jangan mencatat file asset
        if (
            $request->is('storage/*') ||
            $request->is('build/*')
        ) {
            return $response;
        }

        // Ambil ID pengunjung dari cookie
        $visitorKey = $request->cookie('eapbdesa_visitor');

        // Jika belum ada cookie, buat ID baru
        if (!$visitorKey) {
            $visitorKey = (string) Str::uuid();
        }

        $today = now()->toDateString();

        // Hash IP, bukan menyimpan IP asli
        $ipHash = $request->ip()
            ? hash('sha256', $request->ip())
            : null;

        // Hash User Agent
        $userAgentHash = $request->userAgent()
            ? hash('sha256', $request->userAgent())
            : null;

        // Satu pengunjung dihitung satu kali per hari
        VisitorLog::firstOrCreate(
            [
                'visitor_key' => $visitorKey,
                'visited_date' => $today,
            ],
            [
                'ip_hash' => $ipHash,
                'user_agent_hash' => $userAgentHash,
                'path' => $request->path(),
            ]
        );

        // Simpan cookie selama 1 tahun
        if (!$request->hasCookie('eapbdesa_visitor')) {
            Cookie::queue(
                Cookie::make(
                    'eapbdesa_visitor',
                    $visitorKey,
                    60 * 24 * 365,
                    '/',
                    null,
                    $request->isSecure(),
                    true,
                    false,
                    'lax'
                )
            );
        }

        return $response;
    }
}