@extends("layouts.admin")

@section("titulo", "Nuevo Pedido")

@section("css")
 <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
 
@endsection

@section("js")
<!-- DataTables  & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
  $(function () {
    $("#table-producto").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#table-producto_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>
    // carrito
    let carrito = [];

    function adicionarCarrito(prod){
        prod = JSON.parse(prod);

        let producto = {id: prod.id, nombre: prod.nombre, precio: prod.precio, cantidad: 1};
        carrito.push(producto);

        actualizarCarrito();
    }

    function actualizarCarrito(){
        let html = ``;
        let total = 0;
        for (let i = 0; i < carrito.length; i++) {
            const element = carrito[i];
            html = html + `
                        <tr>
                            <td>${element.nombre}</td>
                            <td>${element.precio}</td>
                            <td>${element.cantidad}</td>
                            <td>
                                <button class="btn btn-danger" onclick="quitarCarrito(${i})">x</button>
                            </td>
                        </tr>
            `;
            total += parseFloat(element.precio);  
        }
        document.getElementById("carrito").innerHTML = html;
        document.getElementById("total").innerHTML = total
    }

    function quitarCarrito(posicion){
        carrito.splice(posicion, 1);
        actualizarCarrito();
    }

</script>

@endsection

@section("contenido")

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>CORREO PERSONAL: {{Auth::user()->email}}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3>LISTA PRODUCTOS</h3>

                <table id="table-producto" class="table table-bordered table-striped">
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
        <button class="btn btn-primary btn-xs" onclick="adicionarCarrito('{{$producto}}')">adicionar</button>
    
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3>DETALLES</h3>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>PRECIO</th>
                            <th>CANTIDAD</th>
                            <th>ACCION</th>
                        </tr>
                    </thead>
                    <tbody id="carrito">
                        
                    </tbody>
                </table>
                <h2>TOTAL: Bs. <span id="total"></span></h2>
            </div>
        </div>
    </div>
</div>

@endsection