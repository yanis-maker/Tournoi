<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
      $manager = User::where('permission','>=',1)->get();
      $manageroqp = Tournament::where('statut','>',0)->get('manager_id');
      $managerDispo = User::whereNotIn('id' ,$manageroqp)->where('permission',1)->get();
      $user_permRequest=User::where('perm_request',true)->get();



      return view('admin.dashboard',[
        'managerDispo'=>$managerDispo,
        'Manager'=>$manager,
        'user_permRequest'=>$user_permRequest,
        ]);
    }


    public function change_perm(Request $request){


      $data= $request -> validate([
        'email'=> 'required|email|exists:App\Models\User,email',
      ]);

      $perm=User::where('email',$data['email'])->get();
      $permission=User::where('email',$data['email'])->first();

      if($permission->permission==2){
        return back()->with(['error'=>'Cet utilisateur est admin!']);
      }

      if($request['permission']=='Gestionnaire'){
        $perm->toQuery()->update(['permission'=>1]);
        $perm->toQuery()->update(['perm_request'=>0]);
        return redirect()->route('dashboard-admin')->with('success','Cet utilisateur est maintenant Gestionnaire');
      }
      else if($request['permission']=='Capitaine'){
        $perm->toQuery()->update(['permission'=> 0]);
        return redirect()->route('dashboard-admin')->with('success','Cet utilisateur est maintenant Capitaine');
      }

    }


    public function Creation_Tournoi(Request $request)
    {
        $data=$request->validate([
          'nom' =>'required|max:255',
          'email' => 'required|email|exists:App\Models\User,email',
          'date_start' => 'required|date',
          'date_end' => 'required|date|after:date_start',
          'location' => 'required|min:4|max:255',
          'team_nb' => 'required|numeric'
        ]);

        $manager_id=User::where('email',$request->input('email'))->get('id');
        $manager_id=$manager_id[0]["id"];

        Tournament::create([
            'label' => $data['nom'],
            'manager_id'=>$manager_id,
            'date_start'=>$data['date_start'],
            'date_end'=>$data['date_end'],
            'location'=>$data['location'],
            'teams_nb'=>$data['team_nb'],
        ]);

        $manager = User::where('permission',1)->get();
        $manageroqp = Tournament::where('statut','>',0)->get();
        $managerDispo = User::whereNotIn('email' ,$manageroqp)->where('permission',1)->get();
        $user_permRequest=User::where('perm_request',true)->get();

        return redirect()->route('dashboard-admin')->with('success','Le tournoi est désormais créé');

    }


}
