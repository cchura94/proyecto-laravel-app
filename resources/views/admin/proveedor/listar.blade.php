@extends("layouts.admin")

@section("titulo", "Lista Proveedores")

@section("contenido")

    <a href="{{ route('proveedor.create') }}" class="btn btn-primary">Nuevo Proveedor</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>TELEFONO</th>
                <th>NOMBRE CONTACTO</th>
                <th>DIRECCION</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lista_proveedores as $proveedor)            
            <tr>
                <td>{{ $proveedor->id }}</td>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->telefono_contacto }}</td>
                <td>{{ $proveedor->nombre_contacto }}</td>
                <td>{{ $proveedor->direccion }}</td>
                <td>
                    <a href="{{ route('proveedor.edit', $proveedor->id) }}"><i class="fa fa-edit"></i></a>

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalEliminar{{$proveedor->id}}">
  <i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="ModalEliminar{{$proveedor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Está seguro de eliminar el Proveedor?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('proveedor.destroy', $proveedor->id) }}" method="post">
      @csrf
      @method('DELETE')
      <div class="modal-body">
        <h5>NOMBRE: {{ $proveedor->nombre }}</h5>
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