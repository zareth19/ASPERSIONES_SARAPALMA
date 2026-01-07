<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\DocumentType;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'documentType', 'finca'])->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $documentTypes = DocumentType::all();
        $fincas = Finca::where('active', true)->get();
        return view('users.create', compact('roles', 'documentTypes', 'fincas'));
    }

    public function store(Request $request)
    {
        // Validar que el rol sea solo admin
        $allowedRoles = Role::where('name', 'admin')->pluck('id')->toArray();
        
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
                function ($attribute, $value, $fail) {
                    if (preg_match('/<[^>]*>/', $value)) {
                        $fail('El nombre no puede contener etiquetas HTML.');
                    }
                    if (preg_match('/[<>"\'\/\\]/', $value)) {
                        $fail('El nombre contiene caracteres no permitidos.');
                    }
                }
            ],
            'document_number' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/^[0-9]+$/',
                'unique:users',
                function ($attribute, $value, $fail) {
                    if (!ctype_digit($value)) {
                        $fail('El número de documento solo puede contener números.');
                    }
                }
            ],
            'document_type_id' => [
                'required',
                'integer',
                'exists:document_types,id',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) || $value <= 0) {
                        $fail('Tipo de documento inválido.');
                    }
                }
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                function ($attribute, $value, $fail) use ($request, $allowedRoles) {
                    // Sanitizar email
                    $cleanEmail = filter_var($value, FILTER_SANITIZE_EMAIL);
                    if ($cleanEmail !== $value) {
                        $fail('El email contiene caracteres no válidos.');
                    }
                    
                    // Validar dominio para admin
                    $roleId = $request->role_id;
                    $role = Role::find($roleId);
                    if ($role && $role->name === 'admin' && !str_ends_with($value, '@sarapalma.com.co')) {
                        $fail('Para roles admin el email debe terminar en @sarapalma.com.co');
                    }
                    
                    // Prevenir inyección
                    if (preg_match('/[<>"\'\/\\]/', $value)) {
                        $fail('El email contiene caracteres no permitidos.');
                    }
                },
            ],
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
                function ($attribute, $value, $fail) use ($allowedRoles) {
                    if (!is_numeric($value) || $value <= 0) {
                        $fail('Rol inválido.');
                    }
                    if (!in_array((int)$value, $allowedRoles)) {
                        $fail('Solo se permite el rol de admin.');
                    }
                }
            ],
            'finca_id' => [
                'nullable',
                'integer',
                'exists:fincas_temp,id',
                function ($attribute, $value, $fail) {
                    if ($value !== null && (!is_numeric($value) || $value <= 0)) {
                        $fail('Finca inválida.');
                    }
                }
            ]
        ]);

        // Generar contraseña temporal
        $temporaryPassword = Str::random(8);
        
        // Sanitizar datos de entrada
        $userData = [
            'name' => strip_tags(trim($request->name)),
            'email' => filter_var(trim($request->email), FILTER_SANITIZE_EMAIL),
            'document_number' => preg_replace('/[^0-9]/', '', $request->document_number),
            'document_type_id' => (int) $request->document_type_id,
            'role_id' => (int) $request->role_id,
            'finca_id' => $request->finca_id ? (int) $request->finca_id : null,
            'password' => Hash::make($temporaryPassword),
            'must_change_password' => true,
            'active' => true
        ];
        
        // Validación adicional de seguridad
        if (strlen($userData['name']) < 2 || strlen($userData['name']) > 255) {
            return back()->withErrors(['name' => 'Nombre inválido'])->withInput();
        }
        
        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['email' => 'Email inválido'])->withInput();
        }
        
        $user = User::create($userData);
        $user->load('role', 'finca');

        // Intentar enviar email con credenciales
        $emailSent = false;
        try {
            Mail::to($user->email)->send(new UserCredentialsMail($user, $temporaryPassword));
            $emailSent = true;
            $message = 'Usuario creado exitosamente. Se han enviado las credenciales por correo.';
        } catch (\Exception $e) {
            $message = 'Usuario creado exitosamente. El correo no pudo ser enviado debido a restricciones corporativas.';
        }

        return redirect()->route('users.index')
            ->with('success', $message)
            ->with('temp_password', !$emailSent ? $temporaryPassword : null)
            ->with('user_email', !$emailSent ? $user->email : null);
    }

    public function show(User $user)
    {
        $user->load(['role', 'documentType', 'finca', 'aspersions']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $documentTypes = DocumentType::all();
        $fincas = Finca::where('active', true)->get();
        return view('users.edit', compact('user', 'roles', 'documentTypes', 'fincas'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'document_number' => 'required|unique:users,document_number,' . $user->id,
            'document_type_id' => 'required|exists:document_types,id',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'finca_id' => 'nullable|exists:fincas,id',
            'active' => 'boolean'
        ]);

        $userData = $request->except('password');
        
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
            $userData['must_change_password'] = true;
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    public function profile()
    {
        // Si es una finca logueada, redirigir al dashboard
        if (session('finca_logged')) {
            return redirect()->route('dashboard')->with('error', 'Las fincas no tienen perfil de usuario');
        }
        
        $user = Auth::user();
        if ($user) {
            $user->load(['role', 'documentType', 'finca']);
        }
        return view('users.profile', compact('user'));
    }
}