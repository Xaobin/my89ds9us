<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;


class Carro extends Model{

    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];
    use HasFactory;
// = = = = = = = = = = = = = = = = =
    public function rules() {
        return [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required',
            'km' => 'required'
        ];
    }
// = = = = = = = = = = = = = = = = =
    public function refModelo() {
        return $this->belongsTo('App\Models\Modelo','modelo_id','id');
    }
// = = = = = = = = = = = = = = = = = 
    public function refModeloValues(){
        $cons="select modelos.nome as modelo, modelos.id as id from modelos";
        $dest=
        DB::select($cons);
        //echo gettype($dest); //return: array
        return $dest;
    }
// = = = = = = = = = = = = = = = = =
}
