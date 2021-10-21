@extends("layouts.admin")

@section("titulo", "Gestión Categoria")

@section("contenido")

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal">
  Nueva Categoria
</button>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form action="{{ route('categoria.store') }}" method="post">
        @csrf
      <div class="modal-body">
        <label for="">Ingrese Nombre:</label>
        <input type="text" name="nombre" class="form-control">
        <label for="">Detalle:</label>
        <textarea name="detalle" class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
    </div>
  </div>
</div>

@if (session('mensaje'))
    <div class="alert alert-success">
        {{ session('mensaje') }}
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Lista de Categorias</div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>DETALLE</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista_categorias as $categoria)                        
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->detalle }}</td>
                            <td>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Modal{{ $categoria->id }}"><i class="fa fa-edit"></i></button>

                                <!-- Modal -->
                                <div class="modal fade" id="Modal{{ $categoria->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar {{ $categoria->nombre }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('categoria.update', $categoria->id) }}" method="post">
                                            @csrf
                                            @method("PUT")
                                        <div class="modal-body">
                                            <label for="">Ingrese Nombre:</label>
                                            <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}">
                                            <label for="">Detalle:</label>
                                            <textarea name="detalle" class="form-control">{{ $categoria->detalle }}</textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Modificar</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>

                                <!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalEliminar{{$categoria->id}}">
  <i class="fa fa-trash"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="ModalEliminar{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Está seguro de eliminar la Categoria?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('categoria.destroy', $categoria->id) }}" method="post">
      @csrf
      @method('DELETE')
      <div class="modal-body">
        <h5>NOMBRE: {{ $categoria->nombre }}</h5>
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
            </div>
        </div>
    </div>
</div>

@endsection