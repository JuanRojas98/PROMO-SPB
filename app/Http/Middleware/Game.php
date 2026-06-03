<?php

namespace App\Http\Middleware;

use App\Models\Score;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Game
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $invoice_id = $request->route('invoice_id');

        $alreadyPlayed = Score::where([
            'user_id' => Auth::user()->id,
            'invoice_id' => $invoice_id,
        ])->exists();

        if ($alreadyPlayed) {
            return redirect()->route('participants.ranking');
        }

        return $next($request);
    }
}
