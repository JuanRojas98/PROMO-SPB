<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_code',
        'invoice_file',
        'status',
        'observations',
        'points',
        'validated_by',
        'validated_at',
    ];

    public function score() {
        return $this->hasOne(Score::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function validator() {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
