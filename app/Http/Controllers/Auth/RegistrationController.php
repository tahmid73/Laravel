<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }
    public function index(){
        return view('auth.register');
    }
    public function store(Request $request){
        //validation
        $this->validate($request,[
            'name'=>'required',
            'username'=>'required',
            'password'=>'required',
            'email'=>'required|email'
        ]);

        User::create([
            'name'=>$request->name,
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        auth()->attempt($request->only('email','password'));
        return redirect()->route('dashboard');
        //store
        //sign
        //redirect
    }

}
