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
            <td>{{ $pedido->user }}</td>
            <td>{{ $pedido->cliente }}</td>
            <td>
            
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection