<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 
///= - = - = - = - = - = - = - = - = - = - = -
     public function index(){
        /// view -> with(var, valor) - uma das três formas de enviar dados para view
         return view('/home');
     }
///= - = - = - = - = - = - = - = - = - = - = -
public function login_one(Request $request){
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['message' => 'Logged in successfully']);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
 }
///= - = - = - = - = - = - = - = - = - = - = -
     public function marcas(){
         
         return view('app.marcas');
     }
///= - = - = - = - = - = - = - = - = - = - = -
     public function clientes(){
        
         return view('app.clientes');
     }
///= - = - = - = - = - = - = - = - = - = - = -=
      public function modelos(){
          
          return view('app.modelos');
      }
 ///= - = - = - = - = - = - = - = - = - = - = -=
      public function carros(){
          
         return view('app.carros');
     }
///= - = - = - = - = - = - = - = - = - = - = -
     public function alugueis(){
          
         return view('app.alugueis');
     }
///= - = - = - = - = - = - = - = - = - = - = -
}
