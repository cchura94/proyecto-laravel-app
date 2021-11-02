@extends("layouts.admin")

@section("titulo", "Pedidos")

@section("contenido")

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>FECHA</th>
            <th>PERSONAL</th>
            <th>CLIENTE</th>
            <th>DETALLES</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pedido)    
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->fecha }}</td>
            <td>{{ $pedido->user->email }}</td>
            <td>{{ $pedido->cliente->nombre_completo }}</td>
            <td>
                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$pedido->id}}">
  Mostrar Productos
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal{{$pedido->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
        <tr>
            <td>ID</td>
            <td>NOMBRE</td>
            <td>CANTIDAD</td>
            <td>PRECIO</td>
            <td>SUB T.</td>
        </tr>
        @foreach ($pedido->productos as $prod)
        <tr>
            <td>{{ $prod->id }}</td>
            <td>{{ $prod->nombre }}</td>
            <td>{{ $prod->pivot->cantidad }}</td>
            <td>{{ $prod->precio }}</td>
            <td>{{ $prod->pivot->cantidad * $prod->precio }}</td>
        </tr>
        @endforeach
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection