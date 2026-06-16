<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InvoicePlayed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $hasPendingInvoice = $user->invoices()
            ->whereDoesntHave('score')
            ->first();

        if ($hasPendingInvoice && (!$request->routeIs('participants.game') && !$request->routeIs('participants.game.score'))) {
            return redirect()->route('participants.game', ['invoice_id' => $hasPendingInvoice->id]);
        }

        return $next($request);
    }
}
