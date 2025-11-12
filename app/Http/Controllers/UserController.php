<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\DocumentType;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'document_number' => 'required|unique:users',
            'document_type_id' => 'required|exists:document_types,id',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'finca_id' => 'nullable|exists:fincas,id'
        ]);

        $userData = $request->all();
        $userData['must_change_password'] = true;
        
        User::create($userData);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
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
        $user->update(['active' => false]);
        return redirect()->route('users.index')->with('success', 'Usuario desactivado exitosamente');
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