<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\File; ///X
use App\Models\Marca as marca;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\FormatController as FormatController;

class MarcaController extends FormatController
{
    /*
    Prevent validator redirecting back
         $validator = Validator::make($request->all(), $this->rules());

         if ($validator->fails()) {
              $response['result'] = false;
             $response['message'] = $validator->messages();
             return  response()->json($response);
          }

     */
    public function __construct(marca $marcax){
        $this->marca=$marcax;
    }

    public function index(Request $request)
    {
            //$marcaX=$this->filter($request,$this->marca,'refModelos');
            $marcaX=$this->filtrate($request,$this->marca);
            if ($marcaX=="404"){
                return $this->sendError('Não foi possível localizar o recurso informado.', 404);       
               // return response()->json(['msg'=>'Recurso não encontrado'],404);
            }
           
            if ($marcaX==null)
            { $marcaX = $this->marca->with('refModelos')->get(); }
           return response()->json($marcaX,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate($this->marca->rules(), $this->marca->feedback());
        //dd($request);
        $imagem=$request->file('imagem');
        $imagem_urn=$imagem->store('images','public2'); ///X config/filesystems
     

        $marcaH=$this->marca->create(['nome'=>$request->nome,'imagem'=>$imagem_urn]);
      
        return response()->json($marcaH,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($num)
    {
        //$marcaX=marca::where("id","=",$num)->get();
       $marcaX=$this->marca->with('refModelos')->find($num);
       if ($marcaX===null){
        return response()->json(['msg'=>'Não foi possível localizar o recurso'],404);
       }
        return response()->json($marcaX,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $myid){
        $marcaX=$this->marca->find($myid);

       if ($marcaX==null){
        return response()->json(['msg'=>'o recurso solicitado não existe'],404);
       }
       if ($request->method()=="PATCH"){
            //dinamic rules, rules() is model method 
            $dinrules=array();
          foreach($marcaX->rules() as $input => $rule) {
            //search a key in array   
            if(array_key_exists($input, $request->all())) 
                { $dinrules[$input] = $rule; }
          }
          $request->validate($dinrules, $marcaX->feedback());
       }
       if ($request->method()=="PUT"){
        $request->validate($marcaX->rules(), $marcaX->feedback());
       } 
    //................
            if($request->file('image')) {
                Storage::disk('public2')->delete($marcaX->image); 
                $image = $request->file('image');
                $image_urn = $image->store('images', 'public2');

                $marcaX->fill($request->all());
                $marcaX->image=$image_urn;
                $marcaX->name=$request->name;
                $marcaX->save();
            }
    //................
        else{
            $marcaX->fill($request->all());
            //$marcaX->image=$image_urn;
            $marcaX->save();
            }
      
       return response()->json($marcaX, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($myid)
    {
        $marcaX = $this->marca->find($myid);

        if($marcaX === null) {
            return response()->json(['error' => ' Nenhum registro foi deletado'], 404);
        }
        Storage::disk('public')->delete($marcaX->image);
        $marcaX->delete();
        return response()->json(['msg' => 'Registro removido com sucesso'], 200);
    }

    private function filtrate($request,$objInst){
        if ($request->has('myfilter')){
            //?myfilter= base64 valor
            //base 64 decode: field&&&value
            //aWQmJiY0 is id&&&4
            $myfilter=base64_decode($request->myfilter);
            $vvv=explode("&&&",$myfilter);
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
}
