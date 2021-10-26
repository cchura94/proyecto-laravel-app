@extends("layouts.admin")

@section("titulo", "Nuevo Producto")

@section("contenido")

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('producto.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="">Nombre Producto</label>
                        <input type="text" class="form-control" name="nombre">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Precio</label>
                                <input type="number" step="0.01" class="form-control" name="precio">

                            </div>
                            <div class="col-md-6">
                                <label for="">Cantidad</label>
                                <input type="number" class="form-control" name="stock">

                            </div>

                            <div class="col-md-12">
                                <label for="">Imagen</label>
                                <input type="file" name="imagen">
                            </div>
                            <div class="col-md-12">
                                <label for="">Categoria</label>
                                <select name="categoria_id" id="" class="form-control">
                                    @foreach ($lista_categorias as $categoria)
                                    <option value="{{$categoria->id}}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Descripción</label>
                                <textarea name="descripcion" id="" class="form-control"></textarea>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-success" value="Guardar producto">                       
                        
                    </form>
                
                </div>
            </div>
        </div>
    </div>
@endsection