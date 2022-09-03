<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $table = 'match';

    protected $fillable = [
        'numMatch',
        'team_1',
        'team_2',
        'score_1',
        'score_2',
        'date',
        'tournament_id',
    ];

    public $timestamps = false;
}
