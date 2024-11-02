<?php

namespace App\Http\Controllers;

use App\Models\Aluguel;
//use App\Http\Requests\StoreAlugueisRequest;
//use App\Http\Requests\UpdateAlugueisRequest;
use Illuminate\Http\Request;

class AluguelController extends Controller
{
/// * * * * * * * * * * * * * * * * * * * * * * * * * * 
public function __construct(Aluguel $aluguelA) {
    $this->aluguel = $aluguelA;
}
/// * * * * * * * * * * * * * * * * * * * * * * * * * * 
public function index(Request $request)
{
    //$aluguelX=$this->filtrate($request,$this->aluguel,'temCliente','temCarro');
    $aluguelX=$this->filterA0($request,$this->aluguel,'temCliente','temCarro');
    //$aluguelX=$this->defaultFilter($request,$this->aluguel);
    if (($aluguelX=="404")or($aluguelX==NULL)){
        return response()->json(['msg'=>'Recurso não localizado'],404);
    }
    return response()->json($aluguelX, 200);
    
}

/// * * * * * * * * * * * * * * * * * * * * * * * * * *   
    public function create()
    {
        //
    }

/// * * * * * * * * * * * * * * * * * * * * * * * * * *    
public function store(Request $request)
{
    $request->validate($this->aluguel->rules());
    if ($request->data_final_realizada==""){
        $request->data_final_realizada="2024-01-01T00:00:00";
    }
    $aluguelX = $this->aluguel->create([
        'cliente_id' => $request->cliente_id,
        'carro_id' => $request->carro_id,
        'data_inicial' => $request->data_inicial,
        'data_final_esperada' => $request->data_final_esperada,
        'data_final_realizada' => $request->data_final_realizada,

        'taxa_diaria' => $request->taxa_diaria,
        'km_inicial' => $request->km_inicial,
        'km_final' => $request->km_final
    ]);
    $this->aluguel->setDisponivel($request->carro_id,0);
    return response()->json($aluguelX, 201);
}

/// * * * * * * * * * * * * * * * * * * * * * * * * * *    
public function show($myid)
{
    
    $aluguelX=$this->aluguel->find($myid);
    $varY=$aluguelX->getVehicle($aluguelX->carro_id);
    //$varY={'Modelo':$varY->modelo,'Imagem':$varY->Imagem};
    if ($aluguelX!=NULL){
     $aluguelX=$aluguelX->with('temCarro')->with('temCliente')->get();
     //$tt=gettype($varY);
     $aluguelX[0]['veiculo']=$varY;
     //$aluguelX=array_push($varY,$aluguelX);
     //$aluguelX=$aluguelX->get();
    }
    if($aluguelX === null) {
        return response()->json(['error' => 'Recurso não encontrado'], 404) ;
    } 

    return response()->json($aluguelX, 200);
}

/// * * * * * * * * * * * * * * * * * * * * * * * * * *   
    public function edit(Alugueis $alugueis)
    {
        //
    }

/// * * * * * * * * * * * * * * * * * * * * * * * * * *   
public function update(Request $request, $myid){
    /// https://laravel.com/docs/11.x/queries#update-statements
  

    $aluguelX = $this->aluguel->find($myid);
    //echo $aluguelX->carro_id;
    if($aluguelX === null) {
        return response()->json(['error' => 'Recurso não localizado - ERRO - problema na atualização'], 404);
    }

    if($request->method() === 'PATCH') {

        $asRegras = array();

       ///percorrendo todas as regras definidas no Model
        foreach($aluguelX->rules() as $input => $rule) {
       ///if (array_key_exists("Volvo",$array)) { echo "Key exists!";}    
      ///coletar apenas as regras aplicáveis aos parâmetros parciais da requisição PATCH
            if(array_key_exists($input, $request->all())) {
                $asRegras[$input] = $rule;
            }
        }
        
        $request->validate($asRegras);

    } else {
        $request->validate($aluguelX->rules());
    }
    
    $aluguelX->fill($request->all());
    $aluguelX->save();
    
    $this->aluguel->setDisponivel($aluguelX->carro_id,1);
    return response()->json($aluguelX, 200);
}

