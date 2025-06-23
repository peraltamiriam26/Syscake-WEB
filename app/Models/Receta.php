<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receta extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'nombre',
        'archivo_id',
        'tipoReceta_id',
        'escritor_usuario_id',
        'es_anonimo',
    ];
    
    // protected $hidden = [
    //     'id',
    // ];

    public function ingredientes_receta() // Un nombre más descriptivo
    {
        return $this->hasMany(Ingrediente_has_receta::class);
    }

    // Relación con los pasos (Instrucciones)
    public function instrucciones()
    {
        return $this->hasMany(Instruccion::class);
    }
    
    // Relación con el tipo de comida
    public function tipoReceta() // Relación con TipoReceta
    {
        return $this->belongsTo(Tiporeceta::class, 'tipoReceta_id', 'id');
    }
    
    // Relación con el usuario que creó la receta
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'escritor_usuario_id'); // O 'user_id' si es lo que usas
    }

    // Si tu receta tiene una imagen de portada asociada a un modelo Archivo
    public function archivo()
    {
        return $this->belongsTo(Archivo::class, 'archivo_id');
    }

    
    public function deleteRecipe($id){
        try {
            DB::beginTransaction();

            //primero borraremos los datos de las tablas enlazadas con receta
            Ingrediente_has_receta::where('receta_id',$id)->delete();
            Instruccion::where('receta_id',$id)->delete();
            $instrucciones = Instruccion::where('receta_id',$id)->getr();
            foreach ($instrucciones as $instruccion) {
                if (isset($instruccion->archivo_id)) {
                    Archivo::where('id',$instruccion->archivo_id)->delete();
                }
            }
            //por ultimo borramos la receta
            $recipe = Receta::where('id', $id)->first();
            if( $recipe->delete()){
                DB::commit();
                return true;
            }
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        } catch (Exception $e) {
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        }
    }

    public function ingredientes()
    {
        return $this->belongsToMany(
            Ingrediente::class,
            'ingrediente_has_recetas', // Nombre de tu tabla pivote
            'receta_id',              // Clave foránea de Receta en la tabla pivote
            'ingrediente_id'          // Clave foránea de Ingrediente en la tabla pivote
        )
        ->withPivot('cantidad', 'tipounidad_id'); // Asegúrate de incluir 'tipounidad_id'
        // Eliminamos: ->using(Ingrediente_has_receta::class);
    }

}
