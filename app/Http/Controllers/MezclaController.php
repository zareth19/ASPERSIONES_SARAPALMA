<?php

namespace App\Http\Controllers;

use App\Models\Mezcla;
use Illuminate\Http\Request;

class MezclaController extends Controller
{
    public function index()
    {
        $mezclas = Mezcla::with('codigos')->get();
        return view('mezclas.index', compact('mezclas'));
    }

    public function create()
    {
        return view('mezclas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.'
        ]);

        Mezcla::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('mezclas.index')->with('success', 'Mezcla creada exitosamente');
    }

    public function show(Mezcla $mezcla)
    {
        $mezcla->load('codigos.productos');
        return view('mezclas.show', compact('mezcla'));
    }
}