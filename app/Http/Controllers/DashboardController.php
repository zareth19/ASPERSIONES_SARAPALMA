<?php

namespace App\Http\Controllers;

use App\Models\Aspersion;
use App\Models\Finca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Si es una finca logueada
        if (session('finca_logged')) {
            $fincaId = session('finca_id');
            $aspersionesRecientes = Aspersion::where('finca_id', $fincaId)
                                           ->latest()
                                           ->take(5)
                                           ->get();
            
            return view('dashboard.finca', compact('aspersionesRecientes'));
        }
        
        // Si es un usuario normal
        if ($user && $user->isAdmin()) {
            $totalFincas = Finca::where('active', true)->count();
            $fincasConAspersiones = Aspersion::distinct('finca_id')->count();
            $aspersionesHoy = Aspersion::whereDate('application_date', today())->count();
            $aspersionesMes = Aspersion::whereMonth('application_date', now()->month)->count();
            
            return view('dashboard.admin', compact(
                'totalFincas', 
                'fincasConAspersiones', 
                'aspersionesHoy', 
                'aspersionesMes'
            ));
        } else {
            $aspersionesRecientes = Aspersion::where('finca_id', $user->finca_id)
                                           ->latest()
                                           ->take(5)
                                           ->get();
            
            return view('dashboard.finca', compact('aspersionesRecientes'));
        }
    }
}