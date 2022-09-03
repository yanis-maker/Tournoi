<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tournament;
use App\Models\Match;

class DateMatch implements Rule
{

    protected $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $date_start=Tournament::where('id',$this->id)->first()->date_start;
        $date_end=Tournament::where('id',$this->id)->first()->date_end;

        return ($value > $date_start && $value < $date_end);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $date_start=Carbon::createFromFormat('Y-m-d',Tournament::where('id',$this->id)->first()->date_start)->format('d-m-Y');
        $date_end=Carbon::createFromFormat('Y-m-d',Tournament::where('id',$this->id)->first()->date_end)->format('d-m-Y');
        return ':attribute est invalide. Veuillez entrer une date entre le '.$date_start.' et '.$date_end.'.' ;
    }
}
