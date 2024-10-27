<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
    public function refModelValues(){
        $cons="select car_models.name as model, car_models.id as id from car_models";
        $dest=
        DB::select($cons);
        //echo gettype($dest); //return: array
        return $dest;
    }
// = = = = = = = = = = = = = = = = =
}
