<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function rules() {
        return [
            'nome' => 'required' 
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }
   //= = == = == = == = == = == = == = == = ===
    public function simpleSearch($field1,$vall){
        $table1=$this->table; $opera="";
        if ($field1=='id'){ $opera="="; } else { $opera="LIKE"; $vall="%".$vall."%"; }
         $querr="select * from $table1 where $table1.$field1 $opera '$vall'"; 
        
        $dest=
            DB::select($querr);
            return $dest;
     }
    //= = == = == = == = == = == = == = == = ===
}
