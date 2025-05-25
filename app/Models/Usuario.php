<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LectorsController;
use App\Http\Controllers\EscritorsController;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Usuario extends Model
{
    use HasFactory;
    use SoftDeletes;
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


    public function bajaUsuario($id){
        try {
            DB::beginTransaction();
            $user = $this::searchUser($id);
            if (isset($user->writer)) {
                $writer = $user->writer;
                 DB::commit(); // Confirmar cambios
                return $user->delete() && $writer->delete();
            }
            DB::commit(); // Confirmar cambios
            $reader = $user->reader;

            return $user->delete() && $reader->delete();            
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        }

    }
}
