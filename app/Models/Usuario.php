<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id';  // Nombre de la clave primaria

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'id',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    function buscarUsuarioCorreo($correo){
        $datos = DB::table('usuarios')->where('email', $correo)->first();
        return $datos;
    }

    static function searchUser($id){
        $user = Usuario::where('id', $id)
                        ->first();
        return $user;
    }

    /**
     * Get the phone associated with the user.
     */
    public function writer()
    {
        return $this->hasOne(Escritor::class, 'usuario_id');
    }

    /**
     * Get the phone associated with the user.
     */
    public function reader()
    {
        return $this->hasOne(Lector::class, 'usuario_id');
    }
}
