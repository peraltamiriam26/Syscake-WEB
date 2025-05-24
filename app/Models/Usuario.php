<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LectorsController;
use App\Http\Controllers\EscritorsController;

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

    public function saveUser($request, $id = null){
        if (!isset($id)) {
            //Instanciamos la clase Usuario
            $usuario = new Usuario();
        }else{
            $usuario = Usuario::searchUser($id);
        }

        //Agregamos los valores necesarios para guardarlo en la bd
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        //Encriptamos la contraseña usando Hash
        $usuario->password = Hash::make($request->password);
        //Usamos la funcion save() que guarda en la base de datos
        if($usuario->save()){
            //Buscamos al usuario recien creado por su correo.
            $datos=$usuario->buscarUsuarioCorreo($usuario->email);
            //Verificamos el tipo de usuario que eligio
            if ($request->tipoUsuario === 'lector') {
                $lectorsController = new LectorsController();
                $flag = $lectorsController->create($datos->id);
            }else{
                $escritorsController = new EscritorsController();
                $flag = $escritorsController->create($datos->id);
            }
            return $flag;
        }
        return false; 
    }

    function buscarUsuarioCorreo($correo){
        $datos = DB::table('usuarios')->where('email', $correo)->first();
        return $datos;
    }

    public static function searchUser($id){
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
