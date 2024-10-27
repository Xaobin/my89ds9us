<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Marca extends Model
{
    use HasFactory;
    protected $fillable=['nome','imagem'];
    protected $table="marcas";
/// - - - - - - - - - - - - - - - - - - -
    public function rules() {
        return [
            'nome' => 'required|min:3',
            'imagem' => 'required'
        ];

        /*
            1) tabela 
            2) nome da coluna que será pesquisada na tabela3
            3) id do registro que será desconsiderado na pesquisa
        */
    }
/// - - - - - - - - - - - - - - - - - - -
    public function feedback() {
        return [
            'required' => 'O campo :attribute é requerido',
            'nome.unique' => 'Este nome já está registrado',
            'nome.min' => 'O nome deve ter três caracteres ou mais'
        ];
    }
/// - - - - - - - - - - - - - - - - - - -
    public function refModelos(){
        return $this->hasMany('App\Models\Modelo','marca_id','id');
    }
/// - - - - - - - - - - - - - - - - - - -    
    public function simpleSearch($field1,$vall){
        $table1=$this->table; $opera="";
        if ($field1=='id'){ $opera="="; } else { $opera="LIKE"; $vall="%".$vall."%"; }
         $querr="select * from $table1 where $table1.$field1 $opera '$vall'";
    
        $dest=
            DB::select($querr);
           
            return $dest;
     }
/// - - - - - - - - - - - - - - - - - - -     
}
