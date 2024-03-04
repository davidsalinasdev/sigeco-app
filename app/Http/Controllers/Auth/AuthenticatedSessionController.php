<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Exception;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    public function store(LoginRequest $request)//: RedirectResponse
    {
        
        $datosJson = $request->json()->all();
        
        $externalUserId = $request->input('idUsuario');
        $externalUserName = $request->input('email');
        $password = $request->input('password');

        $ci = $request->input('ci');
        $nombres = $request->input('nombres');
        $paterno = $request->input('paterno');
        $materno = $request->input('materno');
        $celular = $request->input('celular');
        $domicilio = $request->input('domicilio');
        $estado = $request->input('estado');
        $cargo  = $request->input('cargo');
        $sigla = $request->input('sigla');
        $dependencia = $request->input('dependencia');
        $idServidor = $request->input('idServidor');

        // Busca al usuario por el ID proporcionado por el sistema externo
        $user = User::where('idExt', $externalUserId)->first();
        // Si el usuario no existe se crea
        if (!$user) {
            $user = new User();
            $user->idExt = $externalUserId;
            $user->email = $externalUserName;

            $user->name = $nombres." ".$paterno." ".$materno;
            
            $user->ci = $ci;
            $user->nombres = $nombres;
            $user->paterno = $paterno;
            $user->materno = $materno;
            $user->celular = $celular;
            $user->domicilio = $domicilio;
            $user->estado = $estado;
            $user->cargo  = $cargo;
            $user->dependencia = $sigla." ".$dependencia;
            $user->idServidor = $idServidor;
            $user->assignRole('Operador');
        }

        // Asigna valores proporcionados por el sistema externo
        $user->email = $externalUserName;
        
        // Se actualiza su dependencia cada que ingresa
        $user->dependencia = $sigla." ".$dependencia;

        // Guarda los cambios en la base de datos
        $user->save();

        // Autentica al usuario en Laravel
        Auth::login($user);
        if (auth()->check()) {
            $bandera = "En sigeco";
        }else{
            $bandera = "No ingresa a Sigeco";

        }

        //$request->session()->regenerate();
        
        session()->regenerate();

        //$request->authenticate();
        
        try{
            $redirectUrl = redirect()->intended(route('home'))->getTargetUrl();
            
            $datos = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Ingresó correctamente',
                'datosJson' => $datosJson,
                'bandera' => $bandera,
                'redirect' => $redirectUrl
            ];

           //$redirectUrl = Redirect::intended(route('home'))->getTargetUrl();
           //return response()->json(['redirect' => $redirectUrl]);
            
            return response()->json($datos);
           
        } catch (Exception $e) {
            $datos = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se ingresó correctamente',
                'error' => $e->getMessage()
            ];
            return response()->json($datos);
        }
        
        //para probar que se enviaron los datos
        //$datosJson = $request->json()->all();
        //return response()->json(['message' => 'Datos recibidos correctamente']);
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
