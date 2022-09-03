<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tournament;
use App\Models\Match;

class FixDate implements Rule
{
    protected $id;
    protected $request;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id,$request)
    {
        $this->id=$id;
        $this->request=$request;
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
        $date_first_tour=Match::where('tournament_id',$this->id)->get('date');
        $pass=true;
        $i=0;
        
        foreach($date_first_tour as $date){
            $date_list[$i]=$date->date;
            $i++;
        }

        $date_max=max($date_list);
        return ($value>=$date_max);

        //dd($value<$date_list[3]);
        //dd($date_list);
        //return $pass;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $date_first_tour=Match::where('tournament_id',$this->id)->get('date');
        $i=0;
        
        foreach($date_first_tour as $date){
            $date_list[$i]=$date->date;
            $i++;
        }
        $date_max=Carbon::createFromFormat('Y-m-d',max($date_list))->format('d-m-Y');
        return 'Date invalide vous devez choisir une date après le '.$date_max;
    }
}
