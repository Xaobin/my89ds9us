<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable=['marca_id','nome','imagem','portas','assentos','air_bag','abs'];
    protected $table="modelos";

    //.......................
    public function refMarca(){
        return $this->belongsTo('App\Models\Marca','marca_id','id');
    }
    //.......................
    public function refMarcaII(){
        return $this->belongsTo('App\Models\Marca');
    }
    //.......................
    public function rules() {
        return [
            'marca_id' => 'exists:marcas,id',
            'nome' => 'required|unique:modelos,name,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg,webp',
            'portas' => 'required|integer|digits_between:1,5', 
            'assentos' => 'required|integer|digits_between:1,20',
            'air_bag' => 'required|boolean',
            'abs' => 'required|boolean' //true, false, 1, 0, "1", "0"
        ];
    }
    //.......................
    public function refBrandValues(){
        $cons="select car_brands.name as brand, car_brands.id as id from car_brands";
        $dest=
        DB::select($cons);
        
        return $dest;
    }


}
