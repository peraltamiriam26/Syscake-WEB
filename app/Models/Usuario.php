<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\LectorsController;
use App\Http\Controllers\EscritorsController;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use NunoMaduro\Collision\Writer;

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
            $newUser = true;
        }else{
            $usuario = Usuario::searchUser($id);
            $newUser = false;
        }
        try {
            DB::beginTransaction();
            //Agregamos los valores necesarios para guardarlo en la bd
            $usuario->nombre = $request->nombre;
            $usuario->apellido = $request->apellido;
            $usuario->email = $request->email;
            if (!empty($request->password)) {
                //Encriptamos la contraseña usando Hash
                $usuario->password = Hash::make($request->password);
            }

            //Usamos la funcion save() que guarda en la base de datos
            if($usuario->save()){
                //Verificamos el tipo de usuario que eligio
                $flag = $usuario->verifyUserType($usuario->id, $request->tipoUsuario, $newUser);               
                DB::commit();
                Log::debug($flag);
                return $flag;
            }
            Log::debug("false");
            Log::debug($usuario);
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        } catch (Exception $e) {
            Log::debug($e);
            DB::rollBack(); // Revertir cambios si ocurre un error
            return false;
        }

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

    public function verifyUserType($user_id, $newType, $newUser){
        
        if ($newUser) { // Se crea un usuario nuevo, entonces no hace falta comprobar nada
            if ($newType === 'lector') {
                $reader = new Lector();
                $flag = $reader->create($user_id);             
            }else{
                $writer = new Escritor();
                $flag = $writer->create($user_id);
            }
        }else{
            $oldType = Usuario::verifyRoleType($user_id);
            $flag = false;
            if ($oldType != false) {
                if ($newType == 'lector' && $oldType->esEscritor) {
                    /** delete writer and add reader */
                    if ($oldType->delete()) {
                        $reader = new Lector();
                        $flag = $reader->create($user_id);
                    }else{
                        return true; /** true porque no se hace ningún cambio */
                    }
                }elseif ($newType == 'escritor' && $oldType->esLector) {
                    /** delete reader and add writer */
                    if ($oldType->delete()) {
                        $writer = new Escritor();
                        $flag = $writer->create($user_id);
                    }else{
                        return true;
                    }
                }
            }
        }

        
        return $flag;
    }

    public static function verifyRoleType($user_id){
        $reader = Lector::searchReader($user_id);
        if (!isset($reader)) {
            $writer = Escritor::searchWriter($user_id);
            if (isset($writer)) {
                return $writer;
            }
            return false;
        }
        return $reader;
    }
}
