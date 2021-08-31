<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Productos;

use App\Http\Controllers\Controller;




class ProductosController extends Controller
{

    public function index()
    {
        $productos = Productos::all();
        return $productos;

    }



    public function store(Request $request)
    {
        $productos = new Productos();
        $productos->name = $request->name;
        $productos->precio = $request->precio;
        $productos->save();
    }


    public function update(Request $request)
    {
        $productos = Productos::findOrFail($request->id);
        $productos->name = $request->name;
        $productos->precio = $request->precio;


        $productos->save();

        return $productos;

    }

    public function destroy(Request $request)
    {
        $productos = Productos::destroy($request->id);
        return $productos;
    }


}
