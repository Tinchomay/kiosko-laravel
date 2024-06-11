<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use Carbon\Carbon;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\PedidoProductos;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Para utilizar la collection le pasamos las columnas que queramos, aqui se pasan los pedidos que no estan completos
        //With lo que hace es hacer la consulta total, osea solo hace una consulta para poder exportar en el JSON, tenemos que indicar que relacion queremos exportar
        return new PedidoCollection(Pedido::with('user')->with('productos')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Almacenar pedido
        $pedido = new Pedido;
        //El user se obtiene en automatico por el bear token que mandamos
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

        //Obtener el id
        $pedido_id = $pedido->id;

        //Obtener los productos
        $productos = $request->productos;
        
        //Agregando a un arreglo los productos para agregarlos con insert
        $pedido_producto = [];
        foreach($productos as $producto) {
            $pedido_producto[] = [
                'pedido_id' => $pedido_id,
                'producto_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                //Como vamos a añadir array no se crean estas columnas en automatico
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        //Guardar
        PedidoProductos::insert($pedido_producto);
        
        return [
            'message' => 'Pedido realizado correctamente, estara listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {   
        $pedido->estado = 1;
        $pedido->save();
        return [
            'pedido' => 'Completado'
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
