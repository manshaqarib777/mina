<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Auth;
use App\Role;
use App\Categoria;
use App\User;
use App\Mail\UserNotification;
use DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Clickatell\Rest;
use Clickatell\ClickatellException;

class CategoriaController extends Controller
{

    public function create()
    {
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        $ldms_users_all = Categoria::all();
        $ldms_total_users_number = count($ldms_users_all);
        $ldms_user_list = Categoria::all();
        return view('categoria.create', compact('ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_users_all', 'ldms_user_list', 'ldms_total_users_number'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'categoria_name' => 'max:255',
        ]);
        $data = $request->all();
        $ldms_general_setting_data = \App\GeneralSetting::latest()->first();
      
           $message = ' Categoría agregada con éxito.';
      
        Categoria::create($data);
        return redirect('categoria/create')->with('message', $message);
    }

    public function ldmsUserSearch()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        
        $ldms_users_all = Categoria::all();
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        
        $ldms_user_name = $_GET['ldms_userNameSearch'];
        $ldms_user_list = DB::table('users')
                        ->where('name', $ldms_user_name)->get();
       
        if (count($ldms_user_list)==0) {
            return redirect()->back()->with('message1', 'Searched item does not exists.');
        }

        return view('categoria.search', compact('ldms_users_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_user_list'));
    }

    
    public function edit($id)
    {
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->where([
                        ['expired_date', '>=', $todayDate],
                        ['expired_date', '<' , $interval]
                    ])->get();
        $ldms_user_data = Categoria::findOrFail($id);
        return view('categoria.edit', compact('ldms_user_data', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function update(Request $request, $id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
  
        $input = $request->all();
        $ldms_user_data = Categoria::findOrFail($id);
        $ldms_user_data->update($input);
        return redirect('categoria/create')->with('message', 'Datos de usuario actualizados con éxito');
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $data = Categoria::findOrFail($id);
        $data->delete();
        return redirect('categoria/create')->with('message', 'User Data Deleted Sucessfully');
    }

    public function userPass()
    {
        echo str_random(8);
    }
}