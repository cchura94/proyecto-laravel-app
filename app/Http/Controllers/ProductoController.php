<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $lista_productos = Producto::get();
         $lista_proveedores = Proveedor::all();
        return view("admin.producto.listar", compact("lista_productos", "lista_proveedores"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lista_categorias = Categoria::all();
       
        return view("admin.producto.nuevo", compact("lista_categorias"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validar

        // subir la imagen
        $nombre_imagen = "";
        if($file = $request->file("imagen")){
            $nombre_imagen = time()."-".$file->getClientOriginalName();
            $file->move("imagenes", $nombre_imagen);
        }

        // guardar datos
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;
        $producto->imagen = $nombre_imagen;
        $producto->save();
        // redireccionar
        return redirect("/admin/producto")->with("mensaje", "Producto Registrado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $lista_categorias = Categoria::all();
        return view("admin.producto.editar", compact("producto", "lista_categorias"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->categoria_id = $request->categoria_id;

        $nombre_imagen = "";
        if($file = $request->file("imagen")){
            $nombre_imagen = time()."-".$file->getClientOriginalName();
            $file->move("imagenes", $nombre_imagen);
            $producto->imagen = $nombre_imagen;
        }
        
        $producto->save();
        // redireccionar
        return redirect("/admin/producto")->with("mensaje", "Producto Registrado");
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect("/admin/producto")->with("mensaje", "Producto Eliminado");
    
    }

    public function aumentarProductos(Request $request, $id)
    {
        $cantidad = $request->cantidad;
        $proveedor_id = $request->proveedor_id;
        // actualizar el stock del producto
        $producto = Producto::find($id);
        $producto->stock =$producto->stock + $cantidad;
        $producto->save();

        // registrar al proveedor + la cantidad que está asignando
        // N:M
        $producto->proveedores()->attach($proveedor_id, ["cantidad" => $cantidad]);
        
        return redirect()->back()->with("mensaje", "Se agregaron + Producto");
    }
}
