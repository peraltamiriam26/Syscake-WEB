<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

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
        $id = auth()->user()->id;
        $user = Usuario::searchUser($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'nombre' => ['required'],
                'apellido' => ['required'],
                'email' => ['required', 'email', Rule::unique('usuarios')->ignore($id)],
                'password' => ['nullable', 'confirmed', 'min:8'],
            ]);
            if ($user->saveUser($request, $id)){
                // session()->flash('tipo', 'success');
                // session()->flash('mensaje', '¡El usuario se modifico con éxito!');
                // return redirect()->intended('/home');
                return redirect()->route('home')->with('alerta', [
                                                                    'titulo' => '¡Acción exitosa!',
                                                                    'mensaje' => 'Tu cuenta fue modificada.',
                                                                    'tipo' => 'success' // Tipos: success, error, warning, info
                                                                ]);

            }
            session()->flash('tipo', 'danger');
            session()->flash('mensaje', 'Hubo un error al querer modificar el usuario.');
            // return redirect("/");
        }


        return view('user/update',
            [
                'user' => $user,
                'writer' => $user->writer,
                'reader' => $user->reader
            ]    
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        $user = new Usuario();
        return $user->bajaUsuario(auth()->user()->id);
    }



    public function login(Request $request){
	    // Comprobamos que el email y la contraseña han sido introducidos
	    $credentials = $request->validate([
	        'email' => 'required|email',
	        'password' => 'required',
	    ]);
        
	    if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home'); // Redirige al usuario después del login
        }
        else{
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }
        return back();
    }

    public function register(Request $request){

        // Comprobamos que los datos han sido introducidos
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
	        'email' => 'required|email|unique:usuarios,email,',//unique sirve para buscar el elemento y verificar q es unico, usuarios es la tabla donde buscamos, y email el atributo de la tabla q comparamos
	        'password' => 'required|confirmed|min:8',
	    ]);
        $user = new Usuario();
        if ($user->saveUser($request)) {
            session()->flash('tipo', 'success');
            session()->flash('mensaje', '¡El usuario se creo con éxito!');
            return redirect("/");
        }
        // session()->flash('tipo', 'danger');
        // session()->flash('mensaje', 'Hubo un error al querer crear al usuario.');
        return redirect("/");
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Has cerrado sesión correctamente.');
    }

}
