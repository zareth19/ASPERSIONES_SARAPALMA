<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Finca;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'document_number' => 'required',
            'password' => 'required'
        ]);

        // Intentar login como usuario
        $user = User::where('document_number', $request->document_number)
                   ->where('active', true)
                   ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            $welcomeMessage = $user->is_first_login 
                ? "Bienvenido {$user->name} al sistema de aspersiones de la empresa Sara Palma"
                : "Bienvenido {$user->name}, qué bueno verte de vuelta por aquí";
            
            if ($user->is_first_login) {
                $user->update(['is_first_login' => false]);
            }

            return redirect()->route('dashboard')->with([
                'welcome_message' => $welcomeMessage,
                'is_first_login' => $user->is_first_login
            ]);
        }

        // Intentar login como finca con IBM
        $finca = Finca::where('ibm', $request->document_number)
                     ->where('active', true)
                     ->whereNotNull('password')
                     ->first();

        if ($finca && Hash::check($request->password, $finca->password)) {
            // Crear sesión para finca
            session([
                'finca_logged' => true,
                'finca_id' => $finca->id,
                'finca_name' => $finca->name,
                'finca_ibm' => $finca->ibm,
                'finca_hectares' => floatval($finca->hectares)
            ]);
            
            return redirect()->route('dashboard')->with([
                'welcome_message' => "Bienvenido a la finca {$finca->name}",
                'is_finca_login' => true
            ]);
        }

        return back()->withErrors(['document_number' => 'Credenciales incorrectas']);
    }

    public function showRegister()
    {
        $documentTypes = DocumentType::all();
        $fincas = Finca::where('active', true)->get();
        return view('auth.register', compact('documentTypes', 'fincas'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_number' => 'required|unique:users',
            'document_type_id' => 'required|exists:document_types,id',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'finca_id' => 'nullable|exists:fincas,id'
        ]);

        User::create($request->all());

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget(['finca_logged', 'finca_id', 'finca_name', 'finca_ibm', 'finca_hectares']);
        return redirect()->route('login');
    }
}