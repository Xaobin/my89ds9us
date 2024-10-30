<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Aluguel extends Model
{
    use HasFactory;
    protected $table="alugueis";

    protected $fillable = [
        'cliente_id', 
        'carro_id', 
        'data_inicial', 
        'data_final_esperada',
        'data_final_realizada',
        'taxa_diaria',
        'km_inicial',
        'km_final'
    ];
 
    public function rules() {
        return [
            'cliente_id' => 'exists:clientes,id',
            'carro_id' => 'exists:carros,id',
            'data_inicial' => 'required',
           // 'data_final_esperada'=>'required',
           // 'data_final_realizada'=>'required',
            'taxa_diaria'=>'required',
            'km_inicial'=>'required',
           // 'km_final'=>'required'
            
        ];
    }
    // = = = = = = = = = = = = = = = = = 
    public function getCarros(){
        $cons="select carros.placa as placa, modelos.nome as modelo, carros.disponivel as disponivel, carros.id as id from carros, modelos where modelo_id=modelos.id";
        $dest=
        DB::select($cons);
        return $dest;
    }
    // = = = = = = = = = = = = = = = = = 
    public function getClientes(){
        $cons="select clientes.nome as nome, clientes.id as id from clientes";
        $dest=
        DB::select($cons);
        return $dest;
    }
    // = = = = = = = = = = = = = = = = = 
    public function setDisponivel($id,$vall){
        //$cons="UPDATE carros SET carros.disponivel='$vall' WHERE carros.id=$id";
        $dest=
        DB::table('carros')
        ->where('id', $id)
        ->update(['disponivel' => $vall]);
        //$dest=DB::select($cons);
    }

    // = = = = = = = = = = = = = = = = = 
  
    // = = = = = = = = = = = = = = = = = 
    public function temCliente(){
        return  $this->hasOne('App\Models\Cliente','id','cliente_id');
    }
    // = = = = = = = = = = = = = = = = = 
    public function temCarro(){
        return  $this->hasOne('App\Models\Carro','id','carro_id');
    }
    // = = = = = = = = = = = = = = = = =
    public function getModelo($carid){
        $cons="select modelos.nome as Modelo, modelos.imagem as Imagem_modelo from modelos,carros WHERE carros.id=$carid AND modelos.id=carros.modelo_id;";
        $dest=
        DB::select($cons);
        return $dest;
    }
     // = = = = = = = = = = = = = = = = =
     public function getVehicle($carid){
        $cons="select modelos.nome as Modelo, marcas.nome as Marca, marcas.imagem as Imagem_marca, 
modelos.imagem as Imagem_modelo FROM modelos,carros,marcas 
WHERE carros.id=$carid
AND modelos.id=carros.modelo_id
AND modelos.marca_id=marcas.id;";
        $dest=
        DB::select($cons);
        return $dest;
    }
    // = = = = = = = = = = = = = = = = = 
    public function defaultQuery(){
        $cons="select alugueis.id as ID, cliente_id, carros.placa as Placa,modelos.nome as Modelo, clientes.nome as Cliente, carro_id, data_inicial, data_final_esperada, data_final_realizada, taxa_diaria, km_inicial, km_final, alugueis.updated_at, alugueis.created_at from alugueis 
        JOIN carros ON (carros.id=carro_id) 
        JOIN clientes ON (clientes.id=cliente_id) 
        JOIN modelos ON (modelos.id=carros.modelo_id)";
        return $cons;
    }
    // = = = = = = = = = = = = = = = = = 
    public function execQuery($qq){
        $qq=str_replace("\n","",$qq);
        $qq=str_replace("\r","",$qq);
        //echo "=>".$qq."<=";
        $dest=DB::select($qq);
        return $dest;
    }
}