 /// * * * * * * * * * * * * * * * * * * * * * * * * * * 
 public function destroy($myid)
 {
     $aluguelX = $this->aluguel->find($myid);

     if($aluguelX === null) {
         return response()->json(['error' => 'Erro - Recurso não encontrado, não foi possível realizar este procedimento (exclusão)'], 404);
     }
     $this->aluguel->setDisponivel($aluguelX->carro_id,1);
     $aluguelX->delete();
     return response()->json(['msg' => 'A exclusão foi realizada com sucesso!'], 200);
     
 }  
/// * * * * * * * * * * * * * * * * * * * * * * * * * * 
    //==================================
    private function filterA0($request,$objInstance,$ref_method,$ref_methodII){
        $field_like='nome';
         // ?filter=cGxhY2E9S09D ?filter=cGxhY2E9S09DQEBjbGllbnRlPU1hcmll ->placa=KOC@@cliente=Marie
        if ($request->has('filter')){
            //return $this->defaultFilter($request,$objInstance)->with($ref_method);
            //"message": "Call to a member function with() on array",
            $dfill=$this->defaultFilter($request,$objInstance);
             //echo $dfill[0]->Placa;
             $dfill[0]->tem_carro=['placa' =>$dfill[0]->Placa];
             $dfill[0]->tem_cliente=['nome' =>$dfill[0]->Cliente];
            return $dfill;
        } 
    
        if ($request->has('getcarrosvalues')){
            return $objInstance->getCarros();
        }    
        if ($request->has('getclientesvalues')){
            return $objInstance->getClientes();
        } 
    
       //..No one filter, return all
        $objInstance=$objInstance->with($ref_method)->with($ref_methodII);
        $objInstance=$objInstance->get();
         //var_dump($objInstance);
        //echo gettype($objInstance); return object
        return $objInstance;
    }
    
/// * * * * * * * * * * * * * * * * * * * * * * * * * * 
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
private function defaultFilter($request,$objInstance){
    /*
    returned fields:
     ID 	cliente_id 	placa 	Model 	Client 	carro_id 	data_inicial 	data_final_esperada 	data_final_realizada 	taxa_diaria 	km_inicial 	km_final 	updated_at 	created_at
    
    Text fields: placa, Model, Client
    Amount Fields: km_inicial 	km_final
    Date Fields: data_inicial, data_final_esperada, data_final_realizada, updated_at, created_at
    Monetary field: taxa_diaria
    */    
    //Model=ka@@km_inicial>1000
    $fields_like="carros.placa, modelos.nome, clientes.nome data_inicial";
    $fields_amount="km_inicial, km_final";
    $strQuery=" WHERE ";
    $conty=0;
        /// . . . . . . .
       
            $fill=str_replace("kkpkk","+",$request->filter);
            $myfilter=base64_decode($fill);
            
            //echo "--.-.-.-.-.-.-.".$_REQUEST['filter'];
            $myfilter=str_replace("modelo","modelos.nome",$myfilter);
            $myfilter=str_replace("placa","carros.placa",$myfilter);
            $myfilter=str_replace("cliente","clientes.nome",$myfilter);
        // echo "Filter: ".$myfilter." ....";
            $contArroba=substr_count($myfilter,"@@");
            if ($contArroba>0){
                $valys=explode("@@",$myfilter);
                for ($i=0; $i<=count($valys)-1;$i++){
                    $kompII=""; $kompI="";
                    $kompI=$this->compareVLike($valys[$i],$fields_like);
                    if ($kompI!=""){ $strQuery.=$kompI;}
                    else{
                        $kompII=$this->compareSignal($valys[$i],$fields_amount);
                        if ($kompII!=""){ $strQuery.=$kompII;}    
                    }
                }
            }  
        
           if ($contArroba<=0){
            $kompII=""; $kompI="";
            $kompI=$this->compareVLike($myfilter,$fields_like);
            if ($kompI!=""){ $strQuery.=$kompI; }
            else{
                
                $kompII=$this->compareSignal($myfilter,$fields_amount);
                if ($kompII!=""){ $strQuery.=$kompII;}    
            }
           }
            if (strlen($strQuery)<=9){
                return "404";
            }
           
            $strQuery=str_replace("WHERE AND","WHERE",$strQuery);
            //echo "_".$strQuery."_";
            
            $valQuery=$objInstance->defaultQuery();
            $valQuery=$valQuery.$strQuery;
            //echo $valQuery."<br>";
           // echo ">>".$valQuery."<<";
            $objInstance=$objInstance->execQuery($valQuery);
            //echo json_encode($objInstance);
            return $objInstance;
           
        
    } 
// = = = = = = = = = =Default filter ENDS
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
// = = = = = = = = = = = = = = = = =
    private function compareVLike($valya,$fields_like){
        $vvv=explode("=",$valya); 
        $strQuery="";
        if ((substr_count($fields_like,$vvv[0])>0) and (isset($vvv[1]) ) ){
            $komI=$vvv[0];
            $komII=$vvv[1];
    
           $strQuery.="AND ($komI LIKE '%$komII%' )";  
          
        }
        return $strQuery;
    }
    // = = = = = = = = = = = = = = = = =
    private function compareSignal($valya,$fields_amount){
        $operator="";
         if ((substr_count($valya,">")>0)) { $operator=">"; }
         if ((substr_count($valya,">=")>0)) {$operator=">=";}
         if ((substr_count($valya,"<")>0)) {$operator="<";}
         if ((substr_count($valya,"<=")>0)) {$operator="<=";}
    
         if (($operator=="")and(substr_count($valya,"="))){
            $operator="=";
         }
         
        $vvv=explode($operator,$valya);
        $strQuery="";
        if (($operator!="")and($valya!="")){
            $komI=$vvv[0];
            $komII=$vvv[1];
       // if ((substr_count($fields_amount,$vvv[0])>0) and (isset($vvv[1]) ) ){
            $strQuery.="AND ($komI $operator $komII )";  
            //echo "__".$strQuery."__";
       // }
        }
        return $strQuery;
    }
    // = = = = = = = = = = = = = = = = =
    // = = = = = = = = = = = = = = = = =
    // = = = = = = = = = = = = = = = = =
    // = = = = = = = = = = = = = = = = =
    private function filtrate($request,$objInstance,$ref_method,$ref_methodII){
        
        $field_like='nome';
        /*
        filter = Client=mit@@doors=4@@seats=4@@air_bag=1@@abs=1
        filter=
        bmFtZT1lY29AQGRvb3JzPTRAQHNlYXRzPTRAQGFpcl9iYWc9MUBAYWJzPTE=
        */
        //$varY=$aluguelX->getVehicle($aluguelX->carro_id);
        if ($request->has('filter')){
        $objInstance=$objInstance->with($ref_method)->with($ref_methodII);
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
    ///Valores obtidos no App\Model\Alugueis;Rent
        if ($request->has('getcarrosvalues')){
            return $objInstance->getCarros();
        }    
        if ($request->has('getclientesvalues')){
            return $objInstance->getClientes();
        } 
    
       //..No one filter, return all
        $objInstance=$objInstance->with($ref_method)->with($ref_methodII);
        $objInstance=$objInstance->get();
        return $objInstance;
    }

    //==================================
    
/// * * * * * * * * * * * * * * * * * * * * * * * * * * 

}
