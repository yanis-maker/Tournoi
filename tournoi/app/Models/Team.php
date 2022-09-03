<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'label',
        'address',
        'phone',
        'captain',
    ];

    public $timestamps = false;

    protected $attributes=[
        'player_list'=>"{}",
    ];
}
