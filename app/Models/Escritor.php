<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Escritor extends Model
{
    use HasFactory;

    protected $fillable = [
        'esEscritor',
        'usuario_id',
    ];
    
    protected $primaryKey = 'usuario_id';

    public static function searchWriter($id){
        $writer = Escritor::where('usuario_id', $id)
                        ->first();
        return $writer;
    }

    public function deleteWriter($id){
        return Escritor::where('usuario_id', $id)->delete();
    }

    public function create($id){
        $escritor = new Escritor();
        $escritor->esEscritor = 1;
        $escritor->usuario_id = $id;
        return $escritor->save();
    }
}
