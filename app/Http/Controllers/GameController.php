<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'score' => 'required|integer|min:0',
        ]);

        $alreadyPlayed = Score::where([
            'user_id' => Auth::user()->id,
            'invoice_id' => $request->invoice_id
        ])->exists();

        if ($alreadyPlayed) {
            return response()->json([
                'success' => false,
                'message' => 'Ya participaste con esta factura.'
            ], 409);
        }

        $score = Score::create([
            'user_id' => Auth::user()->id,
            'invoice_id' => $request->invoice_id,
            'points' => $request->score
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Puntaje guardado correctamente.',
            'data' => $score
        ]);
    }
}
