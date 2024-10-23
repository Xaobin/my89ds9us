<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\JsonResponse;
//use App\Http\Controllers\Api\FormatController as FormatController;


class Logacontroller extends Controller
{
    ///hu@hugostown.com:123
///= - = - = - = - = - = - = - = - = - = - = -
    public function login_get(){
        return response()->json(["ok"=>false, "status"=>401]);
    }
///= - = - = - = - = - = - = - = - = - = - = -
    public function login_post(Request $request){
	  // dd($request);
       $passw=$request->password;
       $email=$request->email;
      // $email=str_replace("II_II","@",$email);
        $credd=Auth::attempt(['email' => $email, 'password'=>$passw]);
        if($credd){ 
            $user = Auth::user(); 
           // dd($user);
            $request->session()->regenerate();
            $success['token'] =  $user->createToken('adcg &667')->plainTextToken; 
            $success['nome'] =  $user->name;
   
           // return $this->sendResponse($success, 'Login Realizado com Sucesso.');
            return response()->json($success,200);
        } 
        else{ 
            //return $this->sendError('Não Autorizado.', ['error'=>'Sem Autorização'],403);
            if (($email!=null)&&($passw!=null)){ 
               
                $msg="Os parâmetros foram recebidos e ocorreram erros..."; 
            }
            else { $msg="Problemas no recebimento dos parâmetros"; }
            return response()->json(['Aviso'=>$msg,'credentials'=>$credd,'error'=>'Sem Autorização'],403);
        } 
    }

///= - = - = - = - = - = - = - = - = - = - = -

///= - = - = - = - = - = - = - = - = - = - = -
public function login1(Request $request){
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return response()->json(['message' => 'Logged in successfully']);
    }

    return response()->json(['message' => 'Invalid credentials'], 401);
}	
///= - = - = - = - = - = - = - = - = - = - = -
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->boolean('remember')
        );
    }
///= - = - = - = - = - = - = - = - = - = - = -
 protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }
///= - = - = - = - = - = - = - = - = - = - = -
    protected function guard()
    {
        return Auth::guard();
    }
///= - = - = - = - = - = - = - = - = - = - = -
    public function register(Request $request){
       // dd($request);
        ///*
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'email'=>'required|email|string|unique:users',
            'password'=>'required|string|min:3|confirmed',
            'password_confirmation' => 'required '
        ]);
      
        if($validator->fails()){
           // return $this->sendError('Erro na validação de usuário.', $validator->errors());       
           return  response()->json(['Erro'=>'Erro de validação do usuário'],401);
        }
        
        $user=User::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password'])
           //'password'=>password_hash($request->password,PASSWORD_DEFAULT)
        ]);
        $token=$user->createToken('adcg &667');
    
    
    //return response()->json([['ok'=>true,'user'=>$user,'token'=>$token->plainTextToken],201]);
    return  response()->json(['user'=>$user,'token'=>$token->plainTextToken],200);
        //*/
    }
///= - = - = - = - = - = - = - = - = - = - = -
public function login_encrypt(Request $request){
    $method2=Hash::make($request['password']);
    $method1=password_hash($request->password,PASSWORD_DEFAULT);
    return response()->json(['Password Hash - Method 1'=>$method1,'Hash Make - Method 2'=>$method2]);
}
///= - = - = - = - = - = - = - = - = - = - = -
public function logout(){
    auth('api')->logout();
    return response()->json(['msg' => 'Logout was successful!']);
}
///= - = - = - = - = - = - = - = - = - = - = -
public function refresh(){
    $token = auth('api')->refresh(); //cliente encaminhe um jwt(ops, sqn) válido
    return response()->json(['token' => $token]);
}
///= - = - = - = - = - = - = - = - = - = - = -
public function me(){
    //dd(auth()->user());
    return response()->json(auth()->user());
   // return response()->json(mb_convert_encoding($auth->user, 'UTF-8', 'UTF-8'));
}
///= - = - = - = - = - = - = - = - = - = - = -
}
