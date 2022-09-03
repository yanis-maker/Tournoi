<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
      'label',
      'manager_id',
      'date_start',
      'date_end',
      'location',
      'teams_nb',
    ];

    public $timestamps = false;

    protected $attributes= [
      'statut' => 2,
      'teams_list'=>"{}",
      'teams_pending'=>"{}",
    ];
}
