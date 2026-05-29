<?php

namespace App\Livewire\Participants\Ranking;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $ranking = [];
    public $currentUserPoints = 0;
    public $currentUserPosition = null;

    public function render()
    {
        return view('livewire.participants.ranking.index')
            ->layout('layouts.game');
    }

    public function mount() {
        $this->getRanking();
    }

    public function getRanking() {
        $ranking = User::query()
            ->where('role_id', 3)
            ->withSum([
                'scores as total_points' => function($query) {
                    $query->whereHas('invoice', function($q) {
                        $q->where('status', 'approved');
                    });
                }
            ], 'points')
            ->orderByDesc('total_points')
            ->get();

        $this->ranking = $ranking->take(10);

        $currentUser = $ranking->firstWhere('id', Auth::user()->id);

        $this->currentUserPoints = $currentUser?->total_points ?? 0;
        $this->currentUserPosition = $ranking->search(fn ($user) => $user->id === Auth::user()->id) + 1;
    }
}
