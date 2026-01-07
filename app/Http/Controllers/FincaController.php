<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FincaController extends Controller
{ 
    public function index(Request $request)
    {
        $query = Finca::withCount('aspersions');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('ibm', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        $fincas = $query->paginate(15);
        return view('fincas.index', compact('fincas'));
    }

    public function create()
    {
        return view('fincas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ibm' => ['required', 'string', Rule::unique('fincas_temp', 'ibm')],
            'hectares' => 'required|numeric|min:0.01',
            'location' => 'nullable|string|max:255'
        ]);

        Finca::create($request->only(['name', 'ibm', 'hectares', 'location']));

        return redirect()->route('fincas.index')->with('success', 'Finca creada exitosamente');
    }

    public function show(Finca $finca)
    {
        $finca->load(['aspersions.products', 'users']);
        return view('fincas.show', compact('finca'));
    }

    public function edit(Finca $finca)
    {
        return view('fincas.edit', compact('finca'));
    }

    public function update(Request $request, Finca $finca)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ibm' => ['required', 'string', Rule::unique('fincas_temp', 'ibm')->ignore($finca->id)],
            'hectares' => 'required|numeric|min:0.01',
            'location' => 'nullable|string|max:255',
            'active' => 'boolean'
        ]);

        $finca->update($request->only(['name', 'ibm', 'hectares', 'location', 'active']));

        return redirect()->route('fincas.index')->with('success', 'Finca actualizada exitosamente');
    }

    public function destroy(Finca $finca)
    {
        $finca->update(['active' => false]);
        return redirect()->route('fincas.index')->with('success', 'Finca desactivada exitosamente');
    }

    public function setPassword(Request $request, Finca $finca)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        $finca->update([
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['success' => true]);
    }
}