<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
//use App\Http\Requests\StoreCarroRequest;
//use App\Http\Requests\UpdateCarroRequest;

class CarroController extends Controller
{
/// - - - - - - - - - - - - - - - - - - - - - - - -        
    public function __construct(Carro $carrox) {
        $this->carro = $carrox;
    }
/// - - - - - - - - - - - - - - - - - - - - - - - -   
    public function index(Request $request) 
    {
        $carroX=$this->filtrate($request,$this->carro,'refModelo');
        if ($carroX=="404"){
            return response()->json(['msg'=>'Recurso não encontrado'],404);
        }

        return response()->json($carroX, 200);
    }

/// - - - - - - - - - - - - - - - - - - - - - - - - 
    public function create()
    {
        //
    }

 /// - - - - - - - - - - - - - - - - - - - - - - - -    
    public function store(Request $request)
    {
        $request->validate($this->carro->rules());

        $carroX = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carroX, 201);
    }
 /// - - - - - - - - - - - - - - - - - - - - - - - -      
    public function show($myid){
        
        $carroX = $this->carro->with('refModelo')->find($myid);
        if($carroX === null) {
            return response()->json(['error' => 'O recurso não foi localizado'], 404) ;
        } 

        return response()->json($carroX, 200);
    }


/// - - - - - - - - - - - - - - - - - - - - - - - -   
    public function edit(Carro $Carro)
    {
        //
    }
/// - - - - - - - - - - - - - - - - - - - - - - - -   
    public function update(Request $request, $myid)
    {
        $carroX = $this->carro->find($myid);

        if($carroX === null) {
            return response()->json(['error' => 'Recurso não encontrado'], 404);
        }

       //.............
       if($request->method() === 'PATCH') {

        $dinrules = array();

        //percorrendo todas as regras definidas no Model
        foreach($carroX->rules() as $input => $rule) {
            
            //coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
            if(array_key_exists($input, $request->all())) {
                $dinrules[$input] = $rule;
            }
        }
        $request->validate($dinrules);
    } else {
        $request->validate($carroX->rules());
    }
       //.............
        
        $carroX->fill($request->all());
        $carroX->save();
        
        return response()->json($carroX, 200);
    }
    /// - - - - - - - - - - - - - - - - - - - - - - - -   
    public function destroy($myid)
    {
        $carroX = $this->carro->find($myid);

        if($carroX === null) {
            return response()->json(['erro' => 'Erro - Recurso não encontrado'], 404);
        }

        $carroX->delete();
        return response()->json(['msg' => 'Carro excluído!'], 200);
    }
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
private function filtrate($request,$objInstance,$ref_method){
    
    $field_like='placa';
    /*
    filter = name=eco@@doors=4@@seats=4@@air_bag=1@@abs=1
    filter=
    bmFtZT1lY29AQGRvb3JzPTRAQHNlYXRzPTRAQGFpcl9iYWc9MUBAYWJzPTE=
    */
    if ($request->has('filter')){ //begin filter
    $objInstance=$objInstance->with($ref_method);
    $myfilter=base64_decode($request->filter);
    $contArroba=substr_count($myfilter,"@@");
        if ($contArroba>0){
            $valys=explode("@@",$myfilter);
            for ($i=0; $i<=count($valys)-1;$i++){
            $vvv=explode("=",$valys[$i]);
            if (($vvv[0]==$field_like) and (isset($vvv[1]) ) ){
                $objInstance=$objInstance->where($vvv[0],"like","%".$vvv[1]."%");
            }
            else{
                if (isset($vvv[1])){
                    $objInstance=$objInstance->where($vvv[0],$vvv[1]);
                }
            }
        }  }
       if ($contArroba<=0){
         $vvv=explode("=",$myfilter);
         if (($vvv[0]==$field_like) and (isset($vvv[1]) ) ){
                $objInstance=$objInstance->where($vvv[0],"like","%".$vvv[1]."%");
            }
            else{
                if (isset($vvv[1])){
                    $objInstance=$objInstance->where($vvv[0],$vvv[1]);
                }
        }  }
    if ($objInstance==null){
        return "404";
    }
    $objInstance=$objInstance->get();
    return $objInstance;
    } // . . . . End Filter 1

    if ($request->has('refmodelovalues')){
        /// xa  - VALOR OBTIDO NO App\Models\Carro-Car
        /// retorna as referências para serem selecionadas no view
        return $objInstance->refModeloValues();
    }    

   //..No one filter, return all
    $objInstance=$objInstance->with($ref_method);
    $objInstance=$objInstance->get();
    return $objInstance;
}

//==================================

}
