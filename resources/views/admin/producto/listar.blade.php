@extends("layouts.admin")

@section("titulo", "Lista Productos")

@section("contenido")

<a href="{{ route('producto.create') }}" class="btn btn-primary">Nuevo Producto</a>
<table class="table">
  <thead>
    <tr>
      <th>ID</th>
      <th>NOMBRE</th>
      <th>PRECIO</th>
      <th>STOCK</th>
      <th>CATEGORIA</th>
      <th>ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($lista_productos as $producto)
    <tr>
      <td>{{ $producto->id }}</td>
      <td>{{ $producto->nombre }}</td>
      <td>{{ $producto->precio }}</td>
      <td>{{ $producto->stock }}</td>
      <td>{{ $producto->categoria->nombre }}</td>
      <td>


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalDet{{$producto->id}}">
          ver detalle
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modalDet{{$producto->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">DETALLES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-striped">
                  <tr>
                    <td>ID</td>
                    <td>NOMBRE Proveedor</td>
                    <td>CANTIDAD</td>
                  </tr>
                  @foreach ($producto->proveedores as $prov )
                  <tr>
                    <td>{{ $prov->id }}</td>
                    <td>{{ $prov->nombre }}</td>
                    <td>{{ $prov->pivot->cantidad }}</td>
                  </tr>
                  @endforeach

                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalAsig{{$producto->id}}">
          proveer productos
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modalAsig{{$producto->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Asignar Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{route('aumentar-productos', $producto->id)}}" method="post">
                @csrf
                <div class="modal-body">

                  <label for="">Seleccione Proveedor</label>
                  <select name="proveedor_id" id="" class="form-control">
                    @foreach ($lista_proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                  </select>

                  <label for="">Cantidad a proveer</label>
                  <input type="number" name="cantidad" class="form-control">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-warning"><i class="fa fa-edit"></i></a>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalEliminar{{$producto->id}}">
          <i class="fa fa-trash"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="ModalEliminar{{$producto->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Está seguro de eliminar el Producto?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('producto.destroy', $producto->id) }}" method="post">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                  <h5>NOMBRE: {{ $producto->nombre }}</h5>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary">Eliminar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection