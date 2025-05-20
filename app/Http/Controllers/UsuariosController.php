<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Controllers\LectorsController;
use App\Http\Controllers\EscritorsController;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUsuarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsuarioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUsuarioRequest  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }



    public function login(Request $request){
        Log::debug($request);
	    // Comprobamos que el email y la contraseña han sido introducidos
	
        $request->validate([
            'email' => 'required|email',
            'password' => 'current_password',]);
	
	    // Almacenamos las credenciales de email y contraseña
	    $credentials = $request->only('email', 'password');
        // Si el usuario existe lo logamos y lo llevamos a la vista de "logados" con un mensaje
	    if (Auth::attempt($credentials)) {
	        return redirect()->intended('logados')
	            ->withSuccess('Logado Correctamente');
	    }
	
	    // Si el usuario no existe devolvemos al usuario al formulario de login con un mensaje de error
	    return redirect("/")->withSuccess('Los datos introducidos no son correctos');
    }

    public function register(Request $request){

        // Comprobamos que los datos han sido introducidos
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
	        'email' => 'required|email',
	        'password' => 'required|confirmed',
	        'password_confirmation' => 'required',
	    ]);
        Log::debug("Todo es correcto");
        //Instanciamos la clase Usuario
        $usuario = new Usuario();
        //Agregamos los valores necesarios para guardarlo en la bd
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->correo = $request->email;
        //Encriptamos la contraseña usando Hash
        $usuario->password = Hash::make($request->password);
        //Usamos la funcion save() que guarda en la base de datos
        $usuario->save();
        //Buscamos al usuario recien creado por su correo.
        $datos=$usuario->buscarUsuarioCorreo($usuario->correo);
        //Verificamos el tipo de usuario que eligio
        if ($request->tipoUsuario === 'lector') {
            $lectorsController = new LectorsController();
            $lectorsController->create($datos->id);
        }else{
            $escritorsController = new EscritorsController();
            $escritorsController->create($datos->id);
        }
        return redirect("/")->withSuccess('Se registro correctamente el usuario');
    }
}
