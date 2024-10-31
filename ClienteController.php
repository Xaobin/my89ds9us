<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
//use App\Http\Requests\StoreClienteRequest;
//use App\Http\Requests\UpdateClienteRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
//= = == = == = == = == = == = == = == = ===
public function __construct(Cliente $clientex) {
    $this->cliente = $clientex;
}
//= = == = == = == = == = == = == = == = ===
    public function index(Request $request)
    {
         $clienteX=$this->filtrate($request,$this->cliente);
        if ($clienteX=="404"){
            return response()->json(['msg'=>'recurso não encontrado'],404);
        }

        return response()->json($clienteX, 200);
    }

//= = == = == = == = == = == = == = == = ===
    public function create()
    {
        //
    }

//= = == = == = == = == = == = == = == = ===
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());

        $clienteX = $this->cliente->create([
            'nome' => $request->nome
        ]);

        return response()->json($clienteX, 201);
    }

//= = == = == = == = == = == = == = == = ===
    public function show($myid)
    {
        $clienteX = $this->cliente->find($myid);
        if($clienteX === null) {
            return response()->json(['error' => 'O recurso não foi encontrado'], 404) ;
        } 

        return response()->json($clienteX, 200);
    }

//= = == = == = == = == = == = == = == = ===
    public function edit(Cliente $cliente)
    {
        //
    }

//= = == = == = == = == = == = == = == = ===
public function update(Request $request, $myid){
    $clienteX = $this->cliente->find($myid);

    if($clienteX === null) {
        return response()->json(['error' => 'Recurso não encontrado - falha na atualização'], 404);
    }

    if($request->method() === 'PATCH') {

        $dinrules = array();

        
        foreach($clienteX->rules() as $input => $rule) {
            
            if(array_key_exists($input, $request->all())) {
                $dinrules[$input] = $rule;
            }
        }
        
        $request->validate($dinrules);

    } else {
        $request->validate($clienteX->rules());
    }
    
    $clienteX->fill($request->all());
    $clienteX->save();
    
    return response()->json($clienteX, 200);
}

//= = == = == = == = == = == = == = == = ===
    public function destroy(Cliente $cliente)
    {
        //
    }

//= = == = == = == = == = == = == = == = ===
private function filtrate($request,$objInst){
    if ($request->has('myfilter')){
        $myfilter=base64_decode($request->myfilter);
        $vvv=explode("&&&",$myfilter);
        ///Método do App/Models/Client
        $objInst=$objInst->simpleSearch($vvv[0],$vvv[1]);
        if ($objInst==null){
            return "404";
        }
        return $objInst;
    } else{
    $objInst=$objInst->get();
        return $objInst;
    }    
}
//= = == = == = == = == = == = == = == = ===
private function filter($request,$objInstance){
    $objInst=$objInstance;
    $objInst2=null;
//................ 
    if($request->has('filter')) {
        $filters = explode(';', $request->filter);
        foreach($filters as $key => $condition) {
            $c = explode(':', $condition);
            $objInst = $objInst->where($c[0], $c[1], $c[2]);
        }
    }
//................
    if($request->has('fields')) {
        $fields = $request->fields;
        $objInst = $objInst->selectRaw($fields);
    } 
    else {  return $objInst->all();  }
//................
    $objInst=$objInst->get();
    return $objInst;
}
//= = == = == = == = == = == = == = == = ===
}
