<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedidos;

use App\Http\Controllers\Controller;




class PedidosController extends Controller
{

    public function index()
    {
        $pedidos = Pedidos::all();
        return $pedidos;

    }

    public function store(Request $request)
    {
        $pedidos = new Pedidos();
        $pedidos->vendedor = $request->vendedor;
        $pedidos->cliente = $request->cliente;
        $pedidos->descripcion = $request->descripcion;
        $pedidos->precioTotal = $request->precioTotal;
        $pedidos->save();
    }


    // public function store(Request $request)
    // {
    //     $productos = new Productos();
    //     $productos->name = $request->name;
    //     $productos->precio = $request->precio;
    //     $productos->save();
    // }


    // public function update(Request $request)
    // {
    //     $producto = Productos::findOrFail($request->id);
    //     $producto->name = $request->name;
    //     $producto->precio = $request->precio;
    //     $producto->save();
    //     return $producto;

    // }

    // public function destroy(Request $request)
    // {
    //     $productos = Productos::destroy($request->id);
    //     return $productos;

    // }


}
