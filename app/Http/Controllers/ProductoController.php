<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Resources\ProductoCollection;

class ProductoController extends Controller
{
    public function index() 
    { 
        return new ProductoCollection(Producto::where('disponible', 1)->get());
    }

    public function update(Request $request, Producto $producto)
    {
        $producto->disponible = !$producto->disponible;
        $producto->save();

        return [
            'message' => 'Guardado'
        ];
    }

    public function show() 
    { 
        return new ProductoCollection(Producto::all());
    }
}
